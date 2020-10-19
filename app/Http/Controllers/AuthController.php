<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\HelperFunctions;

use App\Models\Admin;
use App\Models\Company;
use App\Models\CompanyActivationCode;

class AuthController extends Controller
{

	/**
	 * Render login page
	 */
	public function renderLoginPage()
	{
		return view('welcome');
	}

	/**
	 * Render company account activation page
	 */
	public function renderAccountActivationPage()
	{
		return view('account_activation');
	}

	
    /**
     * Create admin account
     *
     * @param Illuminate\Http\Request
     */

    public function createAdminAccount(Request $request)
    {
    	if (Admin::where('admin_email', $request->adminEmail)->exists()) {
    		$response_message =  array('success' => false, 'message' => 'Email address already exists' );
    		return response()->json($response_message);
    	} else {
			if (Admin::where('admin_username', $request->adminUsername)->exists()) {
				$response_message =  array('success' => false, 'message' => 'Username already exists' );
				return response()->json($response_message);
			} else {
				$hashedPassword = password_hash($request->adminPassword, PASSWORD_DEFAULT);
				$admin = new Admin();

				$admin->admin_username = $request->adminUsername;
				$admin->admin_password = $hashedPassword;
				$admin->admin_email = $request->adminEmail;

				if ($admin->save()) {
					$response_message =  array('success' => true, 'message' => 'Signup successful' );
					return response()->json($response_message);
				} else {
					$response_message =  array('success' => false, 'message' => 'Unable to signup' );
					return response()->json($response_message);
				}
			}
    	}
    }


    /**
     * Perform admin login
     *
     * @param Illuminate\Http\Request
     */
    public function loginUserAccount(Request $request)
    {
		$userEmail = $request->userEmail;
		$userPassword = $request->userPassword;

    	$adminEmailRequest = Admin::where('admin_email', $userEmail)->get();

    	if (count($adminEmailRequest) > 0 ) {
    		$hashedPassword = $adminEmailRequest[0]['admin_password'];
    		if (password_verify($userPassword, $hashedPassword)) {
    			session_start();
    			$_SESSION['admin_id'] = $adminEmailRequest[0]['admin_id'];
    			$_SESSION['admin_email'] = $adminEmailRequest[0]['admin_email'];
    			$_SESSION['admin_username'] = $adminEmailRequest[0]['admin_username'];

				$userType = 'admin';
    			$response_message =  array('success' => true, 'message' => 'Login successful', 'userType' => $userType);
    			return response()->json($response_message);
    		} else {
    			$response_message =  array('success' => false, 'message' => "Wrong email or password");
    			return response()->json($response_message);
    		}

    	} else {
			$companyEmailRequest = Company::where('email', $userEmail)->get();

			if (count($companyEmailRequest) > 0 ) {
				$hashedPassword = $companyEmailRequest[0]['password'];
				if (password_verify($userPassword, $hashedPassword)) {
					session_start();
					$_SESSION['company_id'] = $companyEmailRequest[0]['id'];
					$_SESSION['company_email'] = $companyEmailRequest[0]['email'];
					$_SESSION['company_name'] = $companyEmailRequest[0]['name'];
					$_SESSION['company_logo'] = $companyEmailRequest[0]['thumbnail'];
	
					$userType = 'company';
					$response_message =  array('success' => true, 'message' => 'Login successful', 'userType' => $userType);
					return response()->json($response_message);
				} else {
					$response_message =  array('success' => false, 'message' => "Wrong email or password");
					return response()->json($response_message);
				}
			} else {
				$response_message =  array('success' => false, 'message' => "Wrong email or password");
				return response()->json($response_message);
			}
            
    	}
	}


	/**
	 * Activate company account
	 */
	public function activateCompanyAccount(Request $request)
	{
		// find the company which has email address same as the one sent with the request
		$company = Company::where('email', $request->companyEmail)->first();

		//if company exists proceed with account activation
		if ($company) {
			$companyStatus = $company->active; // get activation status of company

			// if account is already activated send a response
			if ($companyStatus == "yes") {
				$response_message =  array('success' => false, 'message' => "Account already activated");
				return response()->json($response_message);
			} else {
				//else if account is not already activated, get the token for that account
				$companyActivationTokenData = CompanyActivationCode::where('company_id', $company->id)->get()->first();
				$token = $companyActivationTokenData->activation_code;
				$tokenExpired = $companyActivationTokenData->expired;
				//compare token with the one sent with request
				if ($token != $request->companyToken) {
					// if the token is not equal to the one sent with the request, send a response
					$response_message =  array('success' => false, 'message' => "Invalid email or activation code");
					return response()->json($response_message);
				} else if ($tokenExpired == 'yes') {
					// if the token is expired
					$response_message =  array('success' => false, 'message' => "Activation token expired");
					return response()->json($response_message);
				} else {
					// else if the tokens match update the company's password and activation status, then update
					$hashedPassword = password_hash($request->companyPassword, PASSWORD_DEFAULT);
					$company->password = $hashedPassword;
					$company->active = "yes";
					$company->save();

					// create and save company auth token
					$helperFunction = new HelperFunctions();
					$companyToken = $helperFunction->hashId($company->id);
					$company->token = $companyToken;
					$company->save();

					// update activation token expiration status
					$companyActivationTokenData->expired = 'yes';
					$companyActivationTokenData->save();

					// send a response
					$response_message =  array('success' => true, 'message' => "Account activated successfully");
					return response()->json($response_message);
				}
			}
		} else {
			$response_message =  array('success' => false, 'message' => "Invalid email or activation code");
			return response()->json($response_message);# code...
		}
	}

	/**
	 * Login company account via mobile
	 */
	public function loginCompanyAccountViaMobile(Request $request)
	{
		$company = Company::where('email', $request->email)->get();

		if (count($company) > 0 ) {
			$hashedPassword = $company[0]['password'];
			if (password_verify($request->password, $hashedPassword)) {
				$data = array(
					'company_id' => $company[0]['id'],
					'company_name' => $company[0]['name'],
					'company_thumbnail' => $company[0]['thumbnail'],
					'company_token' => $company[0]['token']
				);

				$response_message =  array('success' => true, 'message' => 'Login successful', 'company_data' => $data);
				return response()->json($response_message);
			} else {
				$response_message =  array('success' => false, 'message' => "Wrong email or password");
				return response()->json($response_message);
			}
		} else {
			$response_message =  array('success' => false, 'message' => "Wrong email or password");
			return response()->json($response_message);
		}
	}


	/**
	 * Logout admin account
	 */
	public function logoutAdminAccount()
	{
		session_start();
    	unset($_SESSION['admin_id']);
        unset($_SESSION['admin_email']);
    	return redirect('/');
	}
	

	/**
	 * Logout company account
	 */
	public function logoutCompanyAccount()
	{
		session_start();
    	unset($_SESSION['company_id']);
        unset($_SESSION['company_email']);
    	return redirect('/');
	}

}
