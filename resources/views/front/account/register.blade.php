
@extends('front.layout.master')

@section('title','Register')

@section('body')
    <!-- -->
    <!-- Breadcrumb section begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="index.html"><i class="fa fa-home"></i>Home</a>
                        <span>Register</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb section end -->
    <!-- register section begin -->
    <div class="register-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="register-form">
                        <h2>Register</h2>
                        @if(session('notification'))
                            <div class="alert alert-warning" role="alert">
                                {{session('notification')}}
                            </div>
                        @endif
                        <form action="" method="post">
                            @csrf
                            <div class="group-input">
                                <label for="name">
                                    Name
                                </label>
                                <input type="text" id="name" name="name">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="group-input">
                                <label for="username">
                                    Email address
                                </label>
                                <input type="email" id="email" name="email">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="group-input">
                                <label for="pass">
                                    Password *
                                </label>
                                <input type="password" id="pass" name="password">
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="group-input">
                                <label for="con-pass">
                                    Confirm Password *
                                </label>
                                <input type="password" id="con-pass" name="password_comfirmation">
                                @if ($errors->has('password_comfirmation'))
                                    <span class="text-danger">{{ $errors->first('password_comfirmation') }}</span>
                                @endif
                            </div>
                            <button type="submit" class="site-btn login-btn">REGISTER</button>
                        </form>
                        <div class="switch-login">
                            <a href="./account/login" class="or-login">Or Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- register section end -->
@endsection
