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

//로그인 validationCheck
Route::prefix('/login')->group(function(){
    Route::get('/loginCheck','LoginController@loginCheck');
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
    //잡 로그 추가  tail -n 20  40
    Route::get('/jobTailAdd','ExecuteController@jobTailAdd');
    //잡 수정 뷰
    Route::get('/jobUpdateView','JobController@jobUpdateView');
    //잡 등록 
    Route::post('/jobRegister','JobController@jobRegister');
    //잡 수정 
    Route::post('/jobUpdate','JobController@jobUpdate');
    
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
    //프로세스 수정
    Route::post('/processEdit','ProcessController@processEdit');
});
//스케줄 prefix
Route::prefix('schedule')->group(function(){
    //스케줄 리스트 뷰
    Route::get('/scheduleListView','ScheduleController@scheduleListView');
    //스케줄 등록 뷰
    Route::post('/scheduleRegister','ScheduleController@scheduleRegister');
    //스케줄 등록 
    Route::get('/scheduleRegisterView','ScheduleController@scheduleRegisterView');
    //스케줄 상세 뷰
    Route::get('/scheduleDetailView','ScheduleController@scheduleDetailView');
    //잡 스케줄 선택
    Route::get('/jobselect','ScheduleController@jobselect');
});

//모니터링 prefix
Route::prefix('monitoring')->group(function(){
    //모니터링 뷰
    Route::get('/monitoringView','MonitoringController@monitoringView');
    //모니터링 잡 리스트
    Route::get('/monitorJobSearchList','MonitoringController@monitorJobSearchList');
    // 모니터링 잡 스케줄 리스트
    Route::get('/monitorJobDetailList','MonitoringController@monitorJobDetailList');
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
    Route::get('/jobGusungModify','PopupController@jobGusungModify');
    // 잡 구성 프로세스 리스트 조회
    Route::get('/popupPsSearch','PopupController@popupPsSearch');
    // 잡 실행
    Route::get('/jobAction','PopupController@jobAction');
    // 모니터링 잡 상세
    Route::get('/jobDetailPopup','PopupController@jobDetailPopup');
    // 모니터링 잡 스케줄 상세
    Route::get('/scheduleDetailPopup','PopupController@scheduleDetailPopup');
    //스케줄러 -> 잡검색
    Route::get('/jobSearchView','PopupController@jobSearchView');

});






//////////////공통 코드 컨트롤러//////////////
Route::prefix('code')->group(function(){
    //업무 대분류
    Route::get('/workLargeCtg','CodeController@workLargeCtg');
    //업무 중분류
    Route::get('/workMediumCtg','CodeController@workMediumCtg');
    //업무 중분류 등록 화면
    Route::get('/workMediumCtg2','CodeController@workMediumCtg2');
    //대분류 중분류 전송
    Route::get('/workDataSelect','CodeController@workDataSelect');
});


////////////관리자 /////////////////////////
Route::prefix('admin')->group(function(){
    //공통코드 대분류 관리 뷰
    Route::get('/commonCodeLargeManageView','AdminController@commonCodeLargeManageView');
    //공통코드 중분류 관리 뷰
    Route::get('/commonCodeMediumManageView','AdminController@commonCodeMediumManageView');
    //공통코드 대분류 상세 뷰
    Route::get('/commonCodeLargeDetailView','AdminController@commonCodeLargeDetailView');
    //공통코드 중분류 상세 뷰
    Route::get('/commonCodeMediumDetailView','AdminController@commonCodeMediumDetailView');
    //공통코드 대분류 등록 뷰
    Route::get('/commonCodeLargeRegisterView','AdminController@commonCodeLargeRegisterView');
    //공통코드 중분류 등록 뷰
    Route::get('/commonCodeMediumRegisterView','AdminController@commonCodeMediumRegisterView');
    //공통코드 대분류 등록
    Route::post('/commonCodeLargeRegister','AdminController@commonCodeLargeRegister');
    //공통코드 중분류 등록
    Route::post('/commonCodeMediumRegister','AdminController@commonCodeMediumRegister');
    //공통코드 대분류 수정 뷰 
    Route::get('/commonCodeLargeUpdateView','AdminController@commonCodeLargeUpdateView');
    //공통코드 중분류 수정 뷰
    Route::get('/commonCodeMediumUpdateView','AdminController@commonCodeMediumUpdateView');
    //공통코드 대분류 존재유무 조회 commonCodeLargeExist
    Route::get('/commonCodeLargeExist','AdminController@commonCodeLargeExist');
    //공통코드 중분류 존재유무 조회 
    Route::get('/commonCodeExist','AdminController@commonCodeExist');
    //공통코드 대분류 수정 
    Route::post('/commonCodeLargeUpdate','AdminController@commonCodeLargeUpdate');
    //공통코드 중분류 수정 
    Route::post('/commonCodeMediumUpdate','AdminController@commonCodeMediumUpdate');
});
