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
        $list = Type::get()->where('status',1)->toArray();
        foreach ($list as $key => $value) {
            $card_type = unserialize($value['card_type']);
            $rangearr = [];            
            foreach ($card_type as $k => $val) {
                 $minrange = $val['min_capacity'];
                 $maxrange = $val['max_capacity'];
                 $mindanwei = $val['min_capacity_danwei'];
                 $maxdanwei = $val['max_capacity_danwei'];
                 $rangearr[$k] = $minrange.$mindanwei.'-'.$maxrange.$maxdanwei;
            }
            $list[$key]['card_range'] = implode(',',$rangearr);
        }
        return view('types.list',['list'=>$list]);
    }
    /**
     * 游戏机型编辑列表
     */
    public function edit($id=0)
    {
        $info = $id?Type::find($id):[];  
        $card_type = $info?unserialize($info['card_type']):[];   
        $count_type = !empty(count($card_type))?count($card_type):1;      
        return view('types.edit', ['id'=>$id,'info'=>$info,'card_type'=>$card_type,'count_type'=>$count_type]);
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
