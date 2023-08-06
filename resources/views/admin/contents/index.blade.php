@extends('admin.layouts.app')

@section('title',trans_choice('labels.models.content',2))

@section('content')

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0"> {{__('messages.static.list',['name'=> trans_choice('labels.models.content',2)])}}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin.dashboard')}}">{{__('labels.fields.dashboard')}}</a>
                                    </li>

                                    <li class="breadcrumb-item active">
                                        {{__('messages.static.list',['name'=> trans_choice('labels.models.content',2)])}}
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

                            <div class="card-header ">
                                <div>
                                    @can('create-content')
                                        <a title="{{__('messages.static.create')}}"  id="create-btn" href="{{route('admin.contents.create')}}"
                                                class="btn btn-icon btn-outline-primary">
                                            <i data-feather="plus"></i>
                                        </a>
                                    @endcan
                                </div>


                            </div>

                            <div class="card-body">
                                <div class="card-tools">
                                    <form id="filter-form">
                                        <div class="row justify-content-end">
                                            @include('admin.layouts.partials.search')

                                            <div class="form-group mr-1 mt-2">
                                                <button type="submit"
                                                        class="btn btn-success">{{__('messages.static.search')}}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th>رقم {{trans_choice('labels.models.content',1)}}</th>
                                            <th>{{trans_choice('labels.models.section',1)}}</th>
                                            <th>{{trans_choice('labels.models.category',1)}}</th>
                                            <th>{{trans_choice('labels.fields.voice',1)}}</th>
                                            <th>{{__('labels.fields.created_at')}}</th>
                                            <th>{{__('messages.static.actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($contents as $key =>  $content)
                                            <tr>
                                                <td>
                                                    {{ $content->id}}
                                                </td>
                                                <td>
                                                    <ul>
                                                        @foreach(getLangs() as $lang => $config)
                                                            <li>
                                                                {{$content->section->translate('name',$lang,false)}}
                                                            </li>
                                                        @endforeach
                                                        <li>
                                                            <a href="{{route('admin.sections.show',$content->section_id)}}">
                                                                <i class="fas fa-arrow-alt-circle-left"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    @if($content->category_id)
                                                    <ul>
                                                        @foreach(getLangs() as $lang => $config)
                                                            <li>
                                                                {{$content->category->translate('name',$lang,false)}}
                                                            </li>
                                                        @endforeach

                                                    </ul>
                                                    @else
                                                        /
                                                    @endif
                                                </td>
                                                <td>
                                                   <ul>
                                                       @foreach(getLangs() as $lang => $config)
                                                       <li class="mt-1">
                                                           @if(isset($content->voice_url[$lang]))
                                                               <a href="{{$content->voice_url[$lang]}}" class="btn btn-sm btn-success">
                                                                   @if(!in_array($lang,['en','ar']))
                                                                       {{$lang}}
                                                                   @else
                                                                       {{__('labels.langs.'.$lang)}}
                                                                   @endif
                                                                   <i class="fas fa-download"></i>
                                                               </a>
                                                           @else
                                                               <a href="javascript:void(0)" class="btn btn-sm btn-danger disabled" disabled>
                                                                   @if(!in_array($lang,['en','ar']))
                                                                       {{$lang}}
                                                                   @else
                                                                       {{__('labels.langs.'.$lang)}}
                                                                   @endif
                                                                   <i class="fas fa-download"></i>
                                                               </a>
                                                           @endif

                                                       </li>
                                                       @endforeach

                                                   </ul>
                                                </td>

                                                <td>
                                                    {{$content->created_at}}
                                                </td>

                                                <td>
                                                        @can('view-content')
                                                            <a title="{{__('messages.static.view')}}"
                                                               href="{{route('admin.contents.show',$content->id)}}">
                                                                <i class="mr-50 fas fa-eye"></i>
                                                            </a>
                                                        @endcan

                                                    @can('delete-content')
                                                        <a title="{{__('messages.static.delete')}}"
                                                           onclick="deleteItem({{$content->id}})" href="javascript:void(0);">
                                                            <i class="mr-50 fas fa-trash"></i>
                                                        </a>
                                                    @endcan


                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center my-1">
                                        {{$contents->links()}}
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

@can('delete-content')
    @include('admin.layouts.partials.delete', ['route' => '/admin/contents/'])
@endcan
