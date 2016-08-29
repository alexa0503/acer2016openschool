//找到url中匹配的字符串
function findInUrl(str) {
    url = location.href;
    return url.indexOf(str) == -1 ? false : true;
}
//获取url参数
function queryString(key) {
    return (document.location.search.match(new RegExp("(?:^\\?|&)" + key + "=(.*?)(?=&|$)")) || ['', null])[1];
}

//产生指定范围的随机数
function randomNumb(minNumb, maxNumb) {
    var rn = Math.round(Math.random() * (maxNumb - minNumb) + minNumb);
    return rn;
}

var wHeight, oHeight;
$(document).ready(function() {
    wHeight = oHeight = $(window).height();
    if (wHeight < 832) {
        wHeight = 832;
    }
    if (oHeight < 950) {
        $('.pageRule').css('padding-bottom', (950 - oHeight) + 'px');
        $('.pageMyAward').css('padding-bottom', (950 - oHeight) + 'px');
    }
    $('.pageOuter').height(wHeight);
    $('.page').height(wHeight);
    $('.h832').css('padding-top', (wHeight - 832) / 2 + 'px');
    $('.page2').on('touchmove', function(e) {
        e.preventDefault();
    });
    //loadImg();
});

function loadImg(images) {
    //var images=[];


    /*图片预加载*/
    var imgNum = 0;
    $.imgpreload(images, {
        each: function() {
            var status = $(this).data('loaded') ? 'success' : 'error';
            if (status == "success") {
                var v = (parseFloat(++imgNum) / images.length).toFixed(2);
                $(".loadingTxt span").html(Math.round(v * 100));
            }
        },
        all: function() {
            goPage1();
        }
    });
}

function goPage1() {
    $('.page0').fadeOut(500);
    $('.page1').fadeIn(500);
}

function showSnid() {
    $('.snidPage').show();
}

function closeSnid() {
    $('.snidPage').hide();
}

function showLoading() {
    $('.loadingBg').show();
    $('.loadingGif').show();
}

function closeLoading() {
    $('.loadingBg').hide();
    $('.loadingGif').hide();
}

function pageAlert(txt) {
    $('.alertTxt').removeClass('alertTxt1', 'alertTxt2');
    $('.alertTxt').html(txt);
    if (txt.length > 16 && txt.length <= 28) {
        $('.alertTxt').addClass('alertTxt1');
    } else if (txt.length > 28) {
        $('.alertTxt').addClass('alertTxt2');
    }
	else{
		$('.alertTxt').removeClass('alertTxt1', 'alertTxt2');
		}
    $('.pageAlert').show();
}

function closeAlert() {
    $('.pageAlert').hide();
}

var ruleBack = 1;

function showRule(e) {
    ruleBack = e;
    $('.page').hide();
    window.scroll(0, 0);
    $('.pageRule').show();
    $('#scrollbar').tinyscrollbar();
}

function closeRule() {
    $('.pageRule').hide();
    window.scroll(0, 0);
    if (ruleBack == 1) {
        $('.page1').show();
    } else if (ruleBack == 2) {
        //$('.pageMyAward').show();
        $('.page1').show();
    } else {
        $('.page1').show();
    }
}

function showAward() {
    $('.page').hide();
    $('.pageMyAward').show();
}

function closeAward() {
    $('.page1').show();
    $('.pageMyAward').hide();
}

function showShare() {

}

function submitSnid(url) {
    var snidCode = $.trim($('.snidCode').val());
    if (snidCode == '') {
        pageAlert('请输入SN码');
        return false;
    } else {
        showLoading();
        $.ajax(url, {
            data: {
                _token: $('input[name="_token"]').val(),
                snid: snidCode
            },
            type: 'post',
            dataType: 'json',
            success: function(json) {
                if (json.ret == 0) {
                    //提交成功
                    closeLoading();
                    goPage2();
                } else {
                    closeLoading();
                    alert(json.msg);
                }
            },
            error: function() {
                closeLoading();
                alert('提交失败~请联系管理员')
                    //pageAlert('提交失败~请重新尝试~');
                    //canSubmitSnid = true;
            }
        });
        //ajax提交snid码

    }
}

function goPage2() {
    $('.snidPage').hide();
    $('.page1').hide();
    $('.page2').show();
}

var hp = 476;
var lighta, lightb, delaya, delayb;
var attackNumb = 0;
var attackMax = 80;
var isFirstTouch = true;
var gameTime = 10;
var gameCurrent = 0;
var gameInterval;
var endType = 0; //1时间到 2打完
function attack(e) {
    if (isFirstTouch) {
        isFirstTouch = false;
        $('.page2Img2').fadeOut(500);
        $('.gameTime').fadeIn(500);
        gameInterval = setInterval(function() {
            gameRunTime();
        }, 1000);
    }
    attackNumb++;
    $('.page2Img1').removeClass('page2Img1Act');
    setTimeout(function() {
        $('.page2Img1').addClass('page2Img1Act');
    }, 100);
    if (e == 1) {
        clearTimeout(lighta, delaya);
        $('.page2Img6a').hide();
        delaya = setTimeout(function() {
            $('.page2Img6a').fadeIn(200);
        }, 10);
        lighta = setTimeout(function() {
            $('.page2Img6a').fadeOut(200);
        }, 150);
    } else {
        clearTimeout(lightb, delayb);
        $('.page2Img6b').hide();
        delayb = setTimeout(function() {
            $('.page2Img6b').fadeIn(200);
        }, 10);
        lightb = setTimeout(function() {
            $('.page2Img6b').fadeOut(200);
        }, 150);
    }
    $('.page2Img9').width((attackMax - attackNumb) / attackMax * hp);
    if (attackMax == attackNumb) {
        clearInterval(gameInterval);
        endType = 2;
        showLoading();
        getLottery();
    }
}

function gameRunTime() {
    gameCurrent++;
    $('.gameTime').html(gameTime - gameCurrent);
    if (gameCurrent == gameTime) {
        clearInterval(gameInterval);
        endType = 1;
        showLoading();
        getLottery();
    }
}

function gameInit() {
    attackNumb = 0;
    gameCurrent = 0;
    $('.gameTime').html('0').hide();
    $('.page2Img2').show();
    $('.page2Img6a').hide();
    $('.page2Img6b').hide();
    $('.page2Img9').width(hp);
    $('.page2Img1').removeClass('page2Img1Act');
    isFirstTouch = true;
};

function getLottery() {

    //ajax抽奖
    $.ajax(lotteryUrl, {
        data: {
            _token: $('input[name="_token"]').val()
        },
        type: 'post',
        dataType: 'json',
        success: function(json) {
            if (json.ret != 0 || json.prize_id == null) {
                var lotteryNumb = 0;
            } else {
                var lotteryNumb = json.prize_id; //1-5等奖
            }
            //成功中奖
            closeLoading();

            $('.awardImg').attr('src', 'assets/images/award' + lotteryNumb + '.png');
            $('.page2').hide();
            $('.pageMyAward').show();
            if (lotteryNumb == 0) {
                if (endType == 2) {
                    pageAlert('你一定拥有尽洪荒之力<br>很遗憾，未中奖，请再接再厉。');
                } else {
                    pageAlert('你的攻击力达到了' + parseInt((attackMax - attackNumb) / attackMax * 100) + '%<br>很遗憾，未中奖，请再接再厉。');
                }
            } else {
                if (endType == 2) {
                    pageAlert('你一定拥有尽洪荒之力<br>恭喜你，获得了' + json.prize_title);
                } else {
                    pageAlert('你的攻击力达到了' + parseInt((attackMax - attackNumb) / attackMax * 100) + '%<br>恭喜你，获得了' + json.prize_title);
                }
            }
            gameInit();
            wxData.desc = '{{env("WECHAT_SHARE_DESC_2")}}';
            wxShare();
        },
        error: function() {
            closeLoading();
            pageAlert('提交失败，请联系管理员~');
            //canSubmitInfo2 = true;
        }
    });


    //成功为中间或者失败
    /*closeLoading();
    $('.awardImg').attr('src','images/award0.png');
    $('.page2').hide();
    $('.pageMyAward').show();
    if(endType==2){
    	pageAlert('你一定拥有尽洪荒之力<br>很遗憾，未中奖，请再接再厉。');
    	}
    	else{
    		pageAlert('你的攻击力达到了'+parseInt((attackMax-attackNumb)/attackMax*100)+'%<br>很遗憾，未中奖，请再接再厉。');
    		}
    gameInit();*/
}

function submitInfo(url) {
    var iName = $.trim($('.infoTxt1').val());
    var iTel = $.trim($('.infoTxt2').val());
    var iAddress = $.trim($('.infoTxt3').val());
    var pattern = /^1[3456789]\d{9}$/;

    if (iName == '') {
        pageAlert('请输入姓名');
        return false;
    } else if (iTel == '' || !pattern.test(iTel)) {
        pageAlert('请输入正确的手机号码');
        return false;
    } else if (iAddress == '') {
        pageAlert('请输入地址');
        return false;
    } else {
        //ajax提交信息
        showLoading();
        $.ajax(url, {
            data: {
                name: iName,
                mobile: iTel,
                address: iAddress,
                _token: $('input[name="_token"]').val()
            },
            type: 'post',
            dataType: 'json',
            success: function(json) {
                //提交成功
                closeLoading();
                if (json.ret == 0) {
                    pageAlert('信息提交成功');
                    $('.infoTxt').attr('disabled', 'disabled');
                    $('.pageMyAwardBtn3').hide();
                    $('.infoSubmited').show();
                } else {
                    pageAlert(json.msg);
                    //canSubmitInfo2 = true;
                }
            },
            error: function() {
                pageAlert('提交失败，请联系管理员~');
                //canSubmitInfo2 = true;
            }
        });
    }


}
