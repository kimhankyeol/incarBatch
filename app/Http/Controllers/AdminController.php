<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;

class AdminController extends Controller
{
    //공통코드 대분류 관리
    public function commonCodeLargeManageView(Request $request){
        $searchWord = $request->input('searchWord');
        if($searchWord==""){
            $data=DB::table('ONLINEBATCH_WORKLARGECODE')->orderBy('WORKLARGE')->paginate(10);
        }else{
            $data=DB::table('ONLINEBATCH_WORKLARGECODE')->where('LONGNAME','like',"%$searchWord%")->orderBy('WorkLarge')->paginate(10);
        }
        $page=$request->input('page');
        $searchParams = array( 'searchWord' => $searchWord);
        return view('/admin/commonCodeLargeManageView',compact('data','searchParams','searchWord'));
    }
    //공통코드 중분류 관리
    public function commonCodeMediumManageView(Request $request){
        $searchWord = $request->input('searchWord');
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        $Used = $request->input('Used');

        //프로시저에 공백값이 안들어가서 임의의 값으로 분기처리함
        if($searchWord==""){
            $searchWord="searchWordNot";
        }
        if($WorkLarge==""){
            $WorkLarge="all";
        }
        if($WorkMedium==""){
            $WorkMedium="all";
        }
        if($Used==""){
            $Used="all";
        }
        $COMMON = new App\Common;
        $data=$COMMON->commonCodeMediumManageView($Used,$WorkLarge,$searchWord);
        $usedLarge=$COMMON->commonLargeCode2();
        $page=$request->input('page');
        //커스텀된 페이지네이션 클래스  변수로는 (현재 페이지번호 ,한 페이지에 보여줄 개수 , 조회된정보)
        $PaginationCustom = new App\Http\Controllers\Render\PaginationCustom($page,10,$data);
        //페이징 정보를 가져옴
        $paginator = $PaginationCustom->getPaging();
        //현재 페이지에서 보여주는 조회 정보 리스트를 가져옴
        $data =$PaginationCustom->getItemsForCurrentPage();
        $searchParams = array( 'searchWord' => $searchWord);
        return view('/admin/commonCodeMediumManageView',compact('data','paginator','searchParams','WorkLarge','WorkMedium','searchWord','Used','usedLarge'));
    }
    //공통코드 대분류 상세 뷰
    public function commonCodeLargeDetailView(Request $request){
        $WorkLarge = $request->input('WorkLarge');
        $commonCodeDetail=DB::table('OnlineBatch_WorkLargeCode')->where('WorkLarge',$WorkLarge)->get();
        return view('/admin/commonCodeLargeDetailView',compact('commonCodeDetail'));
    }
 
    //공통코드 중분류 상세 뷰
    public function commonCodeMediumDetailView(Request $request){
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        //프로시저에 공백값이 안들어가서 임의의 값으로 설정 (프로시저 내부에서 분기처리해주는 값)
        $searchWord="searchWordNot";
        if($WorkLarge==""){
            $WorkLarge="all";
        }
        if($WorkMedium==""){
            $WorkMedium="all";
        }
        $COMMON = new App\Common;
        $commonCodeDetail=$COMMON->commonCodeDetail($searchWord,$WorkLarge,$WorkMedium);
        return view('/admin/commonCodeMediumDetailView',compact('commonCodeDetail'));
    }
    //공통코드 대분류 등록 뷰 
     public function commonCodeLargeRegisterView(){
        return view('/admin/commonCodeLargeRegisterView');
    }
    //공통코드 중분류 등록 뷰
    public function commonCodeMediumRegisterView(){
        $workLargeCtgData=DB::table('ONLINEBATCH_WORKLARGECODE')->where('Used','1')->get();
        return view('/admin/commonCodeMediumRegisterView',compact('workLargeCtgData'));
    }
     //공통코드 대분류 등록
    public function commonCodeLargeRegister(Request $request){
        $WorkLarge = $request->input('WorkLarge');
        $CodeShortName = $request->input('CodeShortName');
        $CodeLongName = $request->input('CodeLongName');
        $CodeSulmyung = $request->input('CodeSulmyung');
        $Used = $request->input('Used');
        $COMMON = new App\Common;
        $result1 = DB::table('ONLINEBATCH_WORKLARGECODE')->where('WORKLARGE',$WorkLarge)->count();
      
        if($result1>0){
            $msg="exist";
            return response()->json(array('msg'=>$msg),200);
        }else if($result1==0){
            $result2 = $COMMON->commonLargeCodeRegister($WorkLarge,$CodeShortName,$CodeLongName,$CodeSulmyung,$Used);
            if($result2==1){
                $msg="success";
                return response()->json(array('msg'=>$msg),200);
            }else{
                $msg="failed";
                return response()->json(array('msg'=>$msg),200);
            }
        }
        
    }
    
    //공통코드 중분류 등록
    public function commonCodeMediumRegister(Request $request){
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        $CodeShortName = $request->input('CodeShortName');
        $CodeLongName = $request->input('CodeLongName');
        $CodeSulmyung = $request->input('CodeSulmyung');
        $Used = $request->input('Used');
        $FilePath = $request->input('FilePath');

        $result1 = DB::table('OnlineBatch_WorkMediumCode')->where('OnlineBatch_WorkMediumCode.WorkLarge',$WorkLarge)->where('OnlineBatch_WorkMediumCode.WorkMedium',$WorkMedium)->exists();
        //1.db에 중복되는경로가 있는지 확인하기 위해 2.리눅스서버에서도 판단해야함
        // 2000이상 코드들은 폴더경로를 지정하지 않으므로  FilePath 가 공백
        $COMMON = new App\Common;
        if($FilePath!=""){
            $FolderPathCount = DB::table('OnlineBatch_WorkMediumCode')->where('OnlineBatch_WorkMediumCode.FilePath',$FilePath)->exists();
            if($result1){
                $msg="exist";
            }else{
                if($FolderPathCount){
                    $msg="folderExist";
                }else{
                    $result2 = $COMMON->commonCodeMediumRegister($WorkLarge,$WorkMedium,$CodeShortName,$CodeLongName,$CodeSulmyung,$Used,$FilePath);
                    if($result2==1){
                        $msg="success";
                    }else{
                        $msg="failed";
                    }
                }
            }
        }else{
            if($result1){
                $msg="exist";
            }else{
                $result2 = $COMMON->commonCodeMediumRegister($WorkLarge,$WorkMedium,$CodeShortName,$CodeLongName,$CodeSulmyung,$Used,"");
                if($result2==1){
                    $msg="success";
                }else{
                    $msg="failed";
                }
            } 
        }
        return response()->json(array('msg'=>$msg),200);
    }
    
    //공통코드 대분류 존재유무 조회 
    public function commonCodeLargeExist(Request $request){
        $WorkLarge = $request->input('WorkLarge');
        $COMMON = new App\Common;
        $data = $COMMON->commonLargeCodeExist($WorkLarge);
        $page=$request->input('page');
        if($page==""){
            $page=1;
        }
        $PaginationCustom = new App\Http\Controllers\Render\PaginationCustom($page,5,$data);
        //페이징 정보를 가져옴
        $paginator = $PaginationCustom->getPaging();
        $data = $PaginationCustom->getItemsForCurrentPage();
        $searchParams = array( 'WorkLarge' => $WorkLarge);
        $returnHTML = view('/admin/commonCodeLargeRegisterSearchListView',compact('data','searchParams','paginator'))->render();
        return response()->json(array('returnHTML'=>$returnHTML),200);
    }
    //공통코드 중분류 존재유무 조회
    public function commonCodeExist(Request $request){
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        //프로시저에 공백값이 안들어가서 임의의 값으로 설정(프로시저 내부에서 분기처리할 값)
        $searchWord="searchWordNot";
        if($WorkLarge==""||$WorkLarge=="all"){
            $WorkLarge="all";
        }
        if($WorkMedium==""||$WorkMedium=="all"){
            $WorkMedium="all";
        }
        $COMMON = new App\Common;
        $data=$COMMON->commonCodeDetail($searchWord,$WorkLarge,$WorkMedium);

        $page=$request->input('page');
        if($page==""){
            $page=1;
        }
        //커스텀된 페이지네이션 클래스  변수로는 (현재 페이지번호 ,한 페이지에 보여줄 개수 , 조회된정보)
        $PaginationCustom = new App\Http\Controllers\Render\PaginationCustom($page,5,$data);
        //페이징 정보를 가져옴
        $paginator = $PaginationCustom->getPaging();
        //현재 페이지에서 보여주는 조회 정보 리스트를 가져옴
        $data =$PaginationCustom->getItemsForCurrentPage();
        $searchParams = array( 'WorkLarge' => $WorkLarge,'WorkMedium' => $WorkMedium,'page'=>$page);

        $returnHTML = view('/admin/commonCodeMediumRegisterSearchListView',compact('data','searchParams','paginator'))->render();
        return response()->json(array('returnHTML'=>$returnHTML),200);
    }
    //공통코드 Large 수정 뷰
    public function commonCodeLargeUpdateView(Request $request){
        $WorkLarge = $request->input('WorkLarge');
        $commonCodeDetail=DB::table('ONLINEBATCH_WORKLARGECODE')->where('WORKLARGE',$WorkLarge)->get();
        return view('/admin/commonCodeLargeUpdateView',compact('commonCodeDetail'));
    }
    //공통코드 Medium 수정 뷰
    public function commonCodeMediumUpdateView(Request $request){
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');

        //프로시저에 공백값이 안들어가서 임의의 값으로 설정 (프로시저 내부에서 분기처리해주는 값)
        $searchWord="searchWordNot";
        if($WorkLarge==""){
            $WorkLarge="all";
        }
        if($WorkMedium==""){
            $WorkMedium="all";
        }
        $COMMON = new App\Common;
        $commonCodeDetail=$COMMON->commonCodeDetail($searchWord,$WorkLarge,$WorkMedium);
        return view('/admin/commonCodeMediumUpdateView',compact('commonCodeDetail'));
    }
    //공통코드 대분류 수정
    public function commonCodeLargeUpdate(Request $request){
        $WorkLarge = $request->input('WorkLarge');
        $CodeShortName = $request->input('CodeShortName');
        $CodeLongName = $request->input('CodeLongName');
        $CodeSulmyung = $request->input('CodeSulmyung');
        $Used = $request->input('Used');
        
        $result = DB::table('ONLINEBATCH_WORKLARGECODE')->Where('WORKLARGE',$WorkLarge)->update([
            'SHORTNAME'=>$CodeShortName,
            'LONGNAME'=>$CodeLongName,
            'SULMYUNG'=>$CodeSulmyung,
            'USED'=>$Used
        ]);
        $msg="success";
        if($result==0){
            $msg="failed";
        }else{
            $msg="success";
        }
        return response()->json(array('result'=>$result,'msg'=>$msg),200);
    }

    //공통코드 중분류 수정
    public function commonCodeMediumUpdate(Request $request){
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        $CodeShortName = $request->input('CodeShortName');
        $CodeLongName = $request->input('CodeLongName');
        $CodeSulmyung = $request->input('CodeSulmyung');
        $FilePath = $request->input('FilePath');
        $Used = $request->input('Used');
        
        $result = DB::table('ONLINEBATCH_WORKMEDIUMCODE')->Where('WORKLARGE',$WorkLarge)->Where('WORKMEDIUM',$WorkMedium)->update([
            'SHORTNAME'=>$CodeShortName,
            'LONGNAME'=>$CodeLongName,
            'SULMYUNG'=>$CodeSulmyung,
            'FILEPATH'=>$FilePath,
            'USED'=>$Used
        ]);
        $msg="success";
        if($result==0){
            $msg="failed";
        }else{
            $msg="success";
        }
        return response()->json(array('result'=>$result,'msg'=>$msg),200);
    }
}
