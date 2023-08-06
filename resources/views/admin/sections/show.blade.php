@extends('admin.layouts.app')

@push('css')

    <link rel="stylesheet" type="text/css" href="{{mix('css/app.css')}}">

@endpush

@section('title',trans_choice('messages.static.details',2))

@section('content')

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">{{__('messages.static.view')}}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin.dashboard')}}">{{__('labels.fields.dashboard')}}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin.sections.index')}}">{{__('messages.static.list',['name'=> trans_choice('labels.models.section',2)])}}</a>
                                    </li>

                                    <li class="breadcrumb-item active">
                                        {{__('messages.static.view')}}
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-md-12 ">
                        <div class="card " id="app">
                            <div class="card-header">
                                <div class="header-actions">
                                    <button class="btn btn-danger m-1" onclick="deleteForm({{$section->id}})">
                                        {{__('messages.static.delete')}}
                                    </button>
                                    <a href="{{route('admin.sections.edit',$section->id)}}" class="m-1 btn btn-warning">
                                        {{__('messages.static.edit')}}
                                    </a>
                                </div>
                            </div>

                            <table class="table  table-bordered">
                                <tr style="width: 30%">
                                    <th >{{__('labels.fields.name')}} : </th>
                                    <td style="min-width: 70%">
                                        <div class="collapse-default">
                                            @foreach(getLangs() as $lang => $config)

                                                <div class="card">
                                                    <div id="headingCollapse-name-{{$lang}}" class="card-header" data-toggle="collapse" role="button" data-target="#collapse-name-{{$lang}}" aria-expanded="false" aria-controls="collapse-name-{{$lang}}">
                                                        <span class="lead collapse-title"> {{$lang}} </span>
                                                    </div>
                                                    {{$section->translate('name',$lang,false)}}
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 30%">{{__('labels.fields.description')}} : </th>
                                    <td style="min-width: 70%">
                                        <div class="collapse-default">
                                            @foreach(getLangs() as $lang => $config)

                                                <div class="card">
                                                    <div id="headingCollapse-description-{{$lang}}" class="card-header" data-toggle="collapse" role="button" data-target="#collapse-description-{{$lang}}" aria-expanded="false" aria-controls="collapse-name-{{$lang}}">
                                                        <span class="lead collapse-title"> {{$lang}} </span>
                                                    </div>
                                                    {{$section->translate('description',$lang,false)}}
                                                </div>
                                            @endforeach
                                        </div>


                                    </td>
                                </tr>

                                <tr>
                                    <th style="width: 30%">{{__('labels.fields.type')}} : </th>
                                    <td style="min-width: 50%">
                                        @if($section->type)
                                            <span class="badge badge-{{$section->type?->getColor()}}">
                                            {{__('labels.enum.section.type.'.$section->type?->value)}}
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @can('create-margin')
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
                                                  action="{{ route('admin.margins.store',$section->id) }}">
                                                @csrf
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
                                                                       dir="{{$config['dir']}}"
                                                                       class="form-control @error('name.'.$lang) is-invalid @enderror"
                                                                       id="name-{{$lang}}" name="name[{{$lang}}]"
                                                                       placeholder="{{ __('labels.fields.name') }}"
                                                                       value="{{ old('name') }}" @if($lang === 'ar') required @endif />
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
                    @endcan
                    <div class="@can('create-margin') col-md-8 @endcan @cannot('create-margin') col-md-12 @endcannot">

                        <div class="card">

                            <div class="card-header ">
                                <h3>{{trans_choice('labels.models.margin',3)}}</h3>
                            </div>

                            <div class="card-body">
                                <div class="card-tools">

                                </div>
                                <div class="table-responsive">
                                    <table class="table" id="table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>{{__('labels.fields.name')}}</th>
                                            <th>{{__('messages.static.actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count($section->margins) != 0)

                                            @foreach($section->margins as $key =>  $margin)
                                                <tr>
                                                    <td>
                                                        {{$key + 1}}
                                                    </td>
                                                    <td>
                                                        <ul>
                                                            @foreach(getLangs() as $lang => $config)
                                                                <li>
                                                                    <span class="bold">{{$lang}} : </span> <span class="badge badge-info">{{$margin->translate('name',$lang,false)}}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </td>


                                                    <td>


                                                        @can('edit-margin')
                                                            <a title="{{__('messages.static.edit')}}"
                                                               href="{{route('admin.margins.edit',$margin->id)}}">
                                                                <i class="mr-50 fas fa-edit"></i>
                                                            </a>
                                                        @endcan

                                                        @can('delete-margin')
                                                            <a title="{{__('messages.static.delete')}}"
                                                               onclick="deleteParagraph({{$margin->id}})" href="javascript:void(0);">
                                                                <i class="mr-50 fas fa-trash"></i>
                                                            </a>
                                                        @endcan


                                                    </td>
                                                </tr>
                                            @endforeach

                                        @else

                                        <td id="td1">&nbsp;</td>

                                         <td width="400">   <h3 style="alignment: center" id="td1">&nbsp;لا يوجد هوامش في هدا القسم</h3></td>

                                        @endif
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
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title text-text-bold-600" id="myModalLabel33">{{__('messages.static.create-item',['name'=>trans_choice('labels.models.margin',1)])}}</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.margins.store',$section->id)}}" method="post">
                    @csrf
                    <div class="modal-body">
                        @foreach(getLangs() as $lang => $config)
                            <div class="form-group">
                                <label>{{__('labels.fields.name')}} ({{$lang}}) : </label>
                                <input type="text" name="name[{{$lang}}]" class="form-control @error('name.'.$lang) is-invalid @endif">
                                @error('name.'.$lang)
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        @endforeach

                        @foreach(getLangs() as $lang => $config)
                            <div class="form-group">
                                <label>{{__('labels.fields.end_at')}} ({{$lang}}) : </label>
                                <input type="text" name="end_at[{{$lang}}]" class="form-control @error('end_at.'.$lang) is-invalid @endif">
                                @error('end_at.'.$lang)
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        @endforeach

                    </div>
                    <div class="modal-footer">
                        <input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal" value="{{__('messages.static.cancel')}}">
                        <input type="submit" class="btn btn-outline-primary btn-lg" value="{{__('messages.static.save')}}">
                    </div>
                </form>
            </div>
        </div>

        @endsection

        @push('js')

            <script src="{{mix('js/app.js')}}"></script>

            <script>
                const deleteForm = id => {

                    Swal.fire({
                        title: '{{__('messages.static.delete_confirm_title')}}',
                        text: "{{__('messages.static.delete_confirm_text')}}",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '{{__('messages.static.delete_btn_yes')}}',
                        cancelButtonText: '{{__('messages.static.delete_btn_cancel')}}'
                    }).then((result) => {
                        if (result.value) {
                            let f = document.createElement("form");
                            f.setAttribute('method', "post");
                            f.setAttribute('action', `/admin/sections/${id}/`);

                            let i1 = document.createElement("input"); //input element, text
                            i1.setAttribute('type', "hidden");
                            i1.setAttribute('name', '_token');
                            i1.setAttribute('value', '{{csrf_token()}}');

                            let i2 = document.createElement("input"); //input element, text
                            i2.setAttribute('type', "hidden");
                            i2.setAttribute('name', '_method');
                            i2.setAttribute('value', 'DELETE');

                            f.appendChild(i1);
                            f.appendChild(i2);
                            document.body.appendChild(f);
                            f.submit();
                        }
                    });
                }
                const deleteParagraph = id => {

                    Swal.fire({
                        title: '{{__('messages.static.delete_confirm_title')}}',
                        text: "{{__('messages.static.delete_confirm_text')}}",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '{{__('messages.static.delete_btn_yes')}}',
                        cancelButtonText: '{{__('messages.static.delete_btn_cancel')}}'
                    }).then((result) => {
                        if (result.value) {
                            let f = document.createElement("form");
                            f.setAttribute('method', "post");
                            f.setAttribute('action', `/admin/margins/${id}`);

                            let i1 = document.createElement("input"); //input element, text
                            i1.setAttribute('type', "hidden");
                            i1.setAttribute('name', '_token');
                            i1.setAttribute('value', '{{csrf_token()}}');

                            let i2 = document.createElement("input"); //input element, text
                            i2.setAttribute('type', "hidden");
                            i2.setAttribute('name', '_method');
                            i2.setAttribute('value', 'DELETE');

                            f.appendChild(i1);
                            f.appendChild(i2);
                            document.body.appendChild(f);
                            f.submit();
                        }
                    });
                }
                $('#table').DataTable( {
                    "paging":   false,
                    "ordering": false,
                    "info":     false,
                    'searching' : false
                } )
            </script>
    @endpush

