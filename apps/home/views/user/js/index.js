$(function(){

})

// 查看充值记录
function examine(uid,type){
  console.log(uid,type);
  window.location.href = "/rechargeRecord/index/uid/"+uid+"/type/"+type;
}