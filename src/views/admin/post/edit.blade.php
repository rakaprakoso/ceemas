@extends('layout.main-admin')
@section('title', 'Edit Article')
@section('additional_head')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />

<!-- Include Bootstrap Datepicker -->
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" />

<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<style>
    .note-editor.note-airframe,
    .note-editor.note-frame {
        background: white;
    }
</style>
@endsection
@section('additional_script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>


<script>
    $(document).ready(function () {
        /*$('#summernote').summernote({
            placeholder: 'Enter news content',
            tabsize: 2,
            height: 300
        });*/

        $("#input-title").change(function () {
            var x = $("#input-title").val();
            var url = x.replace(/\ /g, '-').toLowerCase();
            $("#inputurl").val(url);
        });
        $("#content-temp").change(function () {
            var content = $('#content-temp').val().split("\n");
            $("#hiddencontent").empty();
            for (let index = 0; index < content.length; index++) {
                var txt = $("<input type = 'hidden' name = 'content[]'/>").val(content[index]);
                $("#hiddencontent").append(txt);
            }
        });


        $("#startdate_datepicker").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });
        $('.custom-file-input').on('change', function () {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        $('select[name=category]').change(function () {
            let code = $(this).val() + '-';
            $('input[name=code_product]').val(code);
        });

        $('.img-thumbnail').height($('.form-pic-preview').height() - 10);

    });
</script>
@endsection
@section('page-container')
<div class="h-100vh bg-cover">
    <div class="container py-3">
        <div class="container py-3">
            <div class="d-flex flex-row justify-content-between">
                <h1>Edit Blog</h1>
                <form action="{{route('admin.blog.destroy', $blog->id)}}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i> Delete
                        Data</button>
                </form>
            </div>

            <form method="post" action="{{route('admin.blog.update', $blog->id)}}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">

                    <div class="col-md-6">

                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                id="input-title" aria-describedby="" placeholder="Enter Title" name="title"
                                value="{{$blog->title}}">
                            @error('title')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Publish Date</label>
                            <div class="start_date input-group mb-4">
                                <input class="form-control @error('published') is-invalid @enderror start_date" type="text" placeholder="Enter Date"
                                    id="startdate_datepicker" name="published" value="{{$blog->published}}">
                                <div class="input-group-append">
                                    <span class="fa fa-calendar input-group-text start_date_calendar"
                                        aria-hidden="true "></span>
                                </div>
                                @error('published')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <label>URL</label>
                            <input type="text" class="form-control @error('url') is-invalid @enderror" id="inputurl"
                                aria-describedby="" placeholder="Enter URL" name="url" value="{{$blog->url}}">
                            @error('url')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                            @enderror
                        </div>



                    </div>
                <div class="col-md-6">
                    <div class="form-group h-100 d-flex mb-0  flex-column">
                        <label>Picture</label>
                        <div class="form-pic-preview border flex-grow-1">
                            @if ($blog->thumbnail_img!=null)
                            <div class="w-100 h-100 d-none dummy-pic">
                                <h1 class="m-auto"><i class="fa fa-picture-o" aria-hidden="true"></i></h1>
                            </div>
                            <img class="img-thumbnail img-contain w-100" id="blah"
                                src="{{asset('/img/blog/thumbnail/'.$blog->thumbnail_img)}}" alt="{{$blog->tit}}" />
                            @else
                            <div class="w-100 h-100 d-flex dummy-pic">
                                <h1 class="m-auto"><i class="fa fa-picture-o" aria-hidden="true"></i></h1>
                            </div>
                            <img class="img-thumbnail img-contain w-100 d-none" id="blah" src="{{$blog->thumbnail_img}}"
                                alt="{{$blog->title}}" />
                            @endif

                        </div>
                        <div class="custom-file mb-3">
                            <input type="file" class="custom-file-input" id="customFile" name="file"
                                onchange="readUrl(this)">
                            <input type="hidden" name="pic_indicator" value="">
                            <label class="custom-file-label text-truncate" for="customFile">Choose file</label>
                        </div>
                        @error('file')
                        <span class="badge badge-danger">{{$message}}</span>
                        @enderror

                    </div>



                </div>


        </div>
        <div class="row">
            <div class="col">

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Content</label>
                    {{--<textarea id="summernote" name="description"></textarea>--}}
                    <textarea name="description_text">{!!$blog->content!!}</textarea>
                    <script>
                        CKEDITOR.replace('description_text');
                    </script>
                </div>

                <button type="submit" class="btn btn-success">Update Data</button>
            </div>
        </div>
        </form>
    </div>
</div>
</div>
<script>
    function readUrl(input) {

        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#blah').removeClass('d-none').attr('src', e.target.result);
                $('.dummy-pic').addClass('d-none').removeClass('d-flex');
                let imgData = e.target.result;
                let imgName = input.files[0].name;
                input.setAttribute("data-title", imgName);
                $('.custom-file-label.text-truncate').text(imgName);
                $('input[name=pic_indicator]').val('yes');
                //alert($('input[name=pic_indicator]').val());
                //console.log(e.target.result);



            }
            reader.readAsDataURL(input.files[0]);
        } else {
            $('#blah').attr('src', '{!!asset("/img/blog/thumbnail/".$blog->thumbnail_img)!!}');
            $('input[name=pic_indicator]').val('');
            $('.custom-file-label.text-truncate').text('Choose file');
            //$('.dummy-pic').removeClass('d-none').addClass('d-flex');

        }


    }
</script>
@endsection