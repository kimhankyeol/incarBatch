<div class="mx-2">
<div class="card shadow m-1">
    <div class="card-body">
    <div class="table-responsive">
        <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
        <div class="col-sm-12 text-center">
            <div class="row">
            <table  style="width:100%">
                <tbody>
                <tr role="row" class="odd">
                    <td rowspan="2" style="width:20%;">프로세스 명</td>
                    <td><input class="form-control" type="text" placeholder="argv[1]"></td>
                    <td><input class="form-control" type="text" placeholder="argv[2]"></td>
                    <td><input class="form-control" type="text" placeholder="argv[3]"></td>
                    <td><input class="form-control" type="text" placeholder="argv[4]"></td>
                    <td><input class="form-control" type="text" placeholder="argv[5]"></td>
                </tr>
                <tr role="row" class="even">
                    <td><input class="form-control" type="text" placeholder="argv[6]"></td>
                    <td><input class="form-control" type="text" placeholder="argv[7]"></td>
                    <td><input class="form-control" type="text" placeholder="argv[8]"></td>
                    <td><input class="form-control" type="text" placeholder="argv[9]"></td>
                    <td><input class="form-control" type="text" placeholder="argv[10]"></td>
                </tr>
                <tr role="row" class="odd">
                    <td style="width:20%;">프로세스 설명</td>
                    <td colspan="5"><input class="form-control" type="text" placeholder="설명"></td>
                </tr>
                <tr role="row" class="even">
                    <td>등록일</td>
                    <td colspan="2"><input class="form-control text-center" type="text" placeholder="2020-01-01"></td>
                    <td> 재작업 </td>
                    <td colspan="2"><input class="form-control text-center" type="text" placeholder=" 재작업 "></td>
                </tr>
                </tbody>
            </table>
            </div>
            <div class="footer mt-3">
            <button type="button" class="btn btn-primary" onclick="javascript:submit()">등록</button>
            <button type="button" class="btn btn-primary" onclick="javascript:submit()">취소</button>
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
  </script>
