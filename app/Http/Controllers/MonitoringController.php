<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;
class MonitoringController extends Controller
{
    function monitoringView(Request $request){
        $searchWord = $request->input('searchWord');
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        if($searchWord==""){
            $searchWord="searchWordNot";
        }
        if($WorkLarge==""){
            $WorkLarge="all";
        }
        if($WorkMedium==""){
            $WorkMedium="all";
        }
         // 사용중인 것만 조회
         $MonitorContents = DB::select('CALL Monitor_searchList(?,?,?,?,?)',[$searchWord,$WorkLarge,$WorkMedium,$startDate,$endDate]);
         $usedLarge = DB::select('CALL Common_LargeCode()');
         $page=$request->input('page');
         //커스텀된 페이지네이션 클래스  변수로는 (현재 페이지번호 ,한 페이지에 보여줄 개수 , 조회된정보)
         $PaginationCustom = new App\Http\Controllers\Render\PaginationCustom($page,5,$MonitorContents);
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
         //등록일 시작선택, 끝 미선택
         if($startDate!=""&&$endDate==""){
             $searchDate = array( 'startDate' => $startDate,'endDate' => $endDate);
         }
         //등록일 시작선택, 끝 미선택
         else if($startDate!=""&&$endDate!=""){
             $searchDate = array( 'startDate' => $startDate,'endDate' => $endDate);
         }
         if($WorkLarge!="all"){
             $usedMedium = DB::select('CALL Common_MediumCode(?)',[$WorkLarge]);
             return view('/monitoring/monitoringView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge','usedMedium','searchDate'));
         }else{
             return view('/monitoring/monitoringView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge','searchDate'));
         }
    }
    function monitoringSearchList(Request $request){
        $searchWord = $request->input('searchWord');
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        if($searchWord==""){
            $searchWord="searchWordNot";
        }
        if($WorkLarge==""){
            $WorkLarge="all";
        }
        if($WorkMedium==""){
            $WorkMedium="all";
        }
        if($startDate==""){
            $startDate=null;
        }
        if($endDate==""){
            $endDate=null;
        }
         // 사용중인 것만 조회
         $MonitorContents = DB::select('CALL Monitor_searchList(?,?,?,?,?)',[$searchWord,$WorkLarge,$WorkMedium,$startDate,$endDate]);
         $usedLarge = DB::select('CALL Common_LargeCode()');
         $page=$request->input('page');
         //커스텀된 페이지네이션 클래스  변수로는 (현재 페이지번호 ,한 페이지에 보여줄 개수 , 조회된정보)
         $PaginationCustom = new App\Http\Controllers\Render\PaginationCustom($page,10,$MonitorContents);
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
         //등록일 시작선택, 끝 미선택
         if($startDate!=""&&$endDate==""){
             $searchDate = array( 'startDate' => $startDate,'endDate' => $endDate);
         }
         //등록일 시작선택, 끝 미선택
         else if($startDate!=""&&$endDate!=""){
             $searchDate = array( 'startDate' => $startDate,'endDate' => $endDate);
         }
         if($WorkLarge!="all"){
             $usedMedium = DB::select('CALL Common_MediumCode(?)',[$WorkLarge]);
             $returnHTML = view('/monitoring/monitorJobSearchList',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge','usedMedium','searchDate'))->render();
         }else{
             $returnHTML = view('/monitoring/monitorJobSearchList',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge','searchDate'))->render();
         }
         return response()->json(array('returnHTML'=>$returnHTML),200);
    }
    function monitoringGusungList(Request $request){
        $Job_Seq = $request->input('Job_Seq');
        $Version = $request->input('Version');
        $GusungList = DB::select('CALL Monitor_gusungList(?,?)',[$Job_Seq,$Version]);
        $returnHTML = view('/monitoring/monitorGusungSearchList',compact('GusungList'))->render();

        return response()->json(array('returnHTML'=>$returnHTML,200));
    }
}