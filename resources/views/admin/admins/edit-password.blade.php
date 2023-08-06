@extends('admin.layouts.app')

@section('title',__('messages.static.edit-item',['name' => __('labels.fields.password')]))


@section('content')

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">{{__('messages.static.edit')}}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin.dashboard')}}">{{__('labels.fields.dashboard')}}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin.admins.index')}}">{{__('messages.static.list',['name'=> trans_choice('labels.models.admin',2)])}}</a>
                                    </li>

                                    <li class="breadcrumb-item active">
                                        {{__('messages.static.edit')}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <div class="row" id="table-head">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <button title="{{__('messages.static.back')}}" onclick="document.location = '{{url()->previous()}}'" type="button" class="btn btn-icon btn-outline-info">
                                    <i data-feather='arrow-right'></i>
                                </button>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{__('messages.static.edit')}}</h4>
                                    </div>
                                    <div class="card-body">
                                        <form class="form form-horizontal" method="post" action="{{route('admin.admins.update-password', $admin->id)}}">
                                            @csrf
                                            @method('put')
                                            <div class="row">

                                                <div class="col-12 mb-2">
                                                    <label class="col-12" for="password">{{__('labels.fields.password')}}</label>
                                                    <div class="input-group form-password-toggle col-12 mb-2">
                                                        <input type="password"
                                                               class="form-control @error('password') is-invalid @enderror"
                                                               required name="password" value="{{old('password')}}"
                                                               id="password" placeholder="{{__('labels.fields.password')}}" />

                                                        <div class="input-group-append">
                                                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                                        </div>

                                                        @error('password')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                        @enderror
                                                    </div>

                                                </div>

                                                <div class="col-12 mb-2">
                                                    <label class="col-12" for="password_confirmation">{{__('labels.fields.password_confirmation')}}</label>
                                                    <div class="input-group form-password-toggle col-12 mb-2">
                                                        <input type="password"
                                                               class="form-control"
                                                               required name="password_confirmation" value="{{old('password_confirmation')}}"
                                                               id="password_confirmation" placeholder="{{__('labels.fields.password_confirmation')}}" />

                                                        <div class="input-group-append">
                                                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-9 offset-sm-3">
                                                    <button type="submit" class="btn btn-primary mr-1">{{__('messages.static.save')}}</button>
                                                    <button type="reset" class="btn btn-outline-secondary">{{__('messages.static.reset')}}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

