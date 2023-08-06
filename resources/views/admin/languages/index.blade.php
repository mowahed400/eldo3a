@extends('admin.layouts.app')

@section('title', trans_choice('labels.models.language', 2))

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
                                {{ __('messages.static.list', ['name' => trans_choice('labels.models.language', 2)]) }}
                            </h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">{{ __('labels.fields.dashboard') }}</a>
                                    </li>

                                    <li class="breadcrumb-item active">
                                        {{ __('messages.static.list', ['name' => trans_choice('labels.models.language', 2)]) }}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <div class="row" id="table-head">
                    @can('create-language')
                    <div class="col-4">
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
                                            <h4 class="card-title">{{ __('messages.static.create') }}</h4>
                                        </div>
                                        <div class="card-body">
                                            <form class="form form-horizontal" method="post"
                                                action="{{ route('admin.languages.store') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-12 mb-2">

                                                        <div class="col-12 mb-2">
                                                            <label for="name">
                                                                {{ __('labels.fields.name') }}
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="text"
                                                                class="form-control @error('name') is-invalid @enderror"
                                                                id="name" name="name"
                                                                placeholder="{{ __('labels.fields.name') }}"
                                                                value="{{ old('name') }}" required />
                                                            @error('name')
                                                                <div class="invalid-feedback">يجب أن لا يتجاوز طول النّص 40 حرفًا.</div>
                                                            @enderror
                                                        </div>


                                                        <div class="col-12 mb-2">
                                                            <label for="dir">
                                                                {{ __('labels.fields.direction') }}
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <select name="dir" id="dir" class="form-control @error('dir') is-invalid @enderror">
                                                                <option value="rtl" @if(old('dir') === 'rtl') selected @endif> {{__('labels.fields.rtl')}}</option>
                                                                <option value="ltr" @if(old('dir') === 'ltr') selected @endif> {{__('labels.fields.ltr')}}</option>
                                                            </select>
                                                            @error('dir')
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
                    @endcan
                    <div class="@can('create-language') col-md-8 @endcan @cannot('create-language') col-md-12 @endcannot">

                        <div class="card">

                            <div class="card-header ">
                            </div>

                            <div class="card-body">
                                <div class="card-tools">
                                    <form id="filter-form">
                                        <div class="row justify-content-end">

                                        </div>
                                    </form>
                                </div>
                                <div class="table-responsive">
                                    <table class="table" id="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>{{ __('labels.fields.name') }}</th>
                                                <th>{{ __('labels.fields.direction') }}</th>
                                                <th>{{ __('messages.static.actions') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach (getLangs() as $lang => $config)

                                                <tr>
                                                    <td>
                                                        {{ $lang }}
                                                    </td>

                                                    <td>
                                                        {{ __('labels.fields.'.$config['dir']) }}
                                                    </td>


                                                    <td>
                                                        @can('delete-language')
                                                            @if($lang !== 'ar')
                                                                <a title="{{ __('messages.static.delete') }}"
                                                                   onclick="deleteItem('{{ $lang }}')"
                                                                   href="javascript:void(0)">
                                                                    <i class="mr-50 fas fa-trash"></i>
                                                                </a>
                                                            @endif
                                                        @endcan
                                                            @if($lang !== 'ar')
                                                                <a title="{{ __('messages.static.edit' ,) }}"
                                                                   href="{{route('admin.language.edit',['lang'=>$lang])}}">
                                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                                </a>
                                                            @endif

                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center my-1">
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
    @can('delete-language')

    @include('admin.layouts.partials.delete', ['route' => '/admin/languages/'])
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
                    f.setAttribute('action', `/admin/languages/${id}/send`);

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
