$(function(){

  // 验证配置美妹表单
  $("#belleExtendForm").validate({
      focusInvalid: true,
      rules: {
        qq: {
          required: true,
          digits: true
        },
        wecaht: {
          required: true
        },
        phone: {
          required: true,
          digits: true
        },
        qq_money: {
          required: true,
          number: true
        },
        wechat_money: {
          required: true,
          number: true
        },
        phone_money: {
          required: true,
          number: true
        }
      },
      messages: {
        qq: {
          required: "<span style='color:red;'>QQ号不能为空 :(</span>",
          digits: "<span style='color:red;'>必须输入整数 :(</span>"
        },
        wecaht: {
          required: "<span style='color:red;'>微信号不能为空 :(</span>"
        },
        phone: {
          required: "<span style='color:red;'>手机号不能为空 :(</span>",
          digits: "<span style='color:red;'>必须输入整数 :(</span>"
        },
        qq_money: {
          required: "<span style='color:red;'>查看QQ号费用不能为空 :(</span>",
          number: "<span style='color:red;'>必须输入合法的数字（整数，小数） :(</span>"
        },
        wechat_money: {
          required: "<span style='color:red;'>查看微信号费用不能为空 :(</span>",
          number: "<span style='color:red;'>必须输入合法的数字（整数，小数） :(</span>"
        },
        phone_money: {
          required: "<span style='color:red;'>查看手机号费用不能为空 :(</span>",
          number: "<span style='color:red;'>必须输入合法的数字（整数，小数） :(</span>"
        }
      },
      submitHandler: function(form){
        $(form).ajaxSubmit({
            dataType:"json",
              success:function(res){
                console.log(res);
                // 隐藏Modal
                $('#belleExtendModal').modal('hide');
                // res
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

});
// 修改
function edit(id){
    window.location.href = "/admin/buyHouseCatagory/modify/id/"+id;
}
// 删除
function del(id){
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
        url: "/admin/buyHouseCatagory/dle/id/"+id,
        dataType: "JSON",

        success: function(res){
          // res
          if (res === true) {
            swal("提交成功", "当前操作已发生改变 :)", "success");
            setTimeout("window.location.reload();",2000);
          } else if (res === false) {
            swal("提交失败", "请尝试刷新后重试 :(", "error");
          } else {
            swal("提交失败", "请先删除其下级 :(", "error");
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
// flag
function flag(id,status){
    var title;
    var text;
    // status
    if (status == 1) {
        title = "确认展示该片文章吗？";
        text = "确定后将对外展示 :)";
    } else {
        title = "确认隐藏该篇文章吗？";
        text = "确定后将对外隐藏 :(";
    }
    swal({
            title: title,
            text: text,
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
                    url: "/admin/buyHouseCatagory/flas/id/"+id,
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

// 配置
function config(id){
    console.log(id);
    // Ajax 是否配置
    $.ajax({
        method: "GET",
        url: "/admin/belleExtend/getInfo/raid/"+id,
        dataType: "JSON",
        success: function (res) {
            console.log(res);
            if (res.code == 200) {
                // 配置动态赋值
                $("input[name='qq']").attr("value",res.data.qq);
                $("input[name='wecaht']").attr("value",res.data.wecaht);
                $("input[name='phone']").attr("value",res.data.phone);
                $("input[name='qq_money']").attr("value",res.data.qq_money);
                $("input[name='wechat_money']").attr("value",res.data.wechat_money);
                $("input[name='phone_money']").attr("value",res.data.phone_money);
                // 动态修改form表单action
                $("#belleExtendForm").attr("action","/admin/belleExtend/add/raid/"+id+"/id/"+res.data.id);
            } else {
                // 动态修改form表单action
                $("#belleExtendForm").attr("action","/admin/belleExtend/add/raid/"+id);
            }
        },
        error: function (e) {
            console.log(e);
        }
    });
    $('#belleExtendModal').modal({
        backdrop: 'static',
        keyboard: false,
        show: true
    });
}

// 美妹付费记录
function payRecord(id){
  window.location.href = "/admin/rechargeRecord/payRecord/raid/"+id;
}
