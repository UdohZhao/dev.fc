$(function(){

});


// 验证中文名称
function isChinaName(name) {
 var pattern = /^[\u4E00-\u9FA5]{1,6}$/;
 return pattern.test(name);
}

// 验证手机号
function isPhoneNo(phone) {
 var pattern = /^1[34578]\d{9}$/;
 return pattern.test(phone);
}

// 验证身份证
function isCardNo(card) {
 var pattern = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
 return pattern.test(card);
}

// 成为地主
function become(){
  // 验证表单
  var phone = $("input[name='phone']").val();
  var cname = $("input[name='cname']").val();
  //var id_card = $("input[name='id_card']").val();
  var city = $("input[name='city']").val();
  // if
  if (!isPhoneNo(phone)) {
    $.alert("请输入有效的手机号码 :(", "提示");
  } else if (!isChinaName(cname)) {
    $.alert("请输入有效的姓名 :(", "提示");
  } else if (!isChinaName(city)) {
    $.alert("请输入有效的城市 :(", "提示");
  } else {
    // Ajax提交表单
    $("#landlordForm").ajaxSubmit({
        dataType:"JSON",
        success:function(res){
          console.log(res);
          // res
          if (res.code === 0) {
            $.alert(res.msg, "提交成功");
            setTimeout("window.location.href='/mySite/index'",2000);
          } else {
            $.alert(rem.msg, "提交失败");
          }
        },
        error:function(e){
          console.log(e);
        }
    });
  }


}
