@extends('admin.layouts.app')

@section('title',trans_choice('labels.models.content',2))

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
                            <h2 class="content-header-title float-left mb-0">  اضافة {{   __('labels.fields.keyword') }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin.dashboard')}}">{{__('labels.fields.dashboard')}}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin.section_keywords.index')}}"> {{   __('labels.fields.keyword') }}</a>
                                    </li>

                                    <li class="breadcrumb-item active">
                                        اضافة {{   __('labels.fields.keyword') }}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <div class="row" id="table-head">
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <button title="{{__('messages.static.back')}}" onclick="document.location = '{{url()->previous()}}'" type="button" class="btn btn-icon btn-outline-info">
                                    <i data-feather='arrow-right'></i>
                                </button>

                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title"> اضافة {{   __('labels.fields.keyword') }}</h4>
                                    </div>
                                    <div class="card-body">

                                        @if(count($errors)>0)
                                            <ul class="navbar-nav mr-auto">
                                                @foreach ($errors->all() as $error)
                                                    <li class="nav-item active">
                                                        {{$error}}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif



                                        <form action="{{route('admin.section_keywords.store')}}" method="POST" >

                                            @csrf

                                            <div class="form-group">
                                                <label for="section" class="form-label">{{trans_choice('labels.models.section',1)}}</label>
                                                <select class="form-control" name="section_id" id="section" required>
                                                    @foreach($sections as $section)
                                                        <option value="{{$section->id}}">{{$section->name}}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            <div class="mb-3">
                                                <label for="keyword" class="form-label"> {{   __('labels.fields.keyword') }}</label>
                                                <input type="text" class="form-control" name="keyword" required
                                                       oninvalid="this.setCustomValidity('يرجى ادخال كلمة مفتاحية ');"
                                                       onchange="try{setCustomValidity('')}catch(e){}">
                                            </div>



                                            <button type="submit" class="btn btn-primary">حفظ الكلمة المفتاحية</button>
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

