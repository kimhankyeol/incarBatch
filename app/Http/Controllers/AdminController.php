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
        if($searchWord !=""){
            $data=DB::table('OnlineBatch_CommonCode')->where('OnlineBatch_CommonCode.LongName','like',"%$searchWord%")->paginate(10);
            $searchParams = array( 'searchWord' => $searchWord);
            return view('/admin/commonCodeManageView',compact('data'));
        }else{
            $data=DB::table('OnlineBatch_CommonCode')->paginate(10);
            return view('/admin/commonCodeManageView',compact('data'));
        }
    }

 
    //공통코드 상세 뷰
    public function commonCodeDetailView(Request $request){
        $Codetype = $request->input('Codetype');
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        if($WorkLarge==""&&$WorkMedium==""){
            $WorkMedium="all";
            $commonCodeDetail = DB::table('OnlineBatch_CommonCode')->where('OnlineBatch_CommonCode.Codetype',$Codetype)->where('OnlineBatch_CommonCode.WorkMedium',$WorkMedium)->get();
        }else if($WorkLarge!=""&&$WorkMedium==""){
            $commonCodeDetail = DB::table('OnlineBatch_CommonCode')->where('OnlineBatch_CommonCode.Codetype',$Codetype)->where('OnlineBatch_CommonCode.WorkLarge',$WorkLarge)->get();
        }else if($WorkLarge==""&&$WorkMedium!=""){
            $commonCodeDetail = DB::table('OnlineBatch_CommonCode')->where('OnlineBatch_CommonCode.WorkMedium',$WorkMedium)->get();
        }else if($WorkLarge!=""&&$WorkMedium!=""){
            $commonCodeDetail = DB::table('OnlineBatch_CommonCode')->where('OnlineBatch_CommonCode.Codetype',$Codetype)->where('OnlineBatch_CommonCode.WorkLarge',$WorkLarge)->where('OnlineBatch_CommonCode.WorkMedium',$WorkMedium)->get();
        }

        return view('/admin/commonCodeDetailView',compact('commonCodeDetail'));
    }
    //공통코드 등록 뷰
    public function commonCodeRegisterView(){
        return view('/admin/commonCodeRegisterView');
    }
    //공통코드 등록
    public function commonCodeRegister(Request $request){
        $Codetype = $request->input('Codetype');
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        $CodeShortName = $request->input('CodeShortName');
        $CodeLongName = $request->input('CodeLongName');
        $CodeSulmyung = $request->input('CodeSulmyung');
        $Used = $request->input('Used');
        //코드 중복검사
        $result1 = DB::table('OnlineBatch_CommonCode')->where('OnlineBatch_CommonCode.Codetype',$Codetype)->where('OnlineBatch_CommonCode.WorkLarge',$WorkLarge)->where('OnlineBatch_CommonCode.WorkMedium',$WorkMedium)->count();
        if($result1>0){
            $msg="exist";
            return response()->json(array('msg'=>$msg),200);
        }else if($result1==0){
            $result2 = DB::insert('insert into OnlineBatch_CommonCode(Codetype,WorkLarge,WorkMedium,ShortName,LongName,CodeSulmyung,Used) values(?,?,?,?,?,?,?)',[$Codetype,$WorkLarge,$WorkMedium,$CodeShortName,$CodeLongName,$CodeSulmyung,$Used]);
            if($result2==1){
                $msg="success";
                return response()->json(array('msg'=>$msg),200);
            }else{
                $msg="failed";
                return response()->json(array('msg'=>$msg),200);
            }
        }
        return response()->json(array('msg'=>$msg),200);
    }
    //코드 타입 조회
    public function codeTypeView(Request $request){
        $Codetype = $request->input('Codetype');
        $data=DB::table('OnlineBatch_CommonCode')->where('OnlineBatch_CommonCode.Codetype',$Codetype)->get();
        $returnHTML = view('/admin/commonCodeTypeListView',compact('data'))->render();
        return response()->json(array('returnHTML'=>$returnHTML),200);
    }
    //공통코드 존재유무 조회
    public function commonCodeExist(Request $request){
        $Codetype = $request->input('Codetype');
        $WorkLarge = $request->input('WorkLarge');
        $WorkMedium = $request->input('WorkMedium');
        
        if($WorkLarge==""&&$WorkMedium==""){
            $WorkMedium="all";
            $data = DB::table('OnlineBatch_CommonCode')->where('OnlineBatch_CommonCode.Codetype',$Codetype)->where('OnlineBatch_CommonCode.WorkMedium',$WorkMedium)->get();
        }else if($WorkLarge!=""&&$WorkMedium==""){
            
            $data = DB::table('OnlineBatch_CommonCode')->where('OnlineBatch_CommonCode.Codetype',$Codetype)->where('OnlineBatch_CommonCode.WorkLarge',$WorkLarge)->get();
        }else if($WorkLarge==""&&$WorkMedium!=""){
            $data = DB::table('OnlineBatch_CommonCode')->where('OnlineBatch_CommonCode.WorkMedium',$WorkMedium)->get();
        }else if($WorkLarge!=""&&$WorkMedium!=""){
            $data = DB::table('OnlineBatch_CommonCode')->where('OnlineBatch_CommonCode.Codetype',$Codetype)->where('OnlineBatch_CommonCode.WorkLarge',$WorkLarge)->where('OnlineBatch_CommonCode.WorkMedium',$WorkMedium)->get();
        }
        $returnHTML = view('/admin/commonCodeRegisterSearchListView',compact('data'))->render();
        return response()->json(array('returnHTML'=>$returnHTML),200);
    }
}
