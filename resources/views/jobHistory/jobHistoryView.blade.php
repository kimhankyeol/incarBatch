<div id="content">
    <div class="container-fluid">
        <div class="card shadow mb-4">
        <div class="d-flex justify-content-end card-header py-3">
            <h6 class="flex-grow-1 font-weight-bold text-primary m-0 align-self-center">작업 히스토리</h6>
            <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" style="width: 20rem">
                <div class="input-group">
                <input type="text" class="form-control bg-light border-0 small" style="border: 1px solid #4e73df !important;" placeholder="JOB 명" aria-label="Search" aria-describedby="basic-addon2" onclick="javascript:searchBatch();">
                </div>
            </form>
            <input type="button" class="btn btn-primary" value="조회" style="margin: 0px 5px;" />
        </div>
        <div class="card-body" style="min-height: 530px;">
            <div class="table-responsive">
            <table id="datatable" class="table table-bordered text-center" cellspacing="0" style="width:120%; overflow-x: scroll;">
                <thead>
                <tr>
                    <th style="background-color:#47579c; color : #fff">작업 히스토리 시퀀스</th>
                    <th style="background-color:#47579c; color : #fff">작업 시퀀스</th>
                    <th style="background-color:#47579c; color : #fff">변경 전 작업이름</th>
                    <th style="background-color:#47579c; color : #fff">변경 전 선행작업번호</th>
                    <th style="background-color:#47579c; color : #fff">변경 전 후속작업번호</th>
                    <th style="background-color:#47579c; color : #fff">변경 전 작업레벨</th>
                    <th style="background-color:#47579c; color : #fff">작업 수정전</th>
                    <th style="background-color:#47579c; color : #fff">작업 수정일</th>
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
                </tr>
                <tr>
                    <td>Garrett Winters</td>
                    <td>Accountant</td>
                    <td>Tokyo</td>
                    <td>63</td>
                    <td>2011/07/25</td>
                    <td>$170,750</td>
                    <td>$320,800</td>
                    <td>$320,800</td>
                </tr>
                <tr>
                    <td>Ashton Cox</td>
                    <td>Junior Technical Author</td>
                    <td>San Francisco</td>
                    <td>66</td>
                    <td>2009/01/12</td>
                    <td>$86,000</td>
                    <td>$320,800</td>
                    <td>$320,800</td>
                </tr>
                <tr>
                    <td>Cedric Kelly</td>
                    <td>Senior Javascript Developer</td>
                    <td>Edinburgh</td>
                    <td>22</td>
                    <td>2012/03/29</td>
                    <td>$433,060</td>
                    <td>$320,800</td>
                    <td>$320,800</td>
                </tr>
                <tr onclick="javascript:test()">
                    <td>Airi Satou</td>
                    <td>Accountant</td>
                    <td>Tokyo</td>
                    <td>33</td>
                    <td>2008/11/28</td>
                    <td>$162,700</td>
                    <td>$320,800</td>
                    <td>$320,800</td>
                </tr>
                </tbody>
            </table>
            </div>
        </div>
        </div>
    </div>
</div>