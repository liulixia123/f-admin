@section('title', '机型编辑')
@section('content')
    <div class="layui-form-item">
        <label class="layui-form-label">机型名称</label>
        <div class="layui-input-block">
            <input type="text" value="{{$info['type_name'] or ''}}" name="type_name" required lay-verify="type_name" placeholder="请输入2-12位字母或汉字" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">容量区间</label>
        <div class="layui-input-block">
            <label class="layui-form-label">最小容量:</label><input type="text" value="{{$info['card_type'] or ''}}" name="card_type" required lay-verify="min_capacity" placeholder="请输入2-12位汉字" autocomplete="off" class="min-layui-input">
            <label class="layui-form-label">最大容量:</label><input type="text" value="{{$info['card_type'] or ''}}" name="max_capacity" required lay-verify="max_capacity" placeholder="请输入2-12位汉字" autocomplete="off" class="min-layui-input">
        </div>
    </div>    
@endsection
@section('id',$id)
@section('js')
    <script>
        layui.use(['form','jquery','laypage', 'layer'], function() {
            var form = layui.form(),
                $ = layui.jquery;
            form.render();
            var layer = layui.layer;
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
            });
        });
    </script>
@endsection
@extends('common.edit')
