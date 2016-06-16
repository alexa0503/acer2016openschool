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
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12 ">
                                        <div class="dataTables_length" id="responsive-datatables_length">
                                            <form action="" method="get" id="searchForm" class="form-inline">
                                                <div class="form-group">
                                                    <label>
                                                        <select name="date" class="form-control" id="date">
                                                            <option value="">选择日期</option>
                                                            @foreach ($dates as $date)
                                                            <option value="{{$date}}"@if (Request::get('date') == $date) selected="selected"@endif>{{$date}}</option>
                                                            @endforeach
                                                        </select>
                                                    </label>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <div id="responsive-datatables_filter" class="dataTables_filter" style="text-align:right"><a class="btn btn-warning add" href="{{url('prize/config/add')}}">+增加</a></div>

                                    </div>
                                </div>
                                <table id="basic-datatables" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>日期</th>
                                        <th>奖品</th>
                                        <th>类型</th>
                                        <th>奖品数量</th>
                                        <th>已中</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($prize_configs as $prize_config)
                                    <tr>
                                        <td>{{$prize_config->lottery_date}}</td>
                                        <td>{{$prize_config->prizeInfo->title}}</td>
                                        <td>{{$prize_config->type == 1 ? '普通' : '输码'}}</td>
                                        <td>{{$prize_config->prize_num}}</td>
                                        <td>{{$prize_config->win_num}}</td>
                                        <td><a href="{{ url('cms/prize/config/update/'.$prize_config->id) }}" title="点击更改" class="btn btn-info btn-sm update">修改</a></td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="dataTables_paginate paging_bootstrap" id="basic-datatables_paginate">
                                            {!! $prize_configs->links() !!}
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
    $('#date').change(function(event) {
        /* Act on the event */
        $('#searchForm').submit();
    });
});
</script>
@endsection
