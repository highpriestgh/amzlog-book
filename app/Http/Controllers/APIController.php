<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use JD\Cloudder\Facades\Cloudder;
use App\Helpers\CustomSMS;
use App\Helpers\HelperFunctions;

use App\Models\Company;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Guest;
use App\Models\EmployeeLog;

class APIController extends Controller
{
    /**
     * Get company departments
     */
    public function getCompanyDepartments($companyId)
    {
        $companyDepartments = Department::select('id', 'name')->where('company_id', $companyId)->orderBy('name')->get();
        $response_message =  array('success' => true, 'message' => "Data fetched", 'data' => $companyDepartments);
        return response()->json($response_message);
    }
    

    /**
     * Get company department by ID
     */
    public function getCompanyDepartmentById($companyId, $departmentId)
    {
        $companyDepartment = Department::select('id', 'name')->find($departmentId);
        if ($companyDepartment) {
            $response_message =  array('success' => true, 'message' => "Data fetched", 'data' => $companyDepartment);
            return response()->json($response_message);
        } else {
            $response_message =  array('success' => false, 'message' => "Department not found");
            return response()->json($response_message);
        }
        
        
    }


    /**
     * Get company employees
     */
    public function getCompanyEmployees($companyId)
    {
        $companyEmployees = Employee::select('id', 'first_name', 'last_name', 'thumbnail')->where('company', $companyId)->orderBy('first_name')->get();
        $response_message =  array('success' => true, 'message' => "Data fetched", 'data' => $companyEmployees);
        return response()->json($response_message);
    }


    /**
     * Get company employee by ID
     */
    public function getCompanyEmployeeById($companyId, $employeeId)
    {
        $companyEmployee = Employee::select('id', 'first_name', 'last_name', 'thumbnail')->find($employeeId);
        if ($companyEmployee) {
            $response_message =  array('success' => true, 'message' => "Data fetched", 'data' => $companyEmployee);
            return response()->json($response_message);
        } else {
            $response_message =  array('success' => false, 'message' => "Employee not found");
            return response()->json($response_message);
        }
        
    }


    /**
     * Log guest details
     */
    public function logGuestDetails(Request $request)
    {
        $helperFunction = new HelperFunctions();
        $guest = new Guest();
        $guest->name = $request->name;
        $guest->phone = $request->phone;
        $guest->origin = $request->origin;
        $guest->host_company =  $request->hostCompany;
        $guest->host_department = $request->hostDepartment;
        $guest->host = $request->host;
        $guest->visit_reason = $request->visitReason;
        $guest->code = $helperFunction->generateGuestCode();

        // upload guest photo
        $public_id = 'guest_thumbnail_'.substr(time(), 0, 5);
        Cloudder::upload($request->thumbnail,$public_id , array('folder'=> 'logbook/companies/'.$request->hostCompany.'/guest_photos', 'invalidate' => true));
        $upload_result = Cloudder::getResult();

        // add thumbnail property after photo upload
        if ($upload_result) {
            $guest->thumbnail = $upload_result['secure_url'];
        } else {
            $guest->thumbnail = 'https://res.cloudinary.com/amazing-technologies/image/upload/v1557928971/logbook/default_images/profile-picture.png';
        }
        
        // check if guest details was saved successfully or not
        if ($guest->save()) {
            // get the name of the host
            $host = Employee::find($request->host);
            $hostName = $host->first_name.' '.$host->last_name;

            // get company name
            $companyName = Company::find($request->hostCompany)->name;

            // send SMS to employee notifying him of visitor
            $messageBody = "Hello $hostName, $request->name is waiting for you at the reception of $companyName.";
            $customSMS = new CustomSMS();
            $sendSMS = $customSMS->sendSMS($host->phone, $messageBody);

            $data = array('guestCode' => $guest->code);

            $response_message =  array('success' => true, 'message' => 'Guest details logged successfully', 'data' => $data);
            return response()->json($response_message);
        } else {
            $response_message =  array('success' => false, 'message' => 'Unable to log guest details. Please check your internet connection and try again' );
            return response()->json($response_message);
        }
        
    }


    /**
     * Get guest details by phone number
     */
    public function getGuestDetailsByPhoneNumber($phoneNumber)
    {
        $guest = Guest::where('phone', $phoneNumber)->orderBy('id', 'DESC')->first();
        if ($guest) {
            $response_message =  array('success' => true, 'message' => "Data fetched", 'data' => $guest);
            return response()->json($response_message);
        } else {
            $response_message =  array('success' => false, 'message' => "Guest data not found");
            return response()->json($response_message);
        }
    }


    /**
     * Logout guest
     */
    public function logoutGuest(Request $request)
    {
        // get guest object by guest code
        $guest = Guest::where('code', $request->guestCode)->orderBy('id', 'DESC')->first();

        if ($guest) {
            // if guest code exists, get guest details and update guest time out
            if ($guest->logged_out == 'no') {
                // if guest has not already logged out proceed
                $guestName = $guest->name;
                $guestPhoneNumber = $guest->phone;
                $hostCompany = $guest->host_company;
                $guest->time_out = DB::raw('CURRENT_TIMESTAMP');
                $guest->logged_out = 'yes';

                if ($guest->save()) {
                    $hostCompanyName = Company::find($hostCompany)->name;

                    // send SMS to guest showing appreciation
                    $messageBody = "Hello $guestName, thank you for visiting $hostCompanyName.";
                    $customSMS = new CustomSMS();
                    $sendSMS = $customSMS->sendSMS($guestPhoneNumber, $messageBody);

                    $response_message =  array('success' => true, 'message' => "Thank you for visiting $hostCompanyName");
                    return response()->json($response_message);
                } else {
                    $response_message =  array('success' => false, 'message' => "Could not add department. Please try again");
                    return response()->json($response_message);
                }
            } else {
                // else if guest has already logged out, return an error message
                $response_message =  array('success' => false, 'message' => 'Guest already logged out' );
                return response()->json($response_message);
            }            
        } else {
            // else if guest code does not exist, send an error message
            $response_message =  array('success' => false, 'message' => 'Invalid guest code' );
            return response()->json($response_message);
        }
    }
   

    /**
     * Login employee Attendance
     */
    public function loginEmployeeAttendance(Request $request)
    {
        $employee = Employee::where('pass_code', $request->employeePassCode)->orderBy('id', 'DESC')->first();
        $currentDate = Date('Y-m-d');

        if ($employee) {
            $oldEmployeeLog = EmployeeLog::where(DB::raw('DATE(`time_in`)'), "$currentDate")->where('employee_id', $employee->id)->orderBy('id', 'DESC')->first();

            if ($oldEmployeeLog) {
                $response_message =  array('success' => false, 'message' => 'You have already logged in today' );
                return response()->json($response_message);
            } else {
                $employeeLog = new EmployeeLog();
                $employeeLog->company_id = $request->companyId;
                $employeeLog->employee_id = $employee->id;

                if ($employeeLog->save()) {
                    $response_message =  array('success' => true, 'message' => "Welcome $employee->first_name $employee->last_name" );
                    return response()->json($response_message);
                } else {
                    $response_message =  array('success' => false, 'message' => 'Invalid Code' );
                    return response()->json($response_message);
                }
            }
        } else {
            $response_message =  array('success' => false, 'message' => 'Invalid Code' );
            return response()->json($response_message);
        }
    }


    /**
     * Logout employee attendance
     */
    public function logoutEmployeeAttendance(Request $request)
    {   
        $employee = Employee::where('pass_code', $request->employeePassCode)->orderBy('id', 'DESC')->first();
        if ($employee) {
            $currentDate = Date('Y-m-d');
            $employeeLog = EmployeeLog::where('company_id', $request->companyId)->where('employee_id', $employee->id)->orderBy('id', 'DESC')->first();
            if ($employeeLog) {
                if (substr($employeeLog->time_in, 0, 10) != "$currentDate") {
                    $response_message =  array('success' => false, 'message' => 'You have not logged in today' );
                    return response()->json($response_message);
                } else {
                    if ($employeeLog->time_out != '1000-01-01 00:00:00') {
                        $response_message =  array('success' => false, 'message' => 'You have already logged out today' );
                        return response()->json($response_message);
                    } else {
                        $employeeLog->time_out = DB::raw('CURRENT_TIMESTAMP');
                        if ($employeeLog->save()) {
                            $response_message =  array('success' => true, 'message' => "You've successfully logged out." );
                            return response()->json($response_message);
                        } else {
                            $response_message =  array('success' => false, 'message' => "Could not log out" );
                            return response()->json($response_message);
                        }
                    }
                }
            } else {
                $response_message =  array('success' => false, 'message' => 'Invalid Code' );
                return response()->json($response_message);
            }
            
        } else {
            $response_message =  array('success' => false, 'message' => 'Invalid Code' );
            return response()->json($response_message);
        }
    }
}
