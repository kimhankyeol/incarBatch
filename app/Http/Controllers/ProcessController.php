<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;
class ProcessController extends Controller
{
   //프로세스 리스트 뷰
    public function processListView(){
        return view('index');
    }
   //프로세스 등록 뷰 
    public function processRegisterView(){
        return view('index');
    }
    //프로세스 상세 뷰
    public function processDetailView(Request $request){
        $p_seq = $request->input('p_seq');
        //프로시저를 통한 프로세스 상세정보 검색
        $processDetail=DB::select('CALL processDetail(?)',[$p_seq]);
        return view('index',compact('processDetail'));
    }
    //프로세스 조회 결과
    public function processSearch(Request $request){
        $searchWord = $request ->input('searchWord');
        $msg = "error";

        if($searchWord!=""){
            $processSearchContent = DB::select('CALL searchProcessList(?)',[$searchWord]);
            $page=$request->input('page');
            
            //커스텀된 페이지네이션 클래스  변수로는 (현재 페이지번호 ,한 페이지에 보여줄 개수 , 조회된정보)
            $PaginationCustom = new App\Http\Controllers\Render\PaginationCustom($page,20,$processSearchContent);
            //페이징 정보를 가져옴
            $paginator = $PaginationCustom->getPaging();
            //현재 페이지에서 보여주는 조회 정보 리스트를 가져옴
            $itemsForCurrentPage =$PaginationCustom->getItemsForCurrentPage();
            
            //이 부분은 나중에 jobSearchContent 값이 있는지  없는지 여부를 판단해서 if문 분기 처리 해줘야됨
            $msg="success";

            //페이지 이동시 쿼리스트링에 넣어줄 파라미터
            //라라벨에서 페이지 < 1 2 3 4 5 >  이 부분은 link()로 자동생성 param변수로 page를 기본으로 가지고 있음 
            //url 변수가 추가된다면 array에 담고 jobSearchListView에서 append 해주면됨
            $searchParams = array( 'searchWord' => $searchWord);

            //process/processSearchListView.blade.php 화면반환  
            return view("index",compact('paginator','itemsForCurrentPage','searchWord','searchParams'));
        
        }
       //검색어 없으면 
        else if($searchWord==""){
            return view("index");
        }
        //다른 에러 
        else{
            return view("index");
        }    
    }

}


