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
        $workLargeCtgData=DB::table('OnlineBatch_WorkLargeCode')->where('Used','1')->get();
        $returnHTML=view('code.codeSelect',compact('workLargeCtgData'))->render();
        return response()->json(array('workLargeCtgData'=>$workLargeCtgData,'returnHTML'=>$returnHTML),200);
    }

    //업무 소분류 조회 ajax
    public function workMediumCtg(Request $request){
        $WorkLarge = $request->input('WorkLarge');
        //medium 이 all 인거 제외하고 조회해야됨  all 인거는 대분류
        $workMediumCtgData=DB::table('OnlineBatch_WorkMediumCode')->where('WorkLarge', $WorkLarge)->get();
        $returnHTML=view('code.codeMediumSelect',compact('workMediumCtgData'))->render();
        return response()->json(array('workMediumCtgData'=>$workMediumCtgData,'returnHTML'=>$returnHTML),200);
    }
    //대분류, 중분류 전송해서 경로 설정
    public function workDataSelect(Request $request){
        $workLargeVal = $request->input('workLargeVal');
        $workMediumVal = $request->input('workMediumVal');
        $workFilePath = DB::table('OnlineBatch_WorkMediumCode')->select('FilePath')->where('WorkLarge',$workLargeVal)->where('WorkMedium',$workMediumVal)->get();
        return response()->json(array('workFilePath'=>$workFilePath));
    }

}
