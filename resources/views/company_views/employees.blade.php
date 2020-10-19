@extends('layouts.app')

@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.min.css') }}">
@endsection

@section('content')
<aside id="left-panel" class="left-panel admin-left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">

                <li>
                    <a href="/company/dashboard"><i class="menu-icon fa fa-pie-chart"></i>Dashboard </a>
                </li>

                <li>
                    <a href="/company/analytics"><i class="menu-icon fa fa-bar-chart text-blue"></i>Analytics </a>
                </li>

                <li>
                    <a href="/company/employee-logs"><i class="menu-icon fa fa-id-badge text-info"></i>Employee Logs</a>
                </li>

                <li>
                    <a href="/company/guest-logs"><i class="menu-icon fa fa-child text-orange"></i>Guest Logs </a>
                </li>

                <li>
                    <a href="/company/departments"><i class="menu-icon fa fa-list-alt text-violet"></i>Departments </a>
                </li>

                <li class="active">
                    <a href="#"><i class="menu-icon fa fa-users"></i>Employees </a>
                </li>

                <li>
                    <a href="/company/send-messages"><i class="menu-icon fa fa-send-o text-blue"></i>Send Messages </a>
                </li>

                <li>
                    <a href="/company/account-settings"><i class="menu-icon fa fa-cogs text-warning"></i>Account Settings </a>
                </li>

                <li>
                    <a href="/company/logout"><i class="menu-icon fa fa-power-off text-danger"></i>Logout </a>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>


<!-- Right Panel -->
<div id="right-panel" class="right-panel">

    <!-- Header-->
    <header id="header" class="header admin-header">
        <div class="top-left">
            <div class="navbar-header">
                <a class="navbar-brand" href="#"><img src="{{ asset('images/logo-2.png') }}" class="nav-logo" alt="Logo"></a>
                <a class="navbar-brand hidden" href="./"><img src="{{ asset('images/logo-2.png') }}" class="nav-logo" alt="Logo"></a>
                <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
            </div>
        </div>
        <div class="top-right">
            <div class="header-menu">

                <div class="user-area dropdown float-right">
                    <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ $logo }}" alt="logo" class="img-fluid rounded-circle nav-company-logo"> &nbsp;<small>{{ $username }} <i class="fa fa-caret-down"></i> </small>
                    </a>

                    <div class="user-menu dropdown-menu">
                        <a class="nav-link" href="/company/account-settings"><i class="fa fa-cogs"></i>Account Settings</a>
                        <a class="nav-link" href="/company/logout"><i class="fa fa-power-off"></i>Logout</a>
                    </div>
                </div>

            </div>
        </div>
    </header><!-- /header -->
    <!-- Header-->

    <div class="content">
        <div class="row company-employees-res"></div>
        <div class="btn btn-float rounded-circle pulse" data-target="#add-employee-modal" data-toggle="modal">+</div>
    </div>

</div>

<!-- Add employee modal -->
<div class="modal fade" id="add-employee-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Employee</h5>
        </div>
        <div class="modal-body">
            <form class="add-employee-form">
                <div class="row">
                    <div class="col-6">
                        <img src="" class="add-employee-thumbnail-res img-fluid">
                        <label for="add-employee-thumbnail" class="btn btn-secondary btn-block add-employee-thumbnail-label"><small>Employee Profile Pic</small></label>
                        <input type="file" name="editArticleThumbnail" id="add-employee-thumbnail" accept="image/*" class="add-employee-thumbnail">
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-6">
                        <label><small>First Name:</small></label>
                        <input type="text" class="form-control form-control-sm employee-first-name" required>
                    </div>
                    <div class="col-6">
                        <label><small>Last Name:</small></label>
                        <input type="text" class="form-control form-control-sm employee-last-name" required>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-6">
                        <label><small>Email Address:</small></label>
                        <input type="email" class="form-control form-control-sm employee-email" required>
                    </div>
                    <div class="col-6">
                        <label><small>Phone Number (e.g +233 ...):</small></label>
                        <input type="text" class="form-control form-control-sm employee-phone" required>
                    </div>
                </div><br>

                <div class="form-group">
                    <label><small>Date of Birth:</small></label>
                    <input type="text" class="form-control form-control-sm date-input employee-dob" required>
                </div>

                

                <div class="form-group">
                    <label><small>Employee (Staff) Number:</small></label>
                    <input type="text" class="form-control form-control-sm employee-number" required>
                </div>

                <div class="form-group">
                    <label><small>Department:</small></label>
                    <select class="form-control form-control-sm employee-departments-res employee-dept" required></select>
                </div>

                <div class="form-group">
                    <label><small>Type of Employee:</small></label>
                    <select class="form-control form-control-sm employee-type" required>
                        <option disabled selected>Select Type of Employment</option>
                        <option value="full_time">Full Time</option>
                        <option value="part_time">Part Time</option>
                        <option value="contract">Contract</option>
                    </select>
                </div>

                <div class="form-group">
                    <label><small>Position:</small></label>
                    <input type="text" class="form-control form-control-sm employee-position" required>
                </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-custom add-btn">Add</button>
            <button type="button" class="btn btn-sm btn-info" data-dismiss="modal">Cancel</button>
            </form>
        </div>
    </div>
    </div>
</div>

<!-- update employee modal -->
<div class="modal fade" id="edit-employee-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Employee Details</h5>
        </div>
        <div class="modal-body">
            <form class="edit-employee-form">
                <input type="hidden" class="edit-employee-id">
                <div class="row">
                    <div class="col-6">
                        <img src="" class="edit-employee-thumbnail-res img-fluid">
                        <label for="edit-employee-thumbnail" class="btn btn-secondary btn-block edit-employee-thumbnail-label"><small>Employee Profile Pic</small></label>
                        <input type="file" name="editArticleThumbnail" id="edit-employee-thumbnail" accept="image/*" class="edit-employee-thumbnail">
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-6">
                        <label><small>First Name:</small></label>
                        <input type="text" class="form-control form-control-sm edit-employee-first-name" required>
                    </div>
                    <div class="col-6">
                        <label><small>Last Name:</small></label>
                        <input type="text" class="form-control form-control-sm edit-employee-last-name" required>
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-6">
                        <label><small>Email Address:</small></label>
                        <input type="email" class="form-control form-control-sm edit-employee-email" required>
                    </div>
                    <div class="col-6">
                        <label><small>Phone Number (e.g +233 ...):</small></label>
                        <input type="text" class="form-control form-control-sm edit-employee-phone" required>
                    </div>
                </div><br>

                <div class="form-group">
                    <label><small>Date of Birth:</small></label>
                    <input type="text" class="form-control form-control-sm date-input edit-employee-dob" required>
                </div>

                

                <div class="form-group">
                    <label><small>Employee (Staff) Number:</small></label>
                    <input type="text" class="form-control form-control-sm edit-employee-number" required>
                </div>

                <div class="form-group">
                    <label><small>Department:</small></label>
                    <select class="form-control form-control-sm employee-departments-res edit-employee-dept" required></select>
                </div>

                <div class="form-group">
                    <label><small>Type of Employee:</small></label>
                    <select class="form-control form-control-sm edit-employee-type" required>
                        <option disabled selected>Select Type of Employment</option>
                        <option value="full_time">Full Time</option>
                        <option value="part_time">Part Time</option>
                        <option value="contract">Contract</option>
                    </select>
                </div>

                <div class="form-group">
                    <label><small>Position:</small></label>
                    <input type="text" class="form-control form-control-sm edit-employee-position" required>
                </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-custom edit-btn">Update</button>
            <button type="button" class="btn btn-sm btn-info" data-dismiss="modal">Cancel</button>
            </form>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="view-employee-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Employee Details</h5>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-5">
                    <img src="" alt="employee profile image" class="img-fluid employee-detail-img">
                </div>
                <div class="col-7">
                    <table class="table">
                        <tr>
                            <th col='scope'>Name</th>
                            <td><span class="employee-name"></span></td>
                        </tr>

                        <tr>
                            <th col='scope'>Email</th>
                            <td><span class="employee-email"></span></td>
                        </tr>

                        <tr>
                            <th col='scope'>Phone</th>
                            <td><span class="employee-phone"></span></td>
                        </tr>

                        <tr>
                            <th col='scope'>Date Of Birth</th>
                            <td><span class="employee-dob"></span></td>
                        </tr>

                        <tr>
                            <th col='scope'>(Staff) Number</th>
                            <td><span class="employee-number"></span></td>
                        </tr>

                        <tr>
                            <th col='scope'>Department</th>
                            <td><span class="employee-department"></span></td>
                        </tr>

                        <tr>
                            <th col='scope'>Position</th>
                            <td><span class="employee-position"></span></td>
                        </tr>

                        <tr>
                            <th col='scope'>Account Active</th>
                            <td><span class="employee-active"></span></td>
                        </tr>

                        <tr>
                            <th col='scope'>Employment Type</th>
                            <td><span class="employee-type"></span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-info" data-dismiss="modal">Okay</button>
        </div>
    </div>
    </div>
</div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/constants.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/controllers/user/company-employees-controller.js') }}"></script>
    <script>
        jQuery(".date-input").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            clearBtn: true,
            todayHighlight: true,
            endDate: '0d'
        });
    </script>
@endsection
