@extends('layouts.app')
@section('content')
<div class="wrapper">
	<div class="page page0">
    	<div class="innerDiv">
        	<div class="loadingTxt">已加载：<span>0</span>%</div>
        </div>
    </div>

	<div class="page page1" style="display:none;">
    	<div class="innerDiv">
            <div class="abs earthPage1"></div>
            <div class="abs manPage1 man1 man1Act"></div>
            <div class="bgImg page1Img1">
            	<div class="innerDiv">
                	<img src="{{cdn('assets/images/page1Img11.png')}}" class="abs page1Img11">
                    <img src="{{cdn('assets/images/page1Img12.png')}}" class="abs page1Img12">
                    <img src="{{cdn('assets/images/page1Img13.png')}}" class="abs page1Img13">
                    <img src="{{cdn('assets/images/page1Img14.png')}}" class="abs page1Img14">
                </div>
            </div>
            <div class="abs page1BtnLine">
            	<a href="javascript:void(0);" onClick="showAlert('活动已结束');"><img src="{{cdn('assets/images/btn1.png')}}"></a><br>
                <a href="javascript:void(0);" onClick="showAlert('活动已结束');"><img src="{{cdn('assets/images/btn2.png')}}"></a>
                <div style="padding-top:25px;">
                	<a href="javascript:void(0);" onClick="showRule();"><img src="{{cdn('assets/images/btn3.png')}}"></a>
                    <a href="javascript:void(0);" onClick="showList();"><img src="{{cdn('assets/images/btn4.png')}}"></a>
                </div>
            </div>
            <img src="{{cdn('assets/images/logo.png')}}" class="logo">
        </div>
    </div>

    <div class="page pageSnid" style="display:none;">
    	<div class="innerDiv">
            <div class="abs snidBlock">
            	<div class="innerDiv">
                	<input type="tel" class="abs snidTxt">
                    <a href="javascript:void(0);" class="abs snidBtn" onClick="showAlert('活动已结束');"><img src="{{cdn('assets/images/btn6.png')}}"></a>
                    <a href="javascript:void(0);" class="abs snidClose" onClick="snidClose();"><img src="{{cdn('assets/images/closeBtn.png')}}"></a>
                </div>
            </div>
        </div>
    </div>

    <div class="page pageRule" style="display:none;">
    	<div class="innerDiv">
            <div class="abs ruleBlock">
            	<div id="scrollbar">
                    <div class="scrollbar">
                        <div class="track">
                            <div class="thumb">
                                <div class="end"></div>
                            </div>
                        </div>
                    </div>
                    <div class="viewport">
                        <div class="overview">
                            <div class="rule">
                            	<img src="{{cdn('assets/images/ruleImg.png')}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a onClick="_hmt.push(['_trackEvent','event','click','bottom']);setTimeout(function(){window.location.href='http://touch.acer.com.cn/summer2016/'},500);" href="javascript:void(0);" class="bottomBanner2"><img src="{{cdn('assets/images/bottomBanner.png')}}"></a>
            <a href="javascript:void(0);" class="abs btn5" onClick="closeRule();"><img src="{{cdn('assets/images/btn5.png')}}"></a>
            <img src="{{cdn('assets/images/logo.png')}}" class="logo2">
        </div>
    </div>

    <div class="page page2" style="display:none;">
    	<div class="innerDiv">
            <div class="bgImg page1Img1"></div>
            <img src="{{cdn('assets/images/page2Img3.png')}}" class="abs pae2Img3a">
            <img src="{{cdn('assets/images/page2Img3.png')}}" width="70" class="abs pae2Img3b">
            <img src="{{cdn('assets/images/page2Img3.png')}}" class="abs pae2Img3c">
            <img src="{{cdn('assets/images/page2Img2.png')}}" class="abs page2Img2 page2Img2Act1">
            <img src="{{cdn('assets/images/page2Img1.png')}}" class="abs page2Img1">
            <div class="abs earth"></div>
            <p class="colddownTime" style="display:none;"><font>10</font> s</p>
            <div class="abs man"></div>
            <canvas style="position:absolute; left:0; top:0; display:none;" id="touchCanvas" width="640" height="1139"></canvas>
            <a href="javascript:void(0);" class="abs btn7" onClick="gameStart('{{url("lottery")}}');"><img src="{{cdn('assets/images/btn7.png')}}"></a>
            <img src="{{cdn('assets/images/logo.png')}}" class="logo">
        </div>
    </div>


    <div class="page page3" style="display:none;">
    	<div class="innerDiv">
            <div class="bgImg page3Img1"></div>
            <div class="bgImg page3Img3">
            	<div class="innerDiv">
                	<div class="abs eNumb"></div>
                    <img src="{{cdn('assets/images/ai12.png')}}" class="abs aiImg">
                    <div class="abs aiTxt">携程旅行 优惠大礼包</div>
                    <a onClick="_hmt.push(['_trackEvent','event','click','ctrip']);setTimeout(function(){window.location.href='https://contents.ctrip.com/activitysetupapp/mkt/index/Acer?popup=close'},500);" href="javascript:void(0);" class="abs btn8"><img src="{{cdn('assets/images/btn8.png')}}"></a>
                    <a href="javascript:void(0);" class="abs btn17" onClick="showShareNote();"><img src="{{cdn('assets/images/btn17.png')}}"></a>
                    <a href="javascript:void(0);" class="abs btn18" onClick="playAgain();"><img src="{{cdn('assets/images/btn18.png')}}"></a>
                    <a href="javascript:void(0);" class="abs btn19" onClick="showAwardRule();"><img src="{{cdn('assets/images/btn19.png')}}"></a>
                </div>
            </div>
            <img src="{{cdn('assets/images/logo.png')}}" class="logo">
        </div>
    </div>

    <div class="page page5" style="display:none;">
    	<div class="innerDiv">
			<div class="bgImg page3Img4"></div>
        	<div class="abs eNumb" style="left:397px; top:185px;"></div>
            <a href="javascript:void(0);" class="abs btn22" onClick="showShareNote();"><img src="{{cdn('assets/images/btn22.png')}}"></a>
			<a href="javascript:void(0);" class="abs btn18b" onClick="playAgain();"><img src="{{cdn('assets/images/btn18.png')}}"></a>
			<a href="javascript:void(0);" class="abs btn19b" onClick="showAwardRule();"><img src="{{cdn('assets/images/btn19.png')}}"></a>
            <img src="{{cdn('assets/images/logo.png')}}" class="logo">
        </div>
    </div>

    <div class="page page3b" style="display:none;">
    	<div class="innerDiv">
            <div class="bgImg page3Img2"></div>
            <div class="bgImg page3Img3">
            	<div class="innerDiv">
                	<div class="abs eNumb"></div>
                	<!--<div class="awdTxt abs bgImg awdTxt1"></div>-->
			<div id="prizeInfo">
	                    <!--<img src="{{cdn('assets/images/ai13.png')}}" class="abs aiImg2">
	                    <div class="abs aiTxt2">蜘蛛网 电影优惠券<br><span>SN1234567890</span></div>-->
			</div>
                    <!--未提交过信息-->
			@if (null == $info)
			<input type="text" class="infoTxt infoTxt1" maxlength="20">
			<input type="tel" class="infoTxt infoTxt2" maxlength="11">
			<input type="text" class="infoTxt infoTxt3" maxlength="40">
                    <a href="javascript:void(0);" class="abs btn10" onClick="submitInfo('{{url("info")}}');"><img src="{{cdn('assets/images/btn15.png')}}"></a>
                    <img src="{{cdn('assets/images/infoSubmited.png')}}" class="abs infoSubmited" style="display:none;">
			@else
                    <!--提交过信息-->
			<input type="text" class="infoTxt infoTxt1" maxlength="20" value="{{$info->name}}" disabled="disabled">
			<input type="tel" class="infoTxt infoTxt2" maxlength="11" value="{{$info->mobile}}" disabled="disabled">
			<input type="text" class="infoTxt infoTxt3" maxlength="40" value="{{$info->address}}" disabled="disabled">
                    <img src="{{cdn('assets/images/infoSubmited.png')}}" class="abs infoSubmited">
			@endif
                    <a href="javascript:void(0);" class="abs btn20" onClick="showShareNote();"><img src="{{cdn('assets/images/btn20.png')}}"></a>
                    <a href="javascript:void(0);" class="abs btn21" onClick="playAgain();"><img src="{{cdn('assets/images/btn21.png')}}"></a>
                    <a href="javascript:void(0);" class="abs btn12" onClick="showAwardRule();"><img src="{{cdn('assets/images/btn16.png')}}"></a>
                </div>
            </div>
            <img src="{{cdn('assets/images/logo.png')}}" class="logo2">
        </div>
    </div>

    <div class="page page4" style="display:none;">
    	<div class="innerDiv">
            <div class="abs listBlock">
            	<div id="scrollbar2">
                    <div class="scrollbar">
                        <div class="track">
                            <div class="thumb">
                                <div class="end"></div>
                            </div>
                        </div>
                    </div>
                    <div class="viewport">
                        <div class="overview">
                            <div class="awardList">
                            	<div class="alOuter">
@foreach ($lotteries as $lottery)
@if ($lottery->has_lottery == 1)
<div class="awardInit">
	<div class="innerDiv">
    	<span class="abs awdTime">中奖时间：{{date('Y-m-d', strtotime($lottery->lottery_time))}}</span>
		<a href="javascript:void(0);" @if ( null != $lottery->prize_code_id )onclick="showCode(this);"@endif class="abs awdImg"><img src="{{cdn('assets/images/awd'.$lottery->prize.'.png')}}"></a>
		@if ( null != $lottery->prize_code_id )
		<span class="abs awdCode">{{ $lottery->prizeCode->prize_code }}</span>
		@endif
	</div>
</div>
@endif
@endforeach
@if (null != $lottery_ctrip)
<div class="awardInit">
	<div class="innerDiv">
    	<span class="abs awdTime">中奖时间：{{date('Y-m-d', strtotime($lottery_ctrip->lottery_time))}}</span>
		<a onClick="_hmt.push(['_trackEvent','event','click','ctrip']);setTimeout(function(){window.location.href='https://contents.ctrip.com/activitysetupapp/mkt/index/Acer?popup=close'},500);" href="javascript:void(0);" class="abs awdImg"><img src="{{cdn('assets/images/awd'.$lottery_ctrip->prize.'.png')}}"></a>
	</div>
</div>
@endif
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="javascript:void(0);" class="abs btn13" onClick="showShareNote();"><img src="{{cdn('assets/images/btn13.png')}}"></a>
            <a href="javascript:void(0);" class="abs btn14" onClick="goHome();"><img src="{{cdn('assets/images/btn14.png')}}"></a>

            <!--未提交过信息-->
		@if (null == $info)
		<input type="text" class="infoTxtB infoTxtB1" maxlength="20">
		<input type="tel" class="infoTxtB infoTxtB2" maxlength="11">
		<input type="text" class="infoTxtB infoTxtB3" maxlength="40">
            <a href="javascript:void(0);" class="abs btn15" onClick="submitInfo2('{{url("info")}}');"><img src="{{cdn('assets/images/btn15.png')}}"></a>
            <img src="{{cdn('assets/images/infoSubmited.png')}}" class="abs infoSubmited2" style="display:none;">
		@else
            <!--提交过信息-->
            <input type="text" class="infoTxtB infoTxtB1" maxlength="20" value="{{$info->name}}" disabled="disabled">
			<input type="tel" class="infoTxtB infoTxtB2" maxlength="11" value="{{$info->mobile}}" disabled="disabled">
			<input type="text" class="infoTxtB infoTxtB3" maxlength="40" value="{{$info->address}}" disabled="disabled">
            <img src="{{cdn('assets/images/infoSubmited.png')}}" class="abs infoSubmited2">
		@endif
            <a href="javascript:void(0);" class="abs btn16" onClick="showAwardRule();"><img src="{{cdn('assets/images/btn16.png')}}"></a>
            <img src="{{cdn('assets/images/logo.png')}}" class="logo2">
        </div>
    </div>

    <div class="page pageAwardRule" style="display:none;">
    	<div class="innerDiv">
            <div class="abs awardRule">
            	<div class="innerDiv">
                	<a href="javascript:void(0);" class="abs awardRuleCloseBtn" onClick="closeAwardRule();"><img src="{{cdn('assets/images/closeBtn.png')}}"></a>
                </div>
            </div>
        </div>
    </div>

    <div class="page pageCode" style="display:none;">
    	<div class="innerDiv">
            <p class="snCode abs"></p>
            <a href="javascript:void(0);" onclick="closeCode();" class="abs codeClose"><img src="{{cdn('assets/images/closeBtn.png')}}"></a>
        </div>
    </div>

</div>
<a onClick="_hmt.push(['_trackEvent','event','click','bottom']);setTimeout(function(){window.location.href='http://touch.acer.com.cn/summer2016/'},500);" href="javascript:void(0);" class="bottomBanner" style="display:none;"><img src="{{cdn('assets/images/bottomBanner.png')}}"></a>

<img src="{{cdn('assets/images/shareNote.png')}}" class="shareNote" onClick="closeShareNote();" style="display:none;">

<div class="alertBg" style="display:none;"></div>
<div class="alertBlock" style="display:none;">
	<div class="innerDiv">
    	<p></p>
        <a href="javascript:void(0);" class="abs btn23" onClick="closeAlert();"><img src="{{cdn('assets/images/btn23.png')}}"></a>
    </div>
</div>

{!! csrf_field() !!}
@endsection
@section('scripts')
<script>
$(document).ready(function(){
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
    var images = [];
    //images.push("{{cdn('assets/images/awdTxt1.png')}}");
    images.push("{{cdn('assets/images/earth.png')}}");
    images.push("{{cdn('assets/images/man1.png')}}");
    images.push("{{cdn('assets/images/man2.png')}}");
    images.push("{{cdn('assets/images/page1Img1.png')}}");
    images.push("{{cdn('assets/images/page3Img1.png')}}");
    images.push("{{cdn('assets/images/page3Img2.png')}}");
    images.push("{{cdn('assets/images/page3Img3.png')}}");
    images.push("{{cdn('assets/images/page4Img1.png')}}");
    images.push("{{cdn('assets/images/ruleBg.png')}}");
    images.push("{{cdn('assets/images/scrollHand.png')}}");
    images.push("{{cdn('assets/images/scrollEnd.png')}}");
    images.push("{{cdn('assets/images/snidPop.png')}}");
    loadImg(images);

    wxData.title = '{{env("WECHAT_SHARE_TITLE")}}';
    wxData.desc = '{{env("WECHAT_SHARE_DESC")}}';
    wxData.link = location.href;
    wxData.imgUrl = '{{cdn(env("WECHAT_SHARE_IMG"))}}';
    //wxData.debug = true;
    wxShare();
});
</script>
@endsection
