@extends('admin.layouts.app')

@section('title', __('labels.fields.dashboard'))

@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/app-assets/vendors/css/charts/apexcharts.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/assets/css/style-rtl.css')}}">

@endpush

@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Dashboard Analytics Start -->



                <!-- Stats Horizontal Card -->
                <div class="row">
                    @can('view-section')
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <h2 class="font-weight-bolder mb-0">{{$section_count}}</h2>
                                    <p class="card-text">{{trans_choice('labels.models.section',3)}}</p>
                                </div>
                                <div class="avatar bg-light-primary p-50 m-0">
                                    <div class="avatar-content">
                                        <a href="{{route('admin.sections.index')}}"><i class="font-medium-5 fas fa-flag"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan
                    </div>


                    @can('view-category')
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <h2 class="font-weight-bolder mb-0">{{$category_count}}</h2>
                                    <p class="card-text">{{trans_choice('labels.models.category',3)}}</p>
                                </div>
                                <div class="avatar bg-light-success p-50 m-0">
                                    <div class="avatar-content">
                                        <a href="{{route('admin.categories.index')}}">
                                            <i class="fas fa-check-double font-medium-5"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan

                    @can('view-content')
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <h2 class="font-weight-bolder mb-0">{{$content_count}}</h2>
                                    <p class="card-text">{{trans_choice('labels.models.content',3)}}</p>
                                </div>
                                <div class="avatar bg-light-danger p-50 m-0">
                                    <div class="avatar-content">
                                        <a href="{{route('admin.contents.index')}}">
                                            <i class="far fa-edit font-medium-5"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan

                    @can('view-paragraph')
                    <div class="col-lg-3 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <h2 class="font-weight-bolder mb-0">{{$paragraph_count}}</h2>
                                    <p class="card-text">{{trans_choice('labels.models.paragraph',3)}}</p>
                                </div>
                                <div class="avatar bg-light-warning p-50 m-0">
                                    <div class="avatar-content">
                                        <a href="{{route('admin.paragraphs.index')}}">

                                        <i class="fas fa-paragraph font-medium-5"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan


                </div>





                @can('view-shared-backgrounds')
                <div class="row">

                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <h2 class="font-weight-bolder mb-0">{{$backgrounds_count}}</h2>
                                    <p class="card-text"> {{__ ('labels.models.shared_backgrounds') }}</p>
                                </div>
                                <div class="avatar bg-light-warning p-50 m-0">
                                    <div class="avatar-content">
                                        <a href="{{ route('admin.shared_backgrounds.index') }}">
                                            <i class="fas fa-image font-medium-5"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan

                    @can('view-role')
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <h2 class="font-weight-bolder mb-0">{{$admin_count}}</h2>
                                    <p class="card-text">{{trans_choice('labels.models.admin',3)}}</p>
                                </div>
                                <div class="avatar bg-light-primary p-50 m-0">
                                    <div class="avatar-content">
                                        <a href="{{route('admin.admins.index')}}">

                                            <i class="font-medium-5 fas fa-users"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan

                    @can('view-admin')
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <h2 class="font-weight-bolder mb-0">{{$role_count}}</h2>
                                    <p class="card-text">{{trans_choice('labels.models.role',3)}}</p>
                                </div>
                                <div class="avatar bg-light-success p-50 m-0">
                                    <div class="avatar-content">
                                        <a href="{{route('admin.roles.index')}}">
                                        <i class="fas fa-user-tag font-medium-5"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan

                    @can('view-admin-notification')
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <h2 class="font-weight-bolder mb-0">{{$notification_count}}</h2>
                                    <p class="card-text">{{trans_choice('labels.models.notification',3)}}</p>
                                </div>
                                <div class="avatar bg-light-danger p-50 m-0">
                                    <div class="avatar-content">
                                        <a href="{{route('admin.notifications.index')}}">
                                        <i class="fas fa-bell font-medium-5"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endcan

                    @can('view-language')
                        <div class="col-lg-4 col-sm-6 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div>
                                        <h2 class="font-weight-bolder mb-0">{{$languages_count}}</h2>
                                        <p class="card-text"> {{ trans_choice('labels.models.language', 2) }}</p>
                                    </div>
                                    <div class="avatar bg-light-warning p-50 m-0">
                                        <div class="avatar-content">
                                            <a href="{{ route('admin.languages.index') }}">

                                                <i class="fas fa-language font-medium-5"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan

                </div>


                <!--/ Stats Horizontal Card -->


            </div>
        </div>
    </div>


@endsection

@push('js')
    <script src="{{asset('assets/admin/app-assets/vendors/js/charts/chart.min.js')}}"></script>
@endpush
