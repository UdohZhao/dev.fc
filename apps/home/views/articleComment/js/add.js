$(function(){

    // 监听textarea 
    $("#comments").keyup(function(){
    var len = $(this).val().length;
    if(len > 199){
    $(this).val($(this).val().substring(0,200));
    }
    var num = 200 - len;
    $("#num").text(num);
    });

});

// 提交留言
function btnSubmit(apid){
    console.log(apid);
    // 获取留言
    var comments = $("#comments").val();
    if (comments == '' || comments == false) {
        $.alert("留言不能为空 :(", "提示");
    } else {
        // Ajax 
        $.ajax({
            method: "POST",
            url: "/articleComment/add/apid/"+apid,
            data: {
                content: comments
            },
            dataType: "JSON",
            success: function (res) {
                console.log(res);
                if (res.code == 400) {
                    $.alert(res.msg, "提示");
                } else if (res.code == 401) {
                    $.alert(res.msg, "提示");
                } else {
                    $.alert(res.msg, "提示");
                    setTimeout("window.location.href = document.referrer;",2000);
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
}

