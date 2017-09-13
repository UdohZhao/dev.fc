$(function(){

})

// 编辑
function edit(id){
  window.location.href = "/admin/wechatMenu/add/id/"+id;
}

// 删除
function del(id){
  console.log(id);
  swal({
    title: "确认删除吗？",
    text: "删除后将不可恢复 :(",
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
        type: "GET",
        url: "/admin/wechatMenu/del/id/"+id,
        dataType: "JSON",
        success: function(res){
          console.log(res);
          // res
          if (res.code == 400) {
            swal("提交失败", "请刷新页面后重试 :(", "error");
          } else {
            swal("提交成功", "当前操作已发生改变 :)", "success");
            setTimeout("window.location.reload();",2000);
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

// 推送到微信
function pushWechat(){
  swal({
    title: "确认推送到微信公众号吗？",
    text: "确认后将覆盖之前菜单 :(",
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
        type: "GET",
        url: "/admin/wechatMenu/pushWechat",
        dataType: "JSON",
        success: function(res){
          console.log(res);
          // res
          if (res.code == 400) {
            swal("提交失败", res.msg, "error");
          } else if (res.code == 401) {
            swal("提交失败", res.msg, "error");
          } else {
            swal("提交成功", res.msg, "success");
            setTimeout("window.location.reload();",3000);
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

