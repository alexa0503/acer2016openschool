@extends('layouts.app')
@section('content')
<div class="pageOuter">
	<div class="page page0">
    	<div class="innerDiv">
        	<div class="loadingTxt">已加载：<span>0</span>%</div>
        </div>
    </div>

    <div class="page page1" style="display:none;">
    	<div class="h832">
        	<div class="innerDiv">
            	<div class="bgImg page1Img1"></div>
                <a href="javascript:void(0);" class="abs btn1" onClick="showSnid();"><img src="{{cdn('assets/images/btn1.png')}}"></a>
                <a href="javascript:void(0);" class="abs btn2" onClick="goPage2();"><img src="{{cdn('assets/images/btn2.png')}}"></a>
                <a href="javascript:void(0);" class="abs btn3" onClick="showRule(1);"><img src="{{cdn('assets/images/btn3.png')}}"></a>
                <a href="javascript:void(0);" class="abs btn4" onClick="showAward();"><img src="{{cdn('assets/images/btn4.png')}}"></a>

                <div class="snidPage" style="display:none;">
                	<div class="bgImg page1Img2"></div>
                    <input type="text" class="abs snidCode" maxlength="30">
                    <a href="javascript:void(0);" class="abs btn5" onClick="submitSnid('{{url("snid")}}');"><img src="{{cdn('assets/images/btn5.png')}}"></a>
                    <a href="javascript:void(0);" class="abs page1CloseBtn" onClick="closeSnid();"><img src="{{cdn('assets/images/closeBtn.png')}}"></a>
                </div>
            </div>
        </div>
    </div>

    <div class="page page2" style="display:none;">
    	<div class="h832">
        	<div class="innerDiv">
            	<div class="bgImg page2Img3"></div>
                <div class="bgImg page2Img4"></div>
            	<div class="bgImg page2Img5"></div>
                <div class="bgImg page2Img1"></div>
                <div class="bgImg page2Img2"></div>
                <div class="bgImg page2Img8">
                	<div class="innerDiv">
                    	<div class="page2Img9"></div>
                    </div>
                </div>
                <p class="gameTime" style="display:none;">10</p>
                <div class="bgImg page2Img6a" style="display:none;"></div>
                <div class="bgImg page2Img6b" style="display:none;"></div>
                <div class="bgImg page2Img7a"></div>
                <div class="bgImg page2Img7b"></div>
                <div class="leftTouch" ontouchend="attack(1);"></div>
                <div class="rightTouch" ontouchend="attack(2);"></div>
            </div>
        </div>
    </div>

    <div class="page pageRule" style="display:none;">
    	<div class="h832">
        	<div class="innerDiv">
            	<div class="bgImg pageRuleBg"></div>
                <div class="ruleBlock">
                	<div id="scrollbar">
                        <div class="scrollbar" style="display:none;">
                            <div class="track">
                                <div class="thumb">
                                    <div class="end"></div>
                                </div>
                            </div>
                        </div>
                        <div class="viewport">
                            <div class="overview">
                                <div class="rule">
                                    <img src="{{cdn('assets/images/rule.png')}}" style="padding-top:30px;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="javascript:void(0);" class="abs pageRuleBtn1" onClick="closeRule();"><img src="{{cdn('assets/images/btn9.png')}}"></a>
                <a href="#" class="abs bottomImg"><img src="{{cdn('assets/images/bottomImg.png')}}"></a>
            </div>
        </div>
    </div>

    <div class="page pageMyAward" style="display:none;">
    	<div class="h832">
        	<div class="innerDiv">
            	<div class="bgImg pageMyAwardBg"></div>
                <img src="{{cdn('assets/images/award'.$prize_id.'.png')}}" class="bgImg awardImg">
                <div class="pageAwardBtnLine">
                	<a href="javascript:void(0);" onClick="showShare();"><img src="{{cdn('assets/images/btn7.png')}}"></a>
                	<a href="javascript:void(0);" onClick="closeAward();"><img src="{{cdn('assets/images/btn8.png')}}"></a>
                </div>
				@if (null == $info)
                <input type="text" class="infoTxt infoTxt1" maxlength="20">
                <input type="tel" class="infoTxt infoTxt2" maxlength="11">
                <input type="text" class="infoTxt infoTxt3" maxlength="40">
                <a href="javascript:void(0);" class="abs pageMyAwardBtn3" onClick="submitInfo('{{url("info")}}');"><img src="{{cdn('assets/images/btn5.png')}}"></a>
				@else
                <input type="text" class="infoTxt infoTxt1" maxlength="20" value="{{$info->name}}" disabled="disabled">
                <input type="tel" class="infoTxt infoTxt2" maxlength="11" value="{{$info->mobile}}" disabled="disabled">
                <input type="text" class="infoTxt infoTxt3" maxlength="40" value="{{$info->address}}" disabled="disabled">
				@endif
                <a href="javascript:void(0);" class="abs pageMyAwardBtn4" onClick="showRule(2);"><img src="{{cdn('assets/images/btn6.png')}}"></a>
                <img src="{{cdn('assets/images/infoSubmited.png')}}" class="abs infoSubmited" style="display:none;">
                <a href="#" class="abs bottomImg"><img src="{{cdn('assets/images/bottomImg.png')}}"></a>
            </div>
        </div>
    </div>

    <div class="page pageAlert" style="display:none;">
    	<div class="h832">
        	<div class="innerDiv">
            	<div class="bgImg pageAlertBlack"></div>
            	<div class="bgImg pageAlertBg"></div>
                <p class="alertTxt"></p>
                <a href="javascript:void(0);" class="abs pageAlertBtn1" onClick="closeAlert();"><img src="{{cdn('assets/images/closeBtn.png')}}"></a>
                <a href="javascript:void(0);" class="abs pageAlertBtn2" onClick="closeAlert();"><img src="{{cdn('assets/images/btn10.png')}}"></a>
            </div>
        </div>
    </div>
</div>

<img src="{{cdn('assets/images/logo.png')}}" class="abs logo">

<div class="loadingBg" style="display:none;"></div>
<img src="{{cdn('assets/images/loading.gif')}}" width="80" height="80" class="loadingGif" style="display:none;">

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
	images.push("{{cdn('assets/images/alertBg.png')}}");

	images.push("{{cdn('assets/images/page1Img1.png')}}");
	images.push("{{cdn('assets/images/page1Img2.png')}}");

	images.push("{{cdn('assets/images/page2Img1.png')}}");
	images.push("{{cdn('assets/images/page2Img2.png')}}");
	images.push("{{cdn('assets/images/page2Img3.png')}}");
	images.push("{{cdn('assets/images/page2Img4.png')}}");
	images.push("{{cdn('assets/images/page2Img5.png')}}");
	images.push("{{cdn('assets/images/page2Img6a.png')}}");
	images.push("{{cdn('assets/images/page2Img6b.png')}}");
	images.push("{{cdn('assets/images/page2Img7a.png')}}");
	images.push("{{cdn('assets/images/page2Img7b.png')}}");
	images.push("{{cdn('assets/images/page2Img8.png')}}");

	images.push("{{cdn('assets/images/page3Img1.png')}}");
	images.push("{{cdn('assets/images/page4Img1.png')}}");

    loadImg(images);

    wxData.title = '{{env("WECHAT_SHARE_TITLE")}}';
	@if ($has_lottery == false)
	wxData.desc = '{{env("WECHAT_SHARE_DESC_1")}}';
	@else
	wxData.desc = '{{env("WECHAT_SHARE_DESC_2")}}';
	@endif

    wxData.link = location.href;
    wxData.imgUrl = '{{cdn(env("WECHAT_SHARE_IMG"))}}';
    //wxData.debug = true;
    wxShare();
});
</script>
@endsection
