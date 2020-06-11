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
        $searchWord = $request -> input('searchWord');
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        if($WorkLarge==""){
            $WorkLarge="all";
        }
        if($WorkMedium==""){
            $WorkMedium="all";
        }
        if($searchWord==""){
            $searchWord="searchWordNot";
        }

        
       
        $PROCESS = new APP\Process;
        $COMMON = new App\Common;
         //프로그램 검색 조회 (전체 포함)
        $processContents = $PROCESS->processSearchUsedList($searchWord,$WorkLarge,$WorkMedium);
        //공통코드 대분류 조회 
        $usedLarge=$COMMON->commonLargeCode();

        $page=$request->input('page');
            //커스텀된 페이지네이션 클래스  변수로는 (현재 페이지번호 ,한 페이지에 보여줄 개수 , 조회된정보)
        $PaginationCustom = new App\Http\Controllers\Render\PaginationCustom($page,10,$processContents);
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
            // 잡, 프로그램용 공통코드 중분류
            $usedMedium=$COMMON->jpCommonMediumCode($WorkLarge);
            return view('process.processListView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge','usedMedium'));
        }else{
            return view('process.processListView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge'));
        }
    }
    //프로세스 상세 뷰
    public function processDetailView(Request $request){
        $p_seq = $request->input('P_Seq');
        $PROCESS = new APP\Process;
        //상세정보 
        $processDetail = $PROCESS->processDetail($p_seq);
        //프로세스 사용 미사용 조회
        $processUsed = $PROCESS->processUsed($p_seq);
       
        if(empty($processUsed)){
            $proUsed = "미사용";
        }else{
            $proUsed = $processUsed[0]->usedtotal == 0 ? "미사용":"사용";
        }
        return view('process.processDetailView',compact('processDetail','proUsed'));
    }
    //프로세스 등록 뷰
    public function processRegisterView(){
        $searchWord="searchWordNot";
        $WorkLarge="all";
        $WorkMedium="all";
        //$usedLarge = DB::select('CALL Job_RegViewLargeCode');
        //잡 , 프로그램 공통코드 사용중인 것만 조회
        $COMMON = new App\Common;
        $usedLarge = $COMMON->usedWorkLarge();
        // $db_list = DB::table('ONLINEBATCH_WORKMEDIUMCODE')->where('WorkLarge','3000')->where('Used','1')->get();
        return view('process.processRegisterView',compact('WorkLarge','WorkMedium','usedLarge'));
    }
    //프로세스 등록 저장
    public function processRegister(Request $request){
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        $processPath = $request->input('processPath');//경로
        $processFile = $request->input('processFile');//파일명
        $UseDb=$request->input('UseDb');
        $retry=$request->input('retry');

        $programName = $request->input('programName');
        $programExplain = $request->input('programExplain');

        $Pro_YesangTime=$request->input('Pro_YesangTime');
        $Pro_YesangMaxTime=$request->input('Pro_YesangMaxTime');

        $proParamType=$request->input('proParamType');
        $proParamSulmyungInput=$request->input('proParamSulmyungInput');
        $P_DevId=$request->input('P_DevId');
        $P_RegIp = $_SERVER["REMOTE_ADDR"];
        $P_TextInputCheck=$request->input('P_TextInputCheck');
        $P_TextInput=$request->input('P_TextInput');
        $P_RegId='1611698';
       
        //고정경로 + 대분류 중분류에 따른 경로(processPath) + 파일(processFile)
        $P_FilePath="/home/incar/work".$processPath."/".$processFile;
        //서버에 해당 경로가 존재하는지, 경로 속에 파일이 있는지
        $fileResult1 = file_exists($P_FilePath); 
        $PROCESS = new APP\Process;
        $count = $PROCESS->processFileDBExist($WorkLarge,$WorkMedium,$processFile);
        if($fileResult1){// 경로+파일이 존재하는가?
            if($count==0){
               $result = $PROCESS ->processInsert($WorkLarge,$WorkMedium,$processFile,$retry,$programName,$programExplain ,$Pro_YesangTime,$Pro_YesangMaxTime,$proParamType,$proParamSulmyungInput,$P_DevId,$P_RegIp,$P_TextInputCheck,$P_TextInput,$P_RegId);
                return response()->json(array('result'=>$result, 'fileResult1'=>$fileResult1, 'count'=>$count));//성공
            }else{
                return response()->json(array('count'=>$count,'fileResult1'=>$fileResult1));
            }
        }else{
            return response()->json(array('count'=>$count,'fileResult1'=>$fileResult1));
        }
    }
    //프로세스 수정
    public function processEdit(Request $request){
        $p_seq = $request->input('p_seq');
        $P_ReworkYN=$request->input('retry');
        // $P_UseDB=$request->input('UseDb');
        $P_YesangTime=$request->input('Pro_YesangTime');
        $P_YesangMaxTime=$request->input('Pro_YesangMaxTime');
        $P_Params=$request->input('proParamType');
        $P_ParamSulmyungs=$request->input('proParamSulmyungInput');
        $P_UpdIP=$request->input('P_UpdIP');
        $P_UpDate = $request->input('P_UpDate');
        $P_TextInputCheck = $request->input('P_TextInputCheck');
        $P_TextInput=$request->input('P_TextInput');
        $P_DeleteYN=$request->input('P_DeleteYN');
        //프로그램이 사용중이면 수정x
        $PROCESS = new APP\Process;
        //프로세스 사용 미사용 조회
        $processUsed = $PROCESS->processUsed($p_seq);
        if(empty($processUsed)){
            $proUsed = "unused";
        }else{
            $proUsed = $processUsed[0]->usedtotal == 0 ? "unused":"used";
            if($proUsed=="used"){
                return response()->json(array('P_Seq'=>$p_seq,'proUsed'=>$proUsed));//성공
            }
        }

        //수정자  ID 넣어야함
        if(intVal($P_TextInputCheck)==1){
            $result = DB::table('ONLINEBATCH_PROCESS')->where('P_SEQ',$p_seq)->update([
                'P_REWORKYN'=>$P_ReworkYN,
                'P_YESANGTIME'=>$P_YesangTime,
                'P_YESANGMAXTIME'=>$P_YesangMaxTime,
                'P_PARAMS'=>$P_Params,
                'P_PARAMSULMYUNGS'=>$P_ParamSulmyungs,
                'P_UPDIP'=>$P_UpdIP,
                'P_UPDDATE'=>now(),
                'P_TEXTINPUT'=>$P_TextInput,
                'P_TEXTINPUTCHECK'=>$P_TextInputCheck
            ]);
        }else if(intVal($P_TextInputCheck)==0){
            $result = DB::table('ONLINEBATCH_PROCESS')->where('P_SEQ',$p_seq)->update([
                'P_REWORKYN'=>$P_ReworkYN,
                'P_YESANGTIME'=>$P_YesangTime,
                'P_YESANGMAXTIME'=>$P_YesangMaxTime,
                'P_PARAMS'=>$P_Params,
                'P_PARAMSULMYUNGS'=>$P_ParamSulmyungs,
                'P_UPDIP'=>$P_UpdIP,
                'P_UPDDATE'=>now(),
                'P_TEXTINPUTCHECK'=>$P_TextInputCheck
            ]);
        }
        
        return response()->json(array('result'=>$result,'P_Seq'=>$p_seq,'proUsed'=>$proUsed));//성공
    }
    //프로세스 등록 수정 뷰
    public function processEditView(Request $request){
        $p_seq = $request->input('P_Seq');
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        // $db_list = DB::table('ONLINEBATCH_WORKMEDIUMCODE')->where('WORKLARGE','3000')->get();
        $PROCESS = new APP\Process;
        //프로세스 상세 조회
        $processDetail=$PROCESS->processDetail($p_seq);
        //프로세스 사용 미사용 조회
        $processUsed=$PROCESS->processUsed($p_seq);
        if(empty($processUsed)){
            $proUsed = "미사용";
        }else{
            $proUsed = $processUsed[0]->usedtotal== 0 ? "미사용":"사용";
        }
        
        return view('process.processEditView',compact('processDetail','WorkLarge','WorkMedium','proUsed'));
    }
}