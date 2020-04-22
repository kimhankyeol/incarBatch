<div class="table-responsive">
    <table id="datatable" class="table table-bordered" cellspacing="0">
        <thead>
        <tr>
            <th>대분류</th>
            <th>코드</th>
            <th>사용 여부</th>
        </tr>
        </thead>
        <tbody>
            {{--  조회된 값이 보여주는 위치 --}}
            @if(isset($data))
            @include('admin.commonCodeLargeSearchListView')
            @endIf
        </tbody>
    </table>
    @if(isset($paginator))
    {{$paginator->setPath('/admin/commonCodeLargeExist')->appends(request()->except($searchParams))->links()}}
    @endIf
</div>
