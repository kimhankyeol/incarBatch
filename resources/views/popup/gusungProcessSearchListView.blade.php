

<table id="processList" class="table table-bordered mb-0" cellspacing="0">
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
      
    @if(isset($data))
    <tbody>
        @foreach($data as $proSc)
        <tr onclick="popup.selectRow(this)" ondblclick="pageMove.process.detail('processDetailView','{{$proSc->P_Seq}}')">
            <td class="d-none"><input type="checkbox" class="list-group-item processChecks" value="{{$proSc->P_Seq}}"></td>
            <td>{{$proSc->P_FileName}}</td>
            <td>{{$proSc->P_File}}</td>
            <td>{{$proSc->P_Name}}</td>
            <td class="overflow-auto">
                <li class="d-block col-md-8 p-2 rounded-0" value="1" draggable="true">
                    <label class="m-0">
                        @php
                        $proParamSulArr=explode("||",$proSc->P_ParamSulmyungs);
                        for ($i = 0; $i < count($proParamSulArr); $i++) {
                            echo '<input type="text" class="form-control form-control-sm w-auto d-inline-block" value="'.$proParamSulArr[$i].'"readonly>';
                        }
                        @endphp
                    </label>
                </li>
            </td>
            <td>{{$proSc->P_RegId}}</td>
        </tr>
        @endforeach
    </tbody>
    @endIf
  </table>
  @if(isset($paginator))
  {{$paginator->setPath('/popup/popupPsSearch')->appends(request()->except($searchParams))->links()}}
  @endIf

  <script>$(function(){$("#processList").colResizable();});</script>