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
            //$processContents = DB::select('CALL searchProcessList(?,?,?)',[$searchWord,$WorkLarge, $WorkMedium]);
            $processContents = DB::select('CALL Process_searchUsedList(?,?,?)',[$searchWord,$WorkLarge,$WorkMedium]);
            $usedLarge = DB::select('CALL Common_LargeCode()');
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
                $usedMedium = DB::select('CALL Common_jobMediumCode(?)',[$WorkLarge]);
                return view('process.processListView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge','usedMedium'));
            }else{
                return view('process.processListView',compact('data','searchWord','searchParams','paginator','WorkLarge','WorkMedium','usedLarge'));
            }
    }
    //프로세스 상세 뷰
    public function processDetailView(Request $request){
        $p_seq = $request->input('P_Seq');
        //프로시저를 통한 프로세스 상세정보 검색
        $processDetail=DB::select('CALL Process_detail(?)',[$p_seq]);
        return view('process.processDetailView',compact('processDetail'));
    }
    //프로세스 등록 뷰
    public function processRegisterView(){
        $searchWord="searchWordNot";
        $WorkLarge="all";
        $WorkMedium="all";
        $usedLarge = DB::select('CALL Job_RegViewLargeCode');
        $db_list = DB::table('OnlineBatch_WorkMediumCode')->where('WorkLarge','3000')->where('Used','1')->get();
        return view('process.processRegisterView',compact('db_list','WorkLarge','WorkMedium','usedLarge'));
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
       
        //고정경로 + 대분류 중분류에 따른 경로(processPath) + 파일(processFile)
        $P_FilePath="/home/incar/work".$processPath."/".$processFile;
        //서버에 해당 경로가 존재하는지, 경로 속에 파일이 있는지
        $fileResult1 = file_exists($P_FilePath); 
        $count = DB::table('OnlineBatch_Process')->where('P_WorkLargeCtg',$WorkLarge)->where('P_WorkMediumCtg',$WorkMedium)->where('P_File',$processFile)->count();
        if($fileResult1){// 경로+파일이 존재하는가?
            if($count==0){
                $last_p_seq = DB::table('OnlineBatch_Process')->insertGetId(
                    ['P_WorkLargeCtg'=>$WorkLarge,
                     'P_WorkMediumCtg'=>$WorkMedium,
                     'P_File'=>$processFile,
                     'P_UseDB'=>$UseDb,
                     'P_ReworkYN'=>$retry,
                     'P_Name' =>$programName,
                     'P_Sulmyung'=>$programExplain,
                     'P_YesangTime'=>$Pro_YesangTime,
                     'P_YesangMaxTime'=>$Pro_YesangMaxTime,
                     'P_Params'=>$proParamType,
                     'P_ParamSulmyungs'=>$proParamSulmyungInput,
                     'P_TextInput'=>$P_TextInput,
                     'P_TextInputCheck'=>$P_TextInputCheck,
                     'P_DevId'=>$P_DevId,
                     'P_RegIp'=>ip2long($P_RegIp),
                     'P_RegId'=>1611699,
                     'P_RegDate'=>now()
                    ]
                );
                return response()->json(array('last_p_seq'=>$last_p_seq, 'fileResult1'=>$fileResult1, 'count'=>$count));//성공
            }else{
                return response()->json(array('count'=>$count));
            }
        }else{
            return response()->json(array('count'=>$count,'fileResult1'=>$fileResult1));
        }
    }
    //프로세스 수정
    public function processEdit(Request $request){
        $p_seq = $request->input('p_seq');
        $P_Name = $request->input('programName');
        $P_Sulmyung = $request->input('programExplain');
        $WorkLarge= $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        $P_ReworkYN=$request->input('retry');
        $P_UseDB=$request->input('UseDb');
        $P_YesangTime=$request->input('Pro_YesangTime');
        $P_YesangMaxTime=$request->input('Pro_YesangMaxTime');
        $P_Params=$request->input('proParamType');
        $P_ParamSulmyungs=$request->input('proParamSulmyungInput');
        $P_UpdIP=$request->input('P_UpdIP');
        $P_UpDate = $request->input('P_UpDate');
        $P_TextInputCheck = $request->input('P_TextInputCheck');
        $P_TextInput=$request->input('P_TextInput');
       
    
        if(intVal($P_TextInputCheck)==1){
            $result = DB::table('incar.OnlineBatch_Process')->where('P_Seq',$p_seq)->update([
                'P_Name'=>$P_Name,
                'P_Sulmyung'=>$P_Sulmyung,
                'P_WorkLargeCtg'=>$WorkLarge,
                'P_WorkMediumCtg'=>$WorkMedium,
                'P_UseDB'=>$P_UseDB,
                'P_ReworkYN'=>$P_ReworkYN,
                'P_YesangTime'=>$P_YesangTime,
                'P_YesangMaxTime'=>$P_YesangMaxTime,
                'P_Params'=>$P_Params,
                'P_ParamSulmyungs'=>$P_ParamSulmyungs,
                'P_UpdIP'=>ip2long($P_UpdIP),
                'P_TextInput'=>$P_TextInput,
                'P_TextInputCheck'=>$P_TextInputCheck
            ]);
        }else if(intVal($P_TextInputCheck)==0){
            $result = DB::table('incar.OnlineBatch_Process')->where('P_Seq',$p_seq)->update([
                'P_Name'=>$P_Name,
                'P_Sulmyung'=>$P_Sulmyung,
                'P_WorkLargeCtg'=>$WorkLarge,
                'P_WorkMediumCtg'=>$WorkMedium,
                'P_UseDB'=>$P_UseDB,
                'P_ReworkYN'=>$P_ReworkYN,
                'P_YesangTime'=>$P_YesangTime,
                'P_YesangMaxTime'=>$P_YesangMaxTime,
                'P_Params'=>$P_Params,
                'P_ParamSulmyungs'=>$P_ParamSulmyungs,
                'P_UpdIP'=>ip2long($P_UpdIP),
                'P_TextInputCheck'=>$P_TextInputCheck
            ]);
        }
        return response()->json(array('result'=>$result,'P_Seq'=>$p_seq));//성공
    }
    //프로세스 등록 수정 뷰
    public function processEditView(Request $request){
        $p_seq = $request->input('P_Seq');
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        $db_list = DB::table('OnlineBatch_WorkMediumCode')->where('WorkLarge','3000')->get();
        //프로시저를 통한 프로세스 상세정보 검색
        $processDetail=DB::select('CALL Process_Detail(?)',[$p_seq]);
        return view('process.processEditView',compact('processDetail','db_list','WorkLarge','WorkMedium'));
    }
}