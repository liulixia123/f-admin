@section('title', '游戏编辑')
@section('content')
    <div class="layui-form-item">
        <label class="layui-form-label">游戏名称：</label>
        <div class="layui-input-block">
            <input type="text" value="{{$info['game_name'] or ''}}" name="game_name" required lay-verify="game_name" placeholder="请输入2-12位字母" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">编号：</label>
        <div class="layui-input-block">
            <input type="text" value="{{$info['number'] or ''}}" name="number" required lay-verify="number" placeholder="请输入1-12位字符" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">容量：</label>
        <div class="layui-input-block">
            <input type="text" value="{{$info['size_range'] or ''}}" name="size_range" required lay-verify="size_range" placeholder="请输入整数或小数" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
    <div class="layui-inline">
      <label class="layui-form-label">容量单位：</label>
      <div class="layui-input-block">     
        <select name="danwei">           
            <option value="M" {{isset($info['danwei'])&&$info['danwei']=='M'?'selected':''}}>MB</option>
            <option value="G" {{isset($info['danwei'])&&$info['danwei']=='G'?'selected':''}}>GB</option>
            <option value="T" {{isset($info['danwei'])&&$info['danwei']=='T'?'selected':''}}>TB</option>
        </select>
    </div>
    </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">语言：</label>
        <div class="layui-input-block">
            <input type="text" value="{{$info['language'] or ''}}" name="language" required lay-verify="language" placeholder="请输入2到12位汉字" autocomplete="off" class="layui-input">
        </div>
    </div>
    
    <div class="layui-form-item">
        <label class="layui-form-label">所属机型：</label>
        <div class="layui-input-block">
            @foreach($types as $type)
                <input type="checkbox" value="{{$type['id']}}" required {{in_array($type['id'],$typelist)?'checked':''}} lay-filter="roles_check" name="game_type[]" title="{{$type['type_name']}}">
            @endforeach
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
                //game_name: [/[0-9a-zA-Z\u4e00-\u9fa5]{2,30}$/, '游戏名称必须2到30位字母或汉字'],
                number: [/[[0-9a-zA-Z]{1,12}$/, '游戏编号必须1到12位字符'],
                size_range: [/^([1-9](\d+)?(\.\d{1,2})?$)|(^(0){1}$)|(^\d\.\d(\d))?$/, '容量必须是整数或者小数'],
                language: [/[\u4e00-\u9fa5]{2,12}$/, '语言必须是2到12位汉字'],
            });
            form.on('submit(formDemo)', function(data) {
                var chk_value =[];                
                $('input[name="game_type[]"]:checked').each(function(){
                    chk_value.push($(this).val());
                });
                if(chk_value.length==0){
                    layer.msg('至少选择一个所属游戏机型',{shift: 6,icon:5});
                    return false;
                }  
                console.log($('form').serialize());             
                $.ajax({
                    url:"{{url('/games')}}",
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
    </script>
@endsection
@extends('common.edit')
