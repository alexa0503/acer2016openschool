@extends('layouts.cms')

@section('content')
    <div class="page-content sidebar-page right-sidebar-page clearfix">
        <!-- .page-content-wrapper -->
        <div class="page-content-wrapper">
            <div class="page-content-inner">
                <!-- Start .page-content-inner -->
                <div id="page-header" class="clearfix">
                    <div class="page-header">
                        <h2>信息</h2>
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
                                <!--
                                <div class="row">
                                    <div class="col-md-2 col-xs-12 ">
                                        <div class="dataTables_length" id="responsive-datatables_length"><label><span><select name="responsive-datatables_length" aria-controls="responsive-datatables" class="form-control input-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select></span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-xs-12">
                                        <div id="responsive-datatables_filter" class="dataTables_filter">
                                            <form>
                                                <label><input type="search" class="form-control input-sm" placeholder="请输入手机号" aria-controls="responsive-datatables" name="mobile" value="{{Request::get('mobile')}}"></label>
                                            </form>
                                        </div>
                                    </div>
                                </div>-->
                                <table id="basic-datatables" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>微信昵称</th>
                                        <th>姓名</th>
                                        <th>手机</th>
                                        <th>地址</th>
                                        <th>创建时间</th>
                                        <th>创建IP</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($infos as $info)
                                    <tr>
                                        <td><a href="{{url('cms/wechat',['id'=>$info->user->id])}}">{{ json_decode($info->user->nick_name) }}</a></td>
                                        <td>{{ $info->name }}</td>
                                        <td>{{ $info->mobile }}</td>
                                        <td>{{ $info->address }}</td>
                                        <td>{{ $info->created_time }}</td>
                                        <td>{{ $info->created_ip }}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="dataTables_paginate paging_bootstrap" id="basic-datatables_paginate">
                                            {!! $infos->links() !!}
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
    $('.delete').click(function(){
        var url = $(this).attr('href');
        var obj = $(this).parents('td').parent('tr');
        if( confirm('该操作无法返回,是否继续?')){
            $.ajax(url, {
                dataType: 'json',
                success: function(json){
                    if(json.ret == 0){
                        obj.remove();
                    }
                },
                error: function(){
                    alert('请求失败~');
                }
            });
        }
        return false;
    })
    $('.update').click(function(){
        var url = $(this).attr('href');
        var obj = $(this);
        $.ajax(url, {
            dataType: 'json',
            success: function(json){
                if(json.ret == 0){
                    location.reload();
                }
            },
            error: function(){
                alert('请求失败~');
            }
        });
        return false;
    })
});
</script>
@endsection
