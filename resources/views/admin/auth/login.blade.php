@extends('admin.auth.layouts.app')

@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-v1 px-2">
                    <div class="auth-inner py-2">
                        <!-- Login v1 -->
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="javascript:void(0);" class="brand-logo">
                                    {{-- <img src="{{asset('assets/images/Dash-logo.png')}}" alt="" style=" width: 200px; /* width of container */
    height: 100px; /* height of container */
    object-fit: cover;"> --}}
                                    {{--                <h2 class="brand-text text-primary ml-1">{{config('app.name')}}</h2>--}}
                                </a>
                                @if(session()->has('error'))
                                    <div class="alert alert-danger">
                                        <p class="alert-body">{{session('error')}}</p>
                                    </div>
                                @endif
                                <h4 class="card-title mb-1">{{__('labels.login.welcome-message')}}</h4>
                                <p class="card-text mb-2">{{__('labels.login.welcome-text')}}</p>

                                <form class="auth-login-form mt-2" action="{{route('admin.login')}}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="login-email" class="form-label">{{__('labels.fields.email')}}</label>
                                        <input type="text" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror" id="login-email" name="email" placeholder="john@example.com" aria-describedby="login-email" tabindex="1" autofocus />
                                        @error('email')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="d-flex justify-content-between">
                                            <label for="login-password">{{__('labels.fields.password')}}</label>
                                            <a href="{{route('admin.forgot.password.email')}}">
                                                <small>{{__('messages.static.forgot_password')}}</small>
                                            </a>
                                        </div>
                                        <div class="input-group input-group-merge form-password-toggle @error('password') is-invalid @enderror">
                                            <input type="password" class="form-control form-control-merge @error('password') error @enderror" id="login-password" name="password" tabindex="2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                            <div class="input-group-append">
                                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                            </div>

                                        </div>
                                        @error('password') <span class="error invalid-feedback">{{$message}}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" name="remember_me" type="checkbox" id="remember-me" tabindex="3" />
                                            <label class="custom-control-label" for="remember-me"> {{__('labels.login.remember_me')}} </label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-block" tabindex="4">{{__('labels.login.login')}} </button>
                                </form>

                                <p class="text-center mt-2">
                                    <span>{{__('messages.static.forgot_password')}}</span>
                                    <a href="{{route('admin.forgot.password.email')}}">
                                        <span>{{__('labels.login.create-password')}}</span>
                                    </a>
                                </p>
                            </div>
                        </div>
                        <!-- /Login v1 -->
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
