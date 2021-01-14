@extends('cemas::admin.layout.main')
@section('title', 'File Manager')
@section('additional_head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endsection
@section('content_header')
<h1>File Manager</h1>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="mb-4">
            <div id="fm"></div>
        </div>
    </div>
</div>
@endsection
@section('additional_script')
<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
@endsection
