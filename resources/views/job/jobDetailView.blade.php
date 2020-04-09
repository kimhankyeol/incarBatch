  <!-- Main Content -->
  <div id="content">
    <!-- End of Topbar -->
    <!-- Begin Page Content -->
    <div class="container-fluid">
      <!-- Page Heading -->
      <!-- DataTales Example -->
      <div class="card shadow my-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary" style="text-align: center;">잡 정보 상세</h6>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">잡 ID</div>
          <input type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="{{$jobDetail[0]->Job_Seq}}" readonly>
            <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">잡명</div>
            <input type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="잡명">
            <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">설명</div>
            <textarea type="text" class="col-md-5 form-control form-control-sm" placeholder="설명" style="resize: none;"></textarea>
          </div>
          <hr>
          <div class="row">
            <div class="col-md-2 text-center align-self-center font-weight-bold text-primary">잡 등록자</div>
            <input type="text" class="col-md-2 form-control form-control-sm align-self-center" placeholder="김한결" readonly>
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
            <div class="col-md-3 text-center align-self-center font-weight-bold text-primary">잡 상태</div>
            <input type="text" class="col-md-3 form-control form-control-sm align-self-center" placeholder="-" readonly>
            <div class="col-md-3 text-center align-self-center font-weight-bold text-primary">구성 프로세스</div>
            <input type="text" class="col-md-3 form-control form-control-sm align-self-center" placeholder="-" readonly>              
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
            <div class="col-md-3 text-center align-self-center font-weight-bold text-primary">등록일</div>
            <input type="text" class="col-md-3 form-control form-control-sm align-self-center" placeholder="" readonly>
            <div class="col-md-3 text-center align-self-center font-weight-bold text-primary">최종 수정일</div>
            <input type="text" class="col-md-3 form-control form-control-sm align-self-center" placeholder="" readonly>              
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
          <input type="button" class="mt-3 btn btn-primary float-right" value="등록" onclick="job.register()" />
        </div>
      </div>
    </div>
  </div>

