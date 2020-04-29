
<table id="processList" class="table table-bordered" cellspacing="0">
    <colgroup>
      <col width="0px" />
      <col width="110px" />
      <col width="150px" />
      <col width="120px" />
      <col width="120px" />
      <col width="310px" />
      <col width="100px" />
      <col width="190px" />
    </colgroup>
    <thead>
      <tr>
        <th></th>
        <th>ID</th>
        <th>대분류</th>
        <th>중분류</th>
        <th>프로그램 명</th>
        <th>설명</th>
        <th>등록자</th>
        <th>등록일시</th>
      </tr>
    </thead>
    @if(isset($dataSearch))
    <tbody>
        @foreach($dataSearch as $data)
          <tr onclick="selectRow(this)">
            <td><input type="checkbox" class="list-group-item" value="{{$data->P_Seq}}"></td>
            <td>{{$data->P_Seq}}</td>
            <td>{{$data->P_WorkLargeName}}</td>
            <td>{{$data->P_WorkMediumName}}</td>
            <td>{{$data->P_Name}}</td>
            <td>{{$data->P_Sulmyung}}</td>
            <td>{{$data->P_RegId}}</td>
            <td>{{$data->P_RegDate}}</td>
          </tr>
        @endforeach
      
    </tbody>
    @endIf
  </table>
