<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
    <img class="incar" src="/img/logo.png" alt="" style = "height: 50px; width: auto;">
    </a>
    <hr class="sidebar-divider my-0">
    {{--사이드바 배열로 돌리기 위해서 array 안에 array 이중으로 --}}
    {{--$_SERVER['REQUEST_URI']  요청경로 확인--}}
    {{--foreach문은 배열에 입력한 순서대로 나옴--}}
    {{--for문은 1,2,3,4 인덱스 순으로 나옴 --}}
    <?php
    // print($_SERVER['REQUEST_URI'] );
    $links = array(
        //batchRegisterView
        array('label' => '잡 등록', 'url' => '/','icon'=>'fas fa-fw fa-cog'),
        array('label' => '프로세스 등록', 'url' => '/process/processRegisterView','icon'=>'fas fa-fw fa-cog'),
        array('label' => '잡 구성', 'url' => '/job/batchProcessRegisterView','icon'=>'fas fa-fw fa-cog'),
        array('label' => '잡 실행', 'url' => '/job/batchExecuteView','icon'=>'fas fa-fw fa-wrench'),
        array('label' => '모니터링', 'url' => '/monitoring/monitoringView','icon'=>'fas fa-fw fa-wrench'),
        array('label' => '작업내역', 'url' => '/jobHistory/jobHistoryView','icon'=>'fas fa-fw fa-folder')
    );
    foreach ($links as $r){
        $r['active']= ($_SERVER['REQUEST_URI'] == $r['url'])? 'nav-item active':'nav-item';
        echo '<li class="'.$r['active'].'"> <a class="nav-link" href="'.$r['url'].'"><i class="'.$r['icon'].'"></i><span>'.$r['label'].'</span></a></li>';
    };
    ?>
</ul>
