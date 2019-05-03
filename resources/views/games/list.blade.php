@section('title', '游戏信息列表')
@section('header')
    <div class="layui-inline">
        <button class="layui-btn layui-btn-small layui-btn-normal addBtn" data-desc="添加游戏" data-url="{{url('/games/0/edit')}}"><i class="layui-icon">&#xe654;</i></button>
        <button class="layui-btn layui-btn-small layui-btn-warm freshBtn"><i class="layui-icon">&#x1002;</i></button>
    </div>
    <div class="layui-inline">
        <input type="text" lay-verify="title" value="{{ $input['title'] or '' }}" name="title" placeholder="请输入关键字" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-inline">
        <select name="status" lay-filter="status" lay-verify="status">
            <option value="">请选择一个内容</option>
            <option value="game_name" {{isset($input['status'])&&$input['status']=='game_name'?'selected':''}}>名称</option>
            <option value="number" {{isset($input['status'])&&$input['status']=='number'?'selected':''}}>编号</option>            
        </select>
    </div>
    <div class="layui-inline">
        <input class="layui-input" name="begin" placeholder="时间" onclick="layui.laydate({elem: this, festival: true})" value="{{ $input['begin'] or '' }}">
    </div>
    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
    </div>
@endsection
@section('table')
    <table class="layui-table" lay-even lay-skin="nob">
        <colgroup>
            <col class="hidden-xs" width="50">
            <col class="hidden-xs" width="100">
            <col class="hidden-xs" width="450">
            <col>
            <col class="hidden-xs" width="150">
            <col class="hidden-xs" width="150">
            <col class="hidden-xs" width="150">
            <col width="200">
        </colgroup>
        <thead>
        <tr>
            <th class="hidden-xs">ID</th>
            <th class="hidden-xs">编号</th>
            <th>名称</th>
            <th class="hidden-xs">容量</th>
            <th class="hidden-xs">所属机型</th>
            <th class="hidden-xs">语言</th>
            <th class="hidden-xs">时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($pager as $info)
            <tr>
                <td class="hidden-xs">{{$info['id']}}</td>
                <td class="hidden-xs">{{$info['number']}}</td>
                <td>{{$info['game_name']}}</td>
                <td class="hidden-xs">{{$info['size_range']}}{{$info['danwei']}}B</td>
                <td class="hidden-xs">{{$info['type_name']}}</td>
                <td class="hidden-xs">{{$info['language']}}</td>
                <td class="hidden-xs">{{$info['created_at']}}</td>
                <td>
                    <div class="layui-inline">
                        <button class="layui-btn layui-btn-small layui-btn-normal edit-btn" data-id="{{$info['id']}}" data-desc="修改游戏" data-url="{{url('/games/'. $info['id'] .'/edit')}}"><i class="layui-icon">&#xe642;</i></button>
                        <button class="layui-btn layui-btn-small layui-btn-danger del-btn" data-id="{{$info['id']}}" data-url="{{url('/games/'.$info['id'])}}"><i class="layui-icon">&#xe640;</i></button>
                    </div>
                </td>
            </tr>
        @endforeach
        @if(!$pager[0])
            <tr><td colspan="6" style="text-align: center;color: orangered;">暂无数据</td></tr>
        @endif
        </tbody>
    </table>
    <div class="page-wrap">
        {{$pager->render()}}
    </div>
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