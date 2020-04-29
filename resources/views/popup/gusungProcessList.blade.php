@foreach($jobGusungContents as $data)
<ul class="px-0 mb-0 w-100 d-inline-flex gusungData" draggable="true">
  <ll class="d-none"><input class="gusungChk" type="checkbox" value="{{$data->P_Seq}}"></ll>
  <li class="list-group-item d-inline-flex col-md-1 p-2 rounded-0 text-center h-100 align-items-center justify-content-center">{{$data->JobGusung_Order}}</li>
  <li class="list-group-item d-inline-flex col-md-1 p-2 rounded-0 h-100 align-items-center">{{$data->P_FilePath}}</li>
  <li class="list-group-item d-inline-flex col-md-1 p-2 rounded-0 h-100 align-items-center">{{$data->P_File}}</li>
  <li class="list-group-item d-inline-flex col-md-1 p-2 rounded-0 h-100 align-items-center">{{$data->P_Name}}</li>
  <li class="list-group-item col-md-8 p-2 rounded-0">
    <label class="m-0 w-100">
    @php
     $Job_ParamSulmyungs = explode('||',$data->Job_ParamSulmyungs);
     $paramSulmyungs = explode('||',$data->P_ParamSulmyungs);
     $JobGusung_ParamPos = explode('||',$data->JobGusung_ParamPos);
     //  echo var_dump(sizeof($Job_ParamSulmyungs));
     //echo var_dump(($paramSulmyungs));
     //echo '<br>';
    // echo var_dump(($JobGusung_ParamPos));
    
     for ($i=0; $i < sizeof($paramSulmyungs); $i++) { 
       echo '<input class="form-control form-control-sm w-auto d-inline-block border-0 bg-transparent shadow-none" type="text" value="'.$paramSulmyungs[$i].'" readonly>';
       echo '<select class="form-control form-control-sm w-25 d-inline-block parmSelect">';
         for($j=0; $j <sizeof($Job_ParamSulmyungs); $j++) {
             echo '<option value="'.$j.'"'.($j==$JobGusung_ParamPos[$i]?'selected=true':'').'>'.intval($j+1).') '.$Job_ParamSulmyungs[$j].'</option>';
        }
      echo '</select>';
    }
    @endphp
    </label>
  </li>
</ul>
@endforeach