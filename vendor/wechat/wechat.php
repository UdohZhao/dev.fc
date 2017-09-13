<?php
/**
* 微信类
*/

namespace vendor\wechat;
use core\lib\conf;

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

    // if (array_key_exists('access_token', $res)) {
    //   $_SESSION['access_token'] = $res['access_token'];
    //   $_SESSION['expires_in'] = bcadd($res['expires_in'], time(), 0);
    // } else {
    //   echo '获取access_token失败~';
    //   die;
    // }
  }

  /**
   * 获取微信用户基本信息
   */
  public function getUserInfo($step,$code = '',$access_token,$openid){
    if ($step == 1) {
      // 第一步：用户同意授权，获取code
      $this->getCode();
    } else if ($step == 2) {
      // 第二步：通过code换取网页授权access_token
      $this->getUiAccessToken($code);
    } else if ($step == 4) {
      // 第四步：拉取用户信息(需scope为 snsapi_userinfo)
      $this->getWecahtUserInfo($access_token,$openid);
    }

  }

  /**
   * 获取授权code
   */
  public function getCode(){
    // url
    $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE#wechat_redirect";
    // 参数
    $param['appid'] = $this->appid;
    $param['redirect_uri'] = conf::get('REDIRECT_URI','wechat');
    $param['response_type'] = 'code';
    $param['scope'] = 'snsapi_userinfo';
    $param['state'] = '1';
    $url = replaceUrlParam($url,$param);
    header("Location:$url");
  }

  /**
   * 获取授权access_token
   */
  public function getUiAccessToken($code){
    // url
    $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code";
    // 参数
    $param['appid'] = $this->appid;
    $param['secret'] = $this->appsecret;
    $param['code'] = $code;
    $param['grant_type'] = 'authorization_code';
    $url = replaceUrlParam($url,$param);
    // get请求
    $res = CG($url);
    $res = json_decode($res,true);
    if (array_key_exists('errcode', $res)) {
      echo  '获取授权access_token失败～';
      die;
    }
    $_SESSION['getUiAccessToken'] = $res;
    return;
  }

  /**
   * 拉取用户信息
   */
  public function getWecahtUserInfo($access_token,$openid){
    // url
    $url = "https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN";
    $param['access_token'] = $access_token;
    $param['openid'] = $openid;
    $param['lang'] = 'zh_CN';
    $url = replaceUrlParam($url,$param);
    // get请求
    $res = CG($url);
    $res = json_decode($res,true);
    if (array_key_exists('errcode', $res)) {
      echo  '获取微信用户信息失败～';
      die;
    }
    $_SESSION['getWecahtUserInfo'] = $res;
    return;
  }

}


