<!DOCTYPE html>
<html lang="en">
@include('popup.popupCommon.head')
{{-- js 라이브러리  --}}
@include('popup.popupCommon.popupJs')
<script type="text/javascript" src="/js/colResizable-1.6.js"></script>
<body class="bg-gradient-primary">
  <div id="content" class="gusung-popup">
    <div class="container-fluid">
      <h4 class="p-2 flex-grow-1 font-weight-bold text-white">잡-프로그램 구성</h4>
      <div class="card shadow mb-4">
        <div class="card-body">
          <div class="row">
            <div class="card shadow w-100 mb-2">
              <div class="card-body pt-3 pb-1">
                <div class="row">
                  <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">ID
                  </div>
                  <input type="text" id="Job_UniqueName" class="col-md-2 form-control form-control-sm align-self-center" placeholder="{{'job_'.$jobDetail[0]->Job_WorkLargeCtg.'_'.$jobDetail[0]->Job_WorkMediumCtg.'_'.$jobDetail[0]->Job_Seq}}" readonly>
                  <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">잡
                    명</div>
                  <input type="text" id="Job_Name" class="col-md-2 form-control form-control-sm align-self-center" value="{{$jobDetail[0]->Job_Name}}" readonly>
                  <div class="col-md-1 text-center align-self-center font-weight-bold text-primary">설명
                  </div>
                  <textarea type="text" id="Job_Sulmyung" class="col-md-5 form-control form-control-sm" readonly>{{$jobDetail[0]->Job_Sulmyung}}</textarea>
                </div>
              </div>
              <div class="card-body pt-1 pb3-0">
                <div id="jobParm" class="row mx-auto">
                    @php
                    $jobParamArr=explode("||",$jobDetail[0]->Job_Params);
                    $jobParamSulArr=explode("||",$jobDetail[0]->Job_ParamSulmyungs);
                    for ($i = 0; $i < count($jobParamArr); $i++) { 
                        echo '<p class="my-auto pl-3 my-1 small jobParmNum">'.intVal($i+1).') </p>';
                        echo '<input type="text" class="form-control form-control-sm col-md-2 my-1" readonly value="'.$jobParamSulArr[$i].'"/>';
                    }
                    if(count($jobParamArr)<=10){
                        for ($i = count($jobParamArr); $i < 10; $i++) { 
                            echo '<p class="my-auto pl-3 my-1 small jobParmNum">'.intVal($i+1).') </p>';
                            echo '<input type="text" class="form-control form-control-sm col-md-2 my-1" readonly/>';
                        }
                    }
                    @endphp
                </div>

              </div>
            </div>
          </div>
          <div class="row">
            <!-- 프로그램 -->
            <div class="card shadow mb-2">
              <div class="d-flex justify-content-end card-header py-3">
                <div class="d-inline-flex form-inline w-100 navbar-search">
                    <h5 class="mr-auto mb-0 font-weight-bold text-primary">프로그램</h5>
                  <div class="input-group align-items-center">
                    {{-- 대분류 중분류 선택 --}}
                    <div id="codeLargeView" class="list-code"></div>
                    <select class="form-control bg-light border-primary small">
                      <option>
                        프로그램 명
                      </option>
                      <option>
                        등록자
                      </option>
                    </select>
                    {{-- 검색 단어가 있을떄 없을때 구분  --}}
                    @if(!isset($searchWord))
                    <input id="searchWord" type="text" class="form-control bg-light border-primary small" placeholder="조회" aria-label="Search">
                    @elseif(isset($searchWord))
                    <input id="searchWord" type="text" value="{{$searchWord}}" class="form-control bg-light border-primary small" aria-label="Search">
                    @endif
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
                        <col width="100px" />
                        <col width="100px" />
                        <col width="100px" />
                        <col width="370px" />
                        <col width="80px" />
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
            <div class="col-md-12 text-center">
              <button class="btn btn-primary" type="button" onclick="popup.processAdd()"><i class="fa fa-arrow-down"></i></button>
              <button class="btn btn-danger" type="button" onclick="popup.processDel()"><i class="fa fa-arrow-up"></i></button>
            </div>
          </div>
          <div class="row">
            <h5 class="mb-4 font-weight-bold text-primary">구성 리스트</h5>
            <div class="card shadow w-100 mb-2">
              <!-- List -->
              <div class="card-body">
                {{-- 타이틀 --}}
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
                    @if(isset($jobGusungContents))
                      @include('popup.gusungProcessList')
                    @endIf
                </div>
              </div>
            </div>
            <div class="col-md-12 text-center">
              <button type="button" class="btn btn-info" onclick="popup.gusungAdd({{$jobDetail[0]->Job_Seq}})">등록</button>
              <button type="button" class="btn btn-danger" onclick="window.close()">취소</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  {{-- 구성 추가 --}}
    <script>
        // 검색 페이징
        $(document).ready(function () {
            Sortable({ els: ".gusungData", type: "insert" });
            popup.search("1", "all", "all");
            $(document).on('click', '.pagination a', function (event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                var WorkLarge = "";
                var WorkMedium = "";
                if($(this).attr('href').split('WorkLarge=')[1] == undefined) {
                    WorkLarge = "all";
                } else {
                    WorkLarge = $(this).attr('href').split('WorkLarge=')[1].split('&')[0];
                }
                if($(this).attr('href').split('WorkLarge=')[1] == undefined) {
                    WorkMedium = "all";
                } else {
                    WorkMedium = $(this).attr('href').split('WorkLarge=')[1].split('&')[0];
                }
                popup.search(page, WorkLarge, WorkMedium);
            });
        })
    </script>
    @php
      echo  '<script>code.workLargeCtg("all","all","'.$_SERVER["REQUEST_URI"].'");</script>';
      //echo  var_dump($jobGusungContents);
    @endphp
</body>
</html>