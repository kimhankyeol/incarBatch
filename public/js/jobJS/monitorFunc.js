const monitor = {
  //조회
  search: function (page) {
    var searchWord = $('#searchWord').val();
    var WorkLarge = $('#workLargeVal option:selected').val();
    var WorkMedium = $('#workMediumVal option:selected').val();
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();

    console.log(searchWord)
    console.log(WorkLarge)
    console.log(WorkMedium)
    console.log(startDate)
    console.log(endDate)

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
  }
};