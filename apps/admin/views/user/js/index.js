$(function(){

  // 验证登录表单
  $("#ePassForm").validate({
      focusInvalid: true,
      rules: {
        cname: {
          required: true
        },
        phone: {
          required: true,
           	digits:true
        }
      },
      messages: {
        cname: {
          required: "<span style='color:red;'>姓名不能为空 :(</span>"
        },
        phone: {
          required: "<span style='color:red;'>电话号码不能为空 :(</span>",
           digits: "<span style='color:red;'>请输入正确的电话号码。 :(</span>",
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
function ePass(id,username){

  $("#ePassForm").attr("action","/admin/user/add/id/"+id);
  // modal
  $('#ePassModal').modal({
    backdrop: 'static',
    keyboard: false
  });
}
function flow(id){
	window.location.href = "/admin/user/index/id/"+id+ "/type/"+0 ;
}
function withdrawal(id,status){
    var title;
    // status
    if (status == 0) {
        title = "确认同意提现吗？";
    }
    swal({
            title: title,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确定",
            cancelButtonText: "取消",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm){
            if (isConfirm) {
                // Ajax
                $.ajax({
                    type: "POST",
                    url: "/admin/user/status/id/" +id,
                    data: {status:status},
                    dataType: "JSON",
                    success: function(res){
                        // res
                        if (res === true) {
                            swal("提交成功", "当前操作已发生改变 :)", "success");
                            setTimeout("window.location.reload();",2000);
                        } else {
                            swal("提交失败", "请刷新页面后重试 :(", "error");
                        }
                    },
                    error: function(e){
                        console.log(e);
                        swal("未知错误", "请刷新页面后重试 :(", "error");
                    }
                });
            } else {
                swal("取消了", "当前操作未发生改变 :)", "error");
            }
        });
}
function topUp(id){
	window.location.href = "/admin/rechargeRecord/index/id/"+id;
}
