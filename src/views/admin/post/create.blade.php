@extends('cemas::admin.layout.main')
@section('additional_head')

<!-- Custom -->
<script src="/assets_admin/plugins/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" href="/assets_admin/custom/style.css">
<link rel="stylesheet" href="/assets_admin/plugins/bootstrap-tagsinput/src/bootstrap-tagsinput.css">
@endsection
@section('additional_script')
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
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

    </script>--}}
<!-- Select2 -->
<script src="/assets_admin/plugins/select2/js/select2.full.min.js"></script>
<script src="/assets_admin/plugins/bootstrap-tagsinput/src/bootstrap-tagsinput.js"></script>
<script>
    $(document).ready(function () {
        $("#input-title").change(function () {
            var x = $("#input-title").val();
            var url = x.replace(/\ /g, '_').toLowerCase();
            url = url.replace(/\-/g, '_').toLowerCase();
            url = url.replace(/\_-_/g, '_').toLowerCase();
            url = url.replace(/\___/g, '_').toLowerCase();
            url = url.replace(/\__/g, '_').toLowerCase();
            $("#input-url").val(url);
        });
    });
    $("#propSwitch").click(function () {
        propertiesCheck();
    });

    function propertiesCheck() {
        if ($('#propSwitch').is(':checked')) {
            $('.col-content').removeClass('active');
            $('.col-properties').addClass('active');
        } else {
            $('.col-content').addClass('active');
            $('.col-properties').removeClass('active');
        }
    }
    document.addEventListener("DOMContentLoaded", function () {

        document.getElementById('button-image').addEventListener('click', (event) => {
            event.preventDefault();

            window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
        });
    });

    // set file link
    function fmSetLink($url) {
        document.getElementById('image_label').value = $url;
        document.getElementById("thumbnail_image").style.backgroundImage = "url('"+$url+"')";
        $("#temp_image").addClass('d-none');
        $("#remove_image").removeClass('d-none');
    }
    $("#remove_image").click(function () {
        document.getElementById('image_label').value = null;
        document.getElementById("thumbnail_image").style.backgroundImage = "none";
        $("#temp_image").removeClass('d-none');
        $("#remove_image").addClass('d-none');
    });

</script>
@endsection
@section('content_header')
<h1>Add New Post</h1>
@endsection
@section('content')
<div class="row">
    <div class="col">
        <form method="post" action="{{route('admin.post.store')}}" enctype="multipart/form-data">
            <input name="title" id="input-title" class="form-control form-control-lg mb-3" type="text"
                placeholder="Post Title">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Properties</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Category</label>
                                <select class="select2bs4" multiple="multiple" data-placeholder="Select a State"
                                    style="width: 100%;">
                                    <option>Alabama</option>
                                    <option>Alaska</option>
                                    <option>California</option>
                                    <option>Delaware</option>
                                    <option>Tennessee</option>
                                    <option>Texas</option>
                                    <option>Washington</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tags</label>
                                <select multiple data-role="tagsinput" class="form-control" style="width: 100%;">
                                    <option value="Amsterdam">Amsterdam</option>
                                    <option value="Washington">Washington</option>
                                    <option value="Sydney">Sydney</option>
                                    <option value="Beijing">Beijing</option>
                                    <option value="Cairo">Cairo</option>
                                  </select>
                            </div>

                            <div class="form-group">
                                <label>Published at</label>
                                <div class="input-group date" id="timepicker" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input"
                                        data-target="#timepicker" />
                                    <div class="input-group-append" data-target="#timepicker"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                                    </div>
                                </div>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label>Visibility</label>
                                <select class="select2bs4" style="width: 100%;">
                                    <option selected>Publish</option>
                                    <option>Draft</option>
                                </select>
                            </div>

                        </div>
                        <div class="col-md-6 d-flex flex-column">
                            <div class="form-group">
                                <label>URL</label>
                                <input id="input-url" type="text" class="form-control" placeholder="Enter url">
                            </div>
                            <div class="form-group d-flex flex-grow-1 flex-column">
                                <label>Featured Image</label>
                                <div class="flex-grow-1 border rounded d-flex" id="thumbnail_image">
                                    <button type="button" id="remove_image" class="btn btn-danger d-none"><i class="fas fa-times-circle"></i></button>
                                    <img src="/assets_admin/img/icons/img_icon.png" id="temp_image" class="m-auto" alt="">
                                </div>
                                <div class="input-group">
                                    <input type="text" id="image_label" readonly class="form-control" name="image"
                                        aria-label="Image" aria-describedby="button-image" placeholder="Select your file">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button"
                                            id="button-image">Browse</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.row -->


                </div>

            </div>
            <textarea name="content" class="mb-5" id="editor1" rows="40">
            </textarea>
            {{--<div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="propSwitch">
                        <label class="custom-control-label" for="propSwitch">Show Properties</label>
                    </div>--}}
            <button type="button" class="btn btn-lg btn-block btn-success my-3"><i class="fas fa-upload"></i> Publish</button>
        </form>
    </div>
</div>
<script>
    CKEDITOR.replace('content', {
        filebrowserImageBrowseUrl: '/file-manager/ckeditor'
    });

</script>
<!-- /.content -->
{{--<div class="h-100vh bg-cover">
    <div class="container py-3">
        <div class="container py-3">
            <h1>Add Article</h1>
            <form method="post" action="{{route('admin.post.store')}}" enctype="multipart/form-data">
@csrf
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="input-title"
                aria-describedby="" placeholder="Enter Title" name="title" value="{{old('title')}}">
            @error('title')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label>Publish Date</label>
            <div class="start_date input-group mb-4">
                <input class="form-control start_date @error('published') is-invalid @enderror " type="text"
                    placeholder="Enter Date" id="startdate_datepicker" name="published" value="{{old('published')}}">
                <div class="input-group-append">
                    <span class="fa fa-calendar input-group-text start_date_calendar" aria-hidden="true "></span>
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
            <input type="text" class="form-control @error('url') is-invalid @enderror" id="inputurl" aria-describedby=""
                placeholder="Enter URL" name="url" value="{{old('url')}}">
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
                <div class="w-100 h-100 d-flex dummy-pic">
                    <h1 class="m-auto"><i class="fa fa-picture-o" aria-hidden="true"></i></h1>
                </div>
                <img class="img-thumbnail img-contain w-100 d-none" id="blah" src="#" alt="image" />
            </div>
            <div class="custom-file mb-3">
                <input type="file" class="custom-file-input" id="customFile" name="file" onchange="readUrl(this)">
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
            {{--<textarea id="summernote" name="description"></textarea>--/}}
            <textarea name="description_text">{{old('description_text')}}</textarea>
            <script>
                CKEDITOR.replace('description_text');

            </script>
        </div>

        <button type="submit" class="btn btn-success">Submit</button>
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
                console.log(e.target.result);



            }
            reader.readAsDataURL(input.files[0]);
        } else {
            $('#blah').addClass('d-none').attr('src', '');
            $('.dummy-pic').removeClass('d-none').addClass('d-flex');

        }


    }

</script>--}}
@endsection
