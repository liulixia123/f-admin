<?php
/**
 * 订单管理
 *
 * @author      fzs
 * @Time: 2017/07/14 15:57
 * @version     1.0 版本号
 */
namespace App\Http\Controllers;
use App\Http\Requests\StoreRequest;
use App\Models\Log;
use App\Models\Permission;
use App\Models\Order;
use App\Models\Role;
use App\Service\DataService;
use Illuminate\Http\Request;
class OrdersController extends BaseController
{
    /**
     * 订单列表
     */
    public function index(Request $request){
        /*$game = ['typeid'=>1,'type_name'=>'PSV','card_range'=>70,
                'games'=>[
                    ['id'=>1,'game_name'=>'双飞粉','size_range'=>0.19],
                    ['id'=>1,'game_name'=>'返回手动挡','size_range'=>1],
                    ['id'=>1,'game_name'=>'de','size_range'=>1.2]
                ]
        ];
        errorLog(serialize($game),'bb.log');*/
        $sql = new Order();
        if(true == $request->has('title')&&true == $request->has('status')) {
            $pager = $sql->where($request->input('status'), 'LIKE', '%'.trim($request->input('title')).'%')->orderBy('id', 'desc')->paginate()->appends($request->all());
        }
        if(true == $request->has('begin')) {
            $pager = $sql->where('created_at', '>=', trim($request->input('begin')))->orderBy('id', 'desc')->paginate()->appends($request->all());
        } 
        if(true == $request->has('title')&&true == $request->has('status')&&true == $request->has('begin')) {
            $pager = $sql->where($request->input('status'), 'LIKE', '%'.trim($request->input('title')).'%')->where('created_at', '>=', trim($request->input('begin')))->orderBy('id', 'desc')->paginate()->appends($request->all());
        }       
        if(false == $request->has('title')&&false == $request->has('status')&&false == $request->has('begin')) {
            $pager = $sql->orderBy('id', 'desc')->paginate()->appends($request->all());
        }
              
        foreach ($pager as $key => $value) {
            $orderlist = unserialize($value['info']);
            $pager[$key]['type_name'] = $orderlist['type_name'];
            $pager[$key]['card_range'] = $orderlist['card_range'];
            $gamelist = $orderlist['games'];
            $pager[$key]['games_total'] = count($gamelist);
            $pager[$key]['games'] = $gamelist;
        }
        return view('orders.list',['pager'=>$pager,'input'=>$request->all()]);
    }
    /**
     * 订单编辑列表
     */
    public function edit($id=0)
    {
        $info = $id?Order::find($id):[];
        $orderlist = unserialize($info['info']);
        $info['type_name'] = $orderlist['type_name'];
        $info['card_range'] = $orderlist['card_range'];
        if(empty($orderlist['game_range'])){
            $orderlist['game_range'] = "0GB";
        }
        $info['game_range'] = $orderlist['game_range'];
        $gamelist = $orderlist['games'];
        return view('orders.edit', ['id'=>$id,'info'=>$info,'roles'=>Role::all(),'gamelist'=>$gamelist]);
    }
    /**
     * 订单增加保存
     */
    public function store(StoreRequest $request){
        $model = new Permission();
        $permission = DataService::handleDate($model,$request->all(),'permissions-add_or_update');
        if($permission['status']==1)Log::addLogs(trans('fzs.permissions.handle_permission').trans('fzs.common.success'),'/permissions/story');
        else Log::addLogs(trans('fzs.permissions.handle_permission').trans('fzs.common.fail'),'/permissions/destroy');
        return $permission;
    }
    /**
     * 订单删除
     */
    public function destroy($id)
    {
        if (is_config_id($id, "admin.permission_table_cannot_manage_ids", false))return $this->resultJson('fzs.permissions.notdel', 0);
        $model = new Permission();
        $permission = DataService::handleDate($model,['id'=>$id],'permissions-delete');
        if($permission['status']==1)Log::addLogs(trans('fzs.permissions.del_permission').trans('fzs.common.success'),'/permissions/destroy/'.$id);
        else Log::addLogs(trans('fzs.permissions.del_permission').trans('fzs.common.fail'),'/permissions/destroy/'.$id);
        return $permission;
    }
}
