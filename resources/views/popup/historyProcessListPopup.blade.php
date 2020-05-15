<!DOCTYPE html>
<html lang="en">
@include('popup.popupCommon.head')
{{-- js 라이브러리  --}}
@include('popup.popupCommon.popupJs')

<body class="bg-gradient-primary">
  <div id="content" class="gusung-popup">
    <div class="container-fluid">
      <h4 class="p-2 flex-grow-1 font-weight-bold text-white">스케줄 프로그램</h4>
      <div class="card shadow mb-4">
        <div class="card-body">
          <div class="row">
            <div class="card shadow mb-2">
              <div class="d-flex justify-content-end card-header py-3">
                <div class="d-inline-flex form-inline w-100 navbar-search">
                  <h5 class="mr-auto mb-0 font-weight-bold text-primary">프로그램</h5>
                  <div class="input-group align-items-center">
                    <div class="input-group-append">
                      <div class="btn btn-primary cursor-pointer" onclick="popup.search('1')">
                        <i class="fas fa-search fa-sm"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body py-3">
                <div id="processdatatable" class="table-responsive">
                  <table id="processList" class="table table-bordered" width="100%" cellspacing="0">
                    <colgroup>
                      <col width="100px">
                      <col width="100px">
                      <col width="100px">
                      <col width="370px">
                      <col width="80px">
                    </colgroup>
                    <thead>
                      <tr>
                        <th>경로</th>
                        <th>프로그램</th>
                        <th>프로그램 명</th>
                        <th>파라미터</th>
                        <th>등록자</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- /프로그램 -->
          </div>
          <div class="row">
            <h5 class="mb-4 font-weight-bold text-primary">구성 리스트</h5>
            <div class="card shadow w-100 mb-2">
              <!-- List -->
              <div class="card-body">
                <div class="row text-center">
                  <div class="right-line col-md-1 p-2 bg-primary text-white font-weight-bold rounded-0">순서
                  </div>
                  <div class="right-line col-md-1 p-2 bg-primary text-white font-weight-bold rounded-0">
                    경로</div>
                  <div class="right-line col-md-1 p-2 bg-primary text-white font-weight-bold rounded-0">
                    프로그램</div>
                  <div class="right-line col-md-1 p-2 bg-primary text-white font-weight-bold rounded-0">
                    프로그램 명</div>
                  <div class="right-line col-md-8 p-2 bg-primary text-white font-weight-bold rounded-0">
                    파라미터</div>
                </div>
                <div id="gusungList" class="row px-0 gusungList">
                </div>
              </div>
            </div>
            <div class="col-md-12 text-center">
              <button type="button" class="btn btn-danger" onclick="window.close()">취소</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>