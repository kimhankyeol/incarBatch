<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;

class HistoryController extends Controller
{
    //메인화면
    public function historyListView(Request $request){
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        $startDate = $request -> input('startDate');
        $endDate = $request -> input('endDate');
        $searchType = $request -> input('searchType');
        $searchValue = $request -> input('searchValue');
        $status = $request -> input('status');
        if($searchValue==""){
            $searchValue="searchWordNot";
        }
        if($WorkLarge==""){
            $WorkLarge="all";
        }
        if($WorkMedium==""){
            $WorkMedium="all";
        }
        $historyContents = DB::select('CALL history_searchList(?,?,?,?,?,?,?)',[$WorkLarge,$WorkMedium,$startDate,$endDate,$searchType,$searchValue,$status]);
        $usedLarge = DB::select('CALL Common_LargeCode()');
        if($request->input('page')) {
            $page=$request->input('page');
        }else {
            $page=1;
        }
            //커스텀된 페이지네이션 클래스  변수로는 (현재 페이지번호 ,한 페이지에 보여줄 개수 , 조회된정보)
        $PaginationCustom = new App\Http\Controllers\Render\PaginationCustom($page,10,$historyContents);
        //페이징 정보를 가져옴
        $paginator = $PaginationCustom->getPaging();
        //현재 페이지에서 보여주는 조회 정보 리스트를 가져옴
        $data =$PaginationCustom->getItemsForCurrentPage();
        $searchParams = array( 'searchValue' => $searchValue);
            //대분류 , 중분류 전체일 조건  
        if($WorkLarge=="all"&&$WorkMedium=="all"){
            $searchParams = array( 'searchValue' => $searchValue);
        }
        //대분류 선택, 중분류 전체
        else if($WorkLarge!="all"&&$WorkMedium=="all"){
            $searchParams = array( 'searchValue' => $searchValue,'WorkLarge' => $WorkLarge,'WorkMedium'=>'all');
        }
        //대분류 선택 ,중분류 선택
        else if($WorkLarge!="all"&&$WorkMedium!="all"){
            $searchParams = array( 'searchValue' => $searchValue,'WorkLarge' => $WorkLarge,'WorkMedium' => $WorkMedium);
        }
        
        if($WorkLarge!="all"){
            $usedMedium = DB::select('CALL Common_MediumCode(?)',[$WorkLarge]);
            return view('history.historyListView',compact('data','searchValue','searchParams','WorkLarge','WorkMedium','usedLarge','usedMedium'));
        }else{
            return view('history.historyListView',compact('data','searchValue','searchParams','paginator','WorkLarge','WorkMedium','usedLarge'));
        }
    }
}
