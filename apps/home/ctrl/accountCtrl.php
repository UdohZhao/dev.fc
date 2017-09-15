<?php
namespace apps\home\ctrl;
use core\lib\conf;
use apps\home\model\rechargeRecord;
class accountCtrl extends baseCtrl{
  public $rrdb;
  // 构造方法
  public function _auto(){
    $this->rrdb = new rechargeRecord();
  }

  /**
   * 个人账户页面
   */
  public function index(){
    // Get
    if (IS_GET === true) {
      // 读取当前用户金币
      $residue = $this->udb->getResidue($_SESSION['userinfo']['id']);
      // assign
      $this->assign('residue',$residue);
      // display
      $this->display('account','index.html');
      die;
    }
  }

  /**
   *  微信支付统一下单
   */
  public function pay(){
    // Ajax
    if (IS_AJAX === true) {
      $openid = $_SESSION['getWecahtUserInfo']['openid'];
      $goods = '账户充值';
      $orderid = createIn();
      //$orderid = '123456';
      $money = bcmul($_POST['money'], 100, 0);
      $attach = $_SESSION['userinfo']['id'];
      // 统一下单
      $jsApiParameters = $this->wechat->JsApiPay($openid,$goods,$orderid,$money,$attach);
      echo $jsApiParameters;
      die;
    }
  }

  // 微信支付回调
  public function notify(){

    //$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
    $xml = file_get_contents("php://input");

    // 这句file_put_contents是用来查看服务器返回的XML数据 测试完可以删除了
    file_put_contents(ICUNJI."/vendor/wxpay/wxlogs/check.log",$xml.PHP_EOL,FILE_APPEND);

    //将服务器返回的XML数据转化为数组
    //$data = json_decode(json_encode(simplexml_load_string($xml,'SimpleXMLElement',LIBXML_NOCDATA)),true);
    $data = XA($xml);
    // 保存微信服务器返回的签名sign
    $data_sign = $data['sign'];
    // sign不参与签名算法
    unset($data['sign']);
    $sign = makeSign($data);

    // 判断签名是否正确判断支付状态
    if ( ($sign===$data_sign) && ($data['return_code']=='SUCCESS') && ($data['result_code']=='SUCCESS') ) {
        $result = $data;
        // 这句file_put_contents是用来查看服务器返回的XML数据 测试完可以删除了
        file_put_contents(ICUNJI."/vendor/wxpay/wxlogs/ok.log",$xml.PHP_EOL,FILE_APPEND);

        //获取服务器返回的数据
        $order_sn = $data['out_trade_no'];  //订单单号
        $uid = $data['attach'];        //附加参数,选择传递订单ID
        $openid = $data['openid'];          //付款人openID
        $total_fee = $data['total_fee'];    //付款金额

        // 查询充值订单已经存在就不做处理
        $res = $this->rrdb->getOrderid($order_sn);
        if (!$res) {
          // 获取实际充值金额
          $total_fee = bcdiv($total_fee, 100, 2);

          // 查询当前用户详细信息
          $data = $this->udb->getidInfo($uid);
          if ($data['pid'] != 0) {
            // 获取提成百分比
            $unit_percent = bcdiv(conf::get('UNIT_PERCENT','wechat'), 100, 0);
            // 计算提成金额
            $unit_money = bcmul($total_fee, $unit_percent, 2);
          } else {
            $unit_money = 0;
          }

          // 写入充值数据表
          $rrData = array();
          $rrData['uid'] = $uid;
          $rrData['pid'] = $data['pid'];
          $rrData['orderid'] = $order_sn;
          $rrData['money'] = $total_fee;
          $rrData['unit_money'] = 0;
          $rrData['ctime'] = time();
          $res = $this->rrdb->add($rrData);
          if ($res) {
            // 累加用户金币
            $residue = bcmul($total_fee, conf::get('CONVERSION','wechat'), 0);
            $residue = bcadd($residue, $data['residue'], 0);
            // 更新用户金币
            $this->udb->save($uid,array('residue'=>$residue));
            // unit_money 提成金额不为0
            if ($unit_money != 0) {
              $data = $this->udb->getidInfo($data['pid']);
              $push_money = bcadd($data['push_money'], $unit_money, 2);
              $this->udb->save($data['pid'],array('push_money'=>$push_money));
            }
          }
        }
    }else{
        $result = false;
    }
    // 返回状态给微信服务器
    if ($result) {
      return '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
    }else{
      return '<xml><return_code><![CDATA[FAIL]]></return_code><return_msg><![CDATA[签名失败]]></return_msg></xml>';
    }
  }

}