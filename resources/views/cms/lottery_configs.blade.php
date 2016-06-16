@extends('layouts.cms')

@section('content')
    <div class="page-content sidebar-page right-sidebar-page clearfix">
        <!-- .page-content-wrapper -->
        <div class="page-content-wrapper">
            <div class="page-content-inner">
                <!-- Start .page-content-inner -->
                <div id="page-header" class="clearfix">
                    <div class="page-header">
                        <h2>奖品查看</h2>
                        <span class="txt"></span>
                    </div>

                </div>
                <!-- Start .row -->
                <div class="row">
                    <div class="col-lg-12">
                        <!-- col-lg-12 start here -->
                        <div class="panel panel-default">
                            <!-- Start .panel -->
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 ">
                                        <div class="dataTables_length" id="responsive-datatables_length">
                                        <h5 class="label label-primary">几率请输入小数，为1时几率为100%</h5></div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div id="responsive-datatables_filter" class="dataTables_filter" style="text-align:right"><a class="btn btn-warning add">+增加</a></div>

                                    </div>
                                </div>
                                <table id="basic-datatables" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>开始时间</th>
                                        <th>结束时间</th>
                                        <th>几率</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($lottery_configs as $lottery_config)
                                    <tr>
                                        <td>{{$lottery_config->id}}</td>
                                        <td>{{$lottery_config->start_time}}</td>
                                        <td>{{$lottery_config->shut_time}}</td>
                                        <td>{{$lottery_config->win_odds}}</td>
                                        <td><a href="{{ url('cms/lottery/config/update/'.$lottery_config->id) }}" title="点击更改" class="btn btn-info btn-sm update">修改</a></td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="dataTables_paginate paging_bootstrap" id="basic-datatables_paginate">
                                            {!! $lottery_configs->links() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End .panel -->
                    </div>
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
    $('.update').click(function(){
        var obj = $(this);
        var url = obj.attr('href');
        var tr = obj.parent('td').parent('tr').find('td');
        if( obj.text() == '修改' ){
            tr.eq(1).html('<input value="'+tr.eq(1).text()+'" name="start_time" class="input-sm" />');
            tr.eq(2).html('<input value="'+tr.eq(2).text()+'" name="shut_time" class="input-sm" />');
            tr.eq(3).html('<input value="'+tr.eq(3).text()+'" name="win_odds" class="input-sm" />');
            obj.removeClass('btn-info').addClass('btn-warning').text('更新');
        }
        else{
            var data = {
                'start_time':tr.find('input[name="start_time"]').val(),
                'shut_time':tr.find('input[name="shut_time"]').val(),
                'win_odds':tr.find('input[name="win_odds"]').val()
            };
            $.ajax(url, {
                dataType: 'json',
                data: data,
                type: 'post',
                success: function(json){
                    if(json.ret == 0){
                        tr.eq(1).html(json.data.start_time);
                        tr.eq(2).html(json.data.shut_time);
                        tr.eq(3).html(json.data.win_odds);
                        obj.removeClass('btn-warning').addClass('btn-info').text('修改');
                    }
                },
                error: function(){
                    alert('服务器异常，请求失败~');
                }
            });
        }

        //alert('')
        return false;
    })
    $('.timepicker').timepicker({
       upArrowStyle: 'fa fa-angle-up',
       downArrowStyle: 'fa fa-angle-down',
       showSeconds: true,
       showMeridian: false,
   });
    $('.add').click(function(){
        //var obj = $(this);
        var html = '<tr><td>--</td>';
        html += '<td><input value="" name="start_time" class="input-sm timepicker" type="text" /></td>';
        html += '<td><input value="" name="shut_time" class="input-sm timepicker" type="text" /></td>';
        html += '<td><input value="" name="win_odds" class="input-sm" /></td>';
        html += '<td><button class="btn btn-warning">提交</button></td></tr>';
        var url = '{{url("cms/lottery/config/add")}}';
        var obj = $('#basic-datatables').find('tbody').append(html);
        obj.find('input.timepicker').timepicker({
           upArrowStyle: 'fa fa-angle-up',
           downArrowStyle: 'fa fa-angle-down',
           showSeconds: true,
           showMeridian: false
       });
        obj.find('button').click(function(){
            var tr = $(this).parent('td').parent('tr').find('td');
            var data = {
                'start_time':tr.find('input[name="start_time"]').val(),
                'shut_time':tr.find('input[name="shut_time"]').val(),
                'win_odds':tr.find('input[name="win_odds"]').val()
            }
            $.ajax(url, {
                dataType: 'json',
                data:data,
                type: 'post',
                success: function(json){
                    location.reload();
                },
                error: function(){
                    alert('服务器异常，请求失败~');
                }
            });
            //alert(1);
        });
        return false;
    })
});
</script>
@endsection
