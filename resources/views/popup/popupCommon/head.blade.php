<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="/css/custom.css" rel="stylesheet">
  <script type="text/javascript" src="/js/sortable.js"></script>
  <script type="text/javascript" src="/js/jobJS/codeFunc.js"></script>
  <script type="text/javascript" src="/js/jobJS/popupFunc.js"></script>
  <?php
    $titleList = array(
        array('title' => '프로그램 상세', 'url' => '/popup/processInfo'),
        array('title' => '잡-프로그램 구성', 'url' => '/popup/jobGusung')
    );
    foreach ($titleList as $r){
        if($_SERVER['REQUEST_URI']==$r['url']){
            echo '<title>'.$r['title'].'</title>';
        }
    };
?>
</head>