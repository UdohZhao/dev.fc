$(function(){

  // 验证个人信息表单
  $("#staffsForm").validate({
      focusInvalid: true,
      rules: {
        cname: {
          required: true
        },
        phone: {
          required: true,
          digits: true
        }
      },
      messages: {
        cname: {
          required: "<span style='color:red;'>姓名不能为空 :(</span>"
        },
        phone: {
          required: "<span style='color:red;'>手机号码不能为空 :(</span>",
          digits: "<span style='color:red;'>必须输入整数 :(</span>"
        }
      },
      submitHandler: function(form){
        $(form).ajaxSubmit({
            dataType:"json",
              success:function(res){
                console.log(res);
                // 隐藏Modal
                $('#staffsModal').modal('hide');
                if (res.code == 400) {
                  swal("提交失败", res.msg, "error");
                } else {
                  swal("提交成功", res.msg, "success");
                  setTimeout("window.location.reload();",2000);
                }
              },
              error:function(e){
              console.log(e);
              swal("未知错误", "请尝试刷新页面后重试 :(", "error");
            }
        });
      }
  });

})

// 设置为总代理
function commonality(id){
  console.log(id);
  swal({
    title: "确认设置为总代理吗？",
    text: "确定后将不可更改！",
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
        method: "POST",
        url: "/admin/user/commonality/id/"+id,
        dataType: "JSON",
        success: function (res) {
          console.log(res);
          if (res.code == 400) {
            swal("设置失败", res.msg, "error");
          } else {
            swal("设置成功", res.msg, "success");
            setTimeout("window.location.href = '/admin/user/index/type/1'",2000);
          }
        },
        error: function (e) {
          console.log(e);
        }
      });
    } else {
      swal("取消了", "当前操作没有发生改变 :)", "error");
    }
  });
}

// 完善个人信息
function staffs(id){
  console.log(id);
  // 修改action
  $("#staffsForm").attr("action","/admin/staffs/add/uid/"+id);
  $('#staffsModal').modal({
    backdrop: 'static',
    keyboard: false,
    show: true
  });
}

// 查看下级用户
function grade(type,pid){
  console.log(type,pid);
  // type
  if (type == 1) {
    type = 2;
  } else if (type == 2) {
    type = 3;
  } else if (type == 3) {
    type = 0;
  }
  window.location.href = "/admin/user/index/type/"+type+"/pid/"+pid;
}

// 查看充值记录
function recharge(id){
  console.log(id);
  window.location.href = "/admin/rechargeRecord/index/uid/"+id;
}

// 提现记录
function withdrawal(id){
  console.log(id);
  window.location.href = "/admin/withdrawalRecord/index/uid/"+id;
}

// 地主身份
function landlord(uid){
  console.log(uid);
  window.location.href = "/admin/landlord/index/uid/"+uid;
}