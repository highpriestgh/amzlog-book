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

                <li class="active">
                    <a href="#"><i class="menu-icon fa fa-send-o"></i>Send Messages </a>
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
        <div class="company-messages-res"></div>
        <div class="btn btn-float rounded-circle pulse" data-target="#send-message-modal" data-toggle="modal"><small><i class="fa fa-send-o"></i></small></div>
    </div>

    <div class="modal fade" id="send-message-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Send Message</h5>
                </div>
            <div class="modal-body">
                <form class="send-message-form">
                    <div class="form-group">
                        <select class="form-control form-control-sm send-message-type">
                            <option selected disabled>Choose Receipents</option>
                            <option value="guests">Guests</option>
                            <option value="employees">Employees</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <textarea class="form-control form-control-sm send-message-content" placeholder="Your message..."></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-custom add-btn">Send Message</button>
                <button type="button" class="btn btn-sm btn-info" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
        </div>
    </div>  

</div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/constants.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/controllers/user/send-messages-controller.js') }}"></script>
@endsection
