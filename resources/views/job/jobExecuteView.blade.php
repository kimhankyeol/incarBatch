<!-- Main Content -->
<div id="content">
    <div class="container-fluid">
      <div class="card shadow mb-4">
        <div class="d-flex justify-content-end card-header py-3">
          <h5 class="p-2 flex-grow-1 font-weight-bold text-primary">Job 실행</h5>
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="조회" aria-label="Search"
                style="border: 1px solid #4e73df !important;">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
        <div class="card-body py-3">
          <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
              <thead>

                <thead>
                    <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending" style="background-color:#47579c; color : #fff">작업명</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="background-color:#47579c; color : #fff">설명</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="background-color:#47579c; color : #fff">파라미터</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="background-color:#47579c; color : #fff">프로세스</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="background-color:#47579c; color : #fff">등록일</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="background-color:#47579c; color : #fff">상태</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="background-color:#47579c; color : #fff">예상 작업시간</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="background-color:#47579c; color : #fff">최대 작업시간</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="background-color:#47579c; color : #fff">재작업</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr role="row" class="odd">
                      <td class="sorting_1" onclick="javascript:batchDetailInfoPopup()">작업 1</td>
                      <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Accountant</td>
                      <td>3개</td>
                      <td>3개</td>
                      <td>2020-03-24</td>
                      <td> - </td>
                      <td> 2시간 </td>
                      <td> 3시간 </td>
                      <td> <a href="#" onclick="retry();" class="btn btn-success ">
                        <i class="fas fa-check"></i>
                      </a> </td>
                    </tr>
                    <tr role="row" class="even">
                      <td class="sorting_1">작업 2</td>
                      <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Junior Technical Author</td>
                      <td>2개</td>
                      <td>2개</td>
                      <td>2020-03-23</td>
                      <td>종료</td>
                      <td> 2시간 </td>
                      <td> 4시간 </td>
                      <td> <a href="#" onclick="retry();" class="btn btn-success ">
                        <i class="fas fa-check"></i>
                      </a> </td>
                    </tr>
                    <tr role="row" class="odd">
                      <td class="sorting_1">작업 3</td>
                      <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Senior Javascript Developer</td>
                      <td>2개</td>
                      <td>2개</td>
                      <td>2020-03-22</td>
                      <td>오류</td>
                      <td> - </td>
                      <td> - </td>
                      <td> <a href="#" onclick="retry();" class="btn btn-success ">
                        <i class="fas fa-check"></i>
                      </a> </td>
                    </tr>
                    <tr role="row" class="even">
                      <td class="sorting_1">작업 4</td>
                      <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Accountant</td>
                      <td>3개</td>
                      <td>3개</td>
                      <td>2020-03-21</td>
                      <td>종료</td>
                      <td> - </td>
                      <td> - </td>
                      <td> <a href="#" onclick="retry();" class="btn btn-success ">
                        <i class="fas fa-check"></i>
                      </a> </td>
                    </tr>
                    <tr role="row" class="odd">
                      <td class="sorting_1">작업 5</td>
                      <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">System Architect</td>
                      <td>7개</td>
                      <td>7개</td>
                      <td>2020-03-02</td>
                      <td> - </td>
                      <td> - </td>
                      <td> - </td>
                      <td> <a href="#" onclick="retry();" class="btn btn-success ">
                        <i class="fas fa-check"></i>
                      </a> </td>
                    </tr>
                  </tbody>
            </table>
          </div>
        </div>
        <div class="card-body">
            <div class="card shadow mb-4">
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="h5 mb-0 m-3 font-weight-bold text-gray-800">작업진행율</div>
                </div>
                <div class="col">
                  <div class="progress progress-sm mr-2">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary" style="text-align: center;">Job 실행 로그</h6>
              </div>
              <div class="card-body" style="height: 500px;">
                Job 실행 로그 화면
              </div>
            </div>
          </div>
        </div>
    </div>
</div>

  <script type="text/javascript">
    function batchDetailInfoPopup() {
        var popUrl = "/popup/batchDetailInfoPopup";
        var popOption = "top=10, left=10, width=1200, height=600, status=no, menubar=no, toolbar=no, resizable=no, location=no";
        window.open(popUrl, "_blank", popOption);
    }

    function retry() {
      if (confirm("재작업 하시겠습니까?") == true) {
        document.form.submit();
      } else {
        return;
      }
    }
    function alert() {
      var result = confirm("등록하시겠습니까?");
      if (result) {
        console.log("등록 되었습니다.");
      } else {
        return false;
        console.log("삭제 되었습니다.");
      }
    }

  </script>
