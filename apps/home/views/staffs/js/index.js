$(function(){

});

// 申请提现
function apply(push_money){
  console.log(push_money);
  $.confirm("确认要申请提现吗？", "提示",function() {
    // 少于100不允许提现
    if (push_money < 100) {
      $.alert("仅允许收益金额大于100提现 :(", "提示");
    } else {
      // Ajax
      $.ajax({
        method: "POST",
        url: "/withdrawalRecord/add",
        data: {
          push_money: push_money
        },
        dataType: "JSON",
        success: function (res) {
          console.log(res);
          if (res.code == 400) {
            $.alert(res.msg, "提示");
          } else {
            $.alert(res.msg, "提示");
            setTimeout("window.location.reload();",3000);
          }
        },
        error: function (e) {
          console.log(e);
        }
      });
    }
  }, function() {
    console.log('取消了');
  });
}

// 分享二维码
function share(){
  window.location.href = "/staffs/shareQRcode";
}