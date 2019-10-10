<?php
/**
 * 判断是否为不可操作id
 *
 * @param	number	$id	参数id
 * @param	string	$configName	配置名
 * @param	bool  $emptyRetValue
 * @param	string	$split 分隔符
 * @return	bool
 */
if (!function_exists('is_config_id')) {
    function is_config_id($id, $configName, $emptyRetValue = false, $split = ",")
    {
        if (empty($configName)) return $emptyRetValue;
        $str = trim(config($configName, ""));
        if (empty($str)) return $emptyRetValue;
        $ids = explode($split, $str);
        return in_array($id, $ids);
    }
}
function generateOperation($name){
    //路由配置文件追加路由信息
    $file_path = __DIR__."/../../routes/web.php";
    $str = file_get_contents($file_path);
    if(strpos($str,$name)===false){
        $str = str_replace("SitesController');","SitesController');\r\n\tRoute::resource('".$name."',     '".$name."Controller');",$str);
        file_put_contents($file_path,$str);
        //生成控制器
        /*php artisan make:controller UserController
        php artisan make:model User
        php artisan make:view pages.index*/
        $exitcode = Artisan::call('make:controller UserController');
    }else{
        return false;
    }
    
}
/**
* 验证容量是否规范
*/
function is_validate_capacity($capacity){
    $isMatched = preg_match('/(^[1-9](\d+)?(\.\d{1,2})?$)|(^(0){1}$)|(^\d\.\d(\d)?$)/',$capacity,$matches);
    if(!$isMatched){
        return false;
    }
    return true;
}
/**
 * 验证手机号
 */
function checkMobile($mobile){
    $isMatched = preg_match('/^1[34578]\d{9}$/',$mobile,$matches);
    if(!$isMatched){
        return false;
    }
    return true;
}
/**
 * 产生订单号
 */
function getOrderNumer(){
    return date('YmdHis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
}
/**
 * [errorLog 打印错误日志记录]
 * @param  [type] $message [打印日志记录]
 * @param  [type] $file    [日志文件名]
 * @return [type]          [description]
 */
function errorLog($message,$file)
{
    //将日志文件放在根目录下/log/日期的文件夹名
    $log_dir=$_SERVER['DOCUMENT_ROOT']."/log/".date('Ymd')."/";
    //判断是否存在文件夹，没有则创建
    if(!is_dir($log_dir)){
        @mkdir($log_dir,0777,true);
    }
    //将错误日志记录写入文件中
    $file=$log_dir.$file;
    if(is_array($message)){
        $arr=explode(".",$file);
        if($arr[1]=='php'){
            error_log("<?php \n return ".var_export($message, true)."\n", 3,$file);
        }else{
             error_log(var_export($message, true)."\n", 3,$file);
        }        
    }else{
       error_log($message."\n\n", 3,$file); 
    }   
}
//上传文件
 function upload($file){
        //$file = $request['picfile'];
        if(in_array(strtolower($file->extension()),['jpg','png','gif','jpeg','gpeg'])){
//          3.获取文件
 
//          4.将文件取一个新的名字
            $newName = 'games'.time().rand(100000, 999999).$file->getClientOriginalName();
//           5.移动文件,并修改名字
            $date = date('Y-m-d');
            $file->move(public_path().'/uploads/'.$date.'/',$newName);
            $img_path = '/uploads/'.$date.'/'.$newName;
            return $img_path;               
        }else{
            return "";
        }

    }
//获取浏览器信息
function get_broswer()
{
    $sys = $_SERVER['HTTP_USER_AGENT'];  //获取用户代理字符串
    if(stripos($sys, "MicroMessenger") > 0){
        preg_match('/MicroMessenger\/([^\s]+)/i', $sys, $b);
        $exp[0] = "weixin";
        $exp[1] = $b[1];  //获取微信浏览器版本号
    }elseif (stripos($sys, "Firefox/") > 0) {
        preg_match("/Firefox\/([^;)]+)+/i", $sys, $b);
        $exp[0] = "Firefox";
        $exp[1] = $b[1];  //获取火狐浏览器的版本号
    } elseif (stripos($sys, "Maxthon") > 0) {
        preg_match("/Maxthon\/([\d\.]+)/", $sys, $aoyou);
        $exp[0] = "傲游";
        $exp[1] = $aoyou[1];
    } elseif (stripos($sys, "MSIE") > 0) {
        preg_match("/MSIE\s+([^;)]+)+/i", $sys, $ie);
        $exp[0] = "IE";
        $exp[1] = $ie[1];  //获取IE的版本号
    } elseif (stripos($sys, "OPR") > 0) {
        preg_match("/OPR\/([\d\.]+)/", $sys, $opera);
        $exp[0] = "Opera";
        $exp[1] = $opera[1];
    } elseif (stripos($sys, "Edge") > 0) {
        //win10 Edge浏览器 添加了chrome内核标记 在判断Chrome之前匹配
        preg_match("/Edge\/([\d\.]+)/", $sys, $Edge);
        $exp[0] = "Edge";
        $exp[1] = $Edge[1];
    } elseif (stripos($sys, "Chrome") > 0) {
        preg_match("/Chrome\/([\d\.]+)/", $sys, $google);
        $exp[0] = "Chrome";
        $exp[1] = $google[1];  //获取google chrome的版本号
    } elseif (stripos($sys, 'rv:') > 0 && stripos($sys, 'Gecko') > 0) {
        preg_match("/rv:([\d\.]+)/", $sys, $IE);
        $exp[0] = "IE";
        $exp[1] = $IE[1];
    } elseif (stripos($sys, "MicroMessenger") > 0) {
        $exp[0] = "weixin";
        $exp[1] = "";
    }elseif (stripos($sys, "QQBrowser") > 0) {
        $exp[0] = "QQ";
        $exp[1] = "";
    }elseif (stripos($sys, "UCWEB") > 0) {
        $exp[0] = "UC";
        $exp[1] = "";
    }else {
        $exp[0] = "未知浏览器";
        $exp[1] = "";
    }
    return $exp[0];
}

//获取终端操作系统信息
function get_os()
{
    $agent = $_SERVER['HTTP_USER_AGENT'];
    $os = false;
    if (strpos($agent, 'Android') !== false) {
        preg_match("/(?<=Android )[\d\.]{1,}/", $agent, $version);
        $os = 'Android'.$version[0];
    } elseif (strpos($agent, 'iPhone') !== false) {
        preg_match("/(?<=CPU iPhone OS )[\d\_]{1,}/", $agent, $version);
        $os = 'iPhone '.str_replace('_', '.', $version[0]);
    } elseif (strpos($agent, 'iPad') !== false) {
        preg_match("/(?<=CPU OS )[\d\_]{1,}/", $agent, $version);
        $os = 'iPad'.str_replace('_', '.', $version[0]);
    }elseif (preg_match('/win/i', $agent) && strpos($agent, '95')) {
        $os = 'Windows 95';
    } else if (preg_match('/win 9x/i', $agent) && strpos($agent, '4.90')) {
        $os = 'Windows ME';
    } else if (preg_match('/win/i', $agent) && preg_match('/98/i', $agent)) {
        $os = 'Windows 98';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.0/i', $agent)) {
        $os = 'Windows Vista';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.1/i', $agent)) {
        $os = 'Windows 7';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 6.2/i', $agent)) {
        $os = 'Windows 8';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 10.0/i', $agent)) {
        $os = 'Windows 10';#添加win10判断
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 5.1/i', $agent)) {
        $os = 'Windows XP';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt 5/i', $agent)) {
        $os = 'Windows 2000';
    } else if (preg_match('/win/i', $agent) && preg_match('/nt/i', $agent)) {
        $os = 'Windows NT';
    } else if (preg_match('/win/i', $agent) && preg_match('/32/i', $agent)) {
        $os = 'Windows 32';
    } else if (preg_match('/linux/i', $agent)) {
        $os = 'Linux';
    } else if (preg_match('/unix/i', $agent)) {
        $os = 'Unix';
    } else if (preg_match('/sun/i', $agent) && preg_match('/os/i', $agent)) {
        $os = 'SunOS';
    } else if (preg_match('/ibm/i', $agent) && preg_match('/os/i', $agent)) {
        $os = 'IBM OS/2';
    } else if (preg_match('/Mac/i', $agent) && preg_match('/PC/i', $agent)) {
        $os = 'Macintosh';
    } else if (preg_match('/PowerPC/i', $agent)) {
        $os = 'PowerPC';
    } else if (preg_match('/AIX/i', $agent)) {
        $os = 'AIX';
    } else if (preg_match('/HPUX/i', $agent)) {
        $os = 'HPUX';
    } else if (preg_match('/NetBSD/i', $agent)) {
        $os = 'NetBSD';
    } else if (preg_match('/BSD/i', $agent)) {
        $os = 'BSD';
    } else if (preg_match('/OSF1/i', $agent)) {
        $os = 'OSF1';
    } else if (preg_match('/IRIX/i', $agent)) {
        $os = 'IRIX';
    } else if (preg_match('/FreeBSD/i', $agent)) {
        $os = 'FreeBSD';
    } else if (preg_match('/teleport/i', $agent)) {
        $os = 'teleport';
    } else if (preg_match('/flashget/i', $agent)) {
        $os = 'flashget';
    } else if (preg_match('/webzip/i', $agent)) {
        $os = 'webzip';
    } else if (preg_match('/offline/i', $agent)) {
        $os = 'offline';
    } else {
        $os = '未知操作系统';
    }
    return $os;
}
/**
 * 通过IP获取客户端相关访问信息
 * @param $ip IP
 * @return array
 */
function getClientIPInfo($ip = ''){
    if(!$ip){
        return false;
    }
    $ipContent   = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=$ip");      
    $jsonData = json_decode($ipContent, true);
    if(0 != $jsonData['code']){
        return false;
    }
    $IPinfo = $jsonData['data'];
    return $IPinfo;
}
//获取用户真实ip
function get_user_ip(){
    static $realip;
        if (isset($_SERVER)){
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $realip = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $realip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")){
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
            } else {
                $realip = getenv("REMOTE_ADDR");
            }
        } 
        return $realip;
}
/**
 * 获取客户端手机型号
 * @param $agent    //$_SERVER['HTTP_USER_AGENT']
 * @return array[mobile_brand]      手机品牌
 * @return array[mobile_ver]        手机型号
 */
function getClientMobileBrand($agent = ''){
    if(preg_match('/iPhone\s([^\s|;]+)/i', $agent, $regs)) {
        $mobile_brand = '苹果';
        $mobile_ver = $regs[0];
    }elseif(preg_match('/SAMSUNG|Galaxy|GT-|SCH-|SM-\s([^\s|;]+)/i', $agent, $regs)) {
         $mobile_brand = '三星';
        $mobile_ver = $regs[0];
    }elseif(preg_match('/Huawei|Honor|H60-|H30-\s([^\s|;]+)/i', $agent, $regs)) {
         $mobile_brand = '华为';
        $mobile_ver = $regs[0];
    }elseif(preg_match('/Mi note|mi one\s([^\s|;]+)/i', $agent, $regs)) {        
        $mobile_brand = '小米';
        $mobile_ver = $regs[0];
    }elseif(preg_match('/HM NOTE|HM201\s([^\s|;]+)/i', $agent, $regs)) {        
        $mobile_brand = '红米';
        $mobile_ver = $regs[0];
    }elseif(preg_match('/Coolpad|8190Q|5910\s([^\s|;]+)/i', $agent, $regs)) {        
        $mobile_brand = '酷派';
        $mobile_ver = $regs[0];
    }elseif(preg_match('/ZTE|X9180|N9180|U9180\s([^\s|;]+)/i', $agent, $regs)) {        
        $mobile_brand = '中兴';
        $mobile_ver = $regs[0];
    }elseif(preg_match('/OPPO|X9007|X907|X909|R831S|R827T|R821T|R811|R2017\s([^\s|;]+)/i', $agent, $regs)) {        
        $mobile_brand = 'OPPO';
        $mobile_ver = $regs[0];
    }elseif(preg_match('/HTC|Desire\s([^\s|;]+)/i', $agent, $regs)) {        
        $mobile_brand = 'HTC';
        $mobile_ver = $regs[0];
    }elseif(preg_match('/Nubia|NX50|NX40\s([^\s|;]+)/i', $agent, $regs)) {        
        $mobile_brand = '努比亚';
        $mobile_ver = $regs[0];
    }elseif(preg_match('/M045|M032|M355\s([^\s|;]+)/i', $agent, $regs)) {        
        $mobile_brand = '魅族';
        $mobile_ver = $regs[0];
    }elseif(preg_match('/Gionee|GN\s([^\s|;]+)/i', $agent, $regs)) {        
        $mobile_brand = '金立';
        $mobile_ver = $regs[0];
    }elseif(preg_match('/HS-U|HS-E\s([^\s|;]+)/i', $agent, $regs)) {        
        $mobile_brand = '海信';
        $mobile_ver = $regs[0];
    }elseif(preg_match('/Lenove\s([^\s|;]+)/i', $agent, $regs)) {
        $mobile_brand = '联想';
        $mobile_ver = $regs[0];
    }elseif(preg_match('/ONEPLUS\s([^\s|;]+)/i', $agent, $regs)) {
        $mobile_brand = '一加';
        $mobile_ver = $regs[0];
    }elseif(preg_match('/vivo\s([^\s|;]+)/i', $agent, $regs)) {
        $mobile_brand = 'vivo';
        $mobile_ver = $regs[0];
    }elseif(preg_match('/K-Touch\s([^\s|;]+)/i', $agent, $regs)) {
        $mobile_brand = '天语';
        $mobile_ver = $regs[0];
    }elseif(preg_match('/DOOV\s([^\s|;]+)/i', $agent, $regs)) {
        $mobile_brand = '朵唯';
        $mobile_ver = $regs[0];
    }elseif(preg_match('/GFIVE\s([^\s|;]+)/i', $agent, $regs)) {
        $mobile_brand = '基伍';
        $mobile_ver = $regs[0];
    }elseif(preg_match('/Nokia\s([^\s|;]+)/i', $agent, $regs)) {
        $mobile_brand = '诺基亚';
        $mobile_ver = $regs[0];
    }else{
        $mobile_brand = '其他';
    }
    return ['mobile_brand'=>$mobile_brand, 'mobile_ver'=>$mobile_ver];
}

/**
 * 统计访问量
 */
function getPV(){
    $record = public_path()."/record.txt";
    if(!file_exists($record)){
        return 0;
    }else{ //如果不是第一次访问直接读取内容，并+1,写入更新后再显示新的访客数
        $str = file_get_contents($record);
        $rows = explode("\r\n",$str);
        $count = count($rows);
        return $count;
    }
}
//统计访问量操作
function putPV(){
    $remote = $_SERVER['REMOTE_ADDR'];
    //拼凑要写入到文件的数据：ip|2018-5-20 10:24:15
    $write = $remote . '|' . date('Y-m-d H:i:s');
    $write = "\r\n" . $write;
    $record = public_path()."/record.txt";
    if(!file_exists($record)){
            $one_file = fopen($record,"w+"); //建立一个统计文本，如果不存在就创建            
            file_put_contents($record,$write,FILE_APPEND);
            fclose("$one_file");
            return true;
         }else{ //如果不是第一次访问直接读取内容，并+1,写入更新后再显示新的访客数
            file_put_contents($record,$write,FILE_APPEND);
            return true;
    }
}
/**
 * 容量单位换算
 */
function getDanwei($size_range,$danwei){
    if($danwei=="G"){
      $size_range = $size_range*1000;
    }else if($danwei=="T"){
      $size_range = $size_range*1000*1000;
    }else{
      $size_range = $size_range;
    }
    return $size_range;
  }
/**
* 判断是否是浮点数或整数
*/
function isFloat($num){
    $isMatched = preg_match('/(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/', $num, $matches);
    if($isMatched){
        return true;
    }else{
        return false;
    }
}

/**
 * 判断单位是否正确
 */
function isDanwei($danwei){
    $isMatched = preg_match('/(^GB$)|(^TB$)|(^MB$)/', $danwei, $matches);
    if($isMatched){
        return true;
    }else{
        return false;
    }
}
/**
 * 获取函数执行时间
 */
function getFuncTime($func,$param_arr){
    $start = microtime(true);
    //第一个参数作为回调函数（callback）调用，把参数数组作（param_arr）为回调函数的的参数传入
    //参数数组必须是索引数组
    call_user_func_array($func, $param_arr);

    $end = microtime(true);
    $usedTime = bcsub($end, $start, 4);//毫秒数保留4位

    return  $usedTime;
}
/**
*   将中文转成成英文的字符长度
*/
function getEnByCnByString($string, $length=10){
    if(empty($string)){return false;}
    preg_match_all("/./u", $string, $arr);
    $exp =$arr[0];
    if(empty($exp)){return false;}
    if(is_numeric($exp[0])){return $exp[0];}
    $sum =1;
    $res ='';
    foreach ($exp as $key=>$value){
        $cha =  getFirstCharter($value);
        $res.=$cha;
        if(!empty($cha)){
            $sum++;
        }
        if($sum >$length){
            return $res;
        }
    }
    return $res;
}
/**
* 转化为字母的工具
*/
function getFirstCharter($str)
{
    if(is_numeric($str)){
        return '';
    }
    if (empty($str)) {
        return '';
    }

    $fchar = ord($str{0});

    if ($fchar >= ord('A') && $fchar <= ord('z'))
        return strtoupper($str{0});

    $s1 = iconv('UTF-8', 'gb2312', $str);

    $s2 = iconv('gb2312', 'UTF-8', $s1);

    $s = $s2 == $str ? $s1 : $str;

    $asc = ord($s{0}) * 256 + ord($s{1}) - 65536;

    if ($asc >= -20319 && $asc <= -20284)
        return 'A';

    if ($asc >= -20283 && $asc <= -19776)
        return 'B';

    if ($asc >= -19775 && $asc <= -19219)
        return 'C';

    if ($asc >= -19218 && $asc <= -18711)
        return 'D';

    if ($asc >= -18710 && $asc <= -18527)
        return 'E';

    if ($asc >= -18526 && $asc <= -18240)
        return 'F';

    if ($asc >= -18239 && $asc <= -17923)
        return 'G';

    if ($asc >= -17922 && $asc <= -17418)
        return 'H';

    if ($asc >= -17417 && $asc <= -16475)
        return 'J';

    if ($asc >= -16474 && $asc <= -16213)
        return 'K';

    if ($asc >= -16212 && $asc <= -15641)
        return 'L';

    if ($asc >= -15640 && $asc <= -15166)
        return 'M';

    if ($asc >= -15165 && $asc <= -14923)
        return 'N';

    if ($asc >= -14922 && $asc <= -14915)
        return 'O';

    if ($asc >= -14914 && $asc <= -14631)
        return 'P';

    if ($asc >= -14630 && $asc <= -14150)
        return 'Q';

    if ($asc >= -14149 && $asc <= -14091)
        return 'R';

    if ($asc >= -14090 && $asc <= -13319)
        return 'S';

    if ($asc >= -13318 && $asc <= -12839)
        return 'T';

    if ($asc >= -12838 && $asc <= -12557)
        return 'W';

    if ($asc >= -12556 && $asc <= -11848)
        return 'X';

    if ($asc >= -11847 && $asc <= -11056)
        return 'Y';

    if ($asc >= -11055 && $asc <= -10247)
        return 'Z';

    return null;
}
