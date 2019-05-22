@section('title', '网站编辑')
@section('content')
    <div class="layui-form-item">
        <label class="layui-form-label">网站名称：</label>
        <div class="layui-input-block">
            <input type="text" value="{{$info['site_name'] or ''}}" name="site_name" required lay-verify="site_name" placeholder="请输入2-30位字母或汉字" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">QQ：</label>
        <div class="layui-input-block">
            <input type="text" value="{{$info['qq'] or ''}}" name="qq" required lay-verify="qq" placeholder="请输入有效QQ号" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">邮箱：</label>
        <div class="layui-input-block">
            <input type="text" value="{{$info['email'] or ''}}" name="email" required lay-verify="email" placeholder="请输入有效邮箱" autocomplete="off" class="layui-input">
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
                site_name: [/[0-9a-zA-Z\u4e00-\u9fa5]{2,30}$/, '网站名称必须2到30位字母或汉字'],
                qq: [/^[1-9]\d{6,12}\d$/, '请输入有效QQ号'],
                email: [/^(<\w[\s\w]+>\s)?(\w+[\w+.]*@\w+.(org|com)$)/, '请输入有效邮箱'],
            });
            form.on('submit(formDemo)', function(data) {
                //console.log($('form').serialize());             
                $.ajax({
                    url:"{{url('/site')}}",
                    data:$('form').serialize(),
                    type:'post',
                    dataType:'json',
                    success:function(res){
                        if(res.status == 1){
                            layer.msg(res.msg,{icon:6});
                            var index = parent.layer.getFrameIndex(window.name);
                            setTimeout('parent.layer.close('+index+')',1000);
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
