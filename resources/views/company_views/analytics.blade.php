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

                <li class="active">
                    <a href="#"><i class="menu-icon fa fa-bar-chart"></i>Analytics </a>
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
        <h1>analytics</h1>
    </div>

</div>
@endsection

@section('javascript')
	<script type="text/javascript" src="{{ asset('js/constants.js') }}"></script>
@endsection
