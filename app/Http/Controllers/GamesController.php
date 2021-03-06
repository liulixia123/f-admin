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
    public function index(Request $request){
        //$pager = $sql->orderBy('id', 'desc')->paginate()->appends($request->all());
        return $this->show($request);
    }
    //根据条件查询
    public function show(Request $request){
        $sql = new Game();
        if(true == $request->has('title')&&true == $request->has('status')) {
            $pager = $sql->where($request->input('status'), 'LIKE', '%'.trim($request->input('title')).'%')->where('status',1)->orderBy('id', 'desc')->paginate()->appends($request->all());
        }
        if(true == $request->has('begin')) {
            $pager = $sql->where('created_at', '>=', trim($request->input('begin')))->where('status',1)->orderBy('id', 'desc')->paginate()->appends($request->all());
        }
        if(true == $request->has('title')&&true == $request->has('status')&&true == $request->has('begin')) {
            $pager =$sql->where($request->input('status'), 'LIKE', '%'.trim($request->input('title')).'%')->where('created_at', '>=', trim($request->input('begin')))->where('status',1)->orderBy('id', 'desc')->paginate()->appends($request->all());
        }
        if(false == $request->has('title')&&false == $request->has('status')&&false == $request->has('begin')) {
            $pager = $sql->where('status',1)->orderBy('id', 'desc')->paginate()->appends($request->all());
        }
        //$pager = $sql->where('status',1)->orderBy('id', 'desc')->paginate()->appends($request->all());
        //errorLog($list,'bb.log');
        foreach ($pager as $key => $value) {
           $typeid = [];
           $typeid = Game::find($value['id'])->typeToIds();           
           $tyname = Type::get()->whereIn('id',$typeid)->toArray();           
           $tylist = [];
           foreach ($tyname as $k => $val) {
               $tylist[$k] = $val['type_name'];
           }
           $pager[$key]['type_name'] = implode(',', $tylist);
        }     
        return view('games.list',['pager'=>$pager,'input'=>$request->all()]);
    }
    /**
     * 游戏编辑列表
     */
    public function edit($id=0)
    {
        $info = $id?Game::find($id):[];
        $typelist = $info?$info->typeToIds():[];
        return view('games.edit', ['id'=>$id,'info'=>$info,'types'=>Type::where('status',1)->get(),'typelist'=>$typelist]);
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
