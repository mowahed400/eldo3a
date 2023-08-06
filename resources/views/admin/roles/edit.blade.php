@extends('admin.layouts.app')

@section('title', trans_choice('labels.models.role', 2))

@push('css')

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
                            <h2 class="content-header-title float-left mb-0">{{ __('messages.static.edit') }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">{{ __('labels.fields.dashboard') }}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a
                                            href="{{ route('admin.roles.index') }}"> {{__('messages.static.list',['name'=> trans_choice('labels.models.role',2)])}}</a>
                                    </li>

                                    <li class="breadcrumb-item active">
                                        {{ __('messages.static.edit') }}
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
                                <button title="{{ __('messages.static.back') }}"
                                    onclick="document.location = '{{ url()->previous() }}'" type="button"
                                    class="btn btn-icon btn-outline-info">
                                    <i data-feather='arrow-right'></i>
                                </button>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{ __('messages.static.edit') }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <form class="form form-horizontal" method="post"
                                            action="{{ route('admin.roles.update', $role->id) }}">
                                            @csrf
                                            @method('put')
                                            <div class="row">
                                                <div class="col-md-6 col-12 mb-2">
                                                    <div class="form-group">
                                                        <label for="name">{{ __('labels.fields.name') }}

                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            id="name" name="name"
                                                            placeholder="{{ __('labels.fields.name') }}"
                                                            value="{{ old('name', $role->name) }}" required
                                                           oninvalid="this.setCustomValidity('يرجى ادخال اسم صحيح');"
                                                           onchange="try{setCustomValidity('')}catch(e){}"/>
                                                        @error('name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                </div>
                                                <div class="col-12">
                                                    <div class="table-responsive border rounded mt-1">
                                                        <h6 class="py-1 mx-1 mb-0 font-medium-2">
                                                            <i data-feather="lock" class="font-medium-3 mr-25"></i>
                                                            <span class="align-middle">{{ trans_choice('labels.models.permission', 2) }}</span>
                                                        </h6>
                                                        <table class="table table-striped table-borderless">

                                                            <tbody>
                                                                @foreach (config('permission.admin-permissions-list') as $model => $permissions)
                                                                    <tr>

                                                                        <td><h4> {{ __('labels.permissions_models.'.$model) }}</h4></td>
                                                                        @foreach ($permissions as $permission)
                                                                            <td>
                                                                                @if($permission != '')
                                                                                    <div class="custom-control custom-checkbox">
                                                                                        <input type="checkbox"
                                                                                               class="custom-control-input"
                                                                                               id="{{ $permission }}-{{ $model }}"
                                                                                               @if ($role->permissions->contains('name', $permission . '-' . $model)) checked
                                                                                               @elseif($role->permissions->contains('name', 'create' . '-' . $model)) checked
                                                                                               @endif

                                                                                               value="{{ $permission }}-{{ $model }}"
                                                                                               name="permissions[]" />
                                                                                        <label class="custom-control-label"
                                                                                               for="{{ $permission }}-{{ $model }}">{{ __('labels.permissions_models.'.$permission) }}</label>
                                                                                    </div>
                                                                                @endif

                                                                            </td>
                                                                        @endforeach
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-sm-9 offset-sm-3 mt-2">
                                                    <button type="submit"
                                                        class="btn btn-primary mr-1">{{ __('messages.static.save') }}</button>
                                                    <button type="reset"
                                                        class="btn btn-outline-secondary">{{ __('messages.static.reset') }}</button>
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


@endpush
