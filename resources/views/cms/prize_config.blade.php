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
                                <form id="validate" class="form-horizontal group-border stripped" role="form" action="{{url('cms/prize/config/update', ['id'=>$prize_config->id])}}" method="post">
                                    {!! csrf_field() !!}
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">日期</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" name="lottery_date" class="form-control" value="{{$prize_config->lottery_date}}">
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">奖品</label>
                                        <div class="col-lg-10 col-md-9">
                                            <select class="form-control" name="prize">
                                                @foreach ($prizes as $prize)
                                                <option value="{{$prize->id}}"@if ($prize->id == $prize_config->prize) selected="selected"@endif>{{$prize->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">抽奖方式</label>
                                        <div class="col-lg-10 col-md-9">
                                            <select class="form-control" name="type">
                                                <option value="0" @if ($prize_config->
                                                    type == 0) selected="selected"@endif>输码</option>
                                                <option value="1" @if ($prize_config->
                                                    type == 1) selected="selected"@endif>普通</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- End .form-group  -->
                                    <div class="form-group">
                                        <label for="text" class="col-lg-2 col-md-3 control-label">奖品数量</label>
                                        <div class="col-lg-10 col-md-9">
                                            <input type="text" class="form-control" name="prize_num" value="{{$prize_config->prize_num}}">
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
                                </form>
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
