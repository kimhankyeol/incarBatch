  {{--include 의 경로는 public/resource/view/부터 시작함--}}
{{-- head 부분 --}}
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- 인덱스 공통으로 쓰는 css js--}}
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="/css/custom.css"  rel="stylesheet">
    <script type="text/javascript" src="/vendor/jquery/jquery.js"></script>
    <script type="text/javascript" src="/js/pageMove/pageMove.js"></script>
    <script type="text/javascript" src="/js/jobJS/jobFunc.js"></script>
    <script type="text/javascript" src="/js/jobJS/proFunc.js"></script>
    <script type="text/javascript" src="/js/jobJS/codeFunc.js"></script>
    <?php
    //index.blade 에서 선언한 ifViewRender 에서 가져온 title 변경 script 
    echo $titleInfo;
    //index.blade 에서 선언한 ifViewRender 에서 가져온 리소스 정보
    if($resourceInfo!=""){
        foreach ($resourceInfo as $r){
          echo $r;
        };
    }else{
        echo $resourceInfo;
    }

    ?>
</head>
