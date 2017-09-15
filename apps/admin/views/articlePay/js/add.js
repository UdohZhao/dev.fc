$(function(){

  // 实例化编辑器
  var ue = UE.getEditor('container');


  // 验证登录表单
  $("#articlesForm").validate({
      focusInvalid: true,
      rules: {
        title: {
          required: true
        },
        tips: {
          required: true
        },
        gold: {
          required: true,
          digits: true
        },
      },
      messages: {
        title: {
          required: "<span style='color:red;'>标题不能为空 :(</span>"
        },
        tips: {
          required: "<span style='color:red;'>说明不能为空 :(</span>"
        },
        gold:{
          required: "<span style='color:red;'>金币不能为空 :(</span>",
          digits: "<span style='color:red;'>必须为整数 :(</span>"
        }
      },
     submitHandler: function(form){
     
           //获取封面图片路径，户型解析
        var cover_path = $("input[name='cover_path']").val();
        var ipPath = $("input[name='ipPath']").val();
        var analysis = ue.getContent();
        if (cover_path == '' && ipPath == undefined) {
          swal("提交失败", "请上传封面图片 :(", "error");
        } else if (analysis == false) {
          swal("提交失败", "内容不能为空 :(", "error");
        } else {
                $(form).ajaxSubmit({
                    dataType:"json",
                    success:function(res){
                        // res
                        if (res === true) {
                            swal("提交成功", "可在此页面继续操作 :)", "success");
                            window.setTimeout("window.location.reload();",2000);
                        } else if (res === false) {
                            swal("提交失败", "请尝试刷新页面后重试 :(", "error");
                        } else {
                            swal("提交失败", res, "error");
                        }
                    },
                    error:function(e){
                        console.log(e);
                        swal("未知错误", "请尝试刷新页面后重试 :(", "error");
                    }
                });
            }
        }
  });

})


// 跳转到行业动态条目
  function index(){
    window.location.href = "/admin/articlePay/index/atype/0";
  }

// 跳转到赌石技巧条目
  function indextow(){
    window.location.href = "/admin/articlePay/index/atype/1";
  }


  //图片上传预览    IE是用了滤镜。
  function previewImage(file)
  {
    var MAXWIDTH  = 90;
    var MAXHEIGHT = 90;
    var div = document.getElementById('preview');
    if (file.files && file.files[0])
    {
        div.innerHTML ='<img id=imghead onclick=$("#previewImg").click()>';
        var img = document.getElementById('imghead');
        img.onload = function(){
          var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
          img.width  =  rect.width;
          img.height =  rect.height;
          // img.style.marginLeft = rect.left+'px';
          img.style.marginTop = rect.top+'px';
        }
        var reader = new FileReader();
        reader.onload = function(evt){img.src = evt.target.result;}
        reader.readAsDataURL(file.files[0]);
    }
    else //兼容IE
    {
      var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
      file.select();
      var src = document.selection.createRange().text;
      div.innerHTML = '<img id=imghead>';
      var img = document.getElementById('imghead');
      img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
      var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
      status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
      div.innerHTML = "<div id=divhead style='width:"+rect.width+"px;height:"+rect.height+"px;margin-top:"+rect.top+"px;"+sFilter+src+"\"'></div>";
    }
  }
  function clacImgZoomParam( maxWidth, maxHeight, width, height ){
      var param = {top:0, left:0, width:width, height:height};
      if( width>maxWidth || height>maxHeight ){
          rateWidth = width / maxWidth;
          rateHeight = height / maxHeight;

          if( rateWidth > rateHeight ){
              param.width =  maxWidth;
              param.height = Math.round(height / rateWidth);
          }else{
              param.width = Math.round(width / rateHeight);
              param.height = maxHeight;
          }
      }
      param.left = Math.round((maxWidth - param.width) / 2);
      param.top = Math.round((maxHeight - param.height) / 2);
      return param;
  }