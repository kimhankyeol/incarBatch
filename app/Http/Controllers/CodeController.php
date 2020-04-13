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
        $codeType= $request->input('codeType');
        $workLargeCtgData=DB::table('Work')->where('Codetype', $codeType)->get();
        $returnHTML=view('code.codeSelect',compact('workLargeCtgData'))->render();
        return response()->json(array('workLargeCtgData'=>$workLargeCtgData,'returnHTML'=>$returnHTML),200);
    }

    //업무 소분류 조회 ajax
    public function workMediumCtg(Request $request){
        $codeType= $request->input('codeType');
        $code = $request->input('code');

        $reCodeType = $codeType.$code;
        $workMediumCtgData=DB::table('Work')->where('Codetype', $reCodeType)->get();
        $returnHTML=view('code.codeMediumSelect',compact('workMediumCtgData'))->render();
        return response()->json(array('workMediumCtgData'=>$workMediumCtgData,'reCodeType'=> $reCodeType,'returnHTML'=>$returnHTML),200);
    }
}
