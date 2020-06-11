@foreach($jobGusungContents as $data)
<ul class="px-0 mb-0 w-100 d-inline-flex gusungData" draggable="true" onclick="popup.selectRow(this)">
  <ll class="d-none"><input class="gusungChk" type="checkbox" value="{{$data->p_seq}}"></ll>
  <li class="list-group-item d-inline-flex col-md-1 p-2 rounded-0 text-center h-100 align-items-center justify-content-center">{{$data->jobgusung_order}}</li>
  <li class="list-group-item d-inline-flex col-md-1 p-2 rounded-0 h-100 align-items-center">{{$data->p_filepath}}</li>
  <li class="list-group-item d-inline-flex col-md-1 p-2 rounded-0 h-100 align-items-center">{{$data->p_file}}</li>
  <li class="list-group-item d-inline-flex col-md-1 p-2 rounded-0 h-100 align-items-center">{{$data->p_name}}</li>
  <li class="list-group-item col-md-8 p-2 rounded-0">
    <label class="m-0 w-100">
    @php
     $Job_ParamSulmyungs = explode('||',$data->job_paramsulmyungs);
     $paramSulmyungs = explode('||',$data->p_paramsulmyungs);
     $JobGusung_ParamPos = explode('||',$data->jobgusung_parampos);
    if(isset($data->p_paramsulmyungs)) {
      for ($i=0; $i < sizeof($paramSulmyungs); $i++) { 
       echo '<input class="form-control form-control-sm w-auto d-inline-block border-0 bg-transparent shadow-none text-center" type="text" value="'.$paramSulmyungs[$i].'" readonly>';
       echo '<select class="form-control form-control-sm w-25 d-inline-block parmSelect">';
         for($j=0; $j <sizeof($Job_ParamSulmyungs); $j++) {
             echo '<option value="'.$j.'"'.($j==$JobGusung_ParamPos[$i]?'selected=true':'').'>'.intval($j+1).') '.$Job_ParamSulmyungs[$j].'</option>';
        }
      echo '</select>';
      }
    }
    @endphp
    </label>
  </li>
</ul>
@endforeach