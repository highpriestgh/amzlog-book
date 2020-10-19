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
            <div class="col-md-1"></div>
            <div class="col-md-7 intro-img-animation hide-div">
                <img src="{{ asset('images/intro-img.svg') }}" class="img-fluid intro-img" alt="">
            </div>
            <div class="col-md-3">
                <div class="auth-form-div intro-form-animation hide-div">
                    <div class="auth-img-div">
                        <img src="{{ asset('images/logo.png') }}" class="auth-logo">
                        <h5><small><b>ACCOUNT LOGIN</b></small></h5>
                    </div><br>
                    <form class="user-login-form">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-sm user-email" placeholder="email address">
                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control form-control-sm user-password" placeholder="password">
                        </div>

                        <div class="row">
                            <div class="col-5">
                                <button class="btn btn-sm btn-custom btn-block auth-btn">Log In</button>
                            </div>
                            <div class="col-7">
                                <p class="text-right"><small> <a href="/forgot-password"><small><b>Forgotten Password?</b></small></a></small></p>
                            </div>
                        </div><br>
                    </form>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
@endsection

@section('javascript')
	<script type="text/javascript" src="{{ asset('js/constants.js') }}"></script>
	<script type="text/javascript" src="{{ asset('js/anime.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/index-anim.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/controllers/user/user-auth-controller.js') }}"></script>
@endsection
