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
        $workLargeCtg = $request->input('workLargeCtg');
        $workMediumCtg = $request->input('workMediumCtg');
        if($searchWord==""){
            $searchWord="searchWordNot";
        }
            //이렇게 할거면 프로시저에서 if 문으로 쿼리 따로주자
            // $data=DB::table('OnlineBatch_Job')->where('OnlineBatch_Job.Job_Name','like',"%$searchWord%")->paginate(10);
            $processContents = DB::select('CALL searchProcessList(?,?,?)',[$searchWord,$workLargeCtg, $workMediumCtg]);
            $page=$request->input('page');
                //커스텀된 페이지네이션 클래스  변수로는 (현재 페이지번호 ,한 페이지에 보여줄 개수 , 조회된정보)
            $PaginationCustom = new App\Http\Controllers\Render\PaginationCustom($page,10,$processContents);
            //페이징 정보를 가져옴
            $paginator = $PaginationCustom->getPaging();
            //현재 페이지에서 보여주는 조회 정보 리스트를 가져옴
            $data =$PaginationCustom->getItemsForCurrentPage();
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
            return view('process.processListView',compact('data','searchWord','searchParams','paginator'));
    }
    //프로세스 상세 뷰
    public function processDetailView(Request $request){
        $p_seq = $request->input('P_Seq');
        //프로시저를 통한 프로세스 상세정보 검색
        $processDetail=DB::select('CALL processDetail(?)',[$p_seq]);
        return view('process.processDetailView',compact('processDetail'));
    }
    //프로세스 등록 뷰
    public function processRegisterView(){
        $db_list = DB::table('OnlineBatch_CommonCode')->where('Codetype','=','C')->get();
        return view('process.processRegisterView',compact('db_list'));
    }
    //프로세스 등록 저장
    public function processRegister(Request $request){
        $id1 = $request->input('id1');//경로
        $id2 = $request->input('id2');//파일명
        $programName = $request->input('programName');
        $programExplain = $request->input('programExplain');
        //대분류 중분류
        $workLargeCtg = $request->input('workLargeCtg');
        $workMediumCtg = $request->input('workMediumCtg');
        $retry=$request->input('retry');
        $UseDb=$request->input('UseDb');
        $Pro_YesangTime=$request->input('Pro_YesangTime');
        $Pro_YesangMaxTime=$request->input('Pro_YesangMaxTime');
        $proParamType=$request->input('proParamType');
        $proParamSulmyungInput=$request->input('proParamSulmyungInput');
        $P_RegId = $request->input('P_RegId');
        //고정경로 + 대분류 중분류에 따른 경로(id1) + 파일(id2)
        $P_FilePath="/home/incar/work".$id1."/".$id2;
        //서버에 해당 경로가 존재하는지, 경로 속에 파일이 있는지
        $fileResult1 = file_exists($P_FilePath); 
        $count = DB::table('OnlineBatch_Process')->where('P_WorkLargeCtg',$workLargeCtg)->where('P_WorkMediumCtg',$workMediumCtg)->where('P_File',$id2)->count();
        if($fileResult1){// 경로+파일이 존재하는가?
            if($count==0){
                $last_p_seq = DB::table('OnlineBatch_Process')->insertGetId(
                    ['P_Name' =>$programName,
                    'P_RegId'=>$P_RegId,
                    'P_Sulmyung'=>$programExplain,
                    //대분류, 중분류 저장
                    'P_WorkLargeCtg'=>$workLargeCtg,
                    'P_WorkMediumCtg'=>$workMediumCtg,
                    //파일명 저장
                    'P_File'=>$id2,
                    'P_ReworkYN'=>$retry,
                    'P_UseDB'=>$UseDb,
                    'P_YesangTime'=>$Pro_YesangTime,
                    'P_YesangMaxTime'=>$Pro_YesangMaxTime,
                    'P_Params'=>$proParamType,
                    'P_ParamSulmyungs'=>$proParamSulmyungInput]
                );
                return response()->json(array('last_p_seq'=>$last_p_seq, 'fileResult1'=>$fileResult1, 'count'=>$count));//성공
            }else{
                return response()->json(array('count'=>$count));
            }
        }else{
            return response()->json(array('count'=>$count,'fileResult1'=>$fileResult1));
        }
    }
    //프로세스 등록 수정 뷰
    public function processEditView(Request $request){
        $p_seq = $request->input('P_Seq');
        $Codetype="B";
        //프로시저를 통한 프로세스 상세정보 검색
        $processDetail=DB::select('CALL processDetail(?,?)',[$p_seq,$Codetype]);
        return view('process.processEditView',compact('processDetail'));
    }
}