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
  // 스케줄링 프로세스 정보
  scheduleProcessList(Job_Seq, Sc_Seq) {
    $.ajax({
      url: "/monitoring/scheduleProcessList",
      method: "get",
      data: {
        "Job_Seq": Job_Seq,
        "Sc_Seq": Sc_Seq
      },
      success: function (resp) {
        $('#scheduleProcessList').html(resp.returnHTML);

      }
    })
  },
  // 잡 상세
  jobPopup: function (Job_Seq) {
    window.open('/popup/jobDetailPopup?Job_Seq=' + Job_Seq, '잡 정보 상세', 'top=10, left=10, width=1400, height=875, status=no, location=no, directories=no, status=no, menubar=no, toolbar=no, scrollbars=yes, resizable=no');
  },
  // 잡 스케줄의 상세 정보
  scheduleDetailPopup(Job_Seq, Sc_Seq) {
    window.open('/popup/scheduleDetailPopup?Job_Seq=' + Job_Seq + '&Sc_Seq=' + Sc_Seq, '구성 디테일', 'top=10, left=10, width=1400, height=720, status=no, location=no, directories=no, status=no, menubar=no, toolbar=no, scrollbars=yes, resizable=no');
  },
  // 프로그램 상세
  processDetail: function (P_Seq) {
    window.open('/popup/processDetailPopup?P_Seq=' + P_Seq, '프로그램 정보 상세', 'top=10, left=10, width=1400, height=875, status=no, location=no, directories=no, status=no, menubar=no, toolbar=no, scrollbars=yes, resizable=no');
  }
}
