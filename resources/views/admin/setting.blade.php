@extends('ceemas::admin.layout.dashboard')
@inject('helper', 'Rakadprakoso\Ceemas\app\Traits\helperForBlade')
@section('additional_head')

<!-- Custom -->
<link rel="stylesheet" href="/assets/vendor/ceemas/custom/style.css">
@endsection
@section('additional_script')
<!-- Select2 -->
<script src="/assets/vendor/ceemas/plugins/select2/js/select2.full.min.js"></script>
<script src="/assets/vendor/ceemas/plugins/bootstrap-tagsinput/src/bootstrap-tagsinput.js"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
        $('#published_at').datetimepicker({
            format: 'YYYY-MM-DD hh:mm',
            useCurrent: true,
        });
        $('input[name="published_at"]').val(getCurrentDate());

        $("input[name='date_format']").change(function (e) {
            if ($("input[name='date_format']:checked").val() != "custom") {
                $("input[name='date_format_txt']").val($("input[name='date_format']:checked").val());
                ajaxChangeDate($("input[name='date_format']:checked").val(), e, 'date');
            }

        });

        $("input[name='date_format_txt']").change(function (e) {

            //alert(jQuery("input[name='date_format']:checked").val());
            //$(e.target).attr("checked");
            ajaxChangeDate($("input[name='date_format_txt']").val(), e, 'date');

        });

        $("input[name='time_format']").change(function (e) {
            if ($("input[name='time_format']:checked").val() != "custom") {
                $("input[name='time_format_txt']").val($("input[name='time_format']:checked").val());
                ajaxChangeDate($("input[name='time_format']:checked").val(), e, 'time');
            }

        });

        $("input[name='time_format_txt']").change(function (e) {
            ajaxChangeDate($("input[name='time_format_txt']").val(), e, 'time');

        });

        function ajaxChangeDate(value, e, type_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            var formData = {
                format: value,
                //description: jQuery('#description').val(),
            };
            var state = jQuery('#btn-save').val();
            var type = "POST";
            var ajaxurl = "{{route('ajax.dateFormat')}}";
            $.ajax({
                type: type,
                url: ajaxurl,
                data: formData,
                dataType: 'json',
                success: function (data) {
                    //alert(data);
                    if (type_id == "date") {
                        $('#date_preview').html(data);
                    } else {
                        $('#time_preview').html(data);
                    }


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
    Number.prototype.padLeft = function (base, chr) {
        var len = (String(base || 10).length - String(this).length) + 1;
        return len > 0 ? new Array(len).join(chr || '0') + this : this;
    }

    function getCurrentDate() {
        var d = new Date,
            dformat = [d.getFullYear(),
                (d.getMonth() + 1).padLeft(),
                d.getDate().padLeft(),
            ].join('-') +
            ' ' + [d.getHours().padLeft(),
                d.getMinutes().padLeft()
            ].join(':');
        return dformat;
    }

</script>
@endsection
@section('content_header')
<h1>Setting</h1>
@endsection
@section('content')
<div class="card card-primary card-outline">
    <form action="{{route("admin.settingSave")}}" method="post">
        @csrf
        <div class="card-body">
            <ul class="nav nav-tabs" id="setting-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="setting-general-tab" data-toggle="pill" href="#setting-general"
                        role="tab" aria-controls="setting-general" aria-selected="true">General</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="setting-writing-tab" data-toggle="pill" href="#setting-writing" role="tab"
                        aria-controls="setting-writing" aria-selected="false">Writing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="setting-reading-tab" data-toggle="pill" href="#setting-reading" role="tab"
                        aria-controls="setting-reading" aria-selected="false">Reading</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="setting-media-tab" data-toggle="pill" href="#setting-media" role="tab"
                        aria-controls="setting-media" aria-selected="false">Media</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="setting-permalinks-tab" data-toggle="pill" href="#setting-permalinks"
                        role="tab" aria-controls="setting-permalinks" aria-selected="false">Permalinks</a>
                </li>
            </ul>
            <div class="tab-custom-content">
                <p class="lead mb-0 text-right"><button type="submit" class="btn btn-success text-right"><i
                            class="fas fa-save"></i> Save</button></p>

            </div>
            <div class="tab-content" id="setting-tabContent">
                <div class="tab-pane fade show active" id="setting-general" role="tabpanel"
                    aria-labelledby="setting-general-tab">
                    <div class="form-group row">
                        <label for="input_site_title" class="col-sm-2 col-form-label">Site Title</label>
                        <div class="col">
                            <input name="site_title" type="text" class="form-control" id="input_site_title"
                                placeholder="Site Title" value="{{$ceemas_setting['site_title']}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_tagline" class="col-sm-2 col-form-label">Tagline</label>
                        <div class="col">
                            <input name="tagline" type="text" class="form-control" id="input_tagline"
                                placeholder="Tagline" value="{{$ceemas_setting['tagline']}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_site_address" class="col-sm-2 col-form-label">Site Address</label>
                        <div class="col">
                            <input name="site_address" type="text" class="form-control" id="input_site_address"
                                placeholder="Site Address" value="{{$ceemas_setting['site_address']}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_admin_email" class="col-sm-2 col-form-label">Administration Email</label>
                        <div class="col">
                            <input name="admin_email" type="text" class="form-control" id="input_admin_email"
                                placeholder="Administration Email" value="{{$ceemas_setting['admin_email']}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_timezone" class="col-sm-2 col-form-label">Timezone</label>
                        <div class="col">
                            <select name="timezone" class="select2bs4" id="input_timezone" data-placeholder="Time Zone"
                                style="width: 100%;">
                                <option value="UTC">UTC 0:00</option>
                                @foreach ($helper->getTimeZones() as $timezone)
                                @foreach ($timezone as $key=>$timezone_item)
                                @if ($ceemas_setting['timezone'] ==$key)
                                <option value="{{$key}}" selected>{{$key ." - ". $timezone_item}}</option>
                                @else
                                <option value="{{$key}}">{{$key ." - ". $timezone_item}}</option>
                                @endif
                                @endforeach
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_date_format" class="col-sm-2 col-form-label">Date Format</label>
                        @php
                        $isCustom = true;
                        @endphp
                        <div class="col-sm-6">
                            <label class="lbl-custom">{{$helper->createDate("F j, Y")}} <span
                                    class="badge badge-info px-2">F j, Y</span>
                                <input type="radio" value="F j, Y" @if ($ceemas_setting['date_format']=="F j, Y" ) @php
                                    $isCustom=false; @endphp checked @endif name="date_format">
                                <span class="checkmark"></span>
                            </label>
                            <label class="lbl-custom">{{$helper->createDate("Y - m - d")}} <span
                                    class="badge badge-info px-2">Y - m - d</span>
                                <input type="radio" value="Y - m - d" @if ($ceemas_setting['date_format']=="Y - m - d" ) @php $isCustom=false; @endphp checked @endif
                                    name="date_format">
                                <span class="checkmark"></span>
                            </label>
                            <label class="lbl-custom">{{$helper->createDate("d / m / y")}} <span
                                    class="badge badge-info px-2">d / m / y</span>
                                <input type="radio" value="d / m / y" @if ($ceemas_setting['date_format']=="d / m / y" ) @php $isCustom=false; @endphp checked @endif
                                    name="date_format">
                                <span class="checkmark"></span>
                            </label><label class="lbl-custom">Custom
                                <input type="radio" value="custom" @if ($ceemas_setting['date_format']!=null &&
                                    $isCustom==true) checked @endif name="date_format">
                                <input type="text" class="form-control form-control-sm"
                                    value="{{$ceemas_setting['date_format']}}"
                                    name="date_format_txt">
                                <span class="checkmark"></span>
                            </label>
                            <div class="date_preview alert-info alert p-2">
                                <p class="m-0">Preview : <span id="date_preview">
                                        {{$helper->createDate($ceemas_setting['date_format'])}}
                                    </span></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="input_time_format" class="col-sm-2 col-form-label">Time Format</label>
                        @php
                        $isCustom = true;
                        @endphp
                        <div class="col-sm-6">
                            <label class="lbl-custom">{{$helper->createDate("g:i a")}} <span
                                    class="badge badge-info px-2">g:i a</span>
                                <input type="radio" value="g:i a" @if ($ceemas_setting['time_format']=="g:i a" ) @php $isCustom=false; @endphp checked @endif
                                    name="time_format">
                                <span class="checkmark"></span>
                            </label>
                            <label class="lbl-custom">{{$helper->createDate("g:i A")}} <span
                                    class="badge badge-info px-2">g:i A</span>
                                <input type="radio" value="g:i A" @if ($ceemas_setting['time_format']=="g:i A" ) @php $isCustom=false; @endphp checked @endif
                                    name="time_format">
                                <span class="checkmark"></span>
                            </label>
                            <label class="lbl-custom">{{$helper->createDate("H:i")}} <span
                                    class="badge badge-info px-2">H:i</span>
                                <input type="radio" value="H:i" @if ($ceemas_setting['time_format']=="H:i" ) @php $isCustom=false; @endphp checked @endif
                                    name="time_format">
                                <span class="checkmark"></span>
                            </label><label class="lbl-custom">Custom
                                <input type="radio" value="custom" @if ($ceemas_setting['time_format']!=null &&
                                    $isCustom==true) checked @endif name="time_format">
                                <input type="text" class="form-control form-control-sm"
                                    value="{{$ceemas_setting['time_format']}}"
                                    name="time_format_txt">
                                <span class="checkmark"></span>
                            </label>
                            <div class="time_preview alert-info alert p-2">
                                <p class="m-0">Preview : <span id="time_preview">
                                        {{$helper->createDate($ceemas_setting['time_format'])}}
                                    </span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="setting-writing" role="tabpanel" aria-labelledby="setting-writing-tab">
                    Mauris tincidunt mi at erat gravida, eget tristique urna bibendum. Mauris pharetra purus ut ligula
                    tempor, et vulputate metus facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Maecenas
                    sollicitudin, nisi a luctus interdum, nisl ligula placerat mi, quis posuere purus ligula eu lectus.
                    Donec nunc tellus, elementum sit amet ultricies at, posuere nec nunc. Nunc euismod pellentesque
                    diam.
                </div>
                <div class="tab-pane fade" id="setting-reading" role="tabpanel" aria-labelledby="setting-reading-tab">
                    Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id
                    mi
                    placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique
                    nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis
                    urna
                    a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non
                    luctus
                    efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex
                    vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur
                    eget
                    sem eu risus tincidunt eleifend ac ornare magna.
                </div>
                <div class="tab-pane fade" id="setting-media" role="tabpanel" aria-labelledby="setting-media-tab">
                    Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac,
                    ornare
                    sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod
                    molestie
                    tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec
                    pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl
                    commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet
                    facilisis.
                </div>
                <div class="tab-pane fade" id="setting-permalinks" role="tabpanel"
                    aria-labelledby="setting-permalinks-tab">
                    Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac,
                    ornare
                    sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod
                    molestie
                    tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec
                    pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl
                    commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet
                    facilisis.
                </div>
            </div>
        </div>
    </form>
    <!-- /.card -->
</div>
@endsection
