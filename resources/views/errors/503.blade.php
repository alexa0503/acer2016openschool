<!DOCTYPE html>
<html>
    <head>
        <title>Be right back.</title>

        <link href="{{asset('assets/cms/css/lato.css')}}" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin: 10px 0;
            }
            .desc {
                font-size: 30px;
                margin: 10px 0;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">哟呵,服务器出轨了~</div>
                <div class="desc">错误：{{$error_msg}}</div>
            </div>
        </div>
    </body>
</html>
