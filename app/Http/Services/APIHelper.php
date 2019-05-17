<?php
namespace App\Http\Services;
 
class APIHelper
{
 
    /**
     *  $apiStr = '/api/xxx/list';
        $api = new APIHelper();
        $res =$api->post($body,$apiStr);
        $data = json_decode($res);
     * @param  [type] $body   [description]
     * @param  [type] $apiStr [description]
     * @return [type]         [description]
     */
    public function post($body,$apiStr)
    {
        $client = new \GuzzleHttp\Client(['base_uri' => 'http://ip.taobao.com/service/getIpInfo.php?ip=']);
        $res = $client->request('POST', $apiStr,
            ['json' => $body,
            'headers' => [
                'Content-type'=> 'application/json',
//                'Cookie'=> 'XDEBUG_SESSION=PHPSTORM',
                "Accept"=>"application/json"]
        ]);
        $data = $res->getBody()->getContents();
 
        return $data;
    }
 
    public function get($apiStr,$header)
    {
        $client = new \GuzzleHttp\Client(['base_uri' => 'http://ip.taobao.com/service/getIpInfo.php?ip=']);
        $res = $client->request('GET', $apiStr,['headers' => $header]);
        $statusCode= $res->getStatusCode();
 
        $header= $res->getHeader('content-type');
 
        $data = $res->getBody();
 
        return $data;
    }
    //https请求需要证书
    public static function post_user($body,$apiStr)
    {       
        $client = new \GuzzleHttp\Client(['verify' => '/full/path/to/cert.pem','base_uri' => 'http://xxx.xxx.com/api/']);
        $res = $client->request('POST', $apiStr,
            ['verify' => false,
                'json' => $body,
                'headers' => [
                    'Content-type'=> 'application/json']
            ]);
        $data = $res->getBody()->getContents();
 
        $response=json_decode($data);
 
        return $response;
    }

}
