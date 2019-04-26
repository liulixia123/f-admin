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
}
