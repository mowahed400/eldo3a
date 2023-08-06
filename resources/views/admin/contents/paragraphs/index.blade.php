@extends('admin.layouts.app')

@section('title',trans_choice('labels.models.paragraph',2))

@push('css')
    <link rel="stylesheet" href="{{asset('assets/admin/app-assets/css/plugins/loading.min.css')}}">
    <link
        rel="stylesheet" type="text/css"
        href="//cdn.jsdelivr.net/gh/loadingio/ldbutton@v1.0.1/dist/ldbtn.min.css"
    />
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
                            <h2 class="content-header-title float-left mb-0">{{ trans_choice('labels.models.paragraph', 2) }}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin.dashboard')}}">{{__('labels.fields.dashboard')}}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin.paragraphs.index')}}"> {{ trans_choice('labels.models.paragraph', 2) }}</a>
                                    </li>


                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>رقم المحتوى</th>
                                <th>{{trans_choice('labels.fields.start_from',1)}}</th>
                                <th>{{trans_choice('labels.fields.end_at',1)}}</th>
                                <th style="text-align: center">{{trans_choice('labels.models.paragraph',1)}}</th>
                                <th>{{__('labels.fields.created_at')}}</th>
                                <th width="150">{{__('messages.static.actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($paragraphs as $key =>  $paragraph)

                                <tr>
                                    <td>
                                        {{$key + 1}}
                                    </td>

                                    <td>
                                        {{$paragraph->content_id}}
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
                                               href="{{route('admin.paragraphs.edit',['content_id' => $paragraph->content_id,'paragraph_id' => $paragraph->id])}}">
                                                <i class="mr-50 fas fa-edit"></i>
                                            </a>
                                        @endcan

                                        @can('view-paragraph')
                                            <a title="{{__('messages.static.view')}}"
                                               href="{{route('admin.paragraphs.show',['content_id' => $paragraph->content_id,'paragraph_id' => $paragraph->id])}}">
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
                    </div>
                </div>
            </div>


        </div>
    </div>


@endsection

@push('js')
    <script src="{{asset('assets/admin/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script>
        $('.select2').select2()
    </script>
    <script src="{{mix('js/app.js')}}"></script>
@endpush
