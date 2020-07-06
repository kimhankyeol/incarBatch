<!DOCTYPE html>
<html lang="en">
@include('common.head')
<script>document.title="모니터링 차트"</script>
<!-- Styles -->
<style>
    #chartdiv {
      width: 100%;
      height: 500px;
    }
</style>
<!-- Resources -->
<script src="/amcharts/core.js"></script>
<script src="/amcharts/charts.js"></script>
<script src="/amcharts/animated.js"></script>

<!-- Chart code -->
<script>
const chart = {
    gantt:function(monitorResultObject){
        am4core.ready(function() {
            console.table(JSON.parse(monitorResultObject));
            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end

            var chart = am4core.create("chartdiv", am4charts.XYChart);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in
            
            chart.paddingRight = 30;
            chart.dateFormatter.inputDateFormat = "yyyy-MM-dd HH:mm";

            var colorSet = new am4core.ColorSet();
            colorSet.saturation = 0.4;
            chart.data = JSON.parse(monitorResultObject);

            var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "name";
            categoryAxis.renderer.grid.template.location = 0;
            categoryAxis.renderer.inversed = true;

            var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
            dateAxis.dateFormatter.dateFormat = "yyyy-MM-dd HH:mm";
            dateAxis.renderer.minGridDistance = 70;
            dateAxis.baseInterval = { count: 30, timeUnit: "minute" };
            dateAxis.max = new Date().getTime();
            dateAxis.strictMinMax = true;
            dateAxis.renderer.tooltipLocation = 0;

            var series1 = chart.series.push(new am4charts.ColumnSeries());
            series1.columns.template.width = am4core.percent(80);
            series1.columns.template.height = am4core.percent(50);
            series1.columns.template.tooltipText = "{name}: {openDateX} - {dateX}";

            series1.dataFields.openDateX = "start";
            series1.dataFields.dateX = "end";
            series1.dataFields.categoryY = "name";
            series1.columns.template.propertyFields.fill = "color"; // get color from data
            series1.columns.template.propertyFields.stroke = "red";
            series1.columns.template.strokeOpacity = 1;
            series1.columns.template.strokeWidth = 3;
            series1.columns.template.stroke = "red";
            chart.scrollbarX = new am4core.Scrollbar();

            }); // end am4core.ready()
     }
}

</script>
<script>

function monitoringChartViewData(){
    //모니터링 일자 초기값
    var monitoringChartDate = $('#monitoringChartDate').val();
    var monitorResultObject = [];
    $.ajax({
        url:"/monitoring/monitoringChartViewData",
        method:"get",
        async:false,
        data:{
            'monitoringChartDate':monitoringChartDate
        },
        success:function(resp){
            console.table(resp);
            $('#monitoringChartDate').val(resp.monitoringChartDate);
            if(resp.chartViewData=="notSearchData"){
                $('#chartdiv').html('조회된 데이터가 없습니다.');
                monitorResultObject="";
            }else{
                monitorResultObject = resp.chartViewData;
            }
        },
        error:function(err){

        }
    });
    return monitorResultObject;
}
$(function(){
    var monitorResultObject = monitoringChartViewData();
    if(monitorResultObject!=""){
        chart.gantt(monitorResultObject);
    }
})

</script>
<!-- HTML -->
<body id="page-top" class="bodyBgImg">
    <div id="wrapper">
        @include('common.sidebar')
        <div class="d-flex flex-column" style="width: 100%;">
            <div id="content">
                <div class="container-fluid">
                  <h4 class="h3 my-4 font-weight-bold" style="color:white">모니터링 차트</h4>
                  <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="d-inline-flex col-md-12 text-center" style="">
                            <div class="form-control  col-md-3">모니터링 날짜 </div>
                            <input type="date" class="form-control  col-md-3" id="monitoringChartDate" value="{{$monitoringChartDate}}">
                            <button class="btn btn_orange" onclick="monitor.monitorChartSeatch('{{$monitoringChartDate}}')">검색</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chartdiv"></div>
                    </div>
                  </div>
                </div>
            </div> 
        
        </div>
    </div>
</body>
</html>