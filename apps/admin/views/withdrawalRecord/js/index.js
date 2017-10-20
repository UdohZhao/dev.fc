$(function(){

});

// 成功 & 失败
function commonality(uid,id,status){
    var title;
    // status
    if (status == 2) {
        title = "确认转账成功吗？";
    } else {
        title = "确认转账失败吗？";
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
                    url: "/admin/withdrawalRecord/commonality/uid/"+uid+"/id/" +id+"/status/"+status,
                    dataType: "JSON",
                    success: function(res){
                        console.log(res);
                        if (res.code == 400) {
                            swal("提交失败", res.msg, "error");
                        } else {
                            swal("提交成功", res.msg, "success");
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