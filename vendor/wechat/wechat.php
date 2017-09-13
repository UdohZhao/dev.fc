<?php
/**
* 微信类
*/

namespace vendor\wechat;

class wechat{
  public $token;
  public $debug;
  public $appid;
  public $appsecret;
  // 构造方法
  function __construct($token,$debug = false,$appid,$appsecret){
    $this->token = $token;
    $this->debug = $debug;
    $this->appid = $appid;
    $this->appsecret = $appsecret;
  }

  /**
   * 对接微信
   */
  public function valid(){
    // 接收微信get参数
    $signature = $_GET['signature'];
    $timestamp = $_GET['timestamp'];
    $nonce = $_GET['nonce'];
    $echostr = $_GET['echostr'];
    $res = $this->checkSignature($signature,$timestamp,$nonce);
    if ($res) {
      echo $echostr;
    }
  }

  /**
   *  核对签名
   */
  private function checkSignature($signature,$timestamp,$nonce){
    $tmpArr = array($this->token,$timestamp,$nonce);
    sort($tmpArr);
    $tmpStr = implode($tmpArr);
    $tmpStr = sha1($tmpStr);
    if ($tmpStr == $signature) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * 获取access_token
   */
  public function getAccessToken(){
    // url
    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET";
    $param['grant_type'] = 'client_credential';
    $param['appid'] = $this->appid;
    $param['secret'] = $this->appsecret;
    $url = replaceUrlParam($url,$param);
    // access_token
    $res = json_decode(CG($url),true);
    // if (array_key_exists('access_token', $res)) {
    //   $_SESSION['access_token'] = $res['access_token'];
    //   $_SESSION['expires_in'] = bcadd($res['expires_in'], time(), 0);
    // } else {
    //   echo '获取access_token失败';
    //   die;
    // }
  }

}


