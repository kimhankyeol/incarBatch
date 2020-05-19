<?php
/*
Author : 김한결
2020-04-08 페이징커스텀
*/
namespace App\Http\Controllers\Render;
class ifViewRender {
 //멤버변수
    //html 타이틀 보여줄변수
    private $titleInfo;
    //추가되는 리소스를 담은 변수
    private $resourceInfo = array();
    //추가/변경되는 리소스가 없으면 보내는 변수
    private $resourceNull = "";
    //view 정보 리스트  컨트롤러에서 작업이 끝나면 여기에 추가 해줘야됨  화면분기를 해야되기 때문  (비동기식 처리는 따로 진행됨)
    private $viewInfoList = array(
        array('title' => '메인', 'url' => '/'),
        array('title' => '잡 조회', 'url' => '/job/jobListView'),
        array('title' => '잡 상세', 'url' => '/job/jobDetailView'),
        array('title' => '잡 등록', 'url' => '/job/jobRegisterView'),
        array('title' => '프로그램 조회', 'url' => '/process/processListView'),
        array('title' => '프로그램 등록', 'url' => '/process/processRegisterView'),
        array('title' => '프로그램 상세', 'url' => '/process/processDetailView'),
        array('title' => '스케줄 관리', 'url' => '/schedule/scheduleListView'),
        array('title' => '모니터링', 'url' => '/monitoring/monitoringView'),
        array('title' => '작업내역', 'url' => '/history/historyListView')
    );
    //view 마다 추가/변경되는 리소스 관리 
    //url 에 따른 css /js 추가 
    private $resourceArray = array(
        array('res' => '/css/foopicker.css','url'=>'/monitoring/monitoringView','type'=>'css'),
        array('res' => '/js/foopicker.js','url'=>'/monitoring/monitoringView','type'=>'js'),
     );

     //사이드바 링크 배열
    private $sidebarInfo = array(
        //pageMove.js 무관
        array('label' => '잡 등록', 'url' => '/job/jobListView?page=1','icon'=>'fas fa-fw fa-cog'),
        array('label' => '프로그램 등록', 'url' => '/process/processListView?page=1','icon'=>'fas fa-fw fa-cog'),
        array('label' => '스케줄 관리', 'url' => '/schedule/scheduleListView?page=1','icon'=>'fas fa-fw fa-wrench'),
        array('label' => '모니터링', 'url' => '/monitoring/monitoringView','icon'=>'fas fa-fw fa-wrench'),
        array('label' => '작업내역', 'url' => '/history/historyListView','icon'=>'fas fa-fw fa-folder')
    );


//메소드
    public function setRenderInfo($url){
        //  /경로를 제외하고 나머지는 경로(job/jobListView) 와 파일 위치 (job/jogListView) 같음
        // 이 부분은 화면에 필요한 정보들 title, view 네임을 지정해주는 곳임
            //요청마다 타이틀/뷰를 다르게 지정해야되기 때문
            foreach ($this->viewInfoList as $r){
                if(preg_match_all("/".str_replace("/","\\/",$r['url'])."/","/".$url."/")){
                    $this->titleInfo = '<script>document.title="'.$r['title'].'"</script>';
                }
            };
            //이 부분은 화면(요청)에 따라 리소스 추가/변경 해주는 부분
            foreach ($this->resourceArray as $r){
                if(preg_match_all("/".str_replace("/","\\/",$r['url'])."/","/".$url."/")&&$r['url']!=="/"){
                    if($r['type']=='css'){
                        array_push($this->resourceInfo,'<link rel="stylesheet" type="text/css" href="'.$r['res'].'">');
                    }else if($r['type']=='js'){
                        array_push($this->resourceInfo,'<script type="text/javascript" src="'.$r['res'].'"></script>');
                    }
                }
            };
        }
   
    //html title 변경 script 반환
    public function getHtmlTitle(){
        return $this->titleInfo;
    }
    //resource 반환
    public function getResource(){
        //리소스 추가 된게 있으면 
        if(count($this->resourceInfo)!=0){
            return $this->resourceInfo;
        }else{
            return $this->resourceNull;
        }
    }
    //사이드바 배열 반환
    public function getSidebarArray(){
        return $this->sidebarInfo;
    }
}

?>