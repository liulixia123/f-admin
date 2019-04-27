<?php
/**
 * 游戏信息管理
 *
 * @author      liu
 * @Time: 2019/04/25 15:37
 * @version     1.0 版本号
 */
namespace App\Http\Controllers;
use App\Http\Requests\StoreRequest;
use App\Models\Log;
use App\Models\Game;
use App\Models\Type;
use App\Service\DataService;
use Illuminate\Http\Request;
class GamesController extends BaseController
{
    /**
     * 游戏列表
     */
    public function index(){
        $list = Game::get()->where('status',1)->toArray();
        foreach ($list as $key => $value) {
           $typeid = Game::find($value['id'])->typeToIds();
           $tyname = Type::get('type_name')->where('id','in',$typeid)->toArray();
           $list['type_name'] = implode(',', $tyname);
        }
        return view('games.list',['list'=>$list]);
    }
    /**
     * 游戏编辑列表
     */
    public function edit($id=0)
    {
        $info = $id?Game::find($id):[];
        $typelist = $info?$info->typeToIds():[];
        return view('games.edit', ['id'=>$id,'info'=>$info,'types'=>Type::all(),'typelist'=>$typelist]);
    }
    /**
     * 游戏增加保存
     */
    public function store(StoreRequest $request){
        $model = new Game();
        $permission = DataService::handleDate($model,$request->all(),'games-add_or_update');
        if($permission['status']==1)Log::addLogs(trans('fzs.games.handle_game').trans('fzs.common.success'),'/games/story');
        else Log::addLogs(trans('fzs.games.handle_game').trans('fzs.common.fail'),'/games/destroy');
        return $permission;
    }
    /**
     * 游戏删除
     */
    public function destroy($id)
    {
        if (is_config_id($id, "admin.games_table_cannot_manage_ids", false))return $this->resultJson('fzs.games.notdel', 0);
        $model = new Game();
        $game = DataService::handleDate($model,['id'=>$id],'games-delete');
        if($game['status']==1)Log::addLogs(trans('fzs.games.del_game').trans('fzs.common.success'),'/games/destroy/'.$id);
        else Log::addLogs(trans('fzs.games.del_game').trans('fzs.common.fail'),'/games/destroy/'.$id);
        return $game;
    }
}
