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
                                            href="{{ route('admin.sections.show',$margin->id) }}">{{ __('messages.static.list', ['name' => trans_choice('labels.models.margin', 2)]) }}</a>
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
                                            action="{{ route('admin.margins.update', $margin->id) }}">
                                            @csrf
                                            @method('put')
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    @foreach(getLangs() as $lang => $config)

                                                        <div class="col-12 mb-2">
                                                            <label for="name">
                                                                {{ __('labels.fields.name') }}
                                                                @if($lang === 'ar')
                                                                    <span class="text-danger">*</span>
                                                                @endif
                                                                ({{$lang}})
                                                            </label>
                                                            <input type="text"
                                                                   value="{{ old('name', $margin->translate('name')) }}"
                                                                   dir="{{$config['dir']}}"
                                                                   class="form-control @error('name.'.$lang) is-invalid @enderror"
                                                                   id="name-{{$lang}}" name="name[{{$lang}}]"
                                                                   placeholder="{{ __('labels.fields.name') }}"
                                                                  @if($lang === 'ar') required @endif />
                                                            @error('name.'.$lang)
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    @endforeach

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


@endpush
