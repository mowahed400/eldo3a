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
                                    <a href="javascript:void(0);" class="brand-logo">
                                        <img src="{{asset('assets/vuexy/app-assets/images/logo/logo.png')}}"  height="40px" alt="">
                                        {{--                <h2 class="brand-text text-primary ml-1">{{config('app.name')}}</h2>--}}
                                    </a>            </a>
                                @if(session()->has('status'))
                                    <div class="alert alert-success">
                                        <p class="alert-body">{{session('status')}}</p>
                                    </div>
                                @endif
                                <h4 class="card-title mb-1">{{__('messages.static.forgot_password')}}</h4>
                                <p class="card-text mb-2">{{__('messages.static.reset_text')}}</p>

                                <form class="auth-forgot-password-form mt-2" action="{{route('admin.forgot.password.send')}}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="forgot-password-email" class="form-label">{{__('labels.fields.email')}}</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="forgot-password-email" name="email" placeholder="john@example.com" aria-describedby="forgot-password-email" tabindex="1" autofocus />
                                        @error('email')
                                        <div class="invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <button class="btn btn-primary btn-block" tabindex="2">{{__('labels.login.send-reset-link')}}</button>
                                </form>

                                <p class="text-center mt-2">
                                    <a href="{{route('admin.login.index')}}"> <i data-feather="chevron-left"></i> {{__('labels.login.login')}} </a>
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
