<div class="mx-2">
  <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow my-3">
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100" style="width: 100%;">
      <div class="input-group">
        <input type="text" class="form-control bg-light border-0 small" placeholder="작업 검색..."
          aria-label="Search" aria-describedby="basic-addon2" style="border: 1px solid #96a0c8 !important">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search fa-sm"></i>
          </button>
        </div>
      </div>
    </form>
  </nav>
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
          <div class="row">
            <div class="col-sm-12 text-center">
              <table class="table table-bordered dataTable" id="datatable" width="100%" cellspacing="0" role="grid"
                aria-describedby="dataTable_info" style="width: 100%;">
                <thead>
                  <tr role="row">
                    <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending" style="width: 20%">작업명</th>
                    <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 11%;">설명</th>
                    <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 17%;">파라미터</th>
                    <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 17%;">프로세스</th>
                    <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 20%">등록일</th>
                    <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 15%">상태</th>
                  </tr>
                </thead>
                <tbody>
                  <tr role="row" class="odd">
                    <td class="sorting_1" onclick="javascript:detailInfo()">작업 1</td>
                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Accountant</td>
                    <td>3개</td>
                    <td>3개</td>
                    <td>2020-03-24</td>
                    <td> - </td>
                  </tr>
                  <tr role="row" class="even">
                    <td class="sorting_1">작업 2</td>
                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Junior Technical Author</td>
                    <td>2개</td>
                    <td>2개</td>
                    <td>2020-03-23</td>
                    <td>종료</td>
                  </tr>
                  <tr role="row" class="odd">
                    <td class="sorting_1">작업 3</td>
                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Senior Javascript Developer</td>
                    <td>2개</td>
                    <td>2개</td>
                    <td>2020-03-22</td>
                    <td>실행중</td>
                  </tr>
                  <tr role="row" class="even">
                    <td class="sorting_1">작업 4</td>
                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Accountant</td>
                    <td>3개</td>
                    <td>3개</td>
                    <td>2020-03-21</td>
                    <td>종료</td>
                  </tr>
                  <tr role="row" class="odd">
                    <td class="sorting_1">작업 5</td>
                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">System Architect</td>
                    <td>7개</td>
                    <td>7개</td>
                    <td>2020-03-02</td>
                    <td> - </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- searchBatchPopup --}}
<script type="text/javascript">
  function detailInfo() {
      var popUrl = "/batchDetailInfoPopup";
      var popOption = "top=10, left=10, width=1200, height=600, status=no, menubar=no, toolbar=no, resizable=no, location=no";
      window.open(popUrl, "_blank", popOption);
  }
</script>