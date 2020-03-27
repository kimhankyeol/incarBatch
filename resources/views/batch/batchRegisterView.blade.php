  <!-- Main Content -->
  <div id="content">
    <!-- End of Topbar -->
    <!-- Begin Page Content -->
    <div class="container-fluid">
      <!-- Page Heading -->
      <!-- DataTales Example -->
      <div class="card shadow mb-4">
        <div class="d-flex justify-content-end card-header py-3">
          <h5 class="p-2 font-weight-bold text-primary">잡</h5>
          <form class="d-none d-sm-inline-block form-inline ml-auto my-2 my-md-0 mw-100 navbar-search">
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
                  <select class="form-control bg-light small" style="border: 1px solid #4e73df !important;">
                    <option>
                      잡명
                    </option>
                    <option>
                      등록자
                    </option>
                  </select>
                  <input type="text" class="form-control bg-light border-0 small" placeholder="조회" aria-label="Search" style="border: 1px solid #4e73df !important;">
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
            <table id="datatable" class="table table-bordered" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th style="background-color:#47579c; color : #fff">작업명</th>
                  <th style="background-color:#47579c; color : #fff">설명</th>
                  <th style="background-color:#47579c; color : #fff">등록일</th>
                  <th style="background-color:#47579c; color : #fff">등록자</th>
                </tr>
              </thead>
              <tbody>
              @foreach($jobDB as $job)
                <tr>
                  <td>{{$job->job_name}}</td>
                  <td>{{$job->job_exp}}</td>
                  <td>{{$job->job_regDate}}</td>
                  <td>{{$job->job_register}}</td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary" style="text-align: center;">잡 정보 등록</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">잡명</div>
            <input type="text" class="col-md-3 form-control form-control-sm align-self-center" placeholder="잡명">
            <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">설명</div>
            <textarea type="text" class="col-md-7 form-control form-control-sm" placeholder="설명" style="resize: none;"></textarea>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">잡 등록자</div>
            <input type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="김한결">
            <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">업무구분</div>
            <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">대분류</div>
            <select class="col-md-2 form-control form-control-sm">
              <option>
                인카금융서비스
              </option>
            </select>
            <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">중분류</div>
            <select class="col-md-2 form-control form-control-sm">
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
          </div>
          <hr>
          <div class="row">
            <div class="col-md-3 text-center align-self-center font-weight-bold text-primary">잡 예상 시간</div>
            <input type="text" class="col-md-3 form-control form-control-sm align-self-center" placeholder="분단위로 입력해주세요">
            <div class="col-md-3 text-center align-self-center font-weight-bold text-primary">잡 최대 예상 시간</div>
            <input type="text" class="col-md-3 form-control form-control-sm align-self-center" placeholder="분단위로 입력해주세요">              
          </div>
          <hr>
          <div class="row">
            <div class="col-md-12 font-weight-bold text-primary">
              잡 파라미터 입력
            </div>
            <hr>
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-2 small align-self-center text-center">파라미터 1</div>
                <input type="text" class="col-md-4  form-control form-control-sm" placeholder="파라미터 명">
                <input type="text" class="col-md-6  form-control form-control-sm" placeholder="설명">
              </div>
              <div class="row">
                <div class="col-md-2 small align-self-center text-center">파라미터 2</div>
                <input type="text" class="col-md-4  form-control form-control-sm" placeholder="파라미터 명">
                <input type="text" class="col-md-6  form-control form-control-sm" placeholder="설명">
              </div>
              <div class="row">
                <div class="col-md-2 small align-self-center text-center">파라미터 3</div>
                <input type="text" class="col-md-4  form-control form-control-sm" placeholder="파라미터 명">
                <input type="text" class="col-md-6  form-control form-control-sm" placeholder="설명">
              </div>
              <div class="row">
                <div class="col-md-2 small align-self-center text-center">파라미터 4</div>
                <input type="text" class="col-md-4  form-control form-control-sm" placeholder="파라미터 명">
                <input type="text" class="col-md-6  form-control form-control-sm" placeholder="설명">
              </div>
              <div class="row">
                <div class="col-md-2 small align-self-center text-center">파라미터 5</div>
                <input type="text" class="col-md-4  form-control form-control-sm" placeholder="파라미터 명">
                <input type="text" class="col-md-6  form-control form-control-sm" placeholder="설명">
              </div>
            </div>
            <div class="col-md-6">
              <div class="row">
                <div class="col-md-2 small align-self-center text-center">파라미터 6</div>
                <input type="text" class="col-md-4  form-control form-control-sm" placeholder="파라미터 명">
                <input type="text" class="col-md-6  form-control form-control-sm" placeholder="설명">
              </div>
              <div class="row">
                <div class="col-md-2 small align-self-center text-center">파라미터 7</div>
                <input type="text" class="col-md-4  form-control form-control-sm" placeholder="파라미터 명">
                <input type="text" class="col-md-6  form-control form-control-sm" placeholder="설명">
              </div>
              <div class="row">
                <div class="col-md-2 small align-self-center text-center">파라미터 8</div>
                <input type="text" class="col-md-4  form-control form-control-sm" placeholder="파라미터 명">
                <input type="text" class="col-md-6  form-control form-control-sm" placeholder="설명">
              </div>
              <div class="row">
                <div class="col-md-2 small align-self-center text-center">파라미터 9</div>
                <input type="text" class="col-md-4  form-control form-control-sm" placeholder="파라미터 명">
                <input type="text" class="col-md-6  form-control form-control-sm" placeholder="설명">
              </div>
              <div class="row">
                <div class="col-md-2 small align-self-center text-center">파라미터 10</div>
                <input type="text" class="col-md-4  form-control form-control-sm" placeholder="파라미터 명">
                <input type="text" class="col-md-6  form-control form-control-sm" placeholder="설명">
              </div>
            </div>
          </div>
          <hr>

          <input type="button" class="mt-3 btn btn-info float-right" value="수정" style="margin: 0px 5px;" />
          <input type="button" class="mt-3 btn btn-danger float-right" value="취소" style="margin: 0px 5px;" />
          <input type="button" class="mt-3 btn btn-primary float-right" value="등록" onclick="alert()" />
        </div>
      </div>
    </div>
  </div>

  <script>
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
