@extends('admin.layouts.app')

@push('css')

    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/app-assets/css-rtl/pages/app-user.css')}}">

@endpush

@section('title',trans_choice('messages.static.details',2))

@section('content')

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">{{__('messages.static.view')}}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin.dashboard')}}">{{__('labels.fields.dashboard')}}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin.roles.index')}}">{{__('messages.static.list',['name'=> trans_choice('labels.models.admin',2)])}}</a>
                                    </li>

                                    <li class="breadcrumb-item active">
                                        {{__('messages.static.view')}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <section class="app-user-view">
                    <!-- User Card starts-->
                    <div class="col-md-12">
                        <div class="card user-card">
                            <div class="card-header">
                                <button title="{{__('messages.static.back')}}"
                                        onclick="document.location = '{{url()->previous()}}'" type="button"
                                        class="btn btn-icon btn-outline-info">
                                    <i data-feather='arrow-right'></i>
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div
                                        class="col-xl-6 col-lg-12 d-flex flex-column justify-content-between border-container-lg">
                                        <div class="user-avatar-section">
                                            <div class="d-flex justify-content-start">
                                                <img class="img-fluid rounded" src="{{$admin->image_url}}"
                                                     height="104" width="104" alt="User avatar"/>
                                                <div class="d-flex flex-column ml-1">
                                                    <div class="user-info mb-1">
                                                        <h4 class="mb-0">{{$admin->name}}</h4>
                                                        <span class="card-email">{{$admin->email}}</span>
                                                    </div>
                                                    <div class="d-flex flex-wrap">


                                                            <a href="{{route('admin.admins.edit', $admin->id)}}"
                                                               class="btn btn-outline-primary">
                                                                <i data-feather='edit-2'></i>
                                                            </a>

                                                            <a href="{{route('admin.admins.edit-password',$admin->id)}}" title="{{__('messages.static.edit-item',['name' => __('labels.fields.password')])}}"
                                                                class="btn btn-outline-info ml-1">
                                                                <i data-feather="lock" ></i>
                                                            </a>

                                                        @can('delete-admin')
                                                            <button class="btn btn-outline-danger ml-1"
                                                                    onclick="deleteForm({{$admin->id}})">
                                                                <i data-feather='trash-2'></i>
                                                            </button>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6  col-lg-6 mt-3 mt-xl-0">
                                        <div class="user-info-wrapper">




                                            <div class="d-flex flex-wrap">

                                                <div class="user-info-title">
                                                    <i data-feather="info" class="mr-1"></i>

                                                    <span class="card-text user-info-title font-weight-bold mb-0">
                                                        {{trans_choice('labels.models.role',2)}} :
                                                    </span>

                                                </div>

                                                <span class="invoice-number">

                                                    @foreach($admin->roles as $r)
                                                        <span class="badge badge-success">{{$r->name}}</span>
                                                    @endforeach

                                                </span>
                                            </div>


                                            <div class="d-flex flex-wrap my-50">
                                                <div class="user-info-title">
                                                    <i data-feather="calendar" class="mr-1"></i>
                                                    <span
                                                        class="card-text user-info-title font-weight-bold mb-0">{{__('labels.fields.created_at')}}</span>
                                                </div>
                                                <p class="card-text mb-0">{{$admin->created_at->format('m-d-Y')}}</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

@endsection

@push('js')

    <script src="{{asset('assets/admin/app-assets/js/scripts/pages/app-user-view.js')}}"></script>

    <script>
        const deleteForm = id => {

            Swal.fire({
                title: '{{__('messages.static.delete_confirm_title')}}',
                text: "{{__('messages.static.delete_confirm_text')}}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{__('messages.static.delete_btn_yes')}}',
                cancelButtonText: '{{__('messages.static.delete_btn_cancel')}}'
            }).then((result) => {
                if (result.value) {
                    createForm(id).submit();
                }
            });
        }
        const createForm = id => {
            let f = document.createElement("form");
            f.setAttribute('method', "post");
            f.setAttribute('action', `/admin/admins/${id}`);

            let i1 = document.createElement("input"); //input element, text
            i1.setAttribute('type', "hidden");
            i1.setAttribute('name', '_token');
            i1.setAttribute('value', '{{csrf_token()}}');

            let i2 = document.createElement("input"); //input element, text
            i2.setAttribute('type', "hidden");
            i2.setAttribute('name', '_method');
            i2.setAttribute('value', 'DELETE');

            f.appendChild(i1);
            f.appendChild(i2);
            document.body.appendChild(f);
            return f;
        }
    </script>
@endpush

