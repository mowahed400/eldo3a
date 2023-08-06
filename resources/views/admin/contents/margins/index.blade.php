@extends('admin.layouts.app')

@section('title',trans_choice('labels.models.content',2))

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
                            <h2 class="content-header-title float-left mb-0">{{__('messages.static.details')}}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin.dashboard')}}">{{__('labels.fields.dashboard')}}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin.contents.index')}}"> {{__('messages.static.list',['name'=> trans_choice('labels.models.content',2)])}}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin.contents.show',$content->id)}}">{{trans_choice('labels.models.content',1)}} </a>
                                    </li>

                                    <li class="breadcrumb-item active">
                                        {{trans_choice('labels.models.margin',3)}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body" id="app">
                @if($content->section->margins->count() > 0)
                <margins-component :langs="{{json_encode(getLangs(), JSON_THROW_ON_ERROR)}}"
                                   :content-id="{{$content->id}}"
                                   :section="{{$content->section}}"></margins-component>
                @else
                    <div class="card">
                        <div class="card-body">

                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{mix('js/app.js')}}"></script>

@endpush
