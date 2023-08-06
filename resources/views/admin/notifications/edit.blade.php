@extends('admin.layouts.app')

@section('title', trans_choice('labels.models.notification', 2))

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
                                            href="{{ route('admin.notifications.index') }}">{{ __('messages.static.list', ['name' => trans_choice('labels.models.notification', 2)]) }}</a>
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
                            <div class="card-header d-flex justify-content-start">
                                <button title="{{ __('messages.static.back') }}"
                                    onclick="document.location = '{{ url()->previous() }}'" type="button"
                                    class="btn btn-icon btn-outline-info">
                                    <i data-feather='arrow-right'></i>
                                </button>

                                @can('create-admin-notification')
                                    <button title="{{ __('messages.static.send') }}" onclick="sendNotification({{ $notification->id }})"
                                        type="button" class="btn btn-icon btn-outline-success mx-1">
                                        <i data-feather='bell'></i>
                                    </button>
                                @endcan

                            </div>
                            <div class="col-md-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{ __('messages.static.edit') }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <form class="form form-horizontal" method="post"
                                            action="{{ route('admin.notifications.update', $notification->id) }}">
                                            @csrf
                                            @method('put')
                                            <div class="row">
                                                <div class="col-12 mb-2">

                                                    <div class="col-12 mb-2">
                                                        <label for="title">
                                                            {{ __('labels.fields.title') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text"
                                                            class="form-control @error('title') is-invalid @enderror"
                                                            id="title" name="title"
                                                            placeholder="{{ __('labels.fields.title') }}"
                                                            value="{{ old('title', $notification->title) }}" required />
                                                        @error('title')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>


                                                    <div class="col-12 mb-2">
                                                        <label for="message">
                                                            {{ __('labels.fields.message') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <textarea name="message" id="message" cols="30" rows="3"
                                                            class="form-control @error('message') is-invalid @enderror"
                                                            placeholder="{{ __('labels.fields.message') }}"
                                                            required>{{ old('message', $notification->message) }}</textarea>
                                                        @error('message')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-12 mb-2">
                                                        <label for="receivers">
                                                            التكرار
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <select name="receivers" id="receivers"
                                                                class="form-control @error('receivers') is-invalid @enderror">
                                                            <option value="0" {{ old('receivers', $notification->receivers) == 1 ? 'selected' : '' }}>
                                                                مرة واحدة</option>
                                                            <option value="1" {{ old('receivers', $notification->receivers) == 1 ? 'selected' : '' }}>
                                                                يوميا</option>
                                                            <option value="2" {{ old('receivers', $notification->receivers) == 1 ? 'selected' : '' }}>
                                                                أسبوعيا</option>
                                                        </select>
                                                        @error('receivers')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>


                                                </div>
                                                <div class="col-12 ">
                                                    <button type="submit"
                                                        class="btn btn-primary mr-1">{{ __('messages.static.save') }}</button>
                                                    <button type="reset"
                                                        class="btn btn-outline-secondary">{{ __('messages.static.reset') }}
                                                    </button>
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

    <script>
        const sendNotification = id => {
            Swal.fire({
                title: '{{ __('messages.static.delete_confirm_title') }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ __('messages.static.delete_btn_yes') }}',
                cancelButtonText: '{{ __('messages.static.delete_btn_cancel') }}'
            }).then((result) => {
                if (result.value) {
                    let f = document.createElement("form");
                    f.setAttribute('method', "post");
                    f.setAttribute('action', `/admin/notifications/${id}/send`);

                    let i1 = document.createElement("input"); //input element, text
                    i1.setAttribute('type', "hidden");
                    i1.setAttribute('name', '_token');
                    i1.setAttribute('value', '{{ csrf_token() }}');

                    f.appendChild(i1);
                    document.body.appendChild(f);
                    f.submit();
                }
            });
        }
    </script>

@endpush
