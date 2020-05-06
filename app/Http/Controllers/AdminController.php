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
            $data=DB::table('OnlineBatch_WorkLargeCode')->orderBy('WorkLarge')->paginate(10);
        }else{
            $data=DB::table('OnlineBatch_WorkLargeCode')->where('LongName','like',"%$searchWord%")->orderBy('WorkLarge')->paginate(10);
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
        
        $data=DB::select('Call Common_searchUsedList(?,?,?)',[$Used,$WorkLarge,$searchWord]);
        $usedLarge=DB::select('Call Common_LargeCode2()');
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
        $commonCodeDetail=DB::select('CALL Common_codeDetail(?,?,?)',[$searchWord,$WorkLarge,$WorkMedium]);
        return view('/admin/commonCodeMediumDetailView',compact('commonCodeDetail'));
    }
    //공통코드 대분류 등록 뷰 
     public function commonCodeLargeRegisterView(){
        return view('/admin/commonCodeLargeRegisterView');
    }
    //공통코드 중분류 등록 뷰
    public function commonCodeMediumRegisterView(){
        $workLargeCtgData=DB::table('OnlineBatch_WorkLargeCode')->where('Used','1')->get();
        return view('/admin/commonCodeMediumRegisterView',compact('workLargeCtgData'));
    }
     //공통코드 대분류 등록
    public function commonCodeLargeRegister(Request $request){
        $WorkLarge = $request->input('WorkLarge');
        $CodeShortName = $request->input('CodeShortName');
        $CodeLongName = $request->input('CodeLongName');
        $CodeSulmyung = $request->input('CodeSulmyung');
        $Used = $request->input('Used');

        $result1 = DB::table('OnlineBatch_WorkLargeCode')->where('OnlineBatch_WorkLargeCode.WorkLarge',$WorkLarge)->count();
      
        if($result1>0){
            $msg="exist";
            return response()->json(array('msg'=>$msg),200);
        }else if($result1==0){
            $result2 = DB::insert('insert into OnlineBatch_WorkLargeCode(WorkLarge,ShortName,LongName,Sulmyung,Used) values(?,?,?,?,?)',[$WorkLarge,$CodeShortName,$CodeLongName,$CodeSulmyung,$Used]);
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
        if($FilePath!=""){
            $FolderPathCount = DB::table('OnlineBatch_WorkMediumCode')->where('OnlineBatch_WorkMediumCode.FilePath',$FilePath)->exists();
            if($result1){
                $msg="exist";
                
            }else{
                if($FolderPathCount){
                    $msg="folderExist";
                }else{
                    $result2 = DB::insert('insert into OnlineBatch_WorkMediumCode(WorkLarge,WorkMedium,ShortName,LongName,Sulmyung,Used,FilePath) values(?,?,?,?,?,?,?)',[$WorkLarge,$WorkMedium,$CodeShortName,$CodeLongName,$CodeSulmyung,$Used,$FilePath]);
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
                $result2 = DB::insert('insert into OnlineBatch_WorkMediumCode(WorkLarge,WorkMedium,ShortName,LongName,Sulmyung,Used) values(?,?,?,?,?,?)',[$WorkLarge,$WorkMedium,$CodeShortName,$CodeLongName,$CodeSulmyung,$Used]);
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
        if($WorkLarge==""||$WorkLarge=="all"){
            $data=DB::table('OnlineBatch_WorkLargeCode')->orderBy('WorkLarge')->paginate(10);
        }else{
            $data=DB::table('OnlineBatch_WorkLargeCode')->where('WorkLarge','like',"%$WorkLarge%")->orderBy('WorkLarge')->paginate(10);
        }
        $page=$request->input('page');
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
        $data=DB::select('CALL Common_codeDetail(?,?,?)',[$searchWord,$WorkLarge,$WorkMedium]);

        $page=$request->input('page');
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
        $commonCodeDetail=DB::table('OnlineBatch_WorkLargeCode')->where('WorkLarge',$WorkLarge)->get();
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
        $commonCodeDetail=DB::select('CALL Common_codeDetail(?,?,?)',[$searchWord,$WorkLarge,$WorkMedium]);
        return view('/admin/commonCodeMediumUpdateView',compact('commonCodeDetail'));
    }
    //공통코드 대분류 수정
    public function commonCodeLargeUpdate(Request $request){
        $WorkLarge = $request->input('WorkLarge');
        $CodeShortName = $request->input('CodeShortName');
        $CodeLongName = $request->input('CodeLongName');
        $CodeSulmyung = $request->input('CodeSulmyung');
        $Used = $request->input('Used');
        
        $result = DB::table('incar.OnlineBatch_WorkLargeCode')->Where('WorkLarge',$WorkLarge)->update([
            'ShortName'=>$CodeShortName,
            'LongName'=>$CodeLongName,
            'Sulmyung'=>$CodeSulmyung,
            'Used'=>$Used
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
        
        $result = DB::table('incar.OnlineBatch_WorkMediumCode')->Where('WorkLarge',$WorkLarge)->Where('WorkMedium',$WorkMedium)->update([
            'ShortName'=>$CodeShortName,
            'LongName'=>$CodeLongName,
            'Sulmyung'=>$CodeSulmyung,
            'FilePath'=>$FilePath,
            'Used'=>$Used
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
