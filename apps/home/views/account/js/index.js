$(function(){

  // 默认选中
  $("#price8").removeClass("offActive").addClass("onActive");
   // 选中的money追加金额到支付按钮
  $("#gotoPay").attr("value",'0.01');

});


// 选择价格
function select(k,money){
  console.log(k,money);
  for(i=0; i<=8;){
    $("#price"+i).removeClass("onActive").addClass("offActive");
    i++;
  }
  $("#price"+k).removeClass("offActive").addClass("onActive");
  // 选中的money追加金额到支付按钮
  $("#gotoPay").attr("value",money);
}

// 去支付
function gotoPay(){

  // 获取充值金额
  var money = $("#gotoPay").val();
  if (money == '' || money == false) {
    $.alert("请选择充值金额 :(", "提示");
  } else {
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

// 去往职员页面
function gotoStaff(){
  window.location.href = "/staffs/index";
}

// 提示职员
function hint(){
  $.alert("您当前不是职员身份 :(", "提示");
}


