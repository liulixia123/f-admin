@section('title', '订单编辑')
@section('content')
    <div class="layui-form-item">
        <label class="layui-form-label">订单号:</label>
        <div class="layui-input-block">
            <input type="text" value="{{$info['order_num'] or ''}}" name="order_num" required readonly="readonly" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">用户手机号:</label>
        <div class="layui-input-block">
            <input type="text" value="{{$info['mobile'] or ''}}" name="mobile" required readonly="readonly" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">所选机型:</label>
        <div class="layui-input-block">
            <input type="text" value="{{$info['type_name'] or ''}}" name="type_name" required lay-verify="type_name" placeholder="请输入2-12位字母或汉字" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">卡片容量:</label>
        <div class="layui-input-block">
            <input type="text" value="{{$info['card_range'] or ''}}" name="type_name" required lay-verify="type_name" placeholder="请输入2-12位字母或汉字" autocomplete="off" class="layui-input">
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
    
@endsection
@section('id',$id)
@section('js')
    <script>
        layui.use(['form','jquery','laypage', 'layer'], function() {
            var form = layui.form(),
                $ = layui.jquery;
            form.render();
            /*var layer = layui.layer;
            form.verify({
                min_capacity: [/^([1-9](\d+)?(\.\d{1,2})?$)|(^(0){1}$)|(^\d\.\d(\d))?$/, '卡片类型必须整数或者小数'],
                type_name: [/[a-zA-Z]{2,12}$/, '机型名称必须2到12位字母'],
            });
            form.on('submit(formDemo)', function(data) {
                var chk_value =[];
                //console.log($('form').serialize());
                $.ajax({
                    url:"{{url('/types')}}",
                    data:$('form').serialize(),
                    type:'post',
                    dataType:'json',
                    success:function(res){
                        console.log(res);
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
            });*/
        });
    </script>
@endsection
@extends('common.edit')
