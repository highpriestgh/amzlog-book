@extends('layouts.app')

@section('stylesheet')
    <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
    <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.bootstrap.min.css">
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

                <li class="active">
                    <a href="#"><i class="menu-icon fa fa-child"></i>Guest Logs </a>
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
        <div class="row">
            <div class="col-12 company-guest-logs-res"></div>
        </div>
    </div>

</div>

<div class="modal fade" id="view-guest-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Visit Details</h5>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-5">
                    <img src="" alt="guest profile image" class="img-fluid guest-thumbnail">
                </div>
                <div class="col-7">
                    <table class="table">
                        <tr>
                            <th col='scope'>Guest Name</th>
                            <td><span class="guest-name"></span></td>
                        </tr>

                        <tr>
                            <th col='scope'>Guest Origin</th>
                            <td><span class="guest-origin"></span></td>
                        </tr>

                        <tr>
                            <th col='scope'>Guest Code</th>
                            <td><span class="guest-code"></span></td>
                        </tr>

                        <tr>
                            <th col='scope'>Host Name</th>
                            <td><span class="guest-host-name"></span></td>
                        </tr>
                        

                        <tr>
                            <th col='scope'>Host Department</th>
                            <td><span class="guest-host-dept"></span></td>
                        </tr>

                        <tr>
                            <th col='scope'>Visit Reason</th>
                            <td><span class="guest-visit-reason"></span></td>
                        </tr>

                        <tr>
                            <th col='scope'>Time In</th>
                            <td><span class="guest-time-in"></span></td>
                        </tr>

                        <tr>
                            <th col='scope'>Time Out</th>
                            <td><span class="guest-time-out"></span></td>
                        </tr>

                        <tr>
                            <th col='scope'>Logged Out</th>
                            <td><span class="guest-logged-out"></span></td>
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
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/controllers/user/company-guest-logs-controller.js') }}"></script>
@endsection
