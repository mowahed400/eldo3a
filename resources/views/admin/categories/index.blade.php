@extends('admin.layouts.app')

@section('title',trans_choice('labels.models.category',2))

@section('content')

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0"> {{__('messages.static.list',['name'=> trans_choice('labels.models.category',2)])}}</h2>
                            <div class="breadcrumb-wrapper">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin.dashboard')}}">{{__('labels.fields.dashboard')}}</a>
                                    </li>

                                    <li class="breadcrumb-item active">
                                        {{__('messages.static.list',['name'=> trans_choice('labels.models.category',2)])}}
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
                                    @can('create-section')
                                        <a title="{{__('messages.static.create')}}"  id="create-btn" href="{{route('admin.categories.create')}}"
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
                                            <th>#</th>
                                            <th>{{ __('labels.fields.name') }}</th>
                                            <th>{{ __('labels.fields.parent') }}</th>
                                            <th>{{trans_choice('labels.models.section',2)}}</th>
                                            <th>{{ __('labels.fields.state') }}</th>
                                            <th>{{__('messages.static.actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($categories as $category)
                                            <tr>
                                                <td>
                                                    {{$category->id}}
                                                </td>

                                                <td>
                                                    <ul>
                                                        @foreach(getLangs() as $lang => $config)
                                                            <li>
                                                                {{$category->translate('name',$lang,false)}}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>

                                                <td>
                                                    <ul>
                                                        @foreach(getLangs() as $lang => $config)
                                                            @if($category->parent)
                                                                <li>
                                                                    {{$category->parent->translate('name',$lang,false)}}
                                                                </li>

                                                            @else
                                                                /
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </td>


                                                <td>
                                                    <ul>
                                                        @foreach(getLangs() as $lang => $config)
                                                            <li>
                                                                {{$category->section->translate('name',$lang,false)}}
                                                            </li>
                                                        @endforeach
                                                        <li>
                                                            <a href="{{route('admin.sections.show',$category->section_id)}}">
                                                                <i class="fas fa-arrow-alt-circle-left"></i>
                                                            </a>
                                                        </li>
                                                    </ul>

                                                </td>
                                                <td>
                                                    <span class="badge badge-pill badge-light-{{$category->state->getColor()}} mr-1">
                                                        {{__('labels.enum.category.state.'.$category->state->value)}}
                                                    </span>
                                                </td>

                                                <td>
                                                    @can('edit-category')
                                                        <a title="{{__('messages.static.edit')}}"
                                                           href="{{route('admin.categories.edit',$category->id)}}">
                                                            <i class="mr-50 fas fa-edit"></i>
                                                        </a>
                                                    @endcan

                                                    @can('delete-category')
                                                        <a title="{{__('messages.static.delete')}}"
                                                           onclick="deleteItem({{$category->id}})" href="javascript:void(0);">
                                                            <i class="mr-50 fas fa-trash"></i>
                                                        </a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center my-1">
                                        {{$categories->links()}}
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

@can('delete-category')
    @include('admin.layouts.partials.delete', ['route' => '/admin/categories/'])
@endcan
