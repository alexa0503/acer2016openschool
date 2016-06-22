<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{env("PAGE_TITLE")}}</title>
    <link rel="stylesheet" href="{{cdn('assets/css/common.css')}}">
    <script>
        var wxData = {};
        var wxShareUrl = '{{url("wx/share")}}';
        wxData.link = '{{url("/")}}'
    </script>
    <script src="{{cdn('assets/js/jquery-1.9.1.min.js')}}"></script>
    <script src="{{cdn('assets/js/jquery.imgpreload.js')}}"></script>
    <script src="{{cdn('assets/js/jquery.tinyscrollbar.min.js')}}"></script>
    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script src="{{cdn('assets/js/wx.js')}}"></script>
    <script src="{{cdn('assets/js/common.js')}}"></script>
    <!--移动端版本兼容 -->
    <script type="text/javascript">
        var phoneWidth = parseInt(window.screen.width);
        var phoneScale = phoneWidth / 640;
        var ua = navigator.userAgent;
        if (/Android (\d+\.\d+)/.test(ua)) {
            var version = parseFloat(RegExp.$1);
            if (version > 2.3) {
                document.write('<meta name="viewport" content="width=640, minimum-scale = ' + phoneScale + ', maximum-scale = ' + phoneScale + ', target-densitydpi=device-dpi , user-scalable=no">');
            } else {
                document.write('<meta name="viewport" content="width=640, target-densitydpi=device-dpi , user-scalable=no">');
            }
        } else {
            document.write('<meta name="viewport" content="width=640, minimum-scale=0.1, maximum-scale=1.0 , user-scalable=no" />');
        }
    </script>
    <!--移动端版本兼容 end -->
</head>
<body>
@yield('content')
@yield('scripts')

<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?409597573fc6f07354aa60faa56b7cf6";
  var s = document.getElementsByTagName("script")[0];
  s.parentNode.insertBefore(hm, s);
})();
</script>

</body>
</html>
