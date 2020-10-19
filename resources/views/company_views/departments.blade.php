@extends('layouts.app')

@section('stylesheet')
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

                <li class="active">
                    <a href="#"><i class="menu-icon fa fa-list-alt"></i>Departments </a>
                </li>

                <li>
                    <a href="/company/employees"><i class="menu-icon fa fa-users text-pink"></i>Employees </a>
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
        <div class="company-departments-res"></div>
        <div class="btn btn-float rounded-circle pulse" data-target="#add-department-modal" data-toggle="modal">+</div>
    </div>

</div>

<!-- Add company modal -->
<div class="modal fade" id="add-department-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Company Department</h5>
        </div>
        <div class="modal-body">
            <form class="add-department-form">
                <div class="form-group">
                    <label><small>Department Name:</small></label>
                    <input type="text" class="form-control form-control-sm department-name">
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

<!-- Edit department modal -->
<div class="modal fade" id="edit-department-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Company Department</h5>
        </div>
        <div class="modal-body">
            <form class="edit-department-form">
                <input type="hidden" class="edit-department-id">
                <div class="form-group">
                    <label><small>Department Name:</small></label>
                    <input type="text" class="form-control form-control-sm edit-department-name">
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
@endsection

@section('javascript')
	<script type="text/javascript" src="{{ asset('js/constants.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/controllers/user/company-departments-controller.js') }}"></script>
@endsection
