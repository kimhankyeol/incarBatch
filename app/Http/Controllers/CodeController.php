<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;

//공통코드 요청 컨트롤러
class CodeController extends Controller
{
    //업무 대분류 조회  ajax
    public function workLargeCtg(Request $request){
        //OnlineBatch_CommonCode 테이블에서 대분류 조회 하려면 코드타입 B , workMedium all 들어가면됨
        $Codetype= $request->input('CodeType');
        $WorkMedium= $request->input('WorkMedium');
        $workLargeCtgData=DB::table('OnlineBatch_CommonCode')->where('Codetype', $Codetype)->where('WorkMedium', $WorkMedium)->where('Used','1')->get();
        $returnHTML=view('code.codeSelect',compact('workLargeCtgData'))->render();
        return response()->json(array('workLargeCtgData'=>$workLargeCtgData,'returnHTML'=>$returnHTML),200);
    }

    //업무 소분류 조회 ajax
    public function workMediumCtg(Request $request){
        $Codetype= $request->input('CodeType');
        $WorkLarge = $request->input('WorkLarge');
        //medium 이 all 인거 제외하고 조회해야됨  all 인거는 대분류
        $workMediumCtgData=DB::table('OnlineBatch_CommonCode')->where('Codetype', $Codetype)->where('WorkLarge', $WorkLarge)->where('WorkMedium','!=' ,'all')->where('Used','1')->get();
        $returnHTML=view('code.codeMediumSelect',compact('workMediumCtgData'))->render();
        return response()->json(array('workMediumCtgData'=>$workMediumCtgData,'returnHTML'=>$returnHTML),200);
    }
}
