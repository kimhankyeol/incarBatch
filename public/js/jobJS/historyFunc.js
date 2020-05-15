const history = {
  //조회
  search: function (page) {
    var WorkLarge = $('#workLargeVal option:selected').val();
    var WorkMedium = $('#workMediumVal option:selected').val();
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();
    var searchType = $('#searchType').val();
    var searchValue = $('#searchValue').val();
    var status = $('.status');
    var statusValue = 0;

    console.table(status)

    for (var i = 0; i < status.length; i++) {
      if (status[i].checked) {
        statusValue++;
      }
    }
    if (statusValue == 0) {
      alert("결과를 선택 해주세요.");
      return false;
    } else if (statusValue == 2) {
      tatusValue = "all";
    }
    if (searchWord == '' || searchWord == undefined) {
      searchWord = "searchWordNot";
    }
    $.ajax({
      url: "/history/historyListView",
      method: "get",
      data: {
        'jobStatus': jobStatusStr.substr(0, jobStatusStr.length - 1),
        'searchWord': searchWord,
        'WorkLarge': WorkLarge,
        'WorkMedium': WorkMedium,
        'startDate': startDate,
        'endDate': endDate,
        'page': page
      },
      success: function (resp) {
        console.table(resp)
        //$('#datatable').html(resp.returnHTML)
      }
    })
  },
  detail: function (Job_Seq, Sc_Seq) {
    // 잡 스케줄의 상세 정보
    window.open('/popup/scheduleDetailPopup?Job_Seq=' + Job_Seq + '&Sc_Seq=' + Sc_Seq, '구성 디테일', 'top=10, left=10, width=1400, height=720, status=no, location=no, directories=no, status=no, menubar=no, toolbar=no, scrollbars=yes, resizable=no');
  },
  detailLog: function () {
    event.preventDefault();
    // 잡 스케줄의 상세 정보
    window.open('/popup/historyProcessListPopup', '구성 디테일', 'top = 10, left = 10, width = 1400, height = 720, status = no, location = no, directories = no, status = no, menubar = no, toolbar = no, scrollbars = yes, resizable = no');
  }
}
