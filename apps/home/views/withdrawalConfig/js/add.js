$(function(){

})

// 申请提现
function requestWithdrawal(push_money){
  // 获取提现金额，开户银行，开户卡号
  var money = $("input[name='money']").val();
  var deposit_bank = $("input[name='deposit_bank']").val();
  var card_number = $("input[name='card_number']").val();
  console.log(parseInt(push_money),parseInt(money),deposit_bank,card_number);
  // if
  if (isNaN(parseInt(money)) || parseInt(money) < 100) {
    $.alert("提现金额不能小于100 :(", "提示");
  } else if (parseInt(push_money) < parseInt(money)) {
    $.alert("您当前提现金额不足够 :(", "提示");
  } else if (deposit_bank == '' || deposit_bank == false) {
    $.alert("开户银行不能为空 :(", "提示");
  } else if (card_number == '' || card_number == false) {
    $.alert("开户卡号不能为空 :(", "提示");
  } else {

    // Ajax
    $.ajax({
      type: "POST",
      url: "/withdrawalConfig/add",
      data: {
        money: money,
        deposit_bank: deposit_bank,
        card_number: card_number
      },
      dataType: "JSON",
      success: function (res) {
        console.log(res);
        if (res.code == 0) {
          $.alert(res.msg, "申请成功");
          setTimeout("window.location.reload();",2000);
        } else {
          $.alert(res.msg, "申请失败");
        }
      },
      error: function (e) {
        console.log(e);
      }
    });
  }
}

// 提现列表
function rwIndex(){
  window.location.href = "/withdrawalRecord/index";
}