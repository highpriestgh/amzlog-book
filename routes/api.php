<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/v1/')->group(function() {
    // login company account via mobile
    Route::post('/login-company-account', 'AuthController@loginCompanyAccountViaMobile');

    // get list of departments of a company
    Route::get('/get-company-departments/{companyId}', 'APIController@getCompanyDepartments')->middleware('checkMobileAPIAuth');

    // get company department by ID
    Route::get('/get-company-department/{companyId}/{departmentId}', 'APIController@getCompanyDepartmentById')->middleware('checkMobileAPIAuth');

    // get list of employees of a company
    Route::get('/get-company-employees/{companyId}', 'APIController@getCompanyEmployees')->middleware('checkMobileAPIAuth');

    // get company employee by ID
    Route::get('/get-company-employee/{companyId}/{employeeId}', 'APIController@getCompanyEmployeeById')->middleware('checkMobileAPIAuth');


    // log guest details
    Route::post('/log-guest-details', 'APIController@logGuestDetails')->middleware('checkMobileAPIAuth');

    // get guest details by phone number
    Route::get('/get-guest-details-by-phone-number/{phoneNumber}', 'APIController@getGuestDetailsByPhoneNumber')->middleware('checkMobileAPIAuth');

    // login employee attendance
    Route::post('/login-employee-attendance', 'APIController@loginEmployeeAttendance')->middleware('checkMobileAPIAuth');

    // logout employee attendance
    Route::post('/logout-employee-attendance', 'APIController@logoutEmployeeAttendance')->middleware('checkMobileAPIAuth');

    // logout guest
    Route::post('/logout-guest', 'APIController@logoutGuest')->middleware('checkMobileAPIAuth');
});
