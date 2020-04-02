<div id="content">
    <div class="container-fluid">
        <div class="card shadow mb-4">
        <div class="d-flex justify-content-end card-header py-3">
            <h6 class="flex-grow-1 font-weight-bold text-primary m-0 align-self-center">모니터링</h6>
        </div>
        <script type="text/javascript">
            var foopicker = new FooPicker({
            id: 'datepicker',
            dateFormat: 'yyyy-mm-dd'
            });
            var foopicker2 = new FooPicker({
            id: 'datepicker2'
            });
        </script>
        <div class="card-body py-3">
            <div class="row">
            <div class='col-md-2'>
                <div class="form-group m-0">
                <div class='input-group'>
                    <label class="d-flex align-items-center m-0">등록일
                    <input type='text' id='datepicker' class="form-control mx-2" />
                    <span class="input-group-addon">
                        <i class="fa fa-calendar" style="cursor:pointer"></i>
                    </span>
                    </label>
                </div>
                </div>
            </div>
            <span class="align-self-center"> ~ </span>
            <div class='col-md-2'>
                <div class="form-group m-0">
                <div class='input-group'>
                    <label class="d-flex align-items-center m-0">
                    <input type='text' id='datepicker2' class="form-control mx-2" />
                    <span class="input-group-addon">
                        <i class="fa fa-calendar" style="cursor:pointer"></i>
                    </span>
                    </label>
                </div>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" style="width: 20rem">
                <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" style="border: 1px solid #4e73df !important;" placeholder="JOB 명" aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                    </button>
                    </div>
                </div>
                </form>
            </div>
            <button type="button" class="btn btn-primary ml-auto" style="margin-left: 15px;">조회</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered text-center" id="datatable" cellspacing="0" style="width:150%; overflow-x: scroll;">
            <thead>
                <tr>
                <th style="background-color:#47579c; color : #fff">작업명</th>
                <th style="background-color:#47579c; color : #fff">프로세스명</th>
                <th style="background-color:#47579c; color : #fff">진행상태</th>
                <th style="background-color:#47579c; color : #fff">작업결과</th>
                <th style="background-color:#47579c; color : #fff">사용자</th>
                <th style="background-color:#47579c; color : #fff">선행작업</th>
                <th style="background-color:#47579c; color : #fff">후행작업</th>
                <th style="background-color:#47579c; color : #fff">작업일</th>
                <th style="background-color:#47579c; color : #fff">시작시간</th>
                <th style="background-color:#47579c; color : #fff">종료시간</th>
                <th style="background-color:#47579c; color : #fff">작업시간</th>
                <th style="background-color:#47579c; color : #fff">재작업</th>
                <th style="background-color:#47579c; color : #fff">종료</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>Tiger Nixon</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td>$320,800</td>
                <td><a href="#" onclick="retry();" class="btn btn-sm btn-success">
                    <span class="text">재작업</span>
                    </a></td>
                <td><a href="#" onclick="exit();" class="btn btn-sm btn-danger" style="width:fit-content">
                    <span class="text">종료</span>
                    </a></td>
                </tr>
                <tr>
                <td>Garrett Winters</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>63</td>
                <td>2011/07/25</td>
                <td>$170,750</td>
                <td>$170,750</td>
                <td>$170,750</td>
                <td>$170,750</td>
                <td>$170,750</td>
                <td>$170,750</td>
                <td><a href="#" onclick="retry();" class="btn btn-sm btn-success">
                    <span class="text">재작업</span>
                    </a></td>
                <td><a href="#" onclick="exit();" class="btn btn-sm btn-danger" style="width:fit-content">
                    <span class="text">종료</span>
                    </a></td>
                </tr>
                <tr>
                <td>Ashton Cox</td>
                <td>Junior Technical Author</td>
                <td>San Francisco</td>
                <td>66</td>
                <td>2009/01/12</td>
                <td>$86,000</td>
                <td>$170,750</td>
                <td>$170,750</td>
                <td>$170,750</td>
                <td>$170,750</td>
                <td>$170,750</td>
                <td><a href="#" onclick="retry();" class="btn btn-sm btn-success">
                    <span class="text">재작업</span>
                    </a></td>
                <td><a href="#" onclick="exit();" class="btn btn-sm btn-danger" style="width:fit-content">
                    <span class="text">종료</span>
                    </a></td>
                </tr>
                <tr>
                <td>Cedric Kelly</td>
                <td>Senior Javascript Developer</td>
                <td>Edinburgh</td>
                <td>22</td>
                <td>2012/03/29</td>
                <td>$433,060</td>
                <td>$170,750</td>
                <td>$170,750</td>
                <td>$170,750</td>
                <td>$170,750</td>
                <td>$170,750</td>
                <td><a href="#" onclick="retry();" class="btn btn-sm btn-success">
                    <span class="text">재작업</span>
                    </a></td>
                <td><a href="#" onclick="exit();" class="btn btn-sm btn-danger" style="width:fit-content">
                    <span class="text">종료</span>
                    </a></td>
                </tr>
                <tr>
                <td>Airi Satou</td>
                <td>Accountant</td>
                <td>Tokyo</td>
                <td>33</td>
                <td>2008/11/28</td>
                <td>$162,700</td>
                <td>$170,750</td>
                <td>$170,750</td>
                <td>$170,750</td>
                <td>$170,750</td>
                <td>$170,750</td>
                <td><a href="#" onclick="retry();" class="btn btn-sm btn-success">
                    <span class="text">재작업</span>
                    </a></td>
                <td><a href="#" onclick="exit();" class="btn btn-sm btn-danger" style="width:fit-content">
                    <span class="text">종료</span>
                    </a></td>
                </tr>
            </tbody>
            </table>
        </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary" style="text-align: center;">배치작업로그</h6>
        </div>
        <div class="card-body" style="height: 500px;">
        배치작업 로그 조회 화면
        </div>
    </div>
</div>

{{-- 함수 정리 할것 js 묶어서 --}}
  <script type="text/javascript">
    var foopicker = new FooPicker({
      id: 'datepicker',
      dateFormat: 'yyyy/MM/dd',
      disable: ['29/07/2017', '30/07/2017', '31/07/2017', '01/08/2017']
    });
    var foopicker2 = new FooPicker({
      id: 'datepicker2'
    });
  </script>
{{-- /popup/batchDetailInfoPopup --}}
  <script type="text/javascript">
    function winPopup() {
      var popUrl = "jobList.html";
      var popOption = "top=10, left=10, width=750, height=600, status=no, menubar=no, toolbar=no, resizable=no, location=no";
      window.open(popUrl, "_blank", popOption);
    }
    function test() {
      var popUrl = "batchExecute.html";
      var popOption = "top=10, left=10, width=750, height=600, status=no, menubar=no, toolbar=no, resizable=no, location=no";
      window.open(popUrl, "_blank", popOption);
    }
    function retry() {
      if (confirm("재작업 하시겠습니까?") == true) {
        var popUrl = "/popup/batchDetailInfoPopup";
        var popOption = "top=10, left=10, width=750, height=600, status=no, menubar=no, toolbar=no, resizable=no, location=no";
        window.open(popUrl, "_blank", popOption);
        //document.form.submit();
      } else {
        return;
      }
    }
    function exit() {
      if (confirm("job 실행을 종료하겠습니까?") == true) {
        document.form.submit();
      } else {
        return;
      }
    }
  </script>
</body>

</html>