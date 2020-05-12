const monitor = {
  //조회
  search: function (page) {
    var jobStatus = $('.jobStatus');
    var searchWord = $('#searchWord').val();
    var WorkLarge = $('#workLargeVal option:selected').val();
    var WorkMedium = $('#workMediumVal option:selected').val();
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();
    var jobStatusStr = '';
    for (var i = 0; i < jobStatus.length; i++) {
      if (jobStatus[i].checked) {
        jobStatusStr += jobStatus[i].value + ',';
      } else {
        jobStatusStr += '0,';
      }
    }
    if (searchWord == '' || searchWord == undefined) {
      searchWord = "searchWordNot";
    }
    $.ajax({
      url: "/monitoring/monitorJobSearchList",
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
        $('#monitorDatatable').html(resp.returnHTML)
      }
    })
  },
  detailList: function (Job_Seq, page) {
    $.ajax({
      url: "/monitoring/monitorJobDetailList",
      method: "get",
      data: {
        "Job_Seq": Job_Seq,
        "page": page
      },
      success: function (resp) {
        $('#jobDetailList').html(resp.returnHTML)
      }
    })
  },
  jobPopup: function (Job_Seq) {
    window.open('/popup/jobDetailPopup?Job_Seq=' + Job_Seq, '잡 정보 상세', 'top=10, left=10, width=1400, height=675, status=no, location=no, directories=no, status=no, menubar=no, toolbar=no, scrollbars=yes, resizable=no');
  }
};
