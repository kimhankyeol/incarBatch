<?php
/*
@Author 
2020.04.03 김한결 작성
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;
class JobController extends Controller
{
    //모든 view는 index로 연결하고  index.blade.php 에서 화면을 분기해서 렌더링함
    //잡 리스트 뷰 
    public function jobListView(){
        return view('index');
    }
    //잡 등록뷰
    public function jobRegisterView(){
        return view('index');
    }
    //잡 상세뷰
    public function jobDetailView(Request $request){
        $job_seq = $request->input('job_seq');
        $jobDetail=DB::select('CALL jobDetail(?)',[$job_seq]);
        return view('index',compact('jobDetail'));
    }
    //잡 구성뷰
    public function jobProcessRegisterView(){
        return view('index');
    }
    //잡 실행뷰  
    public function jobExecuteView(){
        return view('index');
    }

    //잡 조회검색 
    public function jobSearch(Request $request){
        $searchWord = $request->input('searchWord');
        $msg = "error";
        //검색어 있으면
        if($searchWord!=""){
            //모델이 없이 쓰려면 
            //$jobSearchContent= DB::table('JOB')->where('JOB.job_name','like',"%$searchWord%")->get();
            //모델존재 쓰는법
            //프로시저 없이
            //$jobSearchContent= APP\Job::where('job_name','like',"%$searchWord%")->get();
            //프로시저 있다면
            //maria db 에서 프로시저를 생성하고 호출함
            $jobSearchContent = DB::select('CALL searchJobList(?)',[$searchWord]);
            $msg="success";
            $returnHTML=view("/job/jobSearchListAjaxView",compact('jobSearchContent'))->render();
            return response()->json(array('data'=>$jobSearchContent,'msg'=>$msg,'html'=>$returnHTML),200);
        }
        //검색어 없으면 
        else if($searchWord==""){
            $msg="blank";
            return response()->json(array('msg'=>$msg));
        }
        //다른 에러 
        else{
            return response()->json(array('msg'=>$msg));
        }      
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
