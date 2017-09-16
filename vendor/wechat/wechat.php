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

    see($res);
    die;

    if (array_key_exists('access_token', $res)) {
      $_SESSION['access_token'] = $res['access_token'];
      $_SESSION['expires_in'] = bcadd($res['expires_in'], time(), 0);
    } else {
      echo '获取授权access_token失败～ ' . $res['errmsg'];
      die;
    }

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

  /**
   * 微信JsApi支付
   * @param  string   $openId     openid
   * @param  string   $goods      商品名称
   * @param  string   $order_sn   订单号
   * @param  string   $total_fee  金额
   * @param  string   $attach 附加参数,我们可以选择传递一个参数,比如订单ID
   */
  public function JsApiPay($openId,$goods,$order_sn,$total_fee,$attach){
      require_once ICUNJI.'/vendor/wxpay/WxPay.Api.php';
      require_once ICUNJI.'/vendor/wxpay/WxPay.JsApiPay.php';
      require_once ICUNJI.'/vendor/wxpay/log.php';

      //初始化日志
      $logHandler= new \CLogFileHandler(ICUNJI.'/vendor/wxpay/wxlogs/'.date('Ymd').'.log');
      $log = \Log::Init($logHandler, 15);

      $tools = new \JsApiPay();
      if(empty($openId)) $openId = $tools->GetOpenid();

      $input = new \WxPayUnifiedOrder();
      $input->SetBody($goods);                 //商品名称
      $input->SetAttach($attach);                  //附加参数,可填可不填,填写的话,里边字符串不能出现空格
      $input->SetOut_trade_no($order_sn);          //订单号
      $input->SetTotal_fee($total_fee);            //支付金额,单位:分
      $input->SetTime_start(date("YmdHis"));       //支付发起时间
      $input->SetTime_expire(date("YmdHis", time() + 600));//支付超时
      $input->SetGoods_tag("1");
      //支付回调验证地址
      $input->SetNotify_url(isHttps()."/account/notify");
      $input->SetTrade_type("JSAPI");              //支付类型
      $input->SetOpenid($openId);                  //用户openID
      $order = \WxPayApi::unifiedOrder($input);    //统一下单

      $jsApiParameters = $tools->GetJsApiParameters($order);

      return $jsApiParameters;
  }

}


