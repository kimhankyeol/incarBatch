<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
//DB 사용하기 위해 다음에는 controller 로 관리하는것 만들어야됨
use Illuminate\Support\Facades\DB;
use App;
class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //잡등록뷰 
    public function jobRegisterView()
    {
        // if (\Request::is('/')) { 
        //     $jobDB= DB::table('JOB')->get();
        //     return view('index',compact('jobDB'));
        // } 
        return view('index');
    }

    //잡구성뷰
    public function batchProcessRegisterView(){
        return view('index');
    }

    //잡실행뷰  
    public function batchExecuteView(){
        return view('index');
    }

    //잡 조회검색 
    public function batchSearch(Request $request){
        $searchWord = $request->input('searchWord');
        $msg = "error";
        //검색어 있으면
        if($searchWord!=""){
            //모델이 없이 쓰려면 
            //$jobSearchContent= DB::table('JOB')->where('JOB.job_name','like',"%$searchWord%")->get();
            //모델존재 쓰는법
            $jobSearchContent= APP\Job::where('job_name','like',"%$searchWord%")->get();
            $msg="success";
            $returnHTML=view("/batch/batchSearchListAjaxView",compact('jobSearchContent'))->render();
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
