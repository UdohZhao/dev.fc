$(function(){

  // 验证登录表单
  $("#Apply").validate({
      focusInvalid: true,
      rules: {
        cname: {
          required: true,
          minlength: 6
        },
        phone: {
          required: true,
          minlength: 6,
        }
      },
      messages: {
        cname: {
          required: "<span style='color:red;'>新密码不能为空 :(</span>",
          minlength: "<span style='color:red;'>新密码长度不能小于6个字符 :(</span>"
        },
        phone: {
          required: "<span style='color:red;'>确认新密码不能为空 :(</span>",
          minlength: "<span style='color:red;'>新密码长度不能小于6个字符 :(</span>",
        }
      },
      submitHandler: function(form){
        $(form).ajaxSubmit({
            dataType:"json",
            success:function(res){
             

              // 隐藏Modal
              $('#ePassModal').modal('hide');
              // res
              if (res === true) {
                swal("提交成功", "受影响的操作 :)", "success");
                window.setTimeout("window.location.reload();",2000);
              } else {
                swal("提交失败", "请尝试刷新页面后重试 :(", "error");
              }
            },
            error:function(e){
              console.log(e);
              swal("未知错误", "请尝试刷新页面后重试 :(", "error");
            }
        });
      }
  });

});

// 修改密码
function ePass(id){
  // 动态赋值
 
  $("#Apply").attr("action","/admin/user/add/id/"+id);
  // modal
  $('#ePassModal').modal({
    backdrop: 'static',
    keyboard: false
  });
}

}