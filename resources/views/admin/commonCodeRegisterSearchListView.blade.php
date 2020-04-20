<div class="table-responsive">
    <table id="datatable" class="table table-bordered" cellspacing="0">
        <thead>
        <tr>
            <th>코드 타입</th>
            <th>대분류</th>
            <th>중분류</th>
            <th>코드 명</th>
            <th>코드 전체 명</th>
            <th>사용 여부</th>
        </tr>
        </thead>
        <tbody>
            {{--  조회된 값이 보여주는 위치 --}}
            @if(isset($data))
            @include('admin.commonCodeSearchListView')
            @endIf
        </tbody>
    </table>
</div>
