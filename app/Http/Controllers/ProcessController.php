<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;
class ProcessController extends Controller
{
   //프로세스 리스트 뷰
    public function processListView(){
        return view('index');
    }
   //프로세스 등록 뷰 
    public function processRegisterView(){
        return view('index');
    }
    //프로세스 상세 뷰
    public function processDetailView(Request $request){
        $p_seq = $request->input('p_seq');
        //프로시저를 통한 프로세스 상세정보 검색
        $processDetail=DB::select('CALL processDetail(?)',[$p_seq]);
        return view('index',compact('processDetail'));
    }
    //프로세스 조회 결과
    public function processSearch(Request $request){
        $searchWord = $request ->input('searchWord');
        $msg = "error";

        if($searchWord!=""){
            $processSearchContent = DB::select('CALL searchProcessList(?)',[$searchWord]);
            $msg = "success";
            $returnHTML = view("/process/processSearchListAjaxView",compact('processSearchContent'))->render();
            return response()->json(array('data'=> $processSearchContent,'msg'=>$msg,'html'=>$returnHTML));
        }
        //검색어 없으면
        else if($searchWord=""){
            $msg = "blank";

            return response()->json(array('msg'=>$msg));
        }
        //다른 에러
        else{
            return response()->json(array('msg'=>$msg));
        }
    }

}


