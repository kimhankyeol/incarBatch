<div class="mx-2">
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow my-3">
      <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100" style="width: 100%;">
        <div class="input-group">
          <input type="text" class="form-control bg-light border-0 small" placeholder="프로세스 검색..."
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
                <table id="datatable" class="table table-bordered datatable"  width="100%" cellspacing="0" role="grid"
                  aria-describedby="dataTable_info" style="width: 100%;">
                  <thead>
                    <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending" style="width: 20%">프로세스명</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 11%;">설명</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 17%;">파라미터</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 20%">등록일</th>
                      <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 20%">재작업</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr role="row" class="odd">
                      <td class="sorting_1" onclick="javascript:processDetailInfo()">프로세스 1</td>
                      <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Accountant</td>
                      <td>3개</td>
                      <td>2020-03-24</td>
                      <td> 재작업 </td>
                    </tr>
                    <tr role="row" class="even">
                      <td class="sorting_1">프로세스 2</td>
                      <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Junior Technical Author</td>
                      <td>2개</td>
                      <td>2020-03-23</td>
                      <td> 재작업 불가 </td>
                    </tr>
                    <tr role="row" class="odd">
                      <td class="sorting_1">프로세스 3</td>
                      <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Senior Javascript Developer</td>
                      <td>2개</td>
                      <td>2020-03-22</td>
                      <td> 재작업 </td>
                    </tr>
                    <tr role="row" class="even">
                      <td class="sorting_1">프로세스 4</td>
                      <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">Accountant</td>
                      <td>3개</td>
                      <td>2020-03-21</td>
                      <td> 재작업 불가</td>
                    </tr>
                    <tr role="row" class="odd">
                      <td class="sorting_1">프로세스 5</td>
                      <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">System Architect</td>
                      <td>7개</td>
                      <td>2020-03-02</td>
                      <td> 재작업 </td>
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
  <script type="text/javascript">
    function processDetailInfo() {
        var popUrl = "/processDetailInfoPopup";
        var popOption = "top=10, left=10, width=1200, height=200, status=no, menubar=no, toolbar=no, resizable=no, location=no";
        window.open(popUrl, "_blank", popOption);
    }
  </script>

