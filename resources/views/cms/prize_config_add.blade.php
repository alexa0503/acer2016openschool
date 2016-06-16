@extends('layouts.cms')

@section('content')
    <div class="page-content sidebar-page right-sidebar-page clearfix">
        <!-- .page-content-wrapper -->
        <div class="page-content-wrapper">
            <div class="page-content-inner">
                <!-- Start .page-content-inner -->
                <div id="page-header" class="clearfix">
                    <div class="page-header">
                        <h2>奖品配置</h2>
                        <span class="txt"></span>
                    </div>

                </div>
                <!-- Start .row -->
                <div class="row">
                    <div class="col-lg-12">
                        <!-- col-lg-12 start here -->
                        <div class="panel panel-default">
                            <!-- Start .panel -->
                            <div class="panel-body pt0 pb0">
                                {{ Form::open(array('url' => 'cms/prize/config/add', 'class'=>'form-horizontal group-border stripped', 'id'=>'form')) }}

                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">日期</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="lottery_date" class="form-control" value="">
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">奖品</label>
                                        <div class="col-lg-10 col-md-9">
                                            <select class="form-control" name="prize">
                                                @foreach ($prizes as $prize)
                                                <option value="{{$prize->id}}">{{$prize->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">抽奖方式</label>
                                        <div class="col-lg-10 col-md-9">
                                            <select class="form-control" name="type">
                                                <option value="0">输码</option>
                                                <option value="1">普通</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">奖品数量</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" class="form-control" name="prize_num" value="">
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label class="col-lg-2 col-md-3 control-label"></label>
                                        <div class="col-lg-10 col-md-9">
                                            <button class="btn btn-default ml15" type="submit">提 交</button>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    {{ Form::close() }}
                            </div>
                        </div>
                        <!-- End .panel -->
                    </div>
                    <!-- col-lg-12 end here -->
                </div>
                <!-- End .row -->
            </div>
            <!-- End .page-content-inner -->
        </div>
        <!-- / page-content-wrapper -->
    </div>
@endsection
@section('scripts')
<script>
$(document).ready(function() {
    $('#form').submit(function(){
        var url = $(this).attr('action');
        var data = $(this).serializeArray();
        $.ajax(url,{
            data: data,
            dataType: 'json',
            method: 'post',
            success: function() {
                location.href="{{url('cms/prize/configs')}}"+'?date='+$('input[name="lottery_date"]').val();
            },
            error: function(xhr){
                var json = jQuery.parseJSON(xhr.responseText);
                var keys = Object.keys(json);
                console.log(keys);
                $('#form .form-group').removeClass('has-error').find('.help-block').remove();
                $('#form .form-group').each(function(){
                    var name = $(this).find('input').attr('name');
                    if( jQuery.inArray(name, keys) != -1){
                        $(this).addClass('has-error');
                        $(this).find('div').append('<label class="help-block" for="'+name+'">'+json[name]+'</label>');
                    }
                })
            }
        });
        return false;
    })
});
</script>
@endsection
