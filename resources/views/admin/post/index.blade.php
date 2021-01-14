@extends('ceemas::admin.layout.dashboard')
@section('title', 'Article - Arif Furniture')
@section('content_header')
<h1>Article</h1>
<a href="{{route('admin.post.create')}}"><button type="button" class="btn btn-success"><i class="fa fa-plus-circle"
            aria-hidden="true"></i> Add
        Article</button></a>
@if (session('status'))
<div class="alert alert-success my-3" role="alert">
    {{ session('status') }}
</div>
@endif
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Article List</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right"
                            placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($post as $item)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$item->title}}</td>
                            <td>{{$item->published_at}}</td>
                            <td><a href="{{route('admin.post.edit',$item->id)}}"
                                    class="badge badge-primary">Details</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection
