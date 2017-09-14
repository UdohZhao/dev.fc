

// 申请成为职员
function ePass(id){

  $("#ePassForm").attr("action","/admin/user/add/id/"+id);
  // modal
  $('#ePassModal').modal({
    backdrop: 'static',
    keyboard: false
  });
}
