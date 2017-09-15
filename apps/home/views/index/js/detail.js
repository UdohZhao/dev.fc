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
