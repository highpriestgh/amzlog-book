<?php

use JD\Cloudder\Facades\Cloudder;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('/')->group(function() {
    // render index page
    Route::get('/', 'AuthController@renderLoginPage');

    // render login page
    Route::get('/login', 'AuthController@renderLoginPage');

    // login user account
    Route::post('/login-user', 'AuthController@loginUserAccount');

    // render company account activation page
    Route::get('/account-activation', 'AuthController@renderAccountActivationPage');

    // activate company account
    Route::post('/activate-company-account', 'AuthController@activateCompanyAccount');
});


/**
 * Routes for the /admin path
 */
Route::prefix('admin')->group(function() {
    // redirect to admin signup page
    Route::get('/', 'AuthController@renderLoginPage');

    // render the admin signup page
    Route::get('/signup', 'AdminController@renderAdminSignupPage');

    // create admin account
    Route::post('/signup', 'AuthController@createAdminAccount');

    // render admin dashboard page
    Route::get('/dashboard', 'AdminController@renderDashboardPage')->middleware('checkAdminAuth');

    // render admin company accounts page
    Route::get('/company-accounts', 'AdminController@renderCompanyAccountsPage')->middleware('checkAdminAuth');

    // render admin report page
    Route::get('/report', 'AdminController@renderReportPage')->middleware('checkAdminAuth');

    // logout admin account
    Route::get('/logout', 'AuthController@logoutAdminAccount');

    // register company account
    Route::post('/register-company-account', 'AdminController@registerCompanyAccount');

    // get all company accounts
    Route::get('/get-company-accounts', 'AdminController@getAllCompanyAccounts');

    // toggle company account status
    Route::post('/toggle-company-account', 'AdminController@toggleCompanyAccountStatus');

});

/**
 * Routes for the /company path
 */
Route::prefix('company')->group(function() {
    // render company dashboard page
    Route::get('/dashboard', 'CompanyController@renderDashboardPage')->middleware('checkCompanyAuth');

    // render company analytics page
    Route::get('/analytics', 'CompanyController@renderAnalyticsPage')->middleware('checkCompanyAuth');

    // render the employee logs page
    Route::get('/employee-logs', 'CompanyController@renderEmployeeLogsPage')->middleware('checkCompanyAuth');

    // render the guest logs page
    Route::get('/guest-logs', 'CompanyController@renderGuestLogsPage')->middleware('checkCompanyAuth');

    // render company departments page
    Route::get('/departments', 'CompanyController@renderDepartmentsPage')->middleware('checkCompanyAuth');

    // render company employees page
    Route::get('/employees', 'CompanyController@renderEmployeesPage')->middleware('checkCompanyAuth');

    // render company account settings page
    Route::get('/account-settings', 'CompanyController@renderAccountSettingsPage')->middleware('checkCompanyAuth');

    // render the send messages page
    Route::get('/send-messages', 'CompanyController@renderSendMessagesPage')->middleware('checkCompanyAuth');

    // add company department
    Route::post('/add-company-department', 'CompanyController@addCompanyDepartment');

    // edit company department
    Route::post('/edit-company-department', 'CompanyController@editCompanyDepartment');

    // get company departments
    Route::get('/get-departments', 'CompanyController@getCompanyDepartments');

    // delete company department
    Route::post('/delete-company-department', 'CompanyController@deleteCompanyDepartment');

    // add company employee
    Route::post('/add-company-employee', 'CompanyController@addCompanyEmployee');

    // edit company employee
    Route::post('/edit-company-employee', 'CompanyController@editCompanyEmployee');

    // get company employees
    Route::get('/get-company-employees', 'CompanyController@getCompanyEmployees');

    // delete company employee
    Route::post('/delete-company-employee', 'CompanyController@deleteCompanyEmployee');

    // toggle employee active status
    Route::post('/toggle-company-employee-active-status', 'CompanyController@toggleCompanyEmployeeActiveStatus');

    // reset company logo
    Route::post('/reset-company-logo', 'CompanyController@resetCompanyLogo');

    // reset company details
    Route::post('/reset-company-details', 'CompanyController@resetCompanyDetails');

    // reset company password
    Route::post('/reset-company-password', 'CompanyController@resetCompanyPassword');

    // get company guest logs
    Route::get('/get-company-guest-logs', 'CompanyController@getCompanyGuestLogs');

    // send company message
    Route::post('/send-message', 'CompanyController@sendCompanyMessage');

    // get sent company messages
    Route::get('/get-sent-company-messages', 'CompanyController@getSentCompanyMessages');

    // get company employee logs
    Route::get('/get-company-employee-attendance-logs', 'CompanyController@getCompanyEmployeeAttendanceLogs');

    // notify company host of overstay
    Route::post('/notify-company-host', 'CompanyController@notifyCompanyHost');

    // get dashboard guest rate
    Route::get('/get-dashboard-guest-rate-data', 'CompanyController@getDashboardGuestRateGraph');

    // logout of company account
    Route::get('/logout', 'AuthController@logoutCompanyAccount');
});