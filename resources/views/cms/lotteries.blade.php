@extends('layouts.cms')

@section('content')
    <div class="page-content sidebar-page right-sidebar-page clearfix">
        <!-- .page-content-wrapper -->
        <div class="page-content-wrapper">
            <div class="page-content-inner">
                <!-- Start .page-content-inner -->
                <div id="page-header" class="clearfix">
                    <div class="page-header">
                        <h2>抽奖记录</h2>
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
                                    <div class="col-md-2 col-xs-12 ">
                                        <!--
                                        <div class="dataTables_length" id="responsive-datatables_length"><label><span><select name="responsive-datatables_length" aria-controls="responsive-datatables" class="form-control input-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select></span></label>
                                        </div>-->
                                    </div>
                                    <div class="col-md-10 col-xs-12">
                                        <div id="responsive-datatables_filter" class="dataTables_filter">
                                            <form action="" method="get" id="searchForm">
                                                <label>
                                                    <select name="prize" class="form-control" id="prize">
                                                        <option value="">选择奖品种类/全部</option>
                                                        @foreach ($prizes as $prize)
                                                        <option value="{{$prize->id}}" @if (Request::get('prize') == $prize->id)selected="selected"@endif>{{$prize->title}}</option>
                                                        @endforeach
                                                    </select>
                                                </label>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <table id="basic-datatables" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>授权用户</th>
                                        <th>用户姓名</th>
                                        <th>用户手机号</th>
                                        <th>用户地址</th>
                                        <th>抽奖方式</th>
                                        <th>SNID</th>
                                        <th>奖品</th>
                                        <th>抽奖时间</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($lotteries as $lottery)
                                    <tr>
                                        <td>{{$lottery->id}}</td>
                                        <td><a href="{{url('cms/wechat',['id'=>$lottery->user->id])}}">{{ json_decode($lottery->user->nick_name) }}</a></td>
                                        <td>@if ($lottery->user->info == null)--@else{{$lottery->user->info->name}}@endif</td>
                                        <td>@if ($lottery->user->info == null)--@else{{$lottery->user->info->mobile}}@endif</td>
                                        <td>@if ($lottery->user->info == null)--@else{{$lottery->user->info->address}}@endif</td>
                                        <td>{{ $lottery->prize_type == 1 ? '普通' : '输码' }}</td>
                                        <td>{{ $lottery->snid ? : '--' }}</td>
                                        <td>
                                            @if ($lottery->prizeInfo != null)
                                            {{ $lottery->prizeInfo->title }}
                                            @else
                                            --
                                            @endif
                                            @if ($lottery->prize_code_id != null)
                                            <br/>
                                            {{ $lottery->prizeCode->prize_code }}
                                        </br/>
                                            @endif
                                        </td>
                                        <td>{{ $lottery->lottery_time ? : '--' }}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="dataTables_paginate paging_bootstrap" id="basic-datatables_paginate">
                                            {!! $lotteries->appends(['prize'=>Request::get('prize')])->links() !!}
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
    $('#prize').change(function(event) {
        /* Act on the event */
        $('#searchForm').submit();
    });
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
