@extends("admin.layouts.app")

@section("title",trans_choice('labels.models.setting',2))

@section("content")
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0"></h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin.dashboard')}}">{{__('labels.fields.dashboard')}}</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-sliders-h"></i>
                            {{trans_choice('labels.models.setting',2)}}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-5 col-sm-3">

                                <div class="nav flex-column " id="vert-tabs-tab" role="tablist" aria-orientation="vertical">

                                    <ul class="nav nav-pills nav-pills-primary flex-column">

                                        <li class="nav-item"><a class="nav-link active " id="vert-tabs-general-tab"  href="#vert-tabs-general" data-toggle="tab"
                                                                aria-controls="vert-tabs-general" aria-selected="true" >{{__('labels.fields.general')}}</a></li>

                                        <li class="nav-item"><a class="nav-link" href="#vert-tabs-privacy_policy" data-toggle="tab"
                                                                aria-controls="vert-tabs-privacy_policy" aria-selected="true">{{__('labels.fields.privacy_policy')}}</a></li>

                                        <li class="nav-item"><a class="nav-link" href="#vert-tabs-user_terms_of_use" data-toggle="tab"
                                                                aria-controls="vert-tabs-driver_terms_of_use" aria-selected="true">{{__('labels.fields.user_terms_of_use')}}</a></li>

                                        <li class="nav-item"><a class="nav-link" href="#vert-tabs-about_us" data-toggle="tab"
                                                                aria-controls="vert-tabs-about_us" aria-selected="true">{{__('labels.fields.about_us')}}</a></li>

                                        <li class="nav-item"><a class="nav-link" href="#vert-tabs-help" data-toggle="tab"
                                                                aria-controls="vert-tabs-help" aria-selected="true">{{__('labels.fields.help')}}</a></li>

                                    </ul>

                                </div>

                            </div>

                            <div class="col-7 col-sm-9">
                                <div class="tab-content" id="vert-tabs-tabContent">

                                    <div class="tab-pane fade show active" id="vert-tabs-general" role="tabpanel"
                                         aria-labelledby="vert-tabs-general-tab">
                                        @include("admin.setting.general")
                                    </div>

                                    <div class="tab-pane fade show" id="vert-tabs-privacy_policy" role="tabpanel"
                                         aria-labelledby="vert-tabs-privacy_policy-tab">
                                        @include("admin.setting.privacy_policy")
                                    </div>


                                    <div class="tab-pane fade show" id="vert-tabs-user_terms_of_use" role="tabpanel"
                                         aria-labelledby="vert-tabs-user_terms_of_use-tab">
                                        @include("admin.setting.user_terms_of_use")
                                    </div>


                                    <div class="tab-pane fade show" id="vert-tabs-about_us" role="tabpanel"
                                         aria-labelledby="vert-tabs-about_us-tab">
                                        @include("admin.setting.about_us")
                                    </div>

                                    <div class="tab-pane fade show" id="vert-tabs-help" role="tabpanel"
                                         aria-labelledby="vert-tabs-help-tab">
                                        @include("admin.setting.help")
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
@push('js')
    <script>
        $(window).on('load', function () {
            $('.note-toolbar').removeClass('card-header')

        })
    </script>
@endpush

