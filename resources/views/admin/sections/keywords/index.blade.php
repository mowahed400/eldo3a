@extends('admin.layouts.app')

@section('title',  __('labels.fields.keyword') )

@push('css')
    <link rel="stylesheet" href="{{asset('assets/admin/app-assets/css/plugins/loading.min.css')}}">
    <link
        rel="stylesheet" type="text/css"
        href="//cdn.jsdelivr.net/gh/loadingio/ldbutton@v1.0.1/dist/ldbtn.min.css"
    />
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
                            <h2 class="content-header-title float-left mb-0">{{   __('labels.models.keywords') }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin.dashboard')}}">{{__('labels.fields.dashboard')}}</a>
                                    </li>

                                    <li class="breadcrumb-item">
                                        <a >{{   __('labels.models.keywords') }}</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="card">
                <div class="card-header">
                    <h1 >اضافة {{  __('labels.fields.keyword') }}</h1>
                </div>

                <div class="col-12">
                    @can('create-section-keyword')
                    <a title="Add Photo"  id="create-btn" href="{{route('admin.section_keywords.create')}}"
                       class="btn btn-icon btn-outline-primary">
                        <i data-feather="plus"></i>
                    </a>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="table-striped">
                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>الكلمة</th>
                                <th>القسم</th>
                                <th>{{__('labels.fields.created_at')}}</th>
                                <th>{{__('messages.static.actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($keywords as   $keyword)

                                <tr>
                                    <td>
                                       {{ $keyword->id}}
                                    </td>

                                    <td>
                                        {{$keyword->keyword}}
                                    </td>

                                    <td>
                                        {{$keyword->section_name}}
                                    </td>

                                    <td>
                                        {{$keyword->created_at}}
                                    </td>

                                    <td>
                                        <a title="{{__('messages.static.delete')}}"
                                           href="{{route('admin.section_keywords.delete',['id' => $keyword->id])}}">
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


@endsection

@push('js')
    <script src="{{asset('assets/admin/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script>
        $('.select2').select2()
    </script>
    <script src="{{mix('js/app.js')}}"></script>
@endpush
