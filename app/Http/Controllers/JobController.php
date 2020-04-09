<?php
/*
@Author 
2020.04.03 김한결 작성
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App;
//정적 메서드를 호출할때 ::   그외 ->
class JobController extends Controller
{
    //모든 view는 index로 연결하고  index.blade.php 에서 화면을 분기해서 렌더링함
    //잡 리스트 뷰 
    public function jobListView(){
        return view('index');
    }
    //잡 등록 뷰
    public function jobRegisterView(){
        return view('index');
    }
    //잡 상세 뷰
    public function jobDetailView(Request $request){
        $job_seq = $request->input('job_seq');
        //프로시저를 통한 잡 상세정보 검색
        $jobDetail=DB::select('CALL jobDetail(?)',[$job_seq]);
        return view('index',compact('jobDetail'));
    }
    //잡 구성 뷰
    public function jobProcessRegisterView(){
        return view('index');
    }
    //잡 실행 뷰  
    public function jobExecuteView(){
        return view('index');
    }

    //잡 조회 검색 
    public function jobSearch(Request $request){
        $searchWord = $request->input('searchWord');
        $msg = "error";
        //검색어 있으면
        if($searchWord!=""){
            //모델이 없이 쓰려면 
            //$jobSearchContent= DB::table('JOB')->where('JOB.job_name','like',"%$searchWord%")->get();
            //프로시저 없이
            //$jobSearchContent= APP\Job::where('job_name','like',"%$searchWord%")->get();
            //프로시저 있다면
            //maria db 에서 프로시저를 생성하고 호출함
            $jobSearchContent = DB::select('CALL searchJobList(?)',[$searchWord]);
            $page=$request->input('page');
            
            //커스텀된 페이지네이션 클래스  변수로는 (현재 페이지번호 ,한 페이지에 보여줄 개수 , 조회된정보)
            $PaginationCustom = new App\Http\Controllers\Render\PaginationCustom($page,30,$jobSearchContent);
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
