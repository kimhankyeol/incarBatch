<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;
use Monolog\Handler\PHPConsoleHandler;

class PopupController extends Controller
{
    //팝업- 프로세스 상세
    public function processInfo(){
        return view('/popup/processInfo');
    }
    //팝업- 잡 구성 (수정필요)
    public function jobGusung(Request $request){
        $Job_Seq = $request->input('Job_Seq');
        $jobGusungContents = DB::select('CALL getJobGusungList(?)',[$Job_Seq]);
        $jobDetail = DB::select('CALL Job_detail(?)',[$Job_Seq]);
        $jobName = DB::table('OnlineBatch_Job')->where("Job_Seq",$Job_Seq)->get();
        $jobName = $jobName[0]->Job_Name;
        return view('/popup/jobGusung',compact('jobGusungContents','jobName','jobDetail'));
    }
    //팝업- 잡 구성 수정/ 등록
    public function jobGusungModify(Request $request){
        $Job_Seq = $request->input('Job_Seq');
        $gusungProcess = $request->input('gusungProcess');
        $gusungData = $request->input('gusungData');

        $gusungCount = DB::table('OnlineBatch_JobGusung')->where('Job_Seq',$Job_Seq);
        $gusungCount = $gusungCount->count();

        if($gusungCount!=0){
            DB::table('OnlineBatch_JobGusung')->where('Job_Seq',$Job_Seq)->delete();
        }
        for($i = 0; $i<count($gusungProcess);$i++){
            DB::table('OnlineBatch_JobGusung')->insert(['Job_Seq'=>$Job_Seq,'P_Seq'=>$gusungProcess[$i],'JobGusung_Order'=>$i+1,'JobGusung_ParamPos'=>$gusungData[$i]]);
        }
        //return response()->json(array('Job_Seq'=>$Job_Seq,'gusungData'=>$gusungData,'gusungProcess'=>count($gusungProcess),'gusungCount'=>$gusungCount,200)); 
        return response()->json(array('count'=>count($gusungProcess),200));
    }
    //팝업 프로세스 검색조회
    public function popupPsSearch(Request $request){
        $searchWord = $request -> input('searchWord');
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
        //이렇게 할거면 프로시저에서 if 문으로 쿼리 따로주자
        // $data=DB::table('OnlineBatch_Job')->where('OnlineBatch_Job.Job_Name','like',"%$searchWord%")->paginate(10);
        $processContents = DB::select('CALL Process_searchUsedList(?,?,?)',[$searchWord,$WorkLarge, $WorkMedium]);
        $page=$request->input('page');
            //커스텀된 페이지네이션 클래스  변수로는 (현재 페이지번호 ,한 페이지에 보여줄 개수 , 조회된정보)
        $PaginationCustom = new App\Http\Controllers\Render\PaginationCustom($page,5,$processContents);
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
        $returnHTML = view('/popup/gusungProcessSearchListView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium'))->render();

        return response()->json(array('returnHTML'=>$returnHTML,200));
        //return $data;

    }
    
    //팝업- 잡 실행
    public function jobAction(){
        return view('/popup/jobAction');
    }
}