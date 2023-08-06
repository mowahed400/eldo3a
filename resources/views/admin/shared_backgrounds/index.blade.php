@extends('admin.layouts.app')

@section('title', __ ('labels.models.shared_backgrounds') )

@push('css')
    <link rel="stylesheet" href="{{asset('assets/admin/app-assets/vendors/css/forms/select/select2.min.css')}}">
@endpush

@section('content')

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0"> {{__ ('labels.models.shared_backgrounds') }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin.dashboard')}}">{{__('labels.fields.dashboard')}}</a>
                                    </li>

                                    <li class="breadcrumb-item active">
                                        {{__ ('labels.models.shared_backgrounds') }}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card">
                <div class="card-header">
                    <h1 >اضافة {{trans_choice('labels.models.shared_background', 1)}}</h1>
                </div>

                <div class="col-12">
                    <div class="card">

                        <div class="card-content">
                            <a title="Add Photo"  id="create-btn" href="{{route('admin.shared_backgrounds.create')}}"
                               class="btn btn-icon btn-outline-primary">
                                <i data-feather="plus"></i>
                            </a>
                        </div>

                        <div class="card-body">
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>الخلفية</th>
                                    <th> القسم</th>
                                    <th>{{__('labels.fields.created_at')}}</th>
                                    <th>{{__('messages.static.actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($backgrounds as $key => $background)

                                    <tr>
                                        <td>
                                            {{$key +1 }}
                                        </td>

                                        <th scope="row">
                                            <img
                                                src= "{{$background->image_url}}"  height="50"
                                                class="img-thumbnail img-fluid" width="50%"  alt="">
                                        </th>

                                        <td>
                                            <h3>
                                                {{$background->section_name}}
                                            </h3>
                                        </td>


                                        <td>
                                            {{$background->created_at}}
                                        </td>

                                        <td>
                                            <a title="{{__('messages.static.delete')}}"
                                               onclick="deleteBackground({{$background->id}})" href="{{route('admin.shared_backgrounds.delete',['id' => $background->id])}}">
                                                <i class="mr-50 fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


