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
                            <h2 class="content-header-title float-left mb-0">{{ __('messages.static.edit') }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">{{ __('labels.fields.dashboard') }}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a
                                            href="{{ route('admin.languages.index') }}">{{ __('messages.static.list', ['name' => trans_choice('labels.models.language', 2)]) }}</a>
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



                            </div>
                            <div class="col-md-6 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">{{ __('messages.static.edit') }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <form class="form form-horizontal" method="post"
                                            action="{{ route('admin.language.update',['lang'=>$lang['name']]) }}">
                                            @csrf
                                            @method('post')
                                            <div class="row">
                                                <div class="col-12 mb-2">

                                                    <div class="col-12 mb-2">
                                                        <label for="title">
                                                            {{ __('labels.fields.name') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            id="name" name="name"
                                                            placeholder="{{ __('labels.fields.name') }}"
                                                            value="{{ old('name', $lang['name']) }}" required />
                                                        @error('name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-12 mb-2">
                                                        <label for="dir">
                                                            {{ __('labels.fields.direction') }}
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <select name="dir" id="dir" class="form-control @error('dir') is-invalid @enderror">
                                                            <option value="rtl" @if(old('dir',$lang['dir']) === 'rtl') selected @endif> {{__('labels.fields.rtl')}}</option>
                                                            <option value="ltr" @if(old('dir',$lang['dir']) === 'ltr') selected @endif> {{__('labels.fields.ltr')}}</option>
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
