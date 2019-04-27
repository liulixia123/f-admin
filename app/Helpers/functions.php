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
