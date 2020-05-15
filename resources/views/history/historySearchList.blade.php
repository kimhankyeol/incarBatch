@foreach($data as $hisSc)
<tr ondblclick="history.detail({{$hisSc->Job_Seq}},{{$hisSc->Sc_Seq}})">
    <td class="text-center">{{$hisSc->JobSM_P_StartTime}}</td>
    <td class="text-center">{{'job_'.$hisSc->Job_WorkLargeCtg.'_'.$hisSc->Job_WorkMediumCtg.'_'.$hisSc->Job_Seq.'_'.$hisSc->Sc_Seq}}</td>
    <td class="text-center">{{$hisSc->Sc_Version}}</td>
    <td class="text-center">{{$hisSc->JobSM_P_Status}}</td>
    <td class="text-center">{{$hisSc->Sc_Sulmyung}}</td>
    <td class="text-center">{{$hisSc->Job_RegId}}</td>
    <td class="overflow-auto">
        @php
        $paramLength = count(explode('||',$hisSc->Sc_Param));
        for ($i=0; $i < $paramLength; $i++) { 
            # code...
            #echo '<label class="m-0">';
            #echo '<input class="form-control form-control-sm col-md-6 border-0 bg-transparent shadow-none" type="text" readonly="" value="파라미터 '.intVal($i+1).' '.explode('||',$detailSc->Job_ParamSulmyungs)[explode('||',$detailSc->JobGusung_ParamPos)[$i]].'">';
            echo '<p class="form-control form-control-sm d-inline-block w-auto readonly mx-1 my-0">'.explode('||',$hisSc->Sc_Param)[$i].'</p>';
            #echo '</label>';
        }
        @endphp
    </td>
    <td class="text-center"><buton type="button" class="btn btn-sm border-primary border-bottom-primary" onclick="history.detailLog()">상세</buton></td>
</tr>
@endforeach