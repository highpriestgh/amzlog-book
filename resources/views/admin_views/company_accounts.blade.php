@extends('layouts.app')

@section('stylesheet')
@endsection

@section('content')
<aside id="left-panel" class="left-panel admin-left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">

                <li>
                    <a href="/admin/dashboard"><i class="menu-icon fa fa-pie-chart"></i>Dashboard </a>
                </li>

                <li class="active">
                    <a href="#"><i class="menu-icon fa fa-building-o"></i>Company Accounts </a>
                </li>

                <li>
                    <a href="/admin/report"><i class="menu-icon fa fa-bar-chart text-warning"></i>Report </a>
                </li>

                <li>
                    <a href="/admin/logout"><i class="menu-icon fa fa-power-off text-danger"></i>Logout </a>
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
                        <i class="fa fa-user-circle-o"></i> &nbsp;<small>{{ $username }} <i class="fa fa-caret-down"></i> </small>
                    </a>

                    <div class="user-menu dropdown-menu">
                        <a class="nav-link" href="/admin/logout"><i class="fa fa-power-off"></i>Logout</a>
                    </div>
                </div>

            </div>
        </div>
    </header><!-- /header -->
    <!-- Header-->

    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="company-accounts-res"></div>
            </div>
        </div>
        <div class="btn btn-float rounded-circle pulse" data-target="#add-company-account-modal" data-toggle="modal">+</div>
    </div>

    <!-- Add company modal -->
    <div class="modal fade" id="add-company-account-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Company Account</h5>
            </div>
            <div class="modal-body">
                <form class="add-company-account-form">
                    <div class="form-group">
                        <label><small>Company Name:</small></label>
                        <input type="text" class="form-control form-control-sm company-name">
                    </div>

                    <div class="form-group">
                        <label><small>Company Email Address:</small></label>
                        <input type="email" class="form-control form-control-sm company-email">
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

    <!-- View company modal -->
    <div class="modal fade" id="view-company-account-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Company Details</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <img  alt="Logo" class="img-fluid company-details-img company-details-thumbnail">
                    </div>
                    <div class="col-md-7">
                        <table class="table">
                            <tr>
                                <th scope="col">Name</th>
                                <td class="img-fluid company-details-name"></td>
                            </tr>

                            <tr>
                                <th scope="col">Email</th>
                                <td class="img-fluid company-details-email"></td>
                            </tr>

                            <tr>
                                <th scope="col">Phone</th>
                                <td class="img-fluid company-details-phone"></td>
                            </tr>

                            <tr>
                                <th scope="col">Location</th>
                                <td class="img-fluid company-details-location"></td>
                            </tr>
                            <tr>
                                <th scope="col">Active</th>
                                <td class="img-fluid company-details-active"></td>
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

</div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/admin-constants.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/controllers/admin/admin-companies-controller.js') }}"></script>
@endsection
