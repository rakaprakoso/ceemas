@extends('layout.main-admin')
@section('title', 'Blog Preview')
@section('container')
    <div class="image-box">
        <div class="container py-3">
            <div class="row my-3">
                <div class="col">
                    <a class="btn btn-primary" href="{{'/'.Request::path().'/edit'}}" role="button">Edit</a>
                    <form action="{{$blog->id}}" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    {{$blog->published}}
                </div>
                <img src="{{asset('/img/blog/thumbnail/'.$blog->thumbnail_img)}}" class="card-img-top" alt="...">
                <div class="card-body">
                  <blockquote class="blockquote mb-0">
                    <h3 class="card-title">{{$blog->title}}</h3>
                    {!!$blog->content!!}
                    <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>
                  </blockquote>
                </div>
              </div>
                
            </div>
        </div>
    </div>
@endsection


