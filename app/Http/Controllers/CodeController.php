<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;

//공통코드 요청 컨트롤러
class CodeController extends Controller
{
    // //업무 대분류 조회  ajax
    // public function workLargeCtg(Request $request){
    //     //ajax 때문에 상위 php에 요청 에 쿼리스트링을 불러오지 못해 $_GET이 안됨 // 상위 php 에서 ajax code.workLargeCtg 를 호출할떄 변수 WorkLarge 를 넣어줬음 
    //     $WorkLarge = $request->input('WorkLarge');
    //     $WorkMedium = $request->input('WorkMedium');
    //     //중분류 관리자 일때는 select box 다르게
    //     //관리자는 대분류를 전체 다보여줘야 되기 때문에 url 에 따라 달라져야함
    //     $workLargeCtgData=DB::select('Call getUsedLargeCodeGubun');
    //     $returnHTML=view('code.codeSelect',compact('workLargeCtgData','WorkLarge','WorkMedium'))->render();
    //     return response()->json(array('workLargeCtgData'=>$workLargeCtgData,'returnHTML'=>$returnHTML),200);
    // }
    //업무 중분류 조회 ajax
    public function workMediumCtg(Request $request){
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        if($WorkMedium==""){
            $WorkMedium="all";
        }
        $workMediumCtgData=DB::table('OnlineBatch_WorkMediumCode')->where('WorkLarge', $WorkLarge)->get();
        // $workMediumCtgData = DB::select('Call Job_searchUsedMediumCode(?)',[$WorkLarge]);
        $returnHTML=view('code.codeMedium',compact('workMediumCtgData','WorkMedium'))->render();
        return response()->json(array('workMediumCtgData'=>$workMediumCtgData,'returnHTML'=>$returnHTML),200);
    }
    public function workMediumCtg2(Request $request){
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        if($WorkMedium==""){
            $WorkMedium="all";
        }
        $workMediumCtgData=DB::table('OnlineBatch_WorkMediumCode')->where('WorkLarge', $WorkLarge)->where('Used',1)->get();
        $returnHTML=view('code.codeMedium',compact('workMediumCtgData','WorkMedium'))->render();
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
