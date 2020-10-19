<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\CustomMailer;
use App\Helpers\HelperFunctions;

use App\Models\Admin;
use App\Models\Company;
use App\Models\CompanyActivationCode;

class AdminController extends Controller
{
    /**
     * Render admin signup page
     */
    public function renderAdminSignupPage()
    {
        return view('admin_views.signup');
    }

    
    /**
     * Render admin dashboard page
     */
    public function renderDashboardPage()
    {
        return view('admin_views.dashboard', ['username' => $_SESSION['admin_username']]);
    }


    /**
     * Render admin companies page
     */
    public function renderCompanyAccountsPage()
    {
        return view('admin_views.company_accounts', ['username' => $_SESSION['admin_username']]);
    }

    /**
     * Render admin report page
     */
    public function renderReportPage()
    {
        return view('admin_views.report', ['username' => $_SESSION['admin_username']]);
    }


    /**
     * Registe company account
     */
    public function registerCompanyAccount(Request $request)
    {
        // check if email address exists either in either the admins or companies table
        if (Admin::where('admin_email', $request->companyEmail)->exists() || Company::where('email', $request->companyEmail)-> exists()) {
            // if email exists in either of the tables, return a response
            $response_message =  array('success' => false, 'message' => 'Email address already exists' );
    		return response()->json($response_message);
        } else {
            // else if email does not exist in either of the tables proceed to registration:
            // prepare mail parameters and send mail
            $helperFunction = new HelperFunctions();
            $activationURL = $helperFunction->getBaseUrl().'/account-activation';
            $registrationToken = "AMZ-LB-".substr(strtoupper(md5(time())), 0, 20);
            $mailSalutation = "Congratulations ";
            $mailTitle = "AMZ LogBook Account Registration";
            $mailSubject = "AMZ LogBook Account Registration";
            $mailBody = "
                <p>Account registration for <b>$request->companyName</b> on AMZ LogBook is successful.<br> Please follow <a href='$activationURL'>this link</a> to activate your account.</p>
                <p>Please use the email address to which this mail was sent (this email address) to activate your account.</p>
                <p>Your account activation token is <b>$registrationToken</b></p>

                <p>We are excited to have you.</p><br><br>

                <p>Cheers.<br> AMZ LogBook</p>
            ";
            
            // create an object of the 'CustomMailer' class to send mail
            $customMailer = new CustomMailer();
            $customMailer->sendMail($request->companyEmail, $mailSubject, $mailTitle, $mailSalutation, $mailBody);
           
            $company = new Company();
            $company->email = $request->companyEmail;
            $company->name = $request->companyName;
            $company->password = "n/a";
            $company->thumbnail = 'https://res.cloudinary.com/amazing-technologies/image/upload/v1557224965/logbook/logos/logo.png';
            $company->banner = 'https://res.cloudinary.com/amazing-technologies/image/upload/v1562334566/logbook/default_images/banner-1571858_1280.jpg';

            if ($company->save()) {
                $companyActivationCode = new CompanyActivationCode();
                $companyActivationCode->company_id = $company->id;
                $companyActivationCode->activation_code = $registrationToken;

                $companyActivationCode->save();
                $response_message =  array('success' => true, 'message' => 'Account registered successfully' );
                return response()->json($response_message);
            } else {
                $response_message =  array('success' => false, 'message' => 'Could not register account. Please check your internet connecton and try again' );
                return response()->json($response_message);
            }

        }
        
    }

    /**
     * Get all company accounts
     */
    public function getAllCompanyAccounts()
    {   
        // select all fields and columns form the 'companies' table and return is as an array of objects
        $companies = Company::all();

        // if the length of array of company objects is greater than 0 (contains elements)
        if (count($companies) > 0) {
            // loop through each company, get the token from the 'company_activation_codes' table and update the object
            foreach ($companies as $key => $value) {
                $token = CompanyActivationCode::where('company_id', $value['id'])->first()->activation_code;
                $value['token'] = $token;
                $companies[$key] = $value;
            }
        }
        
        // send a response to the requester of the data
        $response_message =  array('success' => true, 'message' => 'Data fetched', 'data' => $companies);
        return response()->json($response_message);
    }


    /**
     * Toggle company account status
     */
    public function toggleCompanyAccountStatus(Request $request)
    {
        // select the fields of the company with the id sent with the request
        $company = Company::find($request->id)->first();

        // if the company exists update the 'active' field of that company with the opposite status and update the column
        if ($company) {
            $companyActivationStatus =  $company->active;
            $newCompanyActivationStatus = "";
            $messageString = "";
            if ($company->active == "yes") {
                $newCompanyActivationStatus = "no";
                $messageString = "Account deactivated successfully";
            } else {
                $newCompanyActivationStatus = "yes";
                $messageString = "Account activated successfully";
            }

            $company->active = $newCompanyActivationStatus;
            if ($company->save()) {
                $response_message =  array('success' => true, 'message' => $messageString);
                return response()->json($response_message);
            } else {
                $response_message =  array('success' => false, 'message' => "Unable to chage account status. Please try again");
                return response()->json($response_message);
            }
            
        } else {
            // else if the company does not exist, send a response to the requester
            $response_message =  array('success' => false, 'message' => "Company does not exist");
            return response()->json($response_message);
        }
        
    }
}
