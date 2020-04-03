<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <?php
        $titleList = array(
            array('title' => '잡 등록', 'url' => '/'),
            array('title' => '잡-프로세스 구성', 'url' => '/job/batchProcessRegisterView'),
            array('title' => '프로세스 등록', 'url' => '/process/processRegisterView'),
            array('title' => '잡 실행', 'url' => '/job/batchExecuteView'),
            array('title' => '모니터링', 'url' => '/monitoring/monitoringView'),
            array('title' => '작업내역', 'url' => '/jobHistory/jobHistoryView')
        );
        foreach ($titleList as $r){
            if($_SERVER['REQUEST_URI']==$r['url']){
                echo '<title>'.$r['title'].'</title>';
            }
        };
   ?>

    {{-- 인덱스 공통으로 쓰는 css js--}}
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="/css/custom.css"  rel="stylesheet">
    <script type="text/javascript" src="/vendor/jquery/jquery.js"></script>
    <script type="text/javascript" src="/js/pageMove/pageMove.js"></script>
    {{--모니터링 css js 추가--}}
    {{-- <link rel="stylesheet" type="text/css" href="css/foopicker.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <script type="text/javascript" src="js/foopicker.js"></script> --}}
        {{--나중에는 공통된 css 사용할떄 url 을 배열처리해서 만들어야겠음--}}
    <?php
     $resource = array(
        array('res' => '/css/foopicker.css','url'=>'/monitoring/monitoringView','type'=>'css'),
        array('res' => '/js/foopicker.js','url'=>'/monitoring/monitoringView','type'=>'js'),
        array('res' => '/js/jobJS/jobFunc.js','url'=>'/','type'=>'js'),
     );
     foreach ($resource as $r){
        if($_SERVER['REQUEST_URI']==$r['url']){
            if($r['type']=='css'){
                echo '<link rel="stylesheet" type="text/css" href="'.$r['res'].'">';
            }else{
                echo '<script type="text/javascript" src="'.$r['res'].'"></script>';
            }
        }
     };
    ?>

</head>