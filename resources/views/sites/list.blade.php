@section('title', '网站信息')
@section('header')
    <div class="layui-inline">
    <button class="layui-btn layui-btn-small layui-btn-warm freshBtn"><i class="layui-icon">&#x1002;</i></button>
    </div>
@endsection
@section('table')
    <table class="layui-table" lay-even lay-skin="nob">
        <colgroup>
            <col class="hidden-xs" width="50">
            <col class="hidden-xs" width="300">
            <col class="hidden-xs" width="150">
            <col>
            <col class="hidden-xs" width="150">
            <col class="hidden-xs" width="200">
            <col width="100">
        </colgroup>
        <thead>
        <tr>
            <th class="hidden-xs">ID</th>
            <th>网站名称</th>
            <th class="hidden-xs">QQ</th> 
            <th class="hidden-xs">邮箱</th>            
            <th class="hidden-xs">修改时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $info)
            <tr>
                <td class="hidden-xs">{{$info['id']}}</td>
                <td>{{$info['site_name']}}</td>
                <td class="hidden-xs">{{$info['qq']}}</td>                
                <td class="hidden-xs">{{$info['email']}}</td>
                <td class="hidden-xs">{{$info['updated_at']}}</td>
                <td>
                    <div class="layui-inline">
                        <button class="layui-btn layui-btn-small layui-btn-normal edit-btn" data-id="{{$info['id']}}" data-desc="修改网站" data-url="{{url('/site/'. $info['id'] .'/edit')}}"><i class="layui-icon">&#xe642;</i></button>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
@section('js')
    <script>
        layui.use(['form', 'jquery','laydate', 'layer'], function() {
            var form = layui.form(),
                $ = layui.jquery,
                laydate = layui.laydate,
                layer = layui.layer
            ;
            laydate({istoday: true});
            form.render();
            form.on('submit(formDemo)', function(data) {
            });
        });
    </script>
@endsection
@extends('common.list')
