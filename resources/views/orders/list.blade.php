@section('title', '订单管理')
@section('header')
    <div class="layui-inline">
        <div class="layui-btn layui-btn-small layui-btn-warm hidden-xs fresh" fresh-url="{{url('/orders')}}"><i class="layui-icon">&#x1002;</i></div>
    </div>
    <div class="layui-inline">
        <input type="text" lay-verify="title" value="{{ $input['title'] or '' }}" name="title" placeholder="请输入关键字" autocomplete="off" class="layui-input">
    </div>
    <div class="layui-inline">
        <select name="status" lay-filter="status" lay-verify="status">
            <option value="">请选择一个内容</option>
            <option value="order_num" {{isset($input['status'])&&$input['status']=='order_num'?'selected':''}}>订单ID</option>
            <option value="mobile" {{isset($input['status'])&&$input['status']=='mobile'?'selected':''}}>用户手机号</option>            
        </select>
    </div>
    <div class="layui-inline">
        <input class="layui-input" name="begin" placeholder="下单日期" onclick="layui.laydate({elem: this, festival: true})" value="{{ $input['begin'] or '' }}">
    </div>
    <div class="layui-inline">
        <button class="layui-btn layui-btn-normal" lay-submit lay-filter="formDemo">搜索</button>
    </div>
@endsection
@section('table')
    <table class="layui-table" lay-even lay-skin="nob">
        <colgroup>
            <col class="hidden-xs" width="50">
            <col class="hidden-xs" width="80">
            <col>
            <col class="hidden-xs" width="150">
            <col class="hidden-xs" width="150">
            <col width="200">
        </colgroup>
        <thead>
        <tr>
            <th class="hidden-xs">ID</th>
            <th class="hidden-xs">订单ID</th>
            <th>用户手机号</th>
            <th class="hidden-xs">内容</th>
            <th class="hidden-xs">下单时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($pager as $list)
            <tr>
                <td class="hidden-xs">{{$list['id']}}</td>
                <td class="hidden-xs">{{$list['order_num']}}</td>
                <td>{{$list['mobile']}}</td>
                <td class="hidden-xs">机型:{{$list['type_name']}} 容量:{{$list['card_range']}} 选择游戏个数:{{$list['games_total']}}</td> 
                <td class="hidden-xs">{{$list['created_at']}}</td>
                <td>
                    <div class="layui-inline">
                        <button class="layui-btn layui-btn-small layui-btn-normal edit-btn" data-id="{{$list['id']}}" data-desc="查看订单" data-url="{{url('/orders/'. $list['id'] .'/edit')}}"><i class="layui-icon">&#xe642;</i></button>
                        <button class="layui-btn layui-btn-small layui-btn-danger del-btn" data-id="{{$list['id']}}" data-url="{{url('/orders/'.$list['id'])}}"><i class="layui-icon">&#xe640;</i></button>
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
        layui.use(['form', 'jquery','laydate', 'layer','dialog'], function() {
            var form = layui.form(),
                $ = layui.jquery,
                laydate = layui.laydate,
                dialog = layui.dialog,
                layer = layui.layer
            ;
            form.render();
            laydate({istoday: true});
            $('.fresh').mouseenter(function() {
                dialog.tips('刷新页面', '.fresh');
            })
            form.verify({
                title:function(value){
                    var select_info = $("select[name='status']").val();
                    if(value&&select_info){
                        switch (select_info){
                            case 'order_num':
                                if(!(/^[0-9]\d+/).test(value))return '请输入正确格式的订单ID';
                                break;
                            case 'mobile':
                                if(!(/^[1][3,4,5,7,8]\d+/).test(value))return '请输入正确格式的手机号';
                                break;
                            default:
                                return '输入参数错误';
                                break;

                        }
                    }else if(!value&&select_info){
                        return '请输入关键字';
                    }
                },
                status: function(value) {
                    var keyword = $("input[name='title']").val();
                    if(keyword&&!value){
                        return '请选择一个内容';
                    }
                },
            });
            $('.fresh').click(function() {
                $("input[name='begin']").val('');
                $("input[name='title']").val('');
                $("select[name='status']").val('');
                $('form').submit();
            });
        });
    </script>
@endsection
@extends('common.list')