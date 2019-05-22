<?php
/**
 * 网站基本信息管理
 *
 * @author      fzs
 * @Time: 2017/07/14 15:57
 * @version     1.0 版本号
 */
namespace App\Http\Controllers;
use App\Http\Requests\StoreRequest;
use App\Models\Log;
use App\Models\Site;
use App\Service\DataService;
use Illuminate\Http\Request;
class SitesController extends BaseController
{
    /**
     * 网站基本信息列表
     */
    public function index(Request $request){       
        $list = Site::get()->toArray();
        return view('sites.list',['list'=>$list]);
    }
    /**
     * 网站基本信息编辑列表
     */
    public function edit($id=0)
    {
        $info = $id?Site::find($id):[];        
        return view('sites.edit', ['id'=>$id,'info'=>$info]);
    }
    /**
     * 网站基本信息增加保存
     */
    public function store(StoreRequest $request){
        $model = new Site();
        $permission = DataService::handleDate($model,$request->all(),'sites-add_or_update');
        if($permission['status']==1)Log::addLogs(trans('fzs.sites.handle_permission').trans('fzs.common.success'),'/site/story');
        else Log::addLogs(trans('fzs.sites.handle_sites').trans('fzs.common.fail'),'/permissions/destroy');
        return $permission;
    }
}
