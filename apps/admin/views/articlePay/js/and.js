$(function(){

  // 验证登录表单
  $("#articlesForm").validate({
      focusInvalid: true,
      rules: {
        reads: {
          required: true,
          digits: true
        },
        likes: {
          required: true,
          digits: true
        },
        comments: {
          required: true,
          digits: true
        },
      },
      messages: {
        reads: {
          required: "<span style='color:red;'>阅读数不能为空 :(</span>",
          digits: "<span style='color:red;'>必须为整数 :(</span>"
        },
        likes: {
          required: "<span style='color:red;'>点赞数不能为空 :(</span>",
          digits: "<span style='color:red;'>必须为整数 :(</span>"
        },
        comments: {
          required: "<span style='color:red;'>评论数不能为空 :(</span>",
          digits: "<span style='color:red;'>必须为整数 :(</span>"
        }
      },
     submitHandler: function(form){  
        $(form).ajaxSubmit({
            dataType:"json",
            success:function(res){
                console.log(res);
                if (res.code == 400) {
                    swal("提交失败", res.msg, "error");
                } else {
                    swal("提交成功", res.msg, "success");
                    setTimeout("window.location.href = document.referrer;",2000);
                }
            },
            error:function(e){
                console.log(111);
                console.log(e);
                swal("未知错误", "请尝试刷新页面后重试 :(", "error");
            }
        });

     }
  });

})

