<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;

class ProcessController extends Controller
{
    //프로세스 리스트/검색 뷰
    public function processListView(Request $request){
        $searchWord = $request->input('searchWord');
        if($searchWord==""){
            return view('process.processListView');
        }else{
            $data=DB::table('OnlineBatch_Process')->where('OnlineBatch_Process.P_Name','like',"%$searchWord%")->paginate(10);
            $searchParams = array( 'searchWord' => $searchWord);
            return view('process.processListView',compact('data','searchWord','searchParams'));
        }      
    }
    //프로세스 상세 뷰
    public function processDetailView(Request $request){
        $p_seq = $request->input('P_Seq');
        //프로시저를 통한 프로세스 상세정보 검색
        $processDetail=DB::select('CALL processDetail(?)',[$p_seq]);
        return view('process.processDetailView',compact('processDetail'));
    }
    //프로세스 등록 뷰
    public function processRegisterView(){
        return view('process.processRegisterView');
    }
    //프로세스 등록 저장
    public function processRegister(Request $request){
        $programName = $request->input('programName');
        $programExplain = $request->input('programExplain');
        $retry=$request->input('retry');
        $UseDb=$request->input('UseDb');
        $yaeTime=$request->input('yaeTime');
        $yaeMaxTime=$request->input('yaeMaxTime');
        $path=$request->input('path');
        $proParamType=$request->input('proParamType');
        $proParamSulmyungInput=$request->input('proParamSulmyungInput');
        // $result = DB::insert('insert into incar.OnlineBatch_Process(P_Params) values(?)',[$proParamType]);
        $result = DB::insert('insert into OnlineBatch_Process(P_Name,P_Sulmyung,P_ReworkYN,P_UseDB,P_YesangTime,P_YesangMaxTime,P_FilePath,P_Params,P_ParamSulmyungs) values(?,?,?,?,?,?,?,?,?)',[$programName,$programExplain,$retry,$UseDb,$yaeTime,$yaeMaxTime,$path,$proParamType,$proParamSulmyungInput]);
    //반드시 리턴값이 있어야 함
    return response()->json(array('result'=>$result));
    }

}
