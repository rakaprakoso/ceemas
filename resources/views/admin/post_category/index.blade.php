@extends('ceemas::admin.layout.dashboard')
@inject('helper', 'Rakadprakoso\Ceemas\app\Traits\helperForBlade')
@section('title', '')
@section('additional_script')
<!-- Select2 -->
<script src="/assets_admin/plugins/select2/js/select2.full.min.js"></script>
<script src="/assets_admin/plugins/bootstrap-tagsinput/src/bootstrap-tagsinput.js"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        $("#input-name").change(function () {
            var x = $("#input-name").val();
            var url = x.replace(/\ /g, '-').toLowerCase();
            url = url.replace(/\-/g, '-').toLowerCase();
            url = url.replace(/\_-_/g, '-').toLowerCase();
            url = url.replace(/\___/g, '-').toLowerCase();
            url = url.replace(/\__/g, '-').toLowerCase();
            url = url.replace(/\,/g, '').toLowerCase();
            url = url.replace(/\./g, '').toLowerCase();
            $("#input-slug").val(url);
        });
    });
</script>
@endsection
@section('content_header')
<h1>{{$helper->checkCrudType()}} {{$helper->isCategory()?'Category':'Tag'}}</h1>
@if ($helper->isCrudEdit())
<a href="{{route('admin.category.index').'?q='.Request::get('q').'&page='.Request::get('page')}}">
    <button type="button" class="btn btn-success btn-sm mt-2">
        <i class="fa fa-plus-circle" aria-hidden="true"></i>
        Add New {{$helper->isCategory()?'Category':'Tag'}}
    </button>
</a>
@endif
@if (session('status'))
<div class="alert alert-success my-3" role="alert">
    {{ session('status') }}
</div>
@endif
@endsection
@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card card-primary">

            <!-- $helper->isCrudEdit() & $helper->checkCrudType() -->
            <!-- form start -->
            @php
                $isCategory = $helper->isCategory()?'category':'tag';
            @endphp
            <form class="p-3" method="post" action="{{ $helper->isCrudEdit() ? route('admin.'.$isCategory.'.update', $post_category->id) : route('admin.'.$isCategory.'.store') }}"
                enctype="multipart/form-data">
                @csrf
                @if ($helper->isCrudEdit())
                    @method('put')
                @endif
                @if ($helper->isCategory())
                    <input type="hidden" name="isCategory" value="1">
                @endif
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                        id="input-name" aria-describedby="" placeholder="Enter name" name="name"
                        value="{{ $helper->isCrudEdit() ? $post_category->name : old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                        name="description" id="input-description" placeholder="Enter description"
                        rows="3">{{ $helper->isCrudEdit() ? $post_category->description : old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                @if ($helper->isCategory())
                <div class="form-group">
                    <label>Parent</label>
                    <select name="parent" class="form-control select2" style="width: 100%;" id="parent-slug">
                        <option value="" selected>None</option>
                        @foreach ($data['post_categories_L'] as $item)
                            @if ($helper->isCrudEdit() && $item->id==$post_category->parent)
                                <option value="{{$item->id}}" selected>{{$item->name}}</option>
                            @elseif($helper->isCrudEdit() && $item->id!=$post_category->id)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @elseif($helper->isCrudEdit()==false)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="form-group">
                    <label>Slug</label>
                    <input type="text" class="form-control @error('slug') is-invalid @enderror" id="input-slug"
                        aria-describedby="" placeholder="Enter slug" name="slug" value="{{ $helper->isCrudEdit() ? $post_category->slug : old('slug') }}">
                    @error('slug')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success">{{ $helper->isCrudEdit() ? 'Update' : 'Add' }}</button>
            </form>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$helper->isCategory()?'Category':'Tag'}} List</h3>
                <div class="card-tools">
                    <form action="{{route('admin.category.index')}}" method="get">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="q" class="form-control float-right"
                                    placeholder="Search" value="{{Request::get('q')}}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Slug</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['post_categories_R'] as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->name}}</td>
                            <td>{{$item->description}}</td>
                            <td>{{$item->slug}}</td>
                            <td><a href="{{route('admin.category.edit',$item->id).'?q='.Request::get('q').'&page='.Request::get('page')}}"
                                    class="badge badge-primary">Details
                                </a>
                                <form action="{{route('admin.category.destroy',$item->id)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger badge badge-danger">
                                        <i class="fa fa-trash" aria-hidden="true"></i> Delete
                                        </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                {{ $data['post_categories_R']->withQueryString()->links() }}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection
