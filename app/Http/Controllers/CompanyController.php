<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JD\Cloudder\Facades\Cloudder;
use App\Helpers\CustomSMS;
use App\Helpers\CustomMailer;
use App\Helpers\HelperFunctions;

use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Guest;
use App\Models\EmployeeLog;
use App\Models\SentCompanyMessage;

class CompanyController extends Controller
{

    /**
     * Render company dashboard page
     */
    public function renderDashboardPage()
    {
        // get number of employees for the company
        $companyId = $_SESSION['company_id'];
        $currentDate = Date('Y-m-d');
        $currentMonth = Date('m');
        $currentYear = Date('Y');

        $numberOfEmployees = Employee::where('company', $companyId)->count();
        $numberOfDepartments = Department::where('company_id', $companyId)->count();
        $numberOfGuestToday = DB::select("SELECT * FROM guests WHERE host_company = $companyId AND DATE(time_in)='$currentDate'");
        $numberOfGuestThisMonth = DB::select("SELECT * FROM guests WHERE host_company = $companyId AND MONTH(time_in)='$currentMonth' AND YEAR(time_in)='$currentYear'");


        $data = array(
            'numberOfEmployees' => $numberOfEmployees,
            'numberOfDepartments' => $numberOfDepartments,
            'numberOfGuestToday' => count($numberOfGuestToday),
            'numberOfGuestThisMonth' => count($numberOfGuestThisMonth)
        );
        return view('company_views.dashboard', ['username' => $_SESSION['company_name'], 'logo' => $_SESSION['company_logo'], 'data' => $data]);
    }


    /**
     * Render company analytics page
     */
    public function renderAnalyticsPage()
    {
        return view('company_views.analytics', ['username' => $_SESSION['company_name'], 'logo' => $_SESSION['company_logo']]);
    }


    /**
     * Render company departments page
     */
    public function renderDepartmentsPage()
    {
        return view('company_views.departments', ['username' => $_SESSION['company_name'], 'logo' => $_SESSION['company_logo']]);
    }


    /**
     * Render company employee logs page
     */
    public function renderEmployeeLogsPage() {
        return view('company_views.employee_logs', ['username' => $_SESSION['company_name'], 'logo' => $_SESSION['company_logo']]);
    }


    /**
     * Render company guest logs page
     */
    public function renderGuestLogsPage() {
        return view('company_views.guest_logs', ['username' => $_SESSION['company_name'], 'logo' => $_SESSION['company_logo']]);
    }

    /**
     * Render company employees page
     */
    public function renderEmployeesPage()
    {
        return view('company_views.employees', ['username' => $_SESSION['company_name'], 'logo' => $_SESSION['company_logo']]);
    }

    /**
     * Render send massages page
     */
    public function renderSendMessagesPage()
    {
        return view('company_views.send_messages', ['username' => $_SESSION['company_name'], 'logo' => $_SESSION['company_logo']]);
    }


    /**
     * Render company account settings page
     */
    public function renderAccountSettingsPage()
    {
        $company = Company::find($_SESSION['company_id']);
        return view('company_views.account_settings', ['username' => $_SESSION['company_name'], 'logo' => $_SESSION['company_logo'], 'companyDetails' => $company]);
    }


    /**
     * Add company department
     */
    public function addCompanyDepartment(Request $request)
    {
        session_start();
        $companyId = $_SESSION['company_id'];
        if (Department::where('company_id', $companyId)->where('name', $request->departmentName)->exists()) {
            $response_message =  array('success' => false, 'message' => "Department already exists");
            return response()->json($response_message);
        } else {
            $department = new Department();
            $department->company_id = $companyId;
            $department->name = $request->departmentName;

            if ($department->save()) {
                $response_message =  array('success' => true, 'message' => "Department added successfully");
                return response()->json($response_message);
            } else {
                $response_message =  array('success' => false, 'message' => "Could not add department. Please try again");
                return response()->json($response_message);
            }
        }
    }


    /**
     * Edit company department
     */
    public function editCompanyDepartment(Request $request)
    {
        session_start();
        $companyId = $_SESSION['company_id'];
        if (Department::where('company_id', $companyId)->where('name', $request->departmentName)->where('id', '<>', $request->departmentId)->exists()) {
            $response_message =  array('success' => false, 'message' => "Department already exists");
            return response()->json($response_message);
        } else {
            $department = Department::find($request->departmentId);
            $department->name = $request->departmentName;

            if ($department->save()) {
                $response_message =  array('success' => true, 'message' => "Department updated successfully");
                return response()->json($response_message);
            } else {
                $response_message =  array('success' => false, 'message' => "Could not update department. Please try again");
                return response()->json($response_message);
            }
        }
    }


    /**
     * Get company departments
     */
    public function getCompanyDepartments()
    {
        session_start();
        $companyId = $_SESSION['company_id'];
        $data = Department::where('company_id', $companyId)->orderBy('name')->get();
        $response_message =  array('success' => true, 'message' => "Data fetched", 'data' => $data);
        return response()->json($response_message);
    }


    /**
     * Delete company department
     */
    public function deleteCompanyDepartment(Request $request)
    {
        $department = Department::find($request->departmentId);
        if ($department) {
            if ($department->delete()) {
                $response_message =  array('success' => true, 'message' => "Department deleted successfully");
                return response()->json($response_message);
            } else {
                $response_message =  array('success' => false, 'message' => "Could not delete department. Please try again");
                return response()->json($response_message);
            }
            
        } else {
            $response_message =  array('success' => false, 'message' => "Department does not exist");
            return response()->json($response_message);
        }
        
    }

    /**
     * Send company message
     */
    public function sendCompanyMessage(Request $request)
    {
        session_start();
        $companyId = $_SESSION['company_id'];
        $customSMS = new CustomSMS();
        $counter = 0;
        
        // Check message receipient group, query their phone numbers and broadcast message
        if ($request->messageType == 'guests') {
            $guestPhoneNumbers = DB::select("SELECT DISTINCT phone FROM guests WHERE host_company = $companyId");
            foreach ($guestPhoneNumbers as $key => $value) {
                $customSMS->sendSMS($value->phone, $request->messageContent);
                $counter += 1;
            }
        } else {
            $employeePhoneNumbers = DB::select("SELECT DISTINCT phone FROM employees WHERE company = $companyId");
            foreach ($employeePhoneNumbers as $key => $value) {
                $customSMS->sendSMS($value->phone, $request->messageContent);
                $counter += 1;
            }
        }

        // If one or more messages are sent, save the log and send a response
        if ($counter > 0) {
            $sentMessage = new SentCompanyMessage();
            $sentMessage->company_id = $companyId;
            $sentMessage->message = $request->messageContent;
            $sentMessage->recipients = $request->messageType;
            $sentMessage->save();

            $resMesssage = "";
            if ($counter == 1) {
                $resMesssage = "$counter message sent";
            } else {
                $resMesssage = "$counter messages sent";
            }
            
            $response_message =  array('success' => true, 'message' => $resMesssage);
            return response()->json($response_message);
        } else {
            $response_message =  array('success' => false, 'message' => "No $request->messageType to send message to");
            return response()->json($response_message);
        }
        
    }


    /**
     * Get sent company messsages
     */
    public function getSentCompanyMessages()
    {
        session_start();
        $companyId = $_SESSION['company_id'];
        $sentMessages = SentCompanyMessage::where('company_id', $companyId)->get();
        $response_message =  array('success' => true, 'message' => "Data fetched", 'data' => $sentMessages);
        return response()->json($response_message);
    }


    /**
     * Add company employee
     */
    public function addCompanyEmployee(Request $request)
    {
        session_start();
        $companyId = $_SESSION['company_id'];

        if (Employee::where('number', $request->number)->where('company', $companyId)->exists()) {
            $response_message =  array('success' => false, 'message' => "Employee with this number already exists");
            return response()->json($response_message);
        } else if (Employee::where('email', $request->email)->where('company', $companyId)->exists()) {
            $response_message =  array('success' => false, 'message' => "Employee with this email address already exists");
            return response()->json($response_message);
        } else {
            $helperFunction = new HelperFunctions();
            $passcode = $helperFunction->generateEmployeePassCode();
            
            $employee = new Employee();
            $employee->first_name = $request->firstName;
            $employee->last_name = $request->lastName;
            $employee->number = $request->number;
            $employee->email = $request->email;
            $employee->date_of_birth = $request->dateOfBirth;
            $employee->phone = $request->phone;
            $employee->company = $companyId;
            $employee->department = $request->department;
            $employee->type = $request->type;
            $employee->position = $request->position;
            $employee->pass_code = $passcode;

            if ($request->hasFile('thumbnail')) {
                $public_id = "employee_profile_thumbnail_".time();
                Cloudder::upload($request->file('thumbnail')->getRealPath(),$public_id , array('folder'=> 'logbook/companies/'.$companyId.'/employees'));
                $upload_result = Cloudder::getResult();
    
                if ($upload_result) {
                    $employee->thumbnail = $upload_result['secure_url'];
                } else {
                    $employee->thumbnail = 'https://res.cloudinary.com/amazing-technologies/image/upload/v1557928971/logbook/default_images/profile-picture.png';
                }
            } else {
                $employee->thumbnail = 'https://res.cloudinary.com/amazing-technologies/image/upload/v1557928971/logbook/default_images/profile-picture.png';
            }

            // send SMS to employee notifying him account and access credential creation
            $messageBody = "Hello $request->firstName, your AMZ LogBook access (PIN) code is $passcode. An email, which contains a qr code and access code has been sent to $request->email. You can use either the PIN or qr code to log into AMZ LogBook systems at your company. Please keep your passcode secret to ensure your account's security. Thank you.";
            $customSMS = new CustomSMS();
            $send_sms = $customSMS->sendSMS($request->phone, $messageBody);

            // send email to employee notifying him account and access credential creation
            $helperFunction = new HelperFunctions();
            $hashedPassCode = $helperFunction->hasQRCode($passcode);
            $qrCodeURL = $helperFunction->generateEmployeeQRCode($hashedPassCode, $companyId);
            $mailSalutation = "Hello $request->firstName";
            $mailTitle = "AMZ LogBook Employee Account Registration";
            $mailSubject = "AMZ LogBook Employee Account Registration";
            $mailBody = "
                <p>Your AMZ login access (PIN) code is <b>$passcode</b></p>
                <p>You can also use the QR code below to log into your account.
                <br><b>You can download the QR code <a href='$qrCodeURL'>here</a></b></p>

                <img src='$qrCodeURL' style='height:200px; width: 200px;'>

                <p> Please keep your passcode secret to ensure your account's security</p>

                <p>Thank you.<br> AMZ LogBook</p>
            ";
            
            $customMailer = new CustomMailer();
            $customMailer->sendMail($request->email, $mailSubject, $mailTitle, $mailSalutation, $mailBody);

            if ($employee->save()) {
                $response_message =  array('success' => true, 'message' => 'Employee added successfully' );
                return response()->json($response_message);
            } else {
                $response_message =  array('success' => false, 'message' => 'Unable to add employee. Please check your internet connection and try again' );
                return response()->json($response_message);
            }
        }
        
    }


    /**
     * Edit company employee
     */
    public function editCompanyEmployee(Request $request)
    {
        session_start();
        $companyId = $_SESSION['company_id'];

        if (Employee::where('number', $request->number)->where('company', $companyId)->where('id', '<>', $request->id)->exists()) {
            $response_message =  array('success' => false, 'message' => "Employee with this number already exists");
            return response()->json($response_message);
        } else if (Employee::where('email', $request->email)->where('company', $companyId)->where('id', '<>', $request->id)->exists()) {
            $response_message =  array('success' => false, 'message' => "Employee with this email address already exists");
            return response()->json($response_message);
        } else {
            $employee = Employee::find($request->id);
            $employee->first_name = $request->firstName;
            $employee->last_name = $request->lastName;
            $employee->number = $request->number;
            $employee->email = $request->email;
            $employee->date_of_birth = $request->dateOfBirth;
            $employee->phone = $request->phone;
            $employee->company = $companyId;
            $employee->department = $request->department;
            $employee->type = $request->type;
            $employee->position = $request->position;

            if ($request->hasFile('thumbnail')) {
                $public_id = "employee_profile_thumbnail_".time();
                Cloudder::upload($request->file('thumbnail')->getRealPath(),$public_id , array('folder'=> 'logbook/companies/'.$companyId.'/employees'));
                $upload_result = Cloudder::getResult();
    
                if ($upload_result) {
                    $employee->thumbnail = $upload_result['secure_url'];
                } 
            }

            if ($employee->save()) {
                $response_message =  array('success' => true, 'message' => 'Employee details updated successfully' );
                return response()->json($response_message);
            } else {
                $response_message =  array('success' => false, 'message' => 'Unable to update employee details. Please check your internet connection and try again' );
                return response()->json($response_message);
            }
        }
        
    }

    /**
     * Get company employees
     */
    public function getCompanyEmployees()
    {
        session_start();
        $companyId = $_SESSION['company_id'];

        $employees = Employee::where('company', $companyId)->get();
        foreach ($employees as $key => $value) {
            $departmentName = Department::find($value['department'])->name;

            $value['department_name'] = $departmentName;
            $employees[$key] = $value;
        }
        $response_message =  array('success' => true, 'message' => 'Data fetched', 'data' => $employees );
        return response()->json($response_message);
    }

    /**
     * Delete company employee account
     */
    public function deleteCompanyEmployee(Request $request)
    {
        $employee = Employee::find($request->id);
        if ($employee) {
            if ($employee->delete()) {
                $response_message =  array('success' => true, 'message' => "Employee account deleted successfully");
                return response()->json($response_message);
            } else {
                $response_message =  array('success' => false, 'message' => "Could not delete employee account. Please try again");
                return response()->json($response_message);
            }
            
        } else {
            $response_message =  array('success' => false, 'message' => "Employee does not exist");
            return response()->json($response_message);
        }
    }


    /**
     * Toggle company employee active status
     */
    public function toggleCompanyEmployeeActiveStatus(Request $request)
    {
        $employee = Employee::find($request->id);

        if ($employee) {
            $employeeActiveStatus = $employee->active;
            $newEmployeeActiveStatus = ($employeeActiveStatus == 'yes') ? 'no' : 'yes';
            $employee->active = $newEmployeeActiveStatus;

            if ($employee->save()) {
                $response_message =  array('success' => true, 'message' => 'Employee account status updated successfully' );
                return response()->json($response_message);
            } else {
                $response_message =  array('success' => false, 'message' => 'Unable to update employee account status. Please check your internet connection and try again' );
                return response()->json($response_message);
            } 
        } else {
            $response_message =  array('success' => false, 'message' => "Employee does not exist");
            return response()->json($response_message);
        }
    }

    /**
     * Get company guest logs
     */
    public function getCompanyGuestLogs()
    {
        session_start();
        $companyId = $_SESSION['company_id'];
        $companyGuests = Guest::where('host_company', $companyId)->orderBy('id', 'desc')->get();
        $currentDate = Date('Y-m-d');
        $helperFunction = new HelperFunctions();

        if (count($companyGuests) > 0) {
            foreach ($companyGuests as $key => $value) {
                $host = Employee::find($value['host']);
                $value['host_department'] = Department::find($value['host_department'])->name;
                $value['host_name'] = $host->first_name.' '.$host->last_name;

                // determine if logging was done today or not
                if (substr($value['time_in'], 0, 10) == "$currentDate") {
                    $value['current_date'] = true;
                } else {
                    $value['current_date'] = false;
                }

                // get working time in minutes and seconds
                if ($value['time_out'] == '1000-01-01 00:00:00') {
                    $value['time_spent'] = 'n/a';
                    $value['time_out'] = 'n/a';
                    $value['logged_out'] = 'No';
                } else {
                    $value['time_spent'] = $helperFunction->getDateTimeDifference($value['time_in'], $value['time_out']);
                    $value['logged_out'] = 'Yes';
                }

                $companyGuests[$key] = $value;
            }
        } 
        
        $response_message =  array('success' => true, 'message' => 'Data fetched', 'data' => $companyGuests );
        return response()->json($response_message);
    }

    /**
     * Get company employee logs
     */
    public function getCompanyEmployeeAttendanceLogs()
    {
        session_start();
        $companyId = $_SESSION['company_id'];
        $companyEmployeeLogs = EmployeeLog::where('company_id', $companyId)->orderBy('id', 'DESC')->get();
        if (count($companyEmployeeLogs) > 0) {
            $helperFunction = new HelperFunctions();
            $currentDate = Date('Y-m-d');
            foreach ($companyEmployeeLogs as $key => $value) {
                //get employee name and department
                $employee = Employee::find($value['employee_id']);
                if ($employee) {
                    $value['employee_name'] = $employee->first_name.' '.$employee->last_name;
                    $department = Department::find($employee->department);
                    if ($department) {
                        $value['employee_department'] = $department->name;
                    } else {
                        $value['employee_department'] = 'n/a';
                    }
                } else {
                    $value['employee_name'] = 'n/a';
                    $value['employee_department'] = 'n/a';
                }
                
                // get working time in minutes and seconds
                if ($value['time_out'] == '1000-01-01 00:00:00') {
                    $value['time_at_work'] = 'n/a';
                    $value['time_out'] = 'n/a';
                    $value['logged_out'] = 'No';
                } else {
                    $value['time_at_work'] = $helperFunction->getDateTimeDifference($value['time_in'], $value['time_out']);
                    $value['logged_out'] = 'Yes';
                }

                // determine if logging was done today or not
                if (substr($value['time_in'], 0, 10) == "$currentDate") {
                    $value['current_date'] = true;
                } else {
                    $value['current_date'] = false;
                }

                $companyEmployeeLogs[$key] = $value;
            }
        }

        $response_message =  array('success' => true, 'message' => 'Data fetched', 'data' => $companyEmployeeLogs);
        return response()->json($response_message);        
    }


    /**
     * Notify company host
     */
    public function notifyCompanyHost(Request $request)
    {
        $guest = Guest::find($request->id);
        $host = Employee::find($guest->host);

        $hostName = $host->first_name.' '.$host->last_name;
        $hostPhoneNumber = $host->phone;

        // send SMS to host, notifying him of guest overstay
        $messageBody = "Hello $hostName, please this is a quick reminder of the overstay of your guest. Thank you.";
        $customSMS = new CustomSMS();
        $send_sms = $customSMS->sendSMS($hostPhoneNumber, $messageBody);
        
        $response_message =  array('success' => true, 'message' => '$hostName has been notified' );
        return response()->json($response_message);
    }

    /**
     * Reset company logo
     */
    public function resetCompanyLogo(Request $request)
    {
        if ($request->hasFile('thumbnail')) {
            session_start();
            $companyId = $_SESSION['company_id'];
            $public_id = "company_logo_$companyId";
            Cloudder::upload($request->file('thumbnail')->getRealPath(),$public_id , array('folder'=> 'logbook/companies/'.$companyId.'/logos', 'overwrite' => true));
            $upload_result = Cloudder::getResult();

            if ($upload_result) {
                $company = Company::find($companyId);
                $company->thumbnail = $upload_result['secure_url'];

                if ($company->save()) {
                    $_SESSION['company_logo'] = $upload_result['secure_url'];
                    $response_message =  array('success' => true, 'message' => 'Company logo updated successfully' );
                    return response()->json($response_message);
                } else {
                    $response_message =  array('success' => false, 'message' => 'Unable to update company logo. Please check your internet connection and try again' );
                    return response()->json($response_message);
                } 
            } 
        }
    }

    /**
     * Reset company details
     */
    public function resetCompanyDetails(Request $request)
    {
        session_start();
        $companyId = $_SESSION['company_id'];
        $company = Company::find($companyId);

        if ($company) {
            $company->name = $request->name;
            $company->email = $request->email;
            $company->location = $request->location;
            $company->phone = $request->phone;

            if ($company->save()) {
                $_SESSION['company_name'] = $request->name;
                $response_message =  array('success' => true, 'message' => 'Company details updated successfully' );
                return response()->json($response_message);
            } else {
                $response_message =  array('success' => false, 'message' => 'Unable to update company details. Please check your internet connection and try again' );
                return response()->json($response_message);
            } 
        } else {
            $response_message =  array('success' => false, 'message' => 'Invalid company request' );
                return response()->json($response_message);
        }
    }

    /**
     * Reset company password
     */
    public function resetCompanyPassword(Request $request)
    {
        session_start();
        $companyId = $_SESSION['company_id'];
        $company = Company::find($companyId);

        if ($company) {
            if ($company->save()) {
                $oldUserPassword = $company->password;
                if (password_verify($request->currentPassword, $oldUserPassword)) {
                    $newUserPassword = password_hash($request->newPassword, PASSWORD_DEFAULT);
                    $company->password = $newUserPassword;
                    $company->save();
                    $response_message =  array('success' => true, 'message' => 'Password changed successfully');
                    return response()->json($response_message);
                } else {
                    $response_message =  array('success' => false, 'message' => 'Your current password is incorrect');
                    return response()->json($response_message);
                }
            } else {
                $response_message =  array('success' => false, 'message' => 'Unable to update company password. Please check your internet connection and try again' );
                return response()->json($response_message);
            } 
        } else {
            $response_message =  array('success' => false, 'message' => 'Invalid company request' );
                return response()->json($response_message);
        }
    }


    /**
     * Get dashboard guest rate data
     */
    public function getDashboardGuestRateGraph()
    {
        session_start();
        $companyId = $_SESSION['company_id'];

        $yearMonthData = array();
        $yearMonthNumberData = array();

        $yearMonth = DB::select("SELECT DISTINCT YEAR(time_in) AS yr, MONTH(time_in) AS mn FROM guests WHERE host_company = $companyId ORDER BY YEAR(time_in) DESC LIMIT 12");
        foreach ($yearMonth as $key => $value) {
            $year = $value->yr;
            $month = $value->mn;

            $dateObj   = \DateTime::createFromFormat('!m', intval($month));
            $monthName = $dateObj->format('M');

            $numberOfGuestsForYearMonth = DB::select("SELECT COUNT(*) AS num_of_guests FROM guests WHERE YEAR(time_in) = '$year' AND MONTH(time_in) = '$month' AND host_company = $companyId");

            array_push($yearMonthData, "$monthName $year");
            array_push($yearMonthNumberData, $numberOfGuestsForYearMonth[0]->num_of_guests);
        }

        $data = array('label' => $yearMonthData, 'data' => $yearMonthNumberData);

        $response_message =  array('success' => true, 'message' => 'Data retreived', 'data' => $data);
    	return response()->json($response_message);
    }
}
