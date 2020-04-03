<div id="content">
    <div class="container-fluid">
      <div class="card shadow mb-4">
        <div class="d-flex justify-content-end card-header py-3">
          <h4 class="p-2 flex-grow-1 font-weight-bold text-primary">잡 구성</h4>
        </div>
        <div class="card-body">
          <div class="card shadow mb-4">
            <div class="card-body py-3">
                <div class="col-md-12 font-weight-bold text-primary">
                    잡 구성 목록
                </div>
              <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search float-right">
                <div class="input-group">
                  <input type="text" class="form-control bg-light border-0 small" placeholder="잡 검색" aria-label="Search" style="border: 1px solid #4e73df !important;">
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                      <i class="fas fa-search fa-sm"></i>
                    </button>
                  </div>
                </div>
              </form>
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
          <div class="row mb-4">
            <div class="col-md-5" style="max-width: 42.66667%;">
              <div class="card table-responsive">
                <div class="card-body py-3">
                    <div class="col-md-12 font-weight-bold text-primary">
                        프로세스 검색
                    </div>
                  <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search float-right">
                    <div class="input-group">
                      <input type="text" class="form-control bg-light border-0 small" placeholder="프로세스 검색" aria-label="Search" style="border: 1px solid #4e73df !important;">
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="button">
                          <i class="fas fa-search fa-sm"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
                <table class="table table-bordered text-center" id="datatable" cellspacing="0" style="width:150%; overflow-x: scroll;">
                  <thead>
                    <tr>
                      <th style="background-color:#47579c; color : #fff"></th>
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
            <div class="col-md-1 align-self-center text-center" style="max-width: 6.33333%;">
              <button class="btn btn-primary my-2" type="button"><i class="fa fa-arrow-right"></i></button>
              <button class="btn btn-danger my-2" type="button"><i class="fa fa-arrow-left"></i></button>
            </div>
            <div class="col-md-6 card">
                <div class="font-weight-bold text-primary py-3">
                 잡 - 프로세스 순서 설정
                </div>
              <div class="row mx-0">
                <!-- List -->
                <div class="col-md-2 px-0">
                  <ul class="list-group text-center">
                    <li class="list-group-item">1</li>
                    <li class="list-group-item">2</li>
                    <li class="list-group-item">3</li>
                    <li class="list-group-item">4</li>
                    <li class="list-group-item">5</li>
                    <li class="list-group-item">6</li>
                    <li class="list-group-item">7</li>
                    <li class="list-group-item">8</li>
                    <li class="list-group-item">9</li>
                    <li class="list-group-item">10</li>
                  </ul>
                </div>
                <div class="col-md-10 px-0">
                  <ul class="drag-sort-enable list-group">
                    <li class="list-group-item">Application</li>
                    <li class="list-group-item">Blank</li>
                    <li class="list-group-item">Class</li>
                    <li class="list-group-item">Data</li>
                    <li class="list-group-item">Element</li>
                  </ul>
                </div>
                <div class="col-md-12 px-0 text-right">
                    <div class="btn btn-info">등록</div>
                    <div class="btn btn-danger">취소</div>
                </div>
                 <!--  -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Sort Table -->
  <script type="text/javascript">
    function enableDragSort(listClass) {
      const sortableLists = document.getElementsByClassName(listClass);
      Array.prototype.map.call(sortableLists, (list) => { enableDragList(list) });
    }

    function enableDragList(list) {
      Array.prototype.map.call(list.children, (item) => { enableDragItem(item) });
    }

    function enableDragItem(item) {
      item.setAttribute('draggable', true)
      item.ondrag = handleDrag;
      item.ondragend = handleDrop;
    }

    function handleDrag(item) {
      const selectedItem = item.target,
        list = selectedItem.parentNode,
        x = event.clientX,
        y = event.clientY;

      selectedItem.classList.add('drag-sort-active');
      let swapItem = document.elementFromPoint(x, y) === null ? selectedItem : document.elementFromPoint(x, y);

      if (list === swapItem.parentNode) {
        swapItem = swapItem !== selectedItem.nextSibling ? swapItem : swapItem.nextSibling;
        list.insertBefore(selectedItem, swapItem);
      }
    }

    function handleDrop(item) {
      item.target.classList.remove('drag-sort-active');
    }

    (() => { enableDragSort('drag-sort-enable') })();
  </script>
