@extends('layouts.app')

@section('stylesheet')
    <style>
        body {
            /* background: url("{{ asset('images/index-background.jpg') }}") no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover; */
            background: #fff;
        }

        .site-footer {
            background: transparent;
            color: #fff;
        }

        .polymorph {
            fill: #ffd399;
        }

        @media only screen and (max-width: 768px) {
            body {
                background: url("{{ asset('images/index-background.jpg') }}") no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid auth-main-div">
        <div class="index-overlay">
            <svg viewBox="0 0 215 110">
                <polygon class="polymorph" points="215, 110 0, 110 0, 0 47.7, 0 215, 0">
            </svg>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="auth-form-div intro-form-animation hide-div">
                    <div class="auth-img-div">
                        <img src="{{ asset('images/logo.png') }}" class="auth-logo">
                        <h5><small><b>ADMIN SIGNUP</b></small></h5>
                    </div><br>
                    <form class="admin-signup-form">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-sm admin-signup-username" placeholder="admin username...">
                        </div>

                        <div class="form-group">
                            <input type="email" class="form-control form-control-sm admin-signup-email" placeholder="admin email...">
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control form-control-sm admin-signup-password" placeholder="admin password...">
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control form-control-sm admin-signup-password-conf" placeholder="admin password...">
                        </div>

                        <button class="btn btn-sm btn-custom btn-block auth-btn">Signup</button><br><br>

                        <p class="text-center"><small> <a href="<?php echo Config::get('constants.ADMIN_APP_DIRECTORY'); ?>/login">I already have an admin account</a></small></p>
                    </form>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript" src="{{ asset('js/admin-constants.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/controllers/admin/admin-auth-controller.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/anime.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/index-anim.js') }}"></script>
@endsection
