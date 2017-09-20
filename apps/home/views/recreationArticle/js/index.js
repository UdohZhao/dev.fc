$(function(){

});

// 获取信息
function getInfo(type,id,money){
  console.log(type,id,money);
  var msg;
  if (type == 1) {
    msg = "获取美妹QQ号仅需¥"+money;
  } else if (type == 2) {
    msg = "获取美妹微信号仅需¥"+money;
  } else if (type == 3) {
    msg = "获取美妹手机号仅需¥"+money;
  }
  $.confirm(msg+"（信息真实有效！）", "提示",function() {
    // Ajax 请求微信支付统一下单
    $.ajax({
      method: "POST",
      url: "/account/pay",
      data: {
        money: money,
        raid: id,
        type: type
      },
      dataType: "JSON",
      success: function (res) {
        console.log(res);
        if (typeof WeixinJSBridge == "undefined"){
           if( document.addEventListener ){
               document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
           }else if (document.attachEvent){
               document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
               document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
           }
        }else{
           onBridgeReady(res);
        }
      },
      error: function (e) {
        console.log(e);
      }

    });
  }, function() {
    console.log('取消了。');
  });

}

// 唤起微信支付
function onBridgeReady(jsApiParameters){
   WeixinJSBridge.invoke(
       'getBrandWCPayRequest',
       jsApiParameters,
       function(res){
           if(res.err_msg == "get_brand_wcpay_request:ok" ) {
            $.alert("充值成功 :)", "提示");
            setTimeout("window.location.reload();",3000);
           } else {
            $.alert("您取消了支付 :(", "提示");
           }
       }
   );
}