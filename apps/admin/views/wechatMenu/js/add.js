$(function(){

  // 验证登录表单
  $("#formMenu").validate({
      focusInvalid: true,
      rules: {
        cname: {
          required: true
        },
        url: {
          required: true
        }
      },
      messages: {
        cname: {
          required: "<span style='color:red;'>菜单名称不能为空 :(</span>"
        },
        url: {
          required: "<span style='color:red;'>跳转链接不能为空 :(</span>"
        }
      },
      submitHandler: function(form){
        $(form).ajaxSubmit({
            dataType:"json",
            success:function(res){
              console.log(res);
              // res
              if (res.code == 400) {
                swal("提交失败", res.msg, "error");
              } else if (res.code == 401) {
                swal("提交失败", res.msg, "error");
              } else {
                swal("提交成功", res.msg, "success");
                setTimeout("window.location.href='/admin/wechatMenu/index'",2000);
              }

            },
            error:function(e){
              swal("未知错误 :(", "请刷新页面后重试!", "error");
            }
        });
      }
  });


})