<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//DB 사용하기 위해 다음에는 controller 로 관리하는것 만들어야됨
use Illuminate\Support\Facades\DB;
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
        // $jobDB2= DB::table('JOB')->get();
        return view('index');
    }

    //잡실행뷰  
    public function batchExecuteView(){
        return view('index');
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
