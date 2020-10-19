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

                <li>
                    <a href="/company/departments"><i class="menu-icon fa fa-list-alt text-violet"></i>Departments </a>
                </li>

                <li>
                    <a href="/company/employees"><i class="menu-icon fa fa-users text-pink"></i>Employees </a>
                </li>

                <li>
                    <a href="/company/send-messages"><i class="menu-icon fa fa-send-o text-blue"></i>Send Messages </a>
                </li>

                <li class="active">
                    <a href="#"><i class="menu-icon fa fa-cogs"></i>Account Settings </a>
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
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h3><b><i class="fa fa-cogs"></i> Account Settings</b></h3><hr>

                <!-- doctor profile photo settings -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="settings-div">
                            <h5><b><i class="fa fa-user"></i> Company Logo Update</b></h5><br>
                            <form class="company-logo-update-form" enctype="multipart/form-data" method="post">
                                <div class="row">
                                    <div class="col-6">
                                        <img src="{{ $companyDetails->thumbnail }}" class="update-company-thumbnail-res img-fluid rounded-circle"><br>
                                        <label for="update-company-thumbnail" class="btn btn-secondary btn-block update-company-thumbnail-label"><small>Please select company logo </small></label>
                                        <input type="file" name="editArticleThumbnail" id="update-company-thumbnail" accept="image/*" class="update-company-thumbnail">
                                    </div>
                                    <!-- <div class="col-6">
                                        <img src="{{ $companyDetails->banner }}" class="update-company-thumbnail-res img-fluid"><br>
                                        <label for="update-company-thumbnail" class="btn btn-secondary btn-block update-company-thumbnail-label"><small>Please select company banner </small></label>
                                        <input type="file" name="editArticleThumbnail" id="update-company-thumbnail" accept="image/*" class="update-company-thumbnail">
                                    </div> -->
                                </div><br>

                                <button type="submit" class="btn btn-custom logo-reset-btn">Update</button>
                            </form>
                        </div>
                    </div>
                </div><br><br>

                <!-- doctor details settings -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="settings-div">
                            <h5><b><i class="fa fa-user"></i> Company Details Settings</b></h5><br>
                            <form class="doctor-personal-details-form" method="post">
                                <div class="form-group">
                                    <label><small>Company Name</small></label>
                                    <input type="text" class="form-control form-control-sm name" value="{{ $companyDetails->name }}">
                                </div>

                                <div class="form-group">
                                    <label><small>Email Address</small></label>
                                    <input type="text" class="form-control form-control-sm email" value="{{ $companyDetails->email }}">
                                </div>

                                <div class="form-group">
                                    <label><small>Phone</small></label>
                                    <input type="text" class="form-control form-control-sm phone" value="{{ $companyDetails->phone }}">
                                </div>

                                <div class="form-group">
                                    <label><small>Location</small></label>
                                    <input type="text" class="form-control form-control-sm location" value="{{ $companyDetails->location }}">
                                </div>

                                <button type="submit" class="btn btn-custom details-reset-btn">Update</button>
                            </form>
                        </div>
                    </div>
                </div><br><br>
                
                <!-- doctor password settings -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="settings-div">
                            <h5><b><i class="fa fa-key"></i> Password Reset</b></h5><br>
                            <form class="doctor-password-reset-form" method="post">
                                <div class="row">
                                    <div class="col-6">
                                        <label><small>Current Password</small></label>
                                        <input type="password" class="form-control form-control-sm current-password">
                                    </div>
                                </div><br>

                                <div class="row">
                                    <div class="col-6">
                                        <label><small>New Password</small></label>
                                        <input type="password" class="form-control form-control-sm new-password">
                                    </div>
                                </div><br>

                                <div class="row">
                                    <div class="col-6">
                                        <label><small>Confirm New Password</small></label>
                                        <input type="password" class="form-control form-control-sm new-password-conf">
                                    </div>
                                </div><br>

                                <button type="submit" class="btn btn-custom password-reset-btn">Update</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-2"></div>
        </div>
    </div>

</div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/constants.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/controllers/user/company-account-settings-controller.js') }}"></script>
@endsection
