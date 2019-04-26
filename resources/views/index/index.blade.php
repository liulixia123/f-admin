<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>网站首页</title>
    <link rel="stylesheet" type="text/css" href="static/admin/layui/css/layui.css"/>
    <link rel="stylesheet" type="text/css" href="static/admin/css/admin.css"/>
</head>
<body>
<div class="wrap-container welcome-container">
    <header class="header">
        <table width="100%" border="0" align="left" cellpadding="0" style="margin:0 auto;" cellspacing="1">
        <tr>
        <td width="60%" style="text-align:left;padding-left:5px;"><span class="STYLE1">卡片实际容量:<span id="mycardrl">0</span></span></td>
        <td rowspan="3" style="text-align:center;">
            
            </td>
        </tr>
        <tr>
        <td style="text-align:left;padding-left:5px;"><span class="STYLE1">已选游戏总容量:<span id="selrlsum">0</span></span></td>
        </tr>
        <tr>
        <td style="text-align:left;padding-left:5px;"><span class="STYLE1">卡片剩余容量:<span id="havecardrl">0</span></span></td>
        </tr>
        </table>
    </header>   
    <div class="row">
        <div class="welcome-left-container col-lg-9">
            <div class="data-show">
               <div class="layui-form-item">
                    <label class="layui-form-label">请选择游戏机型：</label>
                    <div class="layui-input-block">
                        <input type="radio" name="types" value="PSV" title="PSV">                              
                        <input type="radio" name="types" value="MP4" title="MP4">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">请选择卡片类型：</label>
                    <div class="layui-input-block">
                        <input type="radio" name="cardtype" value="350.0" title="PSV">                              
                        <input type="radio" name="cardtype" value="7" title="MP4">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">请选择游戏：</label>
                    <div class="layui-input-block permission">
                        <input type="checkbox" name="game_list[]" value="0.19" lay-skin="primary" title="暗黑">
                        <input type="checkbox" name="game_list[]" value="0.38" lay-skin="primary" title="暗黑">
                        <input type="checkbox" name="game_list[]" value="1.2" lay-skin="primary" title="暗黑">                         
                    </div>
                </div>
            </div>
        
      
        </div>
        <table class="layui-table" lay-skin="line">
        <colgroup>
            <col width="50">
            <col class="hidden-xs" width="50">
            <col class="hidden-xs" width="100">
            <col class="hidden-xs" width="100">
            <col>
            <col width="130">
        </colgroup>
        <thead>
        <tr>
            <th><input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose"></th>
            <th class="hidden-xs">编号</th>
            <th class="hidden-xs">名称</th>
            <th class="hidden-xs">容量</th>
        </tr>
        </thead>
        <tbody>
        
            <tr id='node-' class="parent collapsed">
                <td><input type="checkbox" name="" lay-skin="primary" data-id=""></td>
                <td class="hidden-xs"></td>
                <td class="hidden-xs"><input type="number" name="title" autocomplete="off" class="layui-input" value="" data-id="" data-url="" onchange=></td>
                <td class="hidden-xs">Admin</td>
            </tr>
         
        </tbody>
    </table>
        <div class="welcome-edge col-lg-3">
            <!--联系-->
            <div class="panel panel-default contact-panel">
                <div class="panel-header">联系我</div>
                <div class="panel-body">
                    <p>QQ：1255896643</p>
                    <p>E-mail:1255896643@qq.com</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="static/admin/layui/layui.js" type="text/javascript" charset="utf-8"></script>
<script src="static/admin/lib/echarts/echarts.js"></script>
<script>
        layui.use(['form','jquery','laypage', 'layer'], function() {
            var form = layui.form(),
                $ = layui.jquery;
            form.render();
            var layer = layui.layer;
            
            form.on('submit(formDemo)', function(data) {
                var chk_value =[];
                
                var typeval = $('input[name="types"]:checked').val()
                var cardval = $('input[name="cardtype"]:checked').val()
                if(!typeval){
                    layer.msg('至少选择一个游戏机型',{shift: 6,icon:5});
                    return false;
                }
                if(!cardval){
                    layer.msg('至少选择一个卡片类型',{shift: 6,icon:5});
                    return false;
                }
                $('input[name="game_list[]"]:checked').each(function(){
                    chk_value.push($(this).val());
                    if($(this).val()==1)is_have_admin--;
                });
                if(chk_value.length==0){
                    layer.msg('至少选择一个游戏信息',{shift: 6,icon:5});
                    return false;
                }
                //计算容量是否合适
                total = sumArr(chk_value);
                if(cardval<total){
                    layer.msg('选择游戏已超出卡片容量',{shift: 6,icon:5});
                    return false;
                }
                $.ajax({
                    url:"{{url('/permissions')}}",
                    data:$('form').serialize(),
                    type:'post',
                    dataType:'json',
                    success:function(res){
                        if(res.status == 1){
                            layer.msg(res.msg,{icon:6});
                            var index = parent.layer.getFrameIndex(window.name);
                            setTimeout('parent.layer.close('+index+')',2000);
                        }else{
                            layer.msg(res.msg,{shift: 6,icon:5});
                        }
                    },
                    error : function(XMLHttpRequest, textStatus, errorThrown) {
                        layer.msg('网络失败', {time: 1000});
                    }
                });
                return false;
            });
        });
        function sumArr(value) {
            var sum = value.reduce(function(prev,cur,index,array){
                return prev + cur
            });
            return sum;
        }
    </script>
</body>
</html>