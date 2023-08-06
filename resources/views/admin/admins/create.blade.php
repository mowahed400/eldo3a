@extends('admin.layouts.app')

@section('title',trans_choice('labels.models.admin',2))

@push('css')
    <!-- Select2 -->
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
                            <h2 class="content-header-title float-left mb-0">{{__('messages.static.create')}}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin.dashboard')}}">{{__('labels.fields.dashboard')}}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin.admins.index')}}">{{__('messages.static.list',['name'=> trans_choice('labels.models.admin',2)])}}</a>
                                    </li>

                                    <li class="breadcrumb-item active">
                                        {{__('messages.static.create')}}
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
                                        <h4 class="card-title">{{__('messages.static.create')}}</h4>
                                    </div>
                                    <div class="card-body">
                                        <form class="form form-horizontal" method="post" action="{{route('admin.admins.store')}}">
                                            @csrf
                                            <div class="row">

                                                <div class="col-12 mb-2">
                                                    <div class="form-group">
                                                        <label for="name">{{ __('labels.fields.name') }}

                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            id="name" name="name"
                                                            placeholder="{{ __('labels.fields.name') }}"
                                                            value="{{ old('name') }}" required
                                                           oninvalid="this.setCustomValidity('يرجى ادخال اسم صحيح');"
                                                           onchange="try{setCustomValidity('')}catch(e){}"/>
                                                        @error('name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12 mb-2">
                                                    <div class="form-group">
                                                        <label for="email">{{ __('labels.fields.email') }}

                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            id="email" name="email"
                                                            placeholder="{{ __('labels.fields.email') }}"
                                                            value="{{ old('email') }}" required
                                                           oninvalid="this.setCustomValidity('يرجى ادخال بريد صحيح');"
                                                           onchange="try{setCustomValidity('')}catch(e){}"/>
                                                        @error('email')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12 mb-2">
                                                    <label for="password">{{__('labels.fields.password')}}</label>
                                                    <span class="text-danger">*</span>
                                                    <div class="input-group form-password-toggle">
                                                        <input type="password"
                                                               class="form-control @error('password') is-invalid @enderror"
                                                               required name="password"
                                                               id="password" placeholder="{{__('labels.fields.password')}}"
                                                               oninvalid="this.setCustomValidity('يرجى ادخال كلمة مرور صحيحة');"
                                                               onchange="try{setCustomValidity('')}catch(e){}"/>

                                                        <div class="input-group-append">
                                                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                                        </div>

                                                        @error('password')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                        @enderror
                                                    </div>

                                                </div>

                                                <div class="col-12 mb-2">
                                                    <label  for="password_confirmation">{{__('labels.fields.password_confirmation')}}</label>
                                                    <span class="text-danger">*</span>
                                                    <div class="input-group form-password-toggle">
                                                        <input type="password"
                                                               class="form-control  @error('password') is-invalid @enderror"
                                                               required name="password_confirmation"
                                                               id="password_confirmation" placeholder="{{__('labels.fields.password_confirmation')}}"
                                                               oninvalid="this.setCustomValidity('يرجى ادخال نفس كلمة المرور');"
                                                               onchange="try{setCustomValidity('')}catch(e){}"/>

                                                        <div class="input-group-append">
                                                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                                        </div>

                                                        @error('password')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-12 mb-2">
                                                    <div class="form-group">
                                                        <label for="roles">{{trans_choice('labels.models.role',3)}}</label>
                                                        <span class="text-danger">*</span>
                                                        <select required id="roles"
                                                                class="select2 form-control @error('roles') is-invalid @enderror"
                                                                multiple="multiple" name="roles[]"
                                                                data-placeholder="{{trans_choice('labels.models.role',3)}}"
                                                                oninvalid="this.setCustomValidity('يرجى اختيار الدور');"
                                                                onchange="try{setCustomValidity('')}catch(e){}"
                                                                style="width: 100%;">
                                                        </select>
                                                        @error('roles')
                                                        <div class="invalid-feedback">{{$message}}</div>
                                                        @enderror
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


@push('js')
    <script src="{{asset('assets/admin/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>

    <!-- Select2 -->
    <script>
        //Initialize Select2 Elements
        $('.select2').select2({
            cache:true,
            ajax: {
                delay: 250,
                url: '{{route('admin.roles.index')}}',
                dataType: 'json',
                data: function (params) {
                    // Query parameters will be ?search=[term]&page=[page]
                    if (params.term && params.term.length > 3)
                    {
                        return {
                            search: params.term,
                            page: params.page || 1
                        };
                    }

                },
                processResults: function ({roles}, params) {
                    params.page = params.page || 1;

                    let fData = $.map(roles.data, function (obj) {
                        obj.text = obj.name; // replace name with the property used for the text
                        return obj;
                    });

                    return {
                        results: fData,
                        pagination: {
                            more: (params.page * 10) < roles.total
                        }
                    };
                }
            }
        })


    </script>
@endpush
