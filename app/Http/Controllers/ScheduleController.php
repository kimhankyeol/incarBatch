<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;
use DateTime;

class scheduleController extends Controller
{
    //스케줄 리스트 화면  -- 여기 바뀌어야함 
    public function scheduleListView(Request $request){
        $searchWord = $request->input('searchWord');
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        if($searchWord==""){
            $searchWord="searchWordNot";
        }
        if($WorkLarge==""){
            $WorkLarge="all";
        }
        if($WorkMedium==""){
            $WorkMedium="all";
        }
        // 사용중인 것만 조회  //프로시저 다시만들어야함 스케줄에 맞는
        $jobContents = DB::select('CALL Job_searchUsedList(?,?,?)',[$searchWord,$WorkLarge,$WorkMedium]);
        $usedLarge = DB::select('CALL Common_LargeCode()');
        $page=$request->input('page');
        //커스텀된 페이지네이션 클래스  변수로는 (현재 페이지번호 ,한 페이지에 보여줄 개수 , 조회된정보)
        $PaginationCustom = new App\Http\Controllers\Render\PaginationCustom($page,10,$jobContents);
        //페이징 정보를 가져옴
        $paginator = $PaginationCustom->getPaging();
        //현재 페이지에서 보여주는 조회 정보 리스트를 가져옴
        $data =$PaginationCustom->getItemsForCurrentPage();
        $searchParams = array( 'searchWord' => $searchWord);
        //대분류 , 중분류 전체일 조건  
        if($WorkLarge=="all"&&$WorkMedium=="all"){
            $searchParams = array( 'searchWord' => $searchWord);
        }
        //대분류 선택, 중분류 전체
        else if($WorkLarge!="all"&&$WorkMedium=="all"){
            $searchParams = array( 'searchWord' => $searchWord,'WorkLarge' => $WorkLarge,'WorkMedium'=>'all');
        }
        //대분류 선택 ,중분류 선택
        else if($WorkLarge!="all"&&$WorkMedium!="all"){
            $searchParams = array( 'searchWord' => $searchWord,'WorkLarge' => $WorkLarge,'WorkMedium' => $WorkMedium);
        }
        if($WorkLarge!="all"){
            $usedMedium = DB::select('CALL Common_MediumCode(?)',[$WorkLarge]);
            return view('schedule.scheduleListView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge','usedMedium'));
        }else{
            return view('schedule.scheduleListView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge'));
        }
    }
    //스케줄 등록 화면
    public function scheduleRegisterView(Request $request){
        return view("schedule.scheduleRegisterView");
    }
}
