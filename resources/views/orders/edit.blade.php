<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>@yield('title') | {{ Config::get('app.name') }}</title>
    <link rel="stylesheet" type="text/css" href="/static/admin/layui/css/layui.css" />
    <link rel="stylesheet" type="text/css" href="/static/admin/css/admin.css" />
    <link rel="stylesheet" type="text/css" href="/static/admin/css/selectFilter.css" />
    <script src="/static/admin/layui/layui.js" type="text/javascript" charset="utf-8"></script>
    <script src="/static/admin/js/common.js" type="text/javascript" charset="utf-8"></script>
    <script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="/static/admin/js/selectFilter.js" type="text/javascript" charset="utf-8"></script>

</head>
<body>
<div class="wrap-container">
    <form class="layui-form" style="width: 100%;padding-top: 20px;padding-right: 10px;">
        <div class="layui-form-item">
        <label class="layui-form-label">订单号:</label>
        <div class="layui-input-block">           
            <p class="orderclass">{{$info['order_num'] or ''}}</p>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">用户手机号:</label>
        <div class="layui-input-block">
            <p class="orderclass">{{$info['mobile'] or ''}}</p>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">所选机型:</label>
        <div class="layui-input-block">
            <p class="orderclass">{{$info['type_name'] or ''}}</p>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">卡片容量:</label>
        <div class="layui-input-block">
            <p class="orderclass">{{$info['card_range'] or ''}}</p>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">所选游戏容量:</label>
        <div class="layui-input-block">
            <p class="orderclass">{{$info['game_range'] or ''}}</p>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">游戏列表:</label>
        <table class="layui-table" lay-even lay-skin="nob" style="margin: 10px 6px !important;">
        <colgroup>
            <col  width="17%">
            <col  width="49%">
            <col  width="17%">          
            <col  width="17%">            
        </colgroup>
        <thead>
        <tr>
            <th width="17%">游戏ID</th>            
            <th width="49%">游戏名称</th>
            <th width="17%">语言</th>
            <th width="17%">容量</th>            
        </tr>
        </thead>
        <tbody>
        @foreach($gamelist as $list)
            <tr>
                <td>{{$list['id']}}</td>                              
                <td>{{$list['game_name']}}</td>
                <td>{{$list['language']}}</td>    
                <td>{{$list['size_range']}}{{$list['danwei']}}B</td>               
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
        
        <input name="id" type="hidden" value="@yield('id')">
    </form>
</div>
</body>
</html>
    