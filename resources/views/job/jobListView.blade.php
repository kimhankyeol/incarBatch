  <!-- Main Content -->
  <div id="content">
    <!-- End of Topbar -->
    <!-- Begin Page Content -->
    <div class="container-fluid">
      <!-- Page Heading -->
      <!-- DataTales Example -->
      <h4 class="h3 my-4 font-weight-bold text-primary">잡</h4>
      <div class="card shadow mb-4">
        <div class="d-flex justify-content-end card-header py-3">
          <div class="d-none d-sm-inline-block form-inline ml-auto my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group align-items-center">
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
                  {{-- 검색 단어가 있을떄 없을때 구분  --}}
                  @if(!isset($searchWord))
                    <input id="searchWord" type="text" class="form-control bg-light border-primary small" placeholder="조회" aria-label="Search">
                  @elseif(isset($searchWord))
                    <input id="searchWord" type="text" value="{{$searchWord}}" class="form-control bg-light border-primary small" aria-label="Search">
                  @endif
                 
                  <div class="input-group-append">
                    <div class="btn btn-primary" onclick="job.search('1')">
                      <i class="fas fa-search fa-sm"></i>
                    </div>
                  </div>
                  <div class=" text-center align-self-center font-weight-bold text-primary mx-2">
                    <div class="btn btn-info" onclick="pageMove.job.list('jobRegisterView')">등록</div>
                  </div>
            </div>
          </div>
        </div>
        <div class="card-body py-3">
          <div class="table-responsive">
            <table id="datatable" class="table table-bordered" width="100%" cellspacing="0">
              <colgroup>
                  <col width="100px"/>
                  <col width="100px"/>
                  <col width="100px"/>
                  <col width="100px"/>
                  <col width="400px"/>
                  <col width="100px"/>
                  <col width="200px"/>
              </colgroup>
              <thead>
                <tr>
                  <th scope="col">잡ID</th>
                  <th scope="col">잡 명</th>
                  <th scope="col">업무구분(대분류)</th>
                  <th scope="col">업무구분(중분류)</th>
                  <th scope="col">잡 설명</th>
                  <th scope="col">잡 등록자</th>
                  <th scope="col">잡 등록일</th>
                </tr>
              </thead>
              {{--  조회된 값이 보여주는 위치 --}}
              <tbody>
                {{-- isset 변수 존재여부 --}}
                @if(isset($itemsForCurrentPage))
                  @include('job.jobSearchListView')
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

