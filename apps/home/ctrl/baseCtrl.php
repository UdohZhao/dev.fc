<?php
namespace apps\home\ctrl;
use core\lib\conf;
use vendor\wechat\wechat;
use apps\home\model\user;
define('TOKEN', 'bainianfc');
class baseCtrl extends \core\icunji{
  public $appid;
  public $appsecret;
  public $wechat;
  public $udb;
  public $appsPath = '/apps/home/views';
  // 构造方法
  public function _initialize(){
    //控制器初始化
    if(method_exists($this,'_auto'))
        $this->_auto();
    $this->appid = conf::get('APPID','wechat');
    $this->appsecret = conf::get('APPSECRET','wechat');
    $this->wechat = new wechat(TOKEN,DEBUG,$this->appid,$this->appsecret);
   /* $this->udb = new user();
    // 应用路径
    $this->assign('appsPath',$this->appsPath);
    // access_token检测是否过期
    if (isset($_SESSION['expires_in'])) {
      if (time() > $_SESSION['expires_in']) {
        $this->wechat->getAccessToken();
      }
    } else {
      $this->wechat->getAccessToken();
    }
    // pid清除session
    if (isset($_GET['pid']) && intval($_GET['pid']) != 0) {
      unset($_SESSION['userinfo']);
    }
    // 获取微信用户信息
    if (!isset($_SESSION['userinfo'])) {
      $this->wechat->getUserInfo(1,'','','');
    } else {
      // 用户信息传入模版
      $this->assign('userinfo',$_SESSION['userinfo']);
    }
    // 站点名称
    $this->assign('websiteName',conf::get('WEBSITE_NAME','admin'));*/
  }

  /**
   * 对接微信
   */
  public function buttJointWechat(){
    // 接收微信get参数
    $this->wechat->valid();
  }

  /**
   * index 邀请用户专用
   */
  public function index(){
    // Get 
    if (IS_GET === true) {
      // pid 父级id
      $pid = isset($_GET['pid']) ? intval($_GET['pid']) : 0;
      $_SESSION['pid'] = $pid;
    }
  }


  /**
   * 回调获取授权code
   */
  public function getCode(){
    // 获取code , state
    if (isset($_GET['code']) && isset($_GET['state'])) {
      // 第二步：通过code换取网页授权access_token
      $this->wechat->getUserInfo(2,$_GET['code'],'','');
      // 第四步：拉取用户信息(需scope为 snsapi_userinfo)
      $this->wechat->getUserInfo(4,'',$_SESSION['getUiAccessToken']['access_token'],$_SESSION['getUiAccessToken']['openid']);
    }
    // 匹配数据库，读取用户数据
    if (isset($_SESSION['getWecahtUserInfo'])) {
      $res = $this->udb->getopenidInfo($_SESSION['getWecahtUserInfo']['openid']);
      if ($res) {
        $_SESSION['userinfo'] = $res;
      } else {
        // 组装数据
        $data['pid'] = isset($_SESSION['pid']) ? $_SESSION['pid'] : 0;
        $data['openid'] = $_SESSION['getWecahtUserInfo']['openid'];
        $data['nickname'] = $_SESSION['getWecahtUserInfo']['nickname'];
        $data['city'] = $_SESSION['getWecahtUserInfo']['city'];
        $data['province'] = $_SESSION['getWecahtUserInfo']['province'];
        $data['country'] = $_SESSION['getWecahtUserInfo']['country'];
        $data['headimgurl'] = $_SESSION['getWecahtUserInfo']['headimgurl'];
        $data['residue'] = 0;
        $data['push_money'] = 0;
        $data['type'] = 0;
        $data['status'] = 0;
        $data['code_status'] = 0;
        $data['pay_status'] = 0;
        // 写入用户数据表
        $id = $this->udb->add($data);
        if ($id) {
          // 读取用户数据
          $res = $this->udb->getidInfo($id);
          $_SESSION['userinfo'] = $res;
        } else {
          echo '获取数据异常～';
          die;
        }
      }
    }

    header("Location:/account/index");
    die;

  }

}