@extends('layouts.app')
@section('content')
<div class="container">
    <div class="content">
        <div class="title">测试页面</div>
        <div class="desc"></div>
    </div>
</div>
@endsection
@section('scripts')
<script>
$(document).ready(function(){
    //wxData.title = '{{env("WECHAT_SHARE_TITLE")}}';
    //wxData.desc = '{{env("WECHAT_SHARE_DESC")}}';
    //wxData.link = location.href;
    //wxData.imgUrl = '{{asset(env("WECHAT_SHARE_IMG"))}}';
    //wxData.debug = true;
    wxShare();
});
</script>
@endsection
