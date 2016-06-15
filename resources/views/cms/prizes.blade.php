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
                            <div class="panel-body" style="min-height:600px;">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12 ">
                                    <h5 class="label label-primary">分布值为0~10000 为0时表示不可中奖 区间范围为中奖几率</h5>
                                    </div>
                                </div>
                                <table id="basic-datatables" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>名称</th>
                                        <th>分布最小值</th>
                                        <th>分布最大值</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($prizes as $prize)
                                    <tr>
                                        <td>{{$prize->id}}</td>
                                        <td>{{$prize->title}}</td>
                                        <td>{{$prize->seed_min}}</td>
                                        <td>{{$prize->seed_max}}</td>
                                        <td><a href="{{ url('cms/prize/update/'.$prize->id) }}" title="点击更改" class="btn btn-info btn-sm update">修改</a></td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="dataTables_paginate paging_bootstrap" id="basic-datatables_paginate">
                                            {!! $prizes->links() !!}
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
            $.ajax(url, {
                dataType: 'json',
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
