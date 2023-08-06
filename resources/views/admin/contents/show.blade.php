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
                                        <a href="{{route('admin.contents.index')}}">{{__('messages.static.list',['name'=> trans_choice('labels.models.content',2)])}}</a>
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
                    <div class="col-md-4 ">
                        <div class="card text-center" id="app">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 30%">{{trans_choice('labels.models.section',1)}}</th>
                                        <td style="width: 70%">{{$content->section?->name}}</td>
                                    </tr>
                                    @if($content->category)
                                        <tr>
                                            <th style="width: 30%">{{trans_choice('labels.models.category',1)}}</th>
                                            <td style="width: 70%">{{$content->category?->name}}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                            <div class="card-body">

                                <a href="{{route('admin.contents.edit',$content->id)}}" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button type="button" onclick="deleteForm({{$content->id}})" class="mx-1 btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            @foreach(getLangs() as $lang => $config)
                                <upload-file
                                    :object="{{$content}}"
                                    post-route="{{route('admin.contents.voices.upload',['id' => $content->id,'type' => $lang])}}"
                                    delete-route="{{route('admin.contents.voices.delete',['id' => $content->id,'type' => $lang])}}"
                                    :type="' {{__('labels.langs.'.$lang)}}'"
                                ></upload-file>
                            @endforeach



                        </div>
                    </div>

                    <div class="col-md-8">

                        <div class="card">


                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table" id="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{trans_choice('labels.fields.start_from',1)}}</th>
                                            <th>{{trans_choice('labels.fields.end_at',1)}}</th>
                                            <th style="text-align: center">{{trans_choice('labels.models.paragraph',1)}}</th>
                                            <th>{{__('labels.fields.created_at')}}</th>
                                            <th width="150">{{__('messages.static.actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($content->paragraphs as $key =>  $paragraph)
                                            <tr>
                                                <td>
                                                    {{$key + 1}}
                                                </td>
                                                <td>
                                                    <ul>
                                                        @foreach(getLangs() as $lang => $config)
                                                            <li>
                                                                <span class="bold">{{$lang}} : </span> <span class="badge badge-info">{{$paragraph->translate('start_from',$lang,false)}}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul>
                                                        @foreach(getLangs() as $lang => $config)
                                                            <li>
                                                                <span class="bold">{{$lang}} : </span> <span class="badge badge-info">{{$paragraph->translate('end_at',$lang,false)}}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>


                                                <td>
                                                    @if($titles[$key]!=null)
                                                            <?php
                                                            echo  strip_tags($titles[$key]['title no_ 0']);
                                                            echo  strip_tags($titles[$key]['title no_ 1']);
                                                            echo  strip_tags($titles[$key]['title no_ 2']);
                                                            ?>
                                                    @endif

                                                </td>

                                                <td>
                                                    {{$paragraph->created_at}}
                                                </td>

                                                <td>


                                                    @can('edit-paragraph')
                                                        <a title="{{__('messages.static.edit')}}"
                                                           href="{{route('admin.paragraphs.edit',['content_id' => $content->id,'paragraph_id' => $paragraph->id])}}">
                                                            <i class="mr-50 fas fa-edit"></i>
                                                        </a>
                                                    @endcan

                                                    @can('view-paragraph')
                                                        <a title="{{__('messages.static.show')}}"
                                                           href="{{route('admin.paragraphs.show',['content_id' => $content->id,'paragraph_id' => $paragraph->id])}}">
                                                            <i class="mr-50 fas fa-eye"></i>
                                                        </a>
                                                    @endcan

                                                    @can('delete-paragraph')
                                                        <a title="{{__('messages.static.delete')}}"
                                                           onclick="deleteParagraph({{$paragraph->id}})" href="javascript:void(0);">
                                                            <i class="mr-50 fas fa-trash"></i>
                                                        </a>
                                                    @endcan


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
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <label class="modal-title text-text-bold-600" id="myModalLabel33">{{__('messages.static.create-item',['name'=>trans_choice('labels.models.paragraph',1)])}}</label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.paragraphs.store',$content->id)}}" id="contentForm" method="post">
                    @csrf
                    <div class="modal-body">


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
                            f.setAttribute('action', `/admin/contents/${id}`);

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
                            f.setAttribute('action', `/admin/contents/{{$content->id}}/paragraphs/${id}`);

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
                    "searching": false,
                    "paging":   false,
                    "ordering": false,
                    "info":     false,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            text: '<i data-feather="plus"></i>',
                            className :"btn btn-outline-info btn-sm",
                            action: function ( e, dt, node, config ) {
                                $('#inlineForm').modal({
                                    show: true
                                });
                            }
                        },
                        {
                            text: '{{__('messages.static.quick-add')}}<i data-feather="plus"></i>',
                            className :"btn btn-outline-info btn-sm",
                            action: function ( e, dt, node, config ) {
                                $('#contentForm').submit();
                            }
                        },
                        {
                            text: '{{trans_choice('labels.models.margin',3)}}',
                            className :"btn btn-outline-success btn-sm",
                            action: function ( e, dt, node, config ) {
                                window.location = '{{route('admin.contents.margins.index',$content->id)}}'
                            }
                        }
                    ]
                } )
            </script>
    @endpush
