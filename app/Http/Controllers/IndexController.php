<?php
/**
 * 前台首页控制器
 *
 * @author      fzs
 * @Time: 2017/07/14 15:57
 * @version     1.0 版本号
 */
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Game;
use App\Models\Log;
use App\Models\GameType;
use App\Models\Order;
use Redirect;
class IndexController extends Controller
{
	/**
	 * [index 首页]
	 * @return [type] [description]
	 */
	public function index(){
		$id = 1;
		$info = $id?Type::find($id):[];  
        $card_type = $info?unserialize($info['card_type']):[];   
		return view('index.index',['id'=>$id,'typelist'=>Type::get()->where('status',1),'card_type'=>$card_type,'games'=>Game::all()->where('status',1)]);
	}
	//ajax 获取游戏信息
	public function edit()
    {
        $id = request()->input('id');
        $gameT = GameType::get()->where("type_id",$id)->toArray();
        if($gameT){
        	foreach ($gameT as $key => $value) {
        	 $gameid[] = $value['game_id'];
	        }
	        $games = Game::get()->whereIn('id',$gameid)->toArray();
	        foreach ($games as $key => $value) {
	        	$game[] = $value;
	        }
        }else{
        	$game= [];
        }
        
        $info = Type::find($id);  
        $card_type[0] = $info?unserialize($info['card_type']):[];
        $card_type[1]['games'] = $game;
        //errorLog($games,'aa.log');
        return ['status'=>1,'msg'=>trans('fzs.common.success'),'data'=>$card_type];
    }
    //提交的订单后端验证
	public function checkorder(){
		$request = request()->all();
		$type = $request['type'];//机型id
		$card = $request['card'];//卡片容量
		$gameid = $request['gameid'];//游戏id
		if(empty($type)){
			return ['code'=>1,'msg'=>trans('fzs.common.wrong')];
		}
		if(empty($card)){
			return ['code'=>1,'msg'=>trans('fzs.common.wrong')];
		}
		if(empty($gameid)||!is_array($gameid)){
			return ['code'=>1,'msg'=>trans('fzs.common.wrong')];
		}
		//判断数据库是否存在该机型
		$typearr = Type::where('type_name',$type)->get()->toArray();
		if(empty($typearr)){
			return ['code'=>1,'msg'=>trans('fzs.common.wrong')];
		}
		//判断卡片容量是否符合数据库存储
		$cardtype = [];
		if($typearr[0]['card_type']){
			$cardtypearr = unserialize($typearr[0]['card_type']);
			foreach ($cardtypearr as $key => $value) {
				$cardtype[]=$value['min_capacity'];
			}
		}
		//判断传的卡片容量是否正确和数据库一致		
		if(!in_array($card, $cardtype)){
			return ['code'=>1,'msg'=>trans('fzs.common.wrong')];
		}
		// 判断游戏id是否存在
		$gamearr = Game::whereIn('id',$gameid)->get(['id'])->toArray();
		if(empty($gamearr)){
			return ['code'=>1,'msg'=>trans('fzs.common.wrong')];
		}
		//计算游戏容量总大小
		$gamesize = Game::whereIn('id',$gameid)->sum('size_range');
		// 比较游戏总容量是否超出卡片容量
		if($card<$gamesize){
			return ['code'=>1,'msg'=>trans('fzs.common.wrong')];
		}
		return ['code'=>0,'msg'=>trans('fzs.common.success')];
	}
	// 获取确认订单的页面
	public function confirmOrder(){
		$request = request()->all();
		$gameid = $request['gameid'];
		$gameidarr = explode(',', $gameid);
		$gamearr = Game::whereIn('id',$gameidarr)->get()->toArray();

		return view('index.confirm',['gamearr'=>$gamearr]);
	}

	// 确认订单                
	public function confirm(){
		$request = request()->all();
		$mobile = $request['mobile'];
		$type = $request['type'];//机型id
		$selcartype = $request['selcartype'];//卡片容量
		$gameid = $request['gameid'];//游戏id
		if(!checkMobile($mobile)){

		}
		$typearr = Type::where('type_name',$type)->get()->toArray();
		$typeid = $typearr[0]['id'];
		$type_name = $typearr[0]['type_name'];
		$gameidarr = explode(',', $gameid);
		$gamearr = Game::whereIn('id',$gameidarr)->get()->toArray();
		foreach ($gamearr as $key => $value) {
			$game['id'] = $value['id'];
			$game['game_name'] = $value['game_name'];
			$game['size_range'] = $value['size_range'];
			$game['language'] = $value['language'];
			$game['number'] = $value['number'];
			$game['danwei'] = $value['danwei'];
			$games[] = $game;
		}
		$order['typeid'] = $typeid;
		$order['type_name'] = $type_name;
		$order['card_range'] = $selcartype;
		$order['games'] = $games;
		$Model = new Order();
		$Model->mobile = $mobile;
		$Model->order_num = getOrderNumer();
		$Model->info = serialize($order);		
		$Model->save();
		return Redirect::to("/home");
	}
}
