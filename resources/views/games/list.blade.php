@section('title', '游戏信息列表')
@section('header')
    <div class="layui-inline">
    <button class="layui-btn layui-btn-small layui-btn-normal addBtn" data-desc="添加游戏" data-url="{{url('/users/0/edit')}}"><i class="layui-icon">&#xe654;</i></button>
    <button class="layui-btn layui-btn-small layui-btn-warm freshBtn"><i class="layui-icon">&#x1002;</i></button>
    </div>
@endsection
@section('table')
    <table class="layui-table" lay-even lay-skin="nob">
        <colgroup>
            <col class="hidden-xs" width="50">
            <col class="hidden-xs" width="200">
            <col class="hidden-xs" width="150">
            <col>
            <col class="hidden-xs" width="150">
            <col class="hidden-xs" width="150">
            <col width="200">
        </colgroup>
        <thead>
        <tr>
            <th class="hidden-xs">ID</th>
            <th class="hidden-xs">编号</th>
            <th class="hidden-xs">名称</th>
            <th>容量</th>
            <th class="hidden-xs">所属机型</th>
            <th class="hidden-xs">版型</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list as $info)
            <tr>
                <td class="hidden-xs">{{$info['id']}}</td>
                <td class="hidden-xs">{{$info['roles'][0]['display_name'] or '已删除'}}</td>
                <td class="hidden-xs">{{$info['username']}}</td>
                <td>{{$info['email']}}</td>
                <td class="hidden-xs">{{$info['mobile']}}</td>
                <td class="hidden-xs">{{$info['mobile']}}</td>
                <td>
                    <div class="layui-inline">
                        <button class="layui-btn layui-btn-small layui-btn-normal edit-btn" data-id="{{$info['id']}}" data-desc="修改用户" data-url="{{url('/users/'. $info['id'] .'/edit')}}"><i class="layui-icon">&#xe642;</i></button>
                        <button class="layui-btn layui-btn-small layui-btn-danger del-btn" data-id="{{$info['id']}}" data-url="{{url('/users/'.$info['id'])}}"><i class="layui-icon">&#xe640;</i></button>
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
                console.log(data);
            });
        });
    </script>
@endsection
@extends('common.list')