<?php
namespace App\Http\Controllers\Render;
class PaginationCustom{


    //인스턴스를 생성할 때 해야 할 작업을 담아두는 약속된 메소드가 __construct 
    function __construct($page,$paginate,$searchContent,$itemsForCurrentPage=array()){
        //현재 페이지번호
        $this->page = $page;
        //한페이지에서 보여줘야 되는 개수
        $this->paginate = $paginate;
        //조회된 리스트
        $this->searchContent = $searchContent;
        //현재 페이지에서 보여주는 조회 정보 리스트
        $this->itemsForCurrentPage = $itemsForCurrentPage;
      
    }

    //페이징 정보를 가져옴
    public function getPaging(){
        $offset=($this->page * $this->paginate)-$this->paginate;
        $this->itemsForCurrentPage=array_slice( $this->searchContent, $offset,  $this->paginate, true); 
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator( $this->itemsForCurrentPage, count( $this->searchContent), $this->paginate,  $this->page); 
        return $paginator;
    }
     //현재 페이지에서 보여주는 조회 정보 리스트를 가져옴
    public function getItemsForCurrentPage(){
        return  $this->itemsForCurrentPage;
    }
}
?>