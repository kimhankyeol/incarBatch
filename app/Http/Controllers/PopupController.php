<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;

class PopupController extends Controller
{
    //팝업- 프로세스 상세
    public function processInfo(){
        return view('/popup/processInfo');
    }
    //팝업- 잡 구성
    public function jobGusung(Request $request){
        $Job_Seq = $request->input('Job_Seq');
        $jobGusungContents = DB::select('CALL getJobGusungList(?)',[$Job_Seq]);
        $jobName = DB::table('OnlineBatch_Job')->where("Job_Seq",$Job_Seq)->get();
        $jobName = $jobName[0]->Job_Name;
        return view('/popup/jobGusung',compact('jobGusungContents','jobName'));
    }
    //팝업- 잡 구성 수정/ 등록
    public function jobGusungModify(Request $request){
        //delyn 으로 할지 삭제 하고 새로구성
        $Job_Seq = $request->input('Job_Seq');
        $P_Seq = $request->input('P_SeqArr');

        $gusungCount = DB::table('OnlineBatch_JobGusung')->where('Job_Seq',$Job_Seq);
        $gusungCount = $gusungCount->count();

        //프로세스 및 작업이 실행중인지 아닌지
        //잡구성버전
        
        // 1 || 2 || 3
        $P_SeqArr = explode("||",$P_Seq);
        $P_SeqCount =count($P_SeqArr);
        if($gusungCount==0){
            for($i = 0; $i<$P_SeqCount;$i++){
                DB::table('OnlineBatch_JobGusung')->insert(['Job_Seq'=>$Job_Seq,'P_Seq'=>$P_SeqArr[$i],'JobGusung_Order'=>$i+1]);
            }
        }else{
            DB::table('OnlineBatch_JobGusung')->where('Job_Seq',$Job_Seq)->delete();
            for($i = 0; $i<$P_SeqCount;$i++){
                DB::table('OnlineBatch_JobGusung')->insert(['Job_Seq'=>$Job_Seq,'P_Seq'=>$P_SeqArr[$i],'JobGusung_Order'=>$i+1]);
            }
        }
        return response()->json(array('P_SeqArr'=>$P_SeqCount,200));
    }
    //팝업 프로세스 검색조회
    public function popupPsSearch(Request $request){
        $searchWord = $request->input('searchWord');
        $workLargeCtg = $request->input('workLargeCtg');
        $workMediumCtg = $request->input('workMediumCtg');

         //이렇게 할거면 프로시저에서 if 문으로 쿼리 따로주자
        $processContents = DB::select('CALL searchProcessList(?,?,?)',[$searchWord,$workLargeCtg, $workMediumCtg]);
        $page=$request->input('page');
        //커스텀된 페이지네이션 클래스  변수로는 (현재 페이지번호 ,한 페이지에 보여줄 개수 , 조회된정보)
        $PaginationCustom = new App\Http\Controllers\Render\PaginationCustom($page,10,$processContents);
        // //페이징 정보를 가져옴
        $paginator = $PaginationCustom->getPaging();
        // //현재 페이지에서 보여주는 조회 정보 리스트를 가져옴
        $dataSearch =$PaginationCustom->getItemsForCurrentPage();
        $searchParams = array( 'searchWord' => $searchWord);
        //대분류 , 중분류 전체일 조건  
        if($workLargeCtg=="all"&&$workMediumCtg=="all"){
            $searchParams = array( 'searchWord' => $searchWord);
        }
        //대분류 선택, 중분류 전체
        else if($workLargeCtg!="all"&&$workMediumCtg=="all"){
            $searchParams = array( 'searchWord' => $searchWord,'workLargeCtg' => $workLargeCtg,'workMediumCtg'=>'all');
        }
        //대분류 선택 ,중분류 선택
        else if($workLargeCtg!="all"&&$workMediumCtg!="all"){
            $searchParams = array( 'searchWord' => $searchWord,'workLargeCtg' => $workLargeCtg,'workMediumCtg' => $workMediumCtg);
        }
        $returnHTML = view('popup.processSearchList',compact('dataSearch','searchWord','searchParams','paginator'))->render();

        return response()->json(array('returnHTML'=>$returnHTML,200));
    }
    
    //팝업- 잡 실행
    public function jobAction(){
        return view('/popup/jobAction');
    }
}
