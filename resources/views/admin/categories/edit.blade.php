@extends('admin.layouts.app')

@section('title', trans_choice('labels.models.category', 2))

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
                                            href="{{ route('admin.categories.index') }}"> {{__('messages.static.list',['name'=> trans_choice('labels.models.category',2)])}}</a>
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
                    <div class="col-md-6 col-12">
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
                                        <form class="form form-horizontal" method="post" enctype="multipart/form-data"
                                            action="{{ route('admin.categories.update', $category->id) }}">
                                            @csrf
                                            @method('put')
                                            <div class="row">

                                                <div class="col-12 mb-2" >
                                                    <div class="form-group" >
                                                        <label for="section">{{ trans_choice('labels.models.section',1) }}
                                                            <span class="text-danger">*</span>
                                                        </label>

                                                        <select name="section_id" id="section" class="form-control"  required
                                                                oninvalid="this.setCustomValidity('يرجى اختيار القسم ');"
                                                                onchange="try{setCustomValidity('')}catch(e){}">>
                                                            <option value="{{old('receivers',$category->section->id)}}"> --{{$category->section->translate('name','ar')}}-- </option>

                                                            @foreach($sections as $section)
                                                                <option value="{{$section->id}}">{{$section->translate('name','ar')}}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                                @if($category->isChild())
                                                    <div class="col-12 mb-2" >
                                                        <div class="form-group" >
                                                            <label  for="parent">{{ trans_choice('labels.models.category',1) }}
                                                                <span class="text-danger">*</span>
                                                            </label>

                                                            <select name="parent_id" id="parent" class="form-control">
                                                                <option value="{{$category->parent->id}}"> --{{$category->parent->translate('name','ar')}}-- </option>
                                                            </select>

                                                        </div>
                                                    </div>
                                                @endif
                                                @foreach(getLangs() as $lang => $config)
                                                    <div class="col-12 mb-2" >
                                                        <div class="form-group" >
                                                            <label  for="name_{{$lang}}">{{ __('labels.fields.name') }} ({{$lang}})
                                                                <span class="text-danger">*</span>
                                                            </label>

                                                            <input type="text"
                                                                   class="form-control @error('name.'.$lang) is-invalid @enderror"
                                                                   id="name_{{$lang}}" name="name[{{$lang}}]" dir="{{$config['dir']}}"
                                                                   placeholder="{{ __('labels.fields.name') }}"
                                                                   value="{{ old("name.$lang",$category->translate('name',$lang,false)) }}"  required
                                                                   oninvalid="this.setCustomValidity('يرجى ادخال اسم صحيح');"
                                                                   onchange="try{setCustomValidity('')}catch(e){}" />
                                                            @error("name.$lang")
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                @endforeach

                                                @foreach(getLangs() as $lang => $config)
                                                    <div class="col-12 mb-2">
                                                        <div class="form-group">
                                                            <label for="description_{{$lang}}">{{ __('labels.fields.description') }} ({{$lang}})
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <textarea name="description[{{$lang}}]" id="description_{{$lang}}"
                                                                      class="form-control"
                                                                      required
                                                                      dir="{{$config['dir']}}"
                                                                      rows="3" oninvalid="this.setCustomValidity( 'يرجى ادخال وصف صحيح');"
                                                                      onchange="try{setCustomValidity('')}catch(e){}">{{old("description.$lang",$category->translate('description',$lang,false))}}</textarea>
                                                            @error("description.$lang")
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                @endforeach



                                                <div class="col-12 mb-2" >
                                                    <div class="form-group" >
                                                        <label  for="state">{{ __('labels.fields.state') }}</label>
                                                        <select class="form-control @error('state') is-invalid @enderror" name="state" id="state">
                                                            @foreach(\App\Enums\CategoryState::values() as $value)
                                                                <option value="{{$value}}" @if((int)old('state',$category->state->value) === $value) selected @endif> {{__('labels.enum.section.state.'.$value)}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error("state")
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-2" >
                                                    <div class="form-group" >
                                                        <label  for="type">{{ __('labels.fields.display_type') }}</label>
                                                        <select class="form-control @error('type') is-invalid @enderror" name="type" id="type">
                                                            @foreach(\App\Enums\SectionType::values() as $value)
                                                                <option value="{{$value}}" @if((int)old('type',$category->type->value) === $value) selected @endif> {{__('labels.enum.section.type.'.$value)}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error("type")
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-12 mb-2" >
                                                    <div class="form-group" >
                                                        <label  for="image">{{ __('labels.fields.image') }}</label>
                                                        <input type="file"
                                                               style="visibility: hidden" class="form-control @error('image') is-invalid @enderror"
                                                               name="image"
                                                               onchange="imagePreview()"
                                                               accept="image/*"
                                                               id="image">
                                                        <img id="image-preview" onclick="document.getElementById('image').click()"
                                                             src="{{$category->image_url}}"
                                                             class="img-thumbnail img-fluid" width="100%"
                                                             alt="default">
                                                        @error("image")
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-sm-9 offset-sm-3 mt-2">
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
    <script>
        const category = {!! json_encode($category) !!};
        if(category.parent)
        {
            let selectCategories = () => {
                let $id = $('#section').find(":selected").val();
                if ($id) {
                    $.ajax({
                        type: 'GET',
                        dataType: "json",
                        url: '/admin/sections/' + $id,
                        success: function ({categories}) {

                            $('#parent').empty();

                            $('#parent').append(
                                `<option value="${category.parent.id}"> --${category.parent.name.ar}-- </option>`
                            );

                            for (let i = 0; i < categories.length; i++) {
                                if (category.parent.id !== categories[i].id) {
                                    $('#parent').append(
                                        `<option value="${categories[i].id}">${categories[i].name.ar}</option>`
                                    );
                                }
                            }
                        },
                        error: function (error) {
                        }
                    });
                }
            }
            selectCategories();
            $(document).on('change', '#section', function (e) {
                selectCategories();
            });
        }
    </script>
@endpush
