@extends('layouts.cms')

@section('content')
    <div class="page-content sidebar-page right-sidebar-page clearfix">
        <!-- .page-content-wrapper -->
        <div class="page-content-wrapper">
            <div class="page-content-inner">
                <!-- Start .page-content-inner -->
                <div id="page-header" class="clearfix">
                    <div class="page-header">
                        <h2>照片管理</h2>
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
                                <table id="basic-datatables" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>会话ID</th>
                                        <th>图片</th>
                                        <th>态度</th>
                                        <th>自己名</th>
                                        <th>好友名</th>
                                        <th>创建时间</th>
                                        <th>创建IP</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($photos as $photo)
                                    <tr>
                                        <td>{{ $photo->id }}</td>
                                        <td><a href="#" title="{{$photo->sid}}">{{substr($photo->sid,0,10).'...'}}</a></td>
                                        <td><a href="{{asset('uploads/'.$photo->image)}}"><img src="{{asset('uploads/'.$photo->image)}}" class="img-thumbnail" style="max-height: 300px;max-width: 300px;" /></a></td>
                                        <td>{{ $photo->attitude }}</td>
                                        <td>{{ $photo->self_name }}</td>
                                        <td>{{ $photo->friend_name }}</td>
                                        <td>{{ $photo->created_time }}</td>
                                        <td>{{ $photo->created_ip }}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="dataTables_paginate paging_bootstrap" id="basic-datatables_paginate">
                                            {!! $photos->links() !!}
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
