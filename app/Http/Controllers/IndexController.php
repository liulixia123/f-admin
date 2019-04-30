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

class IndexController extends Controller
{
	/**
	 * [index 首页]
	 * @return [type] [description]
	 */
	public function index(){
		return view('index.index');
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
		$typearr = Type::where('id',$type)->get();
		if(empty($typearr)){
			return ['code'=>1,'msg'=>trans('fzs.common.wrong')];
		}
		//判断卡片容量是否符合数据库存储
		if($typearr['number']!=$card){
			return ['code'=>1,'msg'=>trans('fzs.common.wrong')];
		}
		// 判断游戏id是否存在
		$gamearr = Game::whereIn('in',$gameid)->get(['id']);
		if(empty($gamearr)){
			return ['code'=>1,'msg'=>trans('fzs.common.wrong')];
		}
		//计算游戏容量总大小
		$gamesize = Game::whereIn('in',$gameid)->sum('size_range');
		// 比较游戏总容量是否超出卡片容量
		if($card<$gamesize){
			return ['code'=>1,'msg'=>trans('fzs.common.wrong')];
		}
		return ['code'=>0,'msg'=>trans('fzs.common.success')];
	}
	// 获取确认订单的页面
	public function confirmOrder(){
		return view('index.confirm');
	}
}
