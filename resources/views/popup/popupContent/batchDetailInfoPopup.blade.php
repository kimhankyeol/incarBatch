<body class="bg-gradient-primary">
  <div class="mx-2">
    <div class="card shadow m-1">
      <div class="card-body">
        <div class="table-responsive">
          <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="col-sm-12 text-center">
              <div class="row">
                <table  style="width:100%">
                  <tbody>
                    <tr>잡 정보</tr>
                    <tr role="row" class="odd">
                      <td rowspan="2" style="width:20%;">Car_Samsung_20200401163103</td> 
                      <td><input class="form-control" type="text" placeholder="날짜"></td>
                      <td><input class="form-control" type="text" placeholder="날짜"></td>
                      <td><input class="form-control" type="text" placeholder="날짜"></td>
                      <td><input class="form-control" type="text" placeholder="argv[4]" readonly></td>
                      <td><input class="form-control" type="text" placeholder="argv[5]" readonly></td>
                    </tr>
                    <tr role="row" class="even">
                      <td><input class="form-control" type="text" placeholder="argv[6]" readonly></td>
                      <td><input class="form-control" type="text" placeholder="argv[7]" readonly></td>
                      <td><input class="form-control" type="text" placeholder="argv[8]" readonly></td>
                      <td><input class="form-control" type="text" placeholder="argv[9]" readonly></td>
                      <td><input class="form-control" type="text" placeholder="argv[10]" readonly></td>
                    </tr>
                    <tr role="row" class="odd">
                      <td rowspan="2" style="width:20%;">변수 설명</td>
                      <td><input class="form-control" type="text" placeholder="날짜(연도) 숫자" readonly></td>
                      <td><input class="form-control" type="text" placeholder="날짜(월) 숫자"  readonly></td>
                      <td><input class="form-control" type="text" placeholder="날짜(일) 숫자"  readonly></td>
                      <td><input class="form-control" type="text" placeholder="argv[4]"  readonly></td>
                      <td><input class="form-control" type="text" placeholder="argv[5]"  readonly></td>
                    </tr>
                    <tr role="row" class="even">
                      <td><input class="form-control" type="text" placeholder="argv[6]" readonly></td>
                      <td><input class="form-control" type="text" placeholder="argv[7]" readonly></td>
                      <td><input class="form-control" type="text" placeholder="argv[8]" readonly></td>
                      <td><input class="form-control" type="text" placeholder="argv[9]" readonly></td>
                      <td><input class="form-control" type="text" placeholder="argv[10]" readonly></td>
                    </tr>
                    <tr role="row" class="odd">
                      <td style="width:20%;">설명</td>
                      <td colspan="5"><input class="form-control" type="text" placeholder="설명"></td>
                    </tr>
                    <tr role="row" class="even">
                      <td>등록일</td>
                      <td colspan="2"><input class="form-control text-center" type="text" placeholder="2020-04-01"></td>
                      <td>상태</td>
                      <td colspan="2"><input class="form-control text-center" type="text"  placeholder="오류"></td>
                    </tr>
                  </tbody>
                </table>
                <hr class="col-md-12">
                <table class="mb-2" style="width:100%">
                  <tbody>
                    <tr>프로세스 정보</tr>
                    <tr role="row" class="odd">
                      <!-- 프로세스 설명, 프로세스 예상시간, 최대 예상시간 -->
                      
                      <td rowspan="2" style="width:20%;"><input type="checkbox" checked="checked" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Samsung_geyak_2020_01.php</label><i class="fa fa-info-circle" onclick="processDetailInfo()"></i></td>
                      <td><select class="form-control"><optgroup label="parameter1"><option>날짜</option><option>parameter1</option></optgroup></select></td>
                      <td><select class="form-control"><optgroup label="parameter2"><option>날짜</option><option>parameter2</option></optgroup></select></td>
                      <td><select class="form-control" ><optgroup label="parameter3"><option>선택</option><option>parameter3</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter4"><option>선택 불가</option><option>parameter4</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter5"><option>선택 불가</option><option>parameter5</option></optgroup></select></td>
                      <td rowspan="2" class="form-control" style="width:10% !important; display: table-cell !important;"> 재작업 </td>
                    </tr>
                    <tr role="row" class="even">
                      <td><select class="form-control" disabled><optgroup label="parameter6"><option>선택 불가</option><option>parameter6</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter7"><option>선택 불가</option><option>parameter7</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter8"><option>선택 불가</option><option>parameter8</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter9"><option>선택 불가</option><option>parameter9</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter10"><option>선택 불가</option><option>parameter10</option></optgroup></select></td>
                    </tr>
                  </tbody>
                </table>
                <table class="mb-2" style="width:100%">
                  <tbody>
                    <tr role="row" class="odd">
                      <td rowspan="2" style="width:20%;"><input type="checkbox" checked="checked" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Samsung_geyak_2020_02.php</label><i class="fa fa-info-circle"></i></td>
                      <td><select class="form-control"><optgroup label="parameter1"><option>날짜</option><option>parameter1</option></optgroup></select></td>
                      <td><select class="form-control"><optgroup label="parameter2"><option>선택</option><option>parameter2</option></optgroup></select></td>
                      <td><select class="form-control"><optgroup label="parameter3"><option>선택</option><option>parameter3</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter4"><option>선택 불가</option><option>parameter4</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter5"><option>선택 불가</option><option>parameter5</option></optgroup></select></td>
                      <td rowspan="2" class="form-control" style="width:10% !important; display: table-cell !important;"> - </td>
                    </tr>
                    <tr role="row" class="even">
                      <td><select class="form-control" disabled><optgroup label="parameter6"><option>선택 불가</option><option>parameter6</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter7"><option>선택 불가</option><option>parameter7</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter8"><option>선택 불가</option><option>parameter8</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter9"><option>선택 불가</option><option>parameter9</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter10"><option>선택 불가</option><option>parameter10</option></optgroup></select></td>
                    </tr>
                  </tbody>
                </table>
                <table class="mb-2" style="width:100%">
                  <tbody>
                    <tr role="row" class="odd">
                      <td rowspan="2" style="width:20%;"><input type="checkbox" checked="checked" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Samsung_geyak_2020_03.php</label><i class="fa fa-info-circle"></i></td>
                      <td><select class="form-control"><optgroup label="parameter1"><option>날짜</option><option>parameter1</option></optgroup></select></td>
                      <td><select class="form-control"><optgroup label="parameter2"><option>선택</option><option>parameter2</option></optgroup></select></td>
                      <td><select class="form-control"><optgroup label="parameter3"><option>선택</option><option>parameter3</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter4"><option>선택 불가</option><option>parameter4</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter5"><option>선택 불가</option><option>parameter5</option></optgroup></select></td>
                      <td rowspan="2" class="form-control" style="width:10% !important; display: table-cell !important;"> 재작업 </td>
                    </tr>
                    <tr role="row" class="even">
                      <td><select class="form-control" disabled><optgroup label="parameter6"><option>선택 불가</option><option>parameter6</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter7"><option>선택 불가</option><option>parameter7</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter8"><option>선택 불가</option><option>parameter8</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter9"><option>선택 불가</option><option>parameter9</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter10"><option>선택 불가</option><option>parameter10</option></optgroup></select></td>
                    </tr>
                  </tbody>
                </table>
                <table class="mb-2" style="width:100%">
                  <tbody>
                    <tr role="row" class="odd">
                      <td rowspan="2" style="width:20%;"><input type="checkbox" checked="checked" id="vehicle1" name="vehicle1" value="Bike">
                        <label for="vehicle1">Samsung_susuryo.php</label><i class="fa fa-info-circle"></i></td>
                      <td><select class="form-control"><optgroup label="parameter1"><option>날짜</option><option>parameter1</option></optgroup></select></td>
                      <td><select class="form-control"><optgroup label="parameter2"><option>날짜</option><option>parameter2</option></optgroup></select></td>
                      <td><select class="form-control"><optgroup label="parameter3"><option>날짜</option><option>parameter3</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter4"><option>선택 불가</option><option>parameter4</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter5"><option>선택 불가</option><option>parameter5</option></optgroup></select></td>
                      <td rowspan="2" class="form-control" style="width:10% !important; display: table-cell !important;"> 재작업 </td>
                    </tr>
                    <tr role="row" class="even">
                      <td><select class="form-control" disabled><optgroup label="parameter6"><option>선택 불가</option><option>parameter6</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter7"><option>선택 불가</option><option>parameter7</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter8"><option>선택 불가</option><option>parameter8</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter9"><option>선택 불가</option><option>parameter9</option></optgroup></select></td>
                      <td><select class="form-control" disabled><optgroup label="parameter10"><option>선택 불가</option><option>parameter10</option></optgroup></select></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="footer mt-3">
                <button type="button" class="btn btn-primary" onclick="javascript:submit()">실행</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

    <script type="text/javascript">
      function submit() {
        window.close();
      }
      function processDetailInfo() {
          var popUrl = "/popup/processDetailInfoPopup";
          var popOption = "top=10, left=10, width=1200, height=200, status=no, menubar=no, toolbar=no, resizable=no, location=no";
          window.open(popUrl, "_blank", popOption);
      }
    </script>
  
  </body>