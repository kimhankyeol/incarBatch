<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;

class JobController extends Controller
{
    //메인화면
    public function index(){
        return view('index');
    }
    //잡 리스트/검색 뷰
    public function jobListView(Request $request){
        $searchWord = $request->input('searchWord');
        if($searchWord==""){
            return view('job.jobListView');
        }else{
            $data=DB::table('OnlineBatch_Job')->where('OnlineBatch_Job.Job_Name','like',"%$searchWord%")->paginate(10);
            $searchParams = array( 'searchWord' => $searchWord);
            return view('job.jobListView',compact('data','searchWord','searchParams'));
        }      
    }
    //잡 상세 뷰
    public function jobDetailView(Request $request){
        $job_seq = $request->input('Job_Seq');
        //프로시저를 통한 잡 상세정보 검색
        $jobDetail=DB::select('CALL jobDetail(?)',[$job_seq]);
        return view('job.jobDetailView',compact('jobDetail'));
    }
    //잡 등록 뷰
    public function jobRegisterView(){
        return view('job.jobRegisterView');
    }
    //잡 등록
    public function jobRegister(Request $request){
        $Job_Name=$request->input('Job_Name');
        $Job_Sulmyung = $request->input('Job_Sulmyung');
        $Job_RegId = $request->input('Job_RegId');
        $Job_RegIP = $_SERVER["REMOTE_ADDR"];
        $Job_YesangTime = $request->input('Job_YesangTime');
        $Job_YesangMaxTime = $request->input('Job_YesangMaxTime');
        $Job_Params = $request->input('Job_Params');
        $Job_ParamSulmyungs = $request->input('Job_ParamSulmyungs');
        $Job_DeleteYN = "n";
        $Job_GusungVersion = 0;

        //쉘파일이 있는지 없는지
        //절대경로를 부여함

        $shellPath = "/home/sh/";
        $msg="";
        //파일 유무 validation 을 통해 DB insert 여부 결정함
       if(file_exists($shellPath.$Job_Name)){
            $result = DB::insert('CALL jobInsert(?,?,?,?,?,?,?,?,?,?)',[$Job_Name,$Job_Sulmyung,$Job_RegId,$Job_RegIP,$Job_YesangTime,$Job_YesangMaxTime,$Job_Params,$Job_ParamSulmyungs,$Job_DeleteYN,$Job_GusungVersion]);
            $msg="success"; 
        return response()->json(array('result'=>$result,'msg'=>$msg),200);
        }else{
            $msg="FileNotFound"; 
           return response()->json(array('msg'=>$msg,'path'=>$shellPath.$Job_Name));
       }
    }

}
