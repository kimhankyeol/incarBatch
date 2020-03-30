<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//잡 등록 뷰
//권한문제 뜨면 
//sudo setsebool -P httpd_can_network_connect_db 1
//웹 / 앱 서버의 SELinux 설정이 잘못 되었기 때문에 문제가 발생했습니다


//잡등록 뷰
Route::get('/', 'JobController@jobRegisterView');
//잡 prefix
Route::prefix('job')->group(function(){
    // //잡등록 뷰
    // Route::get('/registerView', 'JobController@jobRegisterView');
    //잡구성 뷰
    Route::get('/batchProcessRegisterView','JobController@batchProcessRegisterView');
    //잡실행 뷰
    Route::get('/batchExecuteView','JobController@batchExecuteView');
    //잡 검색 조회 비동기
    Route::get('/batchSearch','JobController@batchSearch');
    
});
//프로세스 prefix
Route::prefix('process')->group(function(){
    //프로세스 등록 뷰
    Route::get('/processRegisterView', 'ProcessController@processRegisterView');
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
