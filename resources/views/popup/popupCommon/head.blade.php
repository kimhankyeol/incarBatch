
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    {{-- <link href="/css/custom.css" rel="stylesheet"> --}}
    <?php
    $titleList = array(
        array('title' => '배치 검색', 'url' => '/popup/searchBatchPopup'),
        array('title' => '프로세스 검색', 'url' => '/popup/searchProcessPopup'),
        array('title' => '배치 상세', 'url' => '/popup/batchDetailInfoPopup'),
        array('title' => '프로세스 상세', 'url' => '/popup/batchDetailInfoPopup'),
    );
    foreach ($titleList as $r){
        if($_SERVER['REQUEST_URI']==$r['url']){
            echo '<title>'.$r['title'].'</title>';
        }
    };
?>
</head>