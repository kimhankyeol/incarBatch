<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

//권한문제 뜨면 
//sudo setsebool -P httpd_can_network_connect_db 1
//웹 / 앱 서버의 SELinux 설정이 잘못 되었기 때문에 문제가 발생했습니다


Route::get('/', 'JobController@index');

//잡 prefix
Route::prefix('job')->group(function(){
    //잡리스트 뷰
    Route::get('/jobListView', 'JobController@jobListView');
    //잡 등록 뷰
    Route::get('/jobRegisterView', 'JobController@jobRegisterView');
    //잡 구성 뷰
    Route::get('/jobProcessRegisterView','JobController@jobProcessRegisterView');
    //잡 상세 뷰
    Route::get('/jobDetailView','JobController@jobDetailView');
    //잡 실행 뷰
    Route::get('/jobExecuteView','JobController@jobExecuteView');
    //잡 등록 
    Route::post('/jobRegister','JobController@jobRegister');
    
});
//프로세스 prefix
Route::prefix('process')->group(function(){
    //프로세스 리스트 뷰
    Route::get('/processListView', 'ProcessController@processListView');
    //프로세스 등록 뷰
    Route::get('/processRegisterView', 'ProcessController@processRegisterView');
    //프로세스 상세 뷰
    Route::get('/processDetailView','ProcessController@processDetailView');
    //프로세스 등록
    Route::post('/processRegister','ProcessController@processRegister');
});

//모니터링 prefix
Route::prefix('monitoring')->group(function(){
    //모니터링 뷰
    Route::get('/monitoringView','MonitoringController@monitoringView');
});

//작업 히스토리 prefix
Route::prefix('jobHistory')->group(function(){
    //작업 히스토리 뷰
    Route::get('/jobHistoryView', 'JobHistoryController@jobHistoryView'); 
});


////////////팝업///////////////////////////////////////
//배치 검색
Route::get('/popup/searchBatchPopup',function(){
    return view('/popup/popupMain');
});
//프로세스 검색 
Route::get('/popup/searchProcessPopup',function(){
    return view('/popup/popupMain');
});
//배치 실행 상세
Route::get('/popup/batchDetailInfoPopup',function(){
    return view('/popup/popupMain');
});
//프로세스 상세
Route::get('/popup/processDetailInfoPopup',function(){
    return view('/popup/popupMain');
});
