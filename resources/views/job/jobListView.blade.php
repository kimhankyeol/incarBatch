  <!-- Main Content -->
  <div id="content">
    <!-- End of Topbar -->
    <!-- Begin Page Content -->
    <div class="container-fluid" style="height: 100%">
      <!-- Page Heading -->
      <!-- DataTales Example -->
      <div class="card shadow mb-4" style="height: 100%">
        <div class="d-flex justify-content-end card-header py-3">
          <h5 class="p-2 font-weight-bold text-primary">잡</h5>
          <div class="d-none d-sm-inline-block form-inline ml-auto my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group align-items-center" style="display:inline-flex">
              <div class="text-center align-self-center font-weight-bold text-primary mx-2">업무구분</div>
              <div class=" text-center align-self-center font-weight-bold text-primary mx-2">대분류</div>
                  <select class="form-control form-control-sm">
                    <option>
                      인카금융서비스
                    </option>
                  </select>
                  <div class="text-center align-self-center font-weight-bold text-primary mx-2">중분류</div>
                  <select class="form-control form-control-sm ml-2 mr-5">
                    <option>
                    정보기술연구소
                    </option>
                    <option>
                      교육
                    </option>
                    <option>
                      제도관리
                    </option>
                  </select>
                  <select class="form-control bg-light small" style="border: 1px solid #4e73df !important;">
                    <option>
                      잡명
                    </option>
                    <option>
                      등록자
                    </option>
                  </select>
                  <input id="searchWord" type="text" class="form-control bg-light border-0 small" placeholder="조회" aria-label="Search" style="border: 1px solid #4e73df !important;">
                  <div class="input-group-append">
                    <div class="btn btn-primary" onclick="job.search()">
                      <i class="fas fa-search fa-sm"></i>
                    </div>
                  </div>
                  <div class=" text-center align-self-center font-weight-bold text-primary mx-2">
                    <div class="btn btn-primary" onclick="pageMove.job.list('jobRegisterView')" style="cursor:pointer">등록</div>
                  </div>
            </div>
          </div>
        </div>
        <div class="card-body py-3">
          <div class="table-responsive">
            <table id="datatable" class="table table-bordered" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th style="background-color:#47579c; color : #fff">잡ID</th>
                  <th style="background-color:#47579c; color : #fff">잡 설명</th>
                  <th style="background-color:#47579c; color : #fff">업무구분(대분류)</th>
                  <th style="background-color:#47579c; color : #fff">업무구분(중분류)</th>
                  <th style="background-color:#47579c; color : #fff">잡 설명</th>
                  <th style="background-color:#47579c; color : #fff">잡 등록자</th>
                  <th style="background-color:#47579c; color : #fff">잡 등록일</th>
                </tr>
              </thead>
              {{-- AJAX 로 조회된 값이 렌더링 되는 위치 --}}
              <tbody id="searchContentView">
             
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

