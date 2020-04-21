<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;

class AdminController extends Controller
{
    //공통코드 관리
    public function commonCodeManageView(Request $request){
        $searchWord = $request->input('searchWord');
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
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
        $data=DB::select('CALL getCommonCode(?,?,?)',[$searchWord,$WorkLarge,$WorkMedium]);
        $page=$request->input('page');
        //커스텀된 페이지네이션 클래스  변수로는 (현재 페이지번호 ,한 페이지에 보여줄 개수 , 조회된정보)
        $PaginationCustom = new App\Http\Controllers\Render\PaginationCustom($page,10,$data);
        //페이징 정보를 가져옴
        $paginator = $PaginationCustom->getPaging();
        //현재 페이지에서 보여주는 조회 정보 리스트를 가져옴
        $data =$PaginationCustom->getItemsForCurrentPage();
        $searchParams = array( 'searchWord' => $searchWord);
        return view('/admin/commonCodeManageView',compact('data','searchParams','paginator','searchWord'));
    }
 
    //공통코드 상세 뷰
    public function commonCodeDetailView(Request $request){
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
        $commonCodeDetail=DB::select('CALL getCommonCode(?,?,?)',[$searchWord,$WorkLarge,$WorkMedium]);

        return view('/admin/commonCodeDetailView',compact('commonCodeDetail'));
    }
    //공통코드 등록 뷰
    public function commonCodeRegisterView(){
        return view('/admin/commonCodeRegisterView');
    }
    //공통코드 등록
    public function commonCodeRegister(Request $request){
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        $CodeShortName = $request->input('CodeShortName');
        $CodeLongName = $request->input('CodeLongName');
        $CodeSulmyung = $request->input('CodeSulmyung');
        $Used = $request->input('Used');
        $FilePath = $request->input('FilePath');

        $result1 = DB::table('OnlineBatch_WorkMediumCode')->where('OnlineBatch_WorkMediumCode.WorkLarge',$WorkLarge)->where('OnlineBatch_WorkMediumCode.WorkMedium',$WorkMedium)->count();
        //1.db에 중복되는경로가 있는지 확인하기 위해 2.리눅스서버에서도 판단해야함
        $FolderPathCount = DB::table('OnlineBatch_WorkMediumCode')->where('OnlineBatch_WorkMediumCode.FilePath',$FilePath)->count();

        if($result1>0){
            $msg="exist";
            return response()->json(array('msg'=>$msg),200);
        }else if($result1==0){
            if($FolderPathCount>0){
                $msg="folderExist";
                return response()->json(array('msg'=>$msg),200);
            }else if($FolderPathCount=0){
                $result2 = DB::insert('insert into OnlineBatch_WorkMediumCode(WorkLarge,WorkMedium,ShortName,LongName,Sulmyung,Used,FilePath) values(?,?,?,?,?,?,?)',[$WorkLarge,$WorkMedium,$CodeShortName,$CodeLongName,$CodeSulmyung,$Used,$FilePath]);
                if($result2==1){
                    $msg="success";
                    return response()->json(array('msg'=>$msg),200);
                }else{
                    $msg="failed";
                    return response()->json(array('msg'=>$msg),200);
                }
            }
        }
        
    }
    //공통코드 존재유무 조회
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
        $data=DB::select('CALL getCommonCode(?,?,?)',[$searchWord,$WorkLarge,$WorkMedium]);

        $page=$request->input('page');
        //커스텀된 페이지네이션 클래스  변수로는 (현재 페이지번호 ,한 페이지에 보여줄 개수 , 조회된정보)
        $PaginationCustom = new App\Http\Controllers\Render\PaginationCustom($page,5,$data);
        //페이징 정보를 가져옴
        $paginator = $PaginationCustom->getPaging();
        //현재 페이지에서 보여주는 조회 정보 리스트를 가져옴
        $data =$PaginationCustom->getItemsForCurrentPage();
        $searchParams = array( 'WorkLarge' => $WorkLarge,'WorkMedium' => $WorkMedium,'page'=>$page);

        $returnHTML = view('/admin/commonCodeRegisterSearchListView',compact('data','searchParams','paginator'))->render();
        return response()->json(array('returnHTML'=>$returnHTML),200);
    }
     //공통코드 수정 뷰
     public function commonCodeUpdateView(Request $request){
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
        $commonCodeDetail=DB::select('CALL getCommonCode(?,?,?)',[$searchWord,$WorkLarge,$WorkMedium]);
        return view('/admin/commonCodeUpdateView',compact('commonCodeDetail'));
    }

    //공통코드 수정
    public function commonCodeUpdate(Request $request){
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
        

        return response()->json(array('result'=>$result),200);
        
    }
}
