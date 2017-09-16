$(function(){

});

// 文章点赞
function likes(apid,likes){
    console.log(apid,likes);
    // Ajax 
    $.ajax({
        method: "POST",
        url: "/index/likes/id/"+apid,
        data: {
            likes: likes
        },
        dataType: "JSON",
        success: function (res) {
            console.log(res);
            $("#likes-num").text(res);
        },
        error: function (e) {
            console.log(e);
        }
    });
}

// 评论点赞
function acLikes(acid,likes){
    console.log(acid,likes);
    // Ajax 
    $.ajax({
        method: "POST",
        url: "/index/acLikes/id/"+acid,
        data: {
            likes: likes
        },
        dataType: "JSON",
        success: function (res) {
            console.log(res);
            window.location.reload();
        },
        error: function (e) {
            console.log(e);
        }
    });
}

// 阅读付费
function btnRead(apid,gold,residue){
    console.log(apid,gold,residue);
    if (gold > residue) {
        $.confirm("您当前剩余$"+residue+"金币，是否前往充值中心？", "提示",function() {
          window.location.href = "/account/index";
          }, function() {
          //点击取消后的回调函数
          console.log('点击了取消');
        });
    } else {
        // Ajax 
        $.ajax({
            method: "POST",
            url: "/articlePayRelation/add/apid/"+apid,
            data: {
                gold: gold,
                residue: residue
            },
            dataType: "JSON",
            success: function (res) {
                console.log(res);
                if (res.code == 400) {
                    $.alert(res.msg, "提示");
                } else {
                    $.alert(res.msg, "提示",function() {
                        window.location.href = "/index/detail/id/"+res.data.apid;
                    });
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
    }
}

// 邀请码阅读
function btncodeRead(apid,code_status){
    console.log(apid,code_status);

    $.confirm("确认使用邀请码兑换阅读吗？", "提示",function() {
        // Ajax 
        $.ajax({
            method: "POST",
            url: "/articlePayRelation/add/apid/"+apid,
            data: {
                code_status: code_status
            },
            dataType: "JSON",
            success: function (res) {
                console.log(res);
                if (res.code == 400) {
                    $.alert(res.msg, "提示");
                } else {
                    $.alert(res.msg, "提示",function() {
                        window.location.href = "/index/detail/id/"+res.data.apid;
                    });
                }
            },
            error: function (e) {
                console.log(e);
            }
        });
      }, function() {
      //点击取消后的回调函数
      console.log('点击了取消');
    });

}
