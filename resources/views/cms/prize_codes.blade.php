@extends('layouts.cms')

@section('content')
    <div class="page-content sidebar-page right-sidebar-page clearfix">
        <!-- .page-content-wrapper -->
        <div class="page-content-wrapper">
            <div class="page-content-inner">
                <!-- Start .page-content-inner -->
                <div id="page-header" class="clearfix">
                    <div class="page-header">
                        <h2>奖券查看</h2>
                        <span class="txt"></span>
                    </div>

                </div>
                <!-- Start .row -->
                <div class="row">
                    <div class="col-lg-12">
                        <!-- col-lg-12 start here -->
                        <div class="panel panel-default">
                            <!-- Start .panel -->
                            <div class="panel-body" style="min-height:600px;">
                                <table id="basic-datatables" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>类型</th>
                                        <th>奖券</th>
                                        <th>状态</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($prize_codes as $prize_code)
                                    <tr>
                                        <td>{{$prize_code->id}}</td>
                                        <td>@if ($prize_code->type == 1)蜘蛛网电子礼品兑换券@elseif($prize_code->type == 2)蜘蛛网电影通兑券@else蜘蛛网电子优惠券 @endif</td>
                                        <td>{{$prize_code->prize_code}}</td>
                                        <td>{{$prize_code->is_active==1?'已用':'未用'}}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="dataTables_paginate paging_bootstrap" id="basic-datatables_paginate">
                                            {!! $prize_codes->links() !!}
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
            tr.eq(2).html('<input value="'+tr.eq(2).text()+'" name="seed_min" class="input-sm" />');
            tr.eq(3).html('<input value="'+tr.eq(3).text()+'" name="seed_max" class="input-sm" />');
            obj.removeClass('btn-info').addClass('btn-warning').text('更新');
        }
        else{
            var data = {
                'seed_min':tr.find('input[name="seed_min"]').val(),
                'seed_max':tr.find('input[name="seed_max"]').val()
            };
            $.ajax(url, {
                dataType: 'json',
                data:data,
                method:'post',
                success: function(json){
                    if(json.ret == 0){
                        tr.eq(2).html(json.data.seed_min);
                        tr.eq(3).html(json.data.seed_max);
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
});
</script>
@endsection
