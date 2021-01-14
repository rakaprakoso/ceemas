@extends('ceemas::admin.layout.dashboard')
@section('title', 'File Manager')
@section('additional_head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('/vendor/file-manager/css/file-manager.css') }}">
@endsection
@section('content_header')
<h1>File Manager</h1>
@endsection
@section('content')
{{--<div class="row">
    <div class="col-12">
        <div class="fm-navbar mb-3">
            <div class="row justify-content-between">
                <div class="col-auto">
                    <div role="group" class="btn-group"><button type="button" disabled="disabled" title="Back"
                            class="btn btn-secondary"><i class="fas fa-step-backward"></i></button><button type="button"
                            disabled="disabled" title="Forward" class="btn btn-secondary"><i
                                class="fas fa-step-forward"></i></button><button type="button" title="Refresh"
                            class="btn btn-secondary"><i class="fas fa-sync-alt"></i></button></div>
                    <div role="group" class="btn-group"><button type="button" title="New file"
                            class="btn btn-secondary"><i class="far fa-file"></i></button><button type="button"
                            title="New folder" class="btn btn-secondary"><i class="far fa-folder"></i></button><button
                            type="button" title="Upload" class="btn btn-secondary"><i
                                class="fas fa-upload"></i></button><button type="button" disabled="disabled"
                            title="Delete" class="btn btn-secondary"><i class="fas fa-trash-alt"></i></button></div>
                    <div role="group" class="btn-group"><button type="button" disabled="disabled" title="Copy"
                            class="btn btn-secondary"><i class="fas fa-copy"></i></button><button type="button"
                            disabled="disabled" title="Cut" class="btn btn-secondary"><i
                                class="fas fa-cut"></i></button><button type="button" disabled="disabled" title="Paste"
                            class="btn btn-secondary"><i class="fas fa-paste"></i></button></div>
                    <div role="group" class="btn-group"><button type="button" title=" Hidden files"
                            class="btn btn-secondary"><i class="fas fa-eye"></i></button></div>
                </div>
                <div class="col-auto text-right">
                    <div role="group" class="btn-group"><button type="button" title="Table"
                            class="btn btn-secondary active"><i class="fas fa-th-list"></i></button><button
                            role="button" title="Grid" class="btn btn-secondary"><i class="fas fa-th"></i></button>
                    </div>
                    <div role="group" class="btn-group"><button type="button" title="Full screen"
                            class="btn btn-secondary"><i class="fas fa-expand-arrows-alt"></i></button></div>
                    <div role="group" class="btn-group"><button type="button" title="About" class="btn btn-secondary"><i
                                class="fas fa-question"></i></button></div>
                </div>
            </div>
        </div>
        <h4>Disks</h4>
        <div class="ceemas-disk">
            @foreach ($config['config']['disks'] as $key=>$item)
            <button type="button" class="btn btn-light" value="{{$key}}">{{$key}}</button>
            @endforeach
        </div>
        <hr>
        <div class="fm-body row ceemas-body">
            <div class="fm-notification"><span></span></div>
            <!---->
            <!---->
            <div class="fm-tree col-4 col-md-3">
                <div class="ceemas-tree-disk fm-tree-disk sticky-top"><i class="far fa-hdd"></i> </div>
                {{--<ul class="nav flex-column ceemas-tree-branch">
                    <li class="nav-item">
                      <a class="nav-link active" href="#">Active</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>
                  </ul>--/}}
                <ul class="list-unstyled fm-tree-branch ceemas-tree-branch">
                    {{--@foreach ($tree['directories'] as $item)
                    <li>
                        @if ($item['props']['hasSubdirectories'])
                        <p class="unselectable"><i class="far fa-plus-square"></i>{{$item['path']}}</p>
                        <ul class="list-unstyled fm-tree-branch" style="display: none;"></ul>
                        @else
                        <p class="unselectable"><i class="fas fa-minus fa-xs"></i>{{$item['path']}}</p>
                        @endif
                    </li>
                    @endforeach
                    {{-- Beranak --}}
                    {{-- <li>
                        <p class="unselectable"><i class="far fa-minus-square"></i> files </p>
                        <ul class="list-unstyled fm-tree-branch" style="">
                            <li>
                                <p class="unselectable selected"><i class="far fa-minus-square"></i> shares </p>
                                <ul class="list-unstyled fm-tree-branch">
                                    <li>
                                        <p class="unselectable"><i class="fas fa-minus fa-xs"></i> test </p>
                                        <!---->
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li> --/}}


                </ul>
            </div>
            <div class="fm-content d-flex flex-column col-8 col-md-9">
                <div class="fm-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb active-manager">
                            <li class="breadcrumb-item"><span class="badge badge-secondary"><i
                                        class="far fa-hdd"></i></span></li>
                        </ol>
                    </nav>
                </div>
                <div class="fm-content-body">
                    <div class="fm-table">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th class="w-65"> Name <i class="fas fa-sort-amount-down"
                                            style="display: none;"></i><i class="fas fa-sort-amount-up"></i></th>
                                    <th class="w-10"> Size
                                        <!---->
                                    </th>
                                    <th class="w-10"> Type
                                        <!---->
                                    </th>
                                    <th class="w-auto"> Date
                                        <!---->
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($content['directories'] as $item)
                                <tr class="">
                                    <td class="fm-content-item unselectable"><i class="far fa-folder"></i>
                                        {{$item['path']}} </td>
                                    <td></td>
                                    <td>Folder</td>
                                    <td>{{date("Y/m/d, H:i:s", $item['timestamp'])}}</td>
                                </tr>
                                @endforeach
                                @foreach ($content['files'] as $item)
                                <tr class="">
                                    <td class="fm-content-item unselectable"><i class="far fa-file"></i>
                                        {{$item['path']}} </td>
                                    <td>{{$item['size']}} Byte</td>
                                    <td>{{$item['extension']}}</td>
                                    <td>{{date("Y/m/d, H:i:s", $item['timestamp'])}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="justify-content-between fm-info-block">
            <div class="col-auto"><span style=""> Selected: 1 Files size: 0 Bytes </span><span style="display: none;">
                    Folders: 2 Files: 1 Files size: 14 Bytes </span></div>
            <div class="col-4">
                <div class="progress" style="display: none;">
                    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                        class="progress-bar progress-bar-striped bg-info" style="width: 0%;"> 0% </div>
                </div>
            </div>
            <div class="col-auto text-right"><span style="display: none;"><i
                        class="fas fa-spinner fa-pulse"></i></span><span title="Clipboard - undefined"
                    style="display: none;"><i class="far fa-clipboard"></i></span><span title="Status"
                    class="text-success"><i class="fas fa-info-circle"></i></span></div>
        </div>
    </div>
</div>--}}
<div class="row mt-5">
    <div class="col-12">
        <div class="mb-4">
            <div id="fm"></div>
        </div>
    </div>
</div>
@endsection
@section('additional_script')
<script src="{{ asset('/vendor/file-manager/js/file-manager.js') }}"></script>
{{--<script>
    $(function () {
        ajaxSelectDisk('public',null);
        //Setup FileManager

        //Main Tree
        $(".ceemas-disk button").click(function (e) {
            ajaxSelectDisk($(e.target).val(), null, e);
        });

        //Branch
        $('.ceemas-tree-branch').on('click', 'p.unselectable', function (e) {
            var path=null;
            if ($(e.target).text()=='') {
                path = $(e.target).parent( ".unselectable" ).next().val();
                e.target = $(e.target).parent( ".unselectable" );
            } else {
                path = $(e.target).next().val();
            }
            alert(path);
            ajaxSelectDisk( $('.ceemas-tree-disk').text() , path, e);
        });


        function ajaxSelectDisk(disk, path, e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            //e.preventDefault();
            var formData = {
                disk: disk,
                path: path,
                //description: jQuery('#description').val(),
            };
            var state = jQuery('#btn-save').val();
            var type = "POST";
            var ajaxurl = "{{route('admin.ajaxSelectDisk')}}";
            $.ajax({
                type: type,
                url: ajaxurl,
                data: formData,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    //console.log(e);
                    if (path==null) {
                        $('.ceemas-tree-disk').html('<i class="far fa-hdd"></i>' + disk);
                        $('.ceemas-tree-branch').html('');
                        data['directories'].forEach(createTree);

                        function createTree(item, index) {
                            var tree = null;
                            if (item['props']['hasSubdirectories']) {
                                tree = '<li><p class="unselectable"><i class="far fa-plus-square"></i>'+item['basename']+'</p>';
                                tree += '<input type="hidden" value="'+item['path']+'">';
                                tree += '<ul class="list-unstyled fm-tree-branch" style="display: none;"></ul></li>';
                            } else {
                                tree = '<li><p class="unselectable"><i class="fas fa-minus fa-xs"></i>'+item['basename']+'</p><li>';
                            }
                            $('.ceemas-tree-branch').append(tree);
                            //document.getElementById("demo").innerHTML += index + ":" + item + "<br>";
                        }
                    } else {
                        data['directories'].forEach(createTree);

                        function createTree(item, index) {
                            var tree = null;
                            if (item['props']['hasSubdirectories']) {
                                tree = '<li><p class="unselectable" ><i class="far fa-plus-square"></i>'+item['basename']+'</p>';
                                tree += '<input type="hidden" value="'+item['path']+'">';
                                tree += '<ul class="list-unstyled fm-tree-branch" style="display: none;"></ul></li>';
                            } else {
                                tree = '<li><p class="unselectable"><i class="fas fa-minus fa-xs"></i>'+item['basename']+'</p><li>';
                            }
                            $(e.target).next().next().append(tree).css('display','block');
                            //document.getElementById("demo").innerHTML += index + ":" + item + "<br>";
                        }
                    }


                    //alert(data);
                    /*if (type_id == "date") {
                        $('#date_preview').html(data);
                    } else {
                        $('#time_preview').html(data);
                    }*/


                    //$('input[name="date_format"]').removeAttr( "checked" );
                    //$(e.target).attr("checked");
                    /*var todo = '<tr id="todo' + data.id + '"><td>' + data.id + '</td><td>' +
                        data.title + '</td><td>' + data.description + '</td>';
                    if (state == "add") {
                        jQuery('#todo-list').append(todo);
                    } else {
                        jQuery("#todo" + todo_id).replaceWith(todo);
                    }
                    jQuery('#myForm').trigger("reset");
                    jQuery('#formModal').modal('hide')*/
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
    });


</script>--}}
@endsection
