const popup={
    popupPsSearch:function(page){
        var searchWord = $('#searchWord').val();
        var workLargeCtg = $('#workLargeVal option:selected').val();
        var workMediumCtg = $('#workMediumVal option:selected').val();
      // 대분류 , 중분류 전체 선택일때 아닐떄 경우의 수
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:"/popup/popupPsSearch",
        method:"get",
        data:{
            "searchWord":$('#searchWord').val(),
            "workLargeCtg":$('#workLargeVal option:selected').val(),
            "workMediumCtg":$('#workMediumVal option:selected').val(),
            "page":page
        },
        success:function(resp){
            // console.table(resp.returnHTML);
        $('#processList').html(resp.returnHTML);
        },
        error:function(err){

        }
      })
    }

}