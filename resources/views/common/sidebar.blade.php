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
     //index.blade 에서 선언한 ifViewRender 에서 가져온 사이드바 정보
    foreach ($sidebarInfo as $r){
        $r['active']= ($_SERVER['REQUEST_URI'] == $r['url'])? 'nav-item active':'nav-item';
        echo '<li class="'.$r['active'].'"> <a class="nav-link" href="'.$r['url'].'"><i class="'.$r['icon'].'"></i><span>'.$r['label'].'</span></a></li>';
    };
    ?>
</ul>
