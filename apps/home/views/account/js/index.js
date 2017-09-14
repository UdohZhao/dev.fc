$(function(){

});

// 选择价格
function select(k,money){
  console.log(k,money);
}

// 唤起微信支付
function onBridgeReady(info){
   WeixinJSBridge.invoke(
       'getBrandWCPayRequest',
       info,
       function(res){
           if(res.err_msg == "get_brand_wcpay_request:ok" ) {
            alert('支付成功');
           } else {
            alert('用户取消了支付');
           }
       }
   );
}

// 去支付
function gotoPay(money){
  // 模拟价格
  var money = '0.01';
  // Ajax
  $.ajax({
    method: "POST",
    url: "/account/pay",
    data: {
      money: money
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



}



