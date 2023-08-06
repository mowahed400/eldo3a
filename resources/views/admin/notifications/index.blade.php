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
                            <h2 class="content-header-title float-left mb-0">
                                {{ __('messages.static.list', ['name' => trans_choice('labels.models.notification', 2)]) }}
                            </h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">{{ __('labels.fields.dashboard') }}</a>
                                    </li>

                                    <li class="breadcrumb-item active">
                                        {{ __('messages.static.list', ['name' => trans_choice('labels.models.notification', 2)]) }}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <div class="row" id="table-head">
                    <div class="col-4">
                        <div class="card">
                            <div class="card-header"></div>
                            @can('create-admin-notification')
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">{{ __('messages.static.create') }}</h4>
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

                                            <form class="form form-horizontal" method="post"
                                                action="{{ route('admin.notifications.store') }}">
                                                @csrf
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
                                                                value="{{ old('title') }}" required oninvalid="this.setCustomValidity('يرجى ادخال عنوان صحيح');"
                                                                   onchange="try{setCustomValidity('')}catch(e){}"/>
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
                                                                  required oninvalid="this.setCustomValidity('يرجى ادخال رسالة  صحيحة');"
                                                                  onchange="try{setCustomValidity('')}catch(e){}">{{ old('message') }}</textarea>
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
                                                                <option value="0">
                                                                 مرة واحدة</option>
                                                                <option value="1">
                                                                  يوميا</option>
                                                                <option value="2">
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
                            @endcan
                        </div>
                    </div>
                    <div class="col-8">

                        <div class="card">

                            <div class="card-header ">
                            </div>

                            <div class="card-body">
                                <div class="card-tools">
                                    <form id="filter-form">
                                        <div class="row justify-content-end">

                                            @include('admin.layouts.partials.search')

                                            <div class="form-group mr-1 mt-2">
                                                <button type="submit"
                                                    class="btn btn-success">{{ __('messages.static.search') }}</button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                                <div class="table-responsive">
                                    <table class="table" id="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>{{ __('labels.fields.title') }}</th>
                                                <th> التكرار</th>
                                                <th>{{ __('labels.fields.message') }}</th>
                                                <th>{{ __('messages.static.actions') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($notifications as $key => $notification)

                                                <tr>
                                                    <td>
                                                        {{$key + 1 }}
                                                    </td>

                                                    <td>
                                                        {{ $notification->title }}
                                                    </td>

                                                    <td>
                                                        @switch($notification->receivers)
                                                            @case(0)
                                                                <span
                                                                    class="badge badge-success">مرة واحدة</span>
                                                            @break

                                                            @case(1)
                                                                <span
                                                                    class="badge badge-info"> يوميا</span>
                                                            @break

                                                            @case(2)
                                                                <span
                                                                    class="badge badge-primary"> أسبوعيا</span>
                                                            @break

                                                            @default
                                                                <span
                                                                    class="badge badge-secondary">مرة واحدة</span>
                                                        @endswitch

                                                    </td>

                                                    <td>
                                                        {{ $notification->message }}
                                                    </td>

                                                    <td>
                                                        @can('edit-admin-notification')
                                                            <a title="{{ __('messages.static.edit') }}"
                                                                href="{{ route('admin.notifications.edit', $notification->id) }}">
                                                                <i class="mr-50 fas fa-edit"></i>
                                                            </a>
                                                        @endcan

                                                        @can('delete-admin-notification')
                                                            <a title="{{ __('messages.static.delete') }}"
                                                                onclick="deleteItem({{ $notification->id }})"
                                                                href="javascript:void(0)">
                                                                <i class="mr-50 fas fa-trash"></i>
                                                            </a>
                                                        @endcan


                                                            <a title="{{ __('messages.static.send') }}"
                                                                onclick="sendNotification({{ $notification->id }})"
                                                                href="javascript:void(0)">
                                                                <i class="mr-50 fas fa-bell"></i>
                                                            </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center my-1">
                                        {{$notifications->links()}}
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

    <script src="{{ asset('assets/admin/app-assets/js/scripts/pages/app-user-edit.js') }}"></script>

    @can('delete-admin-notification')
        @include('admin.layouts.partials.delete', ['route' => '/admin/notifications/'])
    @endcan

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
