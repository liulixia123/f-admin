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
    return date('YmdHis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);;
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
function getBrowser(){
    $flag=$_SERVER['HTTP_USER_AGENT'];
    $para=array();
    
    // 检查操作系统
    if(preg_match('/Windows[\d\. \w]*/',$flag, $match)) $para['os']=$match[0];
    
    if(preg_match('/Chrome\/[\d\.\w]*/',$flag, $match)){
        // 检查Chrome
        $para['browser']=$match[0];
    }elseif(preg_match('/Safari\/[\d\.\w]*/',$flag, $match)){
        // 检查Safari
        $para['browser']=$match[0];
    }elseif(preg_match('/MSIE [\d\.\w]*/',$flag, $match)){
        // IE
        $para['browser']=$match[0];
    }elseif(preg_match('/Opera\/[\d\.\w]*/',$flag, $match)){
        // opera
        $para['browser']=$match[0];
    }elseif(preg_match('/Firefox\/[\d\.\w]*/',$flag, $match)){
        // Firefox
        $para['browser']=$match[0];
    }elseif(preg_match('/OmniWeb\/(v*)([^\s|;]+)/i',$flag, $match)){
        //OmniWeb
        $para['browser']=$match[2];
    }elseif(preg_match('/Netscape([\d]*)\/([^\s]+)/i',$flag, $match)){
        //Netscape
        $para['browser']=$match[2];
    }elseif(preg_match('/Lynx\/([^\s]+)/i',$flag, $match)){
        //Lynx
        $para['browser']=$match[1];
    }elseif(preg_match('/360SE/i',$flag, $match)){
        //360SE
        $para['browser']='360安全浏览器';
    }elseif(preg_match('/SE 2.x/i',$flag, $match)) {
        //搜狗
        $para['browser']='搜狗浏览器';
    }elseif(preg_match('/like mac os x/i',$flag, $match)) {
        //IOS终端
        $para['browser']='ios终端';
    }elseif(preg_match('/iPhone/i',$flag, $match)) {
        //iPhone
        $para['browser']='iPhone';
    }elseif(preg_match('/MicroMessenger/i',$flag, $match)) {
        //微信
        $para['browser']='weixin';
    }elseif(preg_match('/\sQQ/i',$flag, $match)) {
        //QQ
        $para['browser']='QQ';
    }else{
        $para['browser']='unkown';
    }
    return $para;
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
