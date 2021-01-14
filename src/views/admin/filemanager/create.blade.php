@extends('layout.main-admin')
@section('additional_script')
<script type="text/javascript">
    $('.dropzone-wrapper').on('dragover', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass('dragover');
    });
    $('.dropzone-wrapper').on('dragleave', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass('dragover');
    });
    $('.dropzone-wrapper').on('drop', function (e) {
        //e.preventDefault();
        //e.stopPropagation();
        $(this).removeClass('dragover');
    });
    $('.remove-preview').on('click', function () {
        var boxZone = $(this).parents('.preview-zone').find('.box-body');
        var previewZone = $(this).parents('.preview-zone');
        var dropzone = $(this).parents('.form-group').find('.dropzone');
        boxZone.empty();
        previewZone.addClass('hidden');
        reset(dropzone);
    });


    $("#GenerateLink").click(function () {
        var link = $('#FormYoutubeLink').val();
        link = youtube_parser(link);
        var api_key = "AIzaSyBP9SCeAaaXJTBthqJcPdyO1S5LVUXQwaA";
        var src = 'https://www.youtube.com/embed/' + link;
        var img_src = 'https://i.ytimg.com/vi/' + link + '/maxresdefault.jpg';
        $("#videothumbnail").attr('src', src);
        //$("#imgthumbnail").attr('src', img_src);
        $('#FormYoutubeID').val(link);


        $.ajax({
            type: "GET",
            dataType: "json",
            //data:{name: name},
            url: "https://www.googleapis.com/youtube/v3/videos?id=" + link + "&key=" + api_key +
                "&fields=items(id,snippet(title),statistics)&part=snippet,statistics",
            success: function (data) {
                //alert('Get Success');
                console.log(data);
                $("#FormTitle").val(data['items'][0]['snippet']['title']);
                generate_URL();
                $(".embed-responsive").removeClass('d-none');
            }
        });

    });
    $("#FormTitle").change(function () {
        generate_URL();
    });
</script>

@endsection
@section('content-wrapper')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">Add Video</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Quick Example</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{route('admin.file.store')}}" method="POST" id="mediaupload" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">



                                        <div class="form-group">
                                            <label for="FormYoutubeLink">Youtube URL</label>


                                            <div class="input-group input-group">
                                                <input type="text" class="form-control" id="FormYoutubeLink"
                                                    placeholder="Enter Youtube URL">
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-primary"
                                                        id="GenerateLink">Generate</button>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputFile">File input</label>
                                            {{--<div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="exampleInputFile">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="">Upload</span>
                                                </div>
                                            </div>--}}
                                            <div class="dropzone-wrapper">
                                                <div class="dropzone-desc">
                                                    <i class="fa fa-file-o" aria-hidden="true"></i>
                                                    <p class="m-0">Choose an image file or drag it here.</p>
                                                </div>
                                                <input type="file" name="file" id="fileinput" class="dropzone"
                                                    {{--multiple="" accept="image/*"--}}>
                                            </div>
                                        </div>
                                        

                                        <div class="form-group">
                                            <label for="FormYoutubeID">Youtube ID</label>
                                            <input readonly type="text" class="form-control" id="FormYoutubeID"
                                                placeholder="Enter Youtube ID" name="url_video">
                                        </div>
                                        <div class="form-group">
                                            <label for="FormTitle">Title</label>
                                            <input type="text" class="form-control" id="FormTitle"
                                                placeholder="Enter Title" name="title">
                                        </div>
                                        <div class="form-group">
                                            <label for="FormSeries">Series</label>
                                            <input type="text" class="form-control" id="FormSeries"
                                                placeholder="Enter Title" name="series">
                                        </div>
                                        <div class="form-group">
                                            <label for="FormURL">URL</label>
                                            <input type="text" class="form-control" id="FormURL"
                                                placeholder="Enter Title" name="url_web">
                                        </div>


                                    </div>
                                    <div class="col-lg-6">
                                        <div class="embed-responsive embed-responsive-16by9 d-none">
                                            <iframe width="1280" height="640" id="videothumbnail" src="" frameborder="0"
                                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen=""></iframe>

                                        </div>

                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection