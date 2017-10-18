$(function(){

});

// 充值
function topUp(){
  window.location.href = "/account/index";
}

// 我要当地主
function landlord(){
  window.location.href = "/landlord/add";
}

// 提现详情
function withdrawDetails(landlord_status){
  console.log(landlord_status);
  if (landlord_status == 0) {
    $.alert("您目前还不是地主身份 :(", "提示");
  } else {
    window.location.href = "/withdrawalConfig/add";
  }
}

// 分享二维码
function share(landlord_status){
  console.log(landlord_status);
  if (landlord_status == 0) {
    $.alert("您目前还不是地主身份 :(", "提示");
  } else {
    window.location.href = "/staffs/shareQRcode";
  }
}

// 小伙伴
function littleFriends(landlord_status){
  console.log(landlord_status);
  if (landlord_status == 0) {
    $.alert("您目前还不是地主身份 :(", "提示");
  } else {
    window.location.href = "/user/index";
  }
}