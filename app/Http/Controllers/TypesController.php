<?php
/**
 * 游戏机型管理
 *
 * @author      liu
 * @Time: 2019/04/25 15:32
 * @version     1.0 版本号
 */
namespace App\Http\Controllers;
use App\Http\Requests\StoreRequest;
use App\Models\Log;
use App\Models\Permission;
use App\Models\Type;
use App\Service\DataService;
use Illuminate\Http\Request;
class TypesController extends BaseController
{
    /**
     * 游戏机型列表
     */
    public function index(){
        return view('types.list',['list'=>Type::get()->where('status',1)->toArray()]);
    }
    /**
     * 游戏机型编辑列表
     */
    public function edit($id=0)
    {
        $info = $id?Type::find($id):[];        
        return view('types.edit', ['id'=>$id,'info'=>$info]);
    }
    /**
     * 游戏机型增加保存
     */
    public function store(StoreRequest $request){
        $model = new Type();        
        $type = DataService::handleDate($model,$request->all(),'types-add_or_update');
        if($type['status']==1)Log::addLogs(trans('fzs.types.handle_type').trans('fzs.common.success'),'/types/story');
        else Log::addLogs(trans('fzs.types.handle_type').trans('fzs.common.fail'),'/types/destroy');
        return $type;
    }
    /**
     * 游戏机型删除
     */
    public function destroy($id)
    {
        if (is_config_id($id, "admin.type_table_cannot_manage_ids", false))return $this->resultJson('fzs.types.notdel', 0);
        $model = new Type();
        $permission = DataService::handleDate($model,['id'=>$id],'types-delete');
        if($permission['status']==1)Log::addLogs(trans('fzs.types.del_type').trans('fzs.common.success'),'/types/destroy/'.$id);
        else Log::addLogs(trans('fzs.types.del_type').trans('fzs.common.fail'),'/types/destroy/'.$id);
        return $permission;
    }
}
