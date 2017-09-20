$(function(){

});

// 获取信息
function getInfo(type,id,monery){
  console.log(type,id,monery);
  var msg;
  if (type == 0) {
    msg = "获取美妹QQ号仅需¥".monery;
  } else if (type == 1) {
    msg = "获取美妹微信号仅需¥".monery;
  } else if (type == 2) {
    msg = "获取美妹手机号仅需¥".monery;
  }
  $.confirm(msg+"（信息真实有效！）", "提示",function() {

    $.alert("111");

  }, function() {
    console.log('取消了。');
  });

}