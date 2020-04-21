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

// 로그인
Route::get('/login', function(){
    return view('/common/login');
});

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
    //프로세스 수정 뷰
    Route::get('/processEditView','ProcessController@processEditView');
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
Route::prefix('popup')->group(function(){
    //프로세스 상세
    Route::get('/processInfo','PopupController@processInfo');
    // 잡 구성
    Route::get('/jobGusung','PopupController@jobGusung');
    // 잡 구성 수정 등록
    Route::post('/jobGusungModify','PopupController@jobGusungModify');
    // 잡 구성 프로세스 리스트 조회
    Route::get('/popupPsSearch','PopupController@popupPsSearch');
    // 잡 실행
    Route::get('/jobAction','PopupController@jobAction');
});




//////////////공통 코드 컨트롤러//////////////
Route::prefix('code')->group(function(){
    //업무 대분류
    Route::get('/workLargeCtg','CodeController@workLargeCtg');
    //업무 중분류
    Route::get('/workMediumCtg','CodeController@workMediumCtg');
    //대분류 중분류 전송
    Route::get('/workDataSelect','CodeController@workDataSelect');
});


////////////관리자 /////////////////////////
Route::prefix('admin')->group(function(){
    //공통코드 관리 뷰
    Route::get('/commonCodeManageView','AdminController@commonCodeManageView');
    //공통코드 상세 뷰
    Route::get('/commonCodeDetailView','AdminController@commonCodeDetailView');
    //공통코드 등록 뷰
    Route::get('/commonCodeRegisterView','AdminController@commonCodeRegisterView');
    //공통코드 등록
    Route::post('/commonCodeRegister','AdminController@commonCodeRegister');
    //공통코드 존재유무 조회 
    Route::get('/commonCodeExist','AdminController@commonCodeExist');
    //공통코드 수정 뷰
    Route::get('/commonCodeUpdateView','AdminController@commonCodeUpdateView');
    //공통코드 수정 
    Route::post('/commonCodeUpdate','AdminController@commonCodeUpdate');
});
