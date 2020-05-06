const monitor = {
  //조회
  search: function (page) {
    var searchWord = $('#searchWord').val();
    var WorkLarge = $('#workLargeVal option:selected').val();
    var WorkMedium = $('#workMediumVal option:selected').val();
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();
    $.ajax({
      url: "/monitoring/monitoringSearchList",
      method: "get",
      data: {
        'searchWord': searchWord,
        'WorkLarge': WorkLarge,
        'WorkMedium': WorkMedium,
        'startDate': startDate,
        'endDate': endDate,
        'page': page
      },
      success: function (resp) {
        $('#monitorDatatable').html(resp.returnHTML)
      }
    })
  },
  gusungList: function (Job_Seq, Version) {
    console.log(Job_Seq)
    console.log(Version)
    $.ajax({
      url: "/monitoring/monitoringGusungList",
      method: "get",
      data: {
        "Job_Seq": Job_Seq,
        "Version": Version
      },
      success: function (resp) {
        console.table(resp);
        $('#gusungDatatable').html(resp.returnHTML)
      }
    })
  },
  detailPopup: function (Job_Seq, Skd_Seq) {
    window.open('/popup/gusungDetail', '구성 디테일', 'top=10, left=10, width=1400, height=720, status=no, location=no, directories=no, status=no, menubar=no, toolbar=no, scrollbars=yes, resizable=no');
  }
};