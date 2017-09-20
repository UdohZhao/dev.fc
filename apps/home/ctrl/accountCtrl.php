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
      if (isset($_SESSION['userinfo']['id'])) {
        // 新用户赠送金币
        $present = conf::get('PRESENT','wechat');
        // 读取当前用户类型
        $type = $this->udb->getType($_SESSION['userinfo']['id']);
        // 读取当前用户金币
        $residue = $this->udb->getResidue($_SESSION['userinfo']['id']);
        // assign
        $this->assign('present',$present);
        $this->assign('type',$type);
        $this->assign('residue',$residue);
      }
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
      $orderid = createIn();
      $money = bcmul($_POST['money'], 100, 0);
      // raid 美妹付费
      if (isset($_POST['raid']) && isset($_POST['type'])) {
        $goods = '美妹付费';
        $uid = $_SESSION['userinfo']['id'];
        $raid = $_POST['raid'];
        $type = $_POST['type'];
        $attachStr = "$uid,$raid,$type";
      } else {
        $goods = '账户充值';
        $uid = $_SESSION['userinfo']['id'];
        $raid = 0;
        $type = 0;
        $attachStr = "$uid,$raid,$type";
      }
      $attach = $attachStr;
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
        $attach = $data['attach'];        //附加参数,选择传递订单ID
        $openid = $data['openid'];          //付款人openID
        $total_fee = $data['total_fee'];    //付款金额

        // 字符串转换成数组 ，uid，raid，type
        $attachArr = explode(',', $attach);
        $uid = $attachArr[0];
        $raid = $attachArr[1];
        $type = $attachArr[2];

        // 查询充值订单已经存在就不做处理
        $res = $this->rrdb->getOrderid($order_sn);
        if (!$res) {
          // 获取实际充值金额
          $total_fee = bcdiv($total_fee, 100, 2);
          // 测试充值金额
          $total_fee = bcadd($total_fee, conf::get('TEST_MONEY','wechat'));
          // 查询当前用户详细信息
          $data = $this->udb->getidInfo($uid);
          // 普通用户充值计算提成
          if ($data['type'] != 1 && $data['pid'] != 0) {
            // 获取总代理提成百分比
            $general_agency_percent = bcdiv(conf::get('GENERAL_AGENCY_PERCENT','wechat'), 100, 2);
            // 获取代理商提成百分比
            $agent_percent = bcdiv(conf::get('AGENT_PERCENT','wechat'), 100, 2);
            // 获取经销商提成百分比
            $agency_percent = bcdiv(conf::get('AGENCY_PERCENT','wechat'), 100, 2);
            // 计算总代理提成金额
            $general_agency_money = bcmul($total_fee, $general_agency_percent, 2);
            // 计算代理商提成金额
            $agent_money = bcmul($total_fee, $agent_percent, 2);
            // 计算经销商提成金额
            $agency_money = bcmul($total_fee, $agency_percent, 2);
          }

          // 写入充值数据表
          $rrData = array();
          $rrData['uid'] = $uid;
          $rrData['pid'] = $data['pid'];
          $rrData['raid'] = $raid;
          $rrData['orderid'] = $order_sn;
          $rrData['money'] = $total_fee;
          $rrData['general_agency_money'] = $general_agency_money;
          $rrData['agent_money'] = $agent_money;
          $rrData['agency_money'] = $agency_money;
          $rrData['ctime'] = time();
          $rrData['type'] = $type;
          $res = $this->rrdb->add($rrData);
          if ($res) {
            // 累加用户金币
            $residue = bcmul($total_fee, conf::get('CONVERSION','wechat'), 0);
            $residue = bcadd($residue, $data['residue'], 0);
            /*// 新用户赠送金币
            if ($data['pid'] != 0 && $data['pay_status'] != 1) {
              $residue = bcadd($residue, conf::get('PRESENT','wechat'), 0);
              $upData['pay_status'] = 1;
            }*/
            // 更新数据
            $upData['residue'] = $residue;
            // 更新用户金币
            $this->udb->save($uid,$upData);
            // 利润分配
            if ($data['type'] != 1 && $data['pid'] != 0) {
              // 用户信息
              $userinfoData = array();
              // 获取经销商用户信息
              $userinfoData['agency'] = $this->udb->getidInfo($data['pid']);
              // 获取代理商用户信息
              $userinfoData['agent'] = $this->udb->getidInfo($userinfoData['agency']['pid']);
              // 获取总代理用户信息
              $userinfoData['general_agency'] = $this->udb->getidInfo($userinfoData['agent']['pid']);
              // 累加经销商提成金额
              $userinfoupData['agency']['push_money'] = bcadd($userinfoData['agency']['push_money'], $agency_money, 2);
              // 累加代理商提成金额
              $userinfoupData['agent']['push_money'] = bcadd($userinfoData['agent']['push_money'], $agent_money, 2);
              // 累加总代理提成金额
              $userinfoupData['general_agency']['push_money'] = bcadd($userinfoData['general_agency']['push_money'], $general_agency_money, 2);
              // 更新经销商提成金额
              $this->udb->save($userinfoData['agency']['id'],array('push_money'=>$userinfoupData['agency']['push_money']));
              // 更新代理商提成金额
              $this->udb->save($userinfoData['agent']['id'],array('push_money'=>$userinfoupData['agent']['push_money']));
              // 更新总代理提成金额
              $this->udb->save($userinfoData['general_agency']['id'],array('push_money'=>$userinfoupData['general_agency']['push_money']));
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