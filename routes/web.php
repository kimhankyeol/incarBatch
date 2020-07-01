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
Route::get('/kim','AdminController@kim');
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
    // //잡 구성 뷰
    // Route::get('/jobProcessRegisterView','JobController@jobProcessRegisterView');
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
    //스케줄 업데이트
    Route::post('/scheduleDump','ScheduleController@scheduleDump');
    //달력 보기 
    Route::get('/scheduleCalendarView','ScheduleController@scheduleCalendarView');
    //스케줄 ajax  getScheduleInfo
    Route::get('/getScheduleInfo','ScheduleController@getScheduleInfo');
    //스케줄 event 
    Route::get('/getEventInfo','ScheduleController@getEventInfo');
    //텍스트변수수정 모달에서 변경유무 상관없이 취소나 close 버튼 누르면 다시원래의 텍스트 입력정보로 돌아옴  
    Route::get('/pTextInputNotModify','ScheduleController@pTextInputNotModify');

});

//모니터링 prefix
Route::prefix('monitoring')->group(function(){
    //모니터링 뷰
    Route::get('/monitoringView','MonitoringController@monitoringView');
    //모니터링 잡 리스트
    Route::get('/scheduleList','MonitoringController@scheduleList');
    // 모니터링 잡 스케줄 프로세스 리스트
    Route::get('/scheduleProcessList','MonitoringController@scheduleProcessList');
    // 모니터링 잡 스케줄 재작업 체크
    Route::get('/reWorkScheduleChk','MonitoringController@reWorkScheduleChk');
    // 모니터링 잡 스케줄 재작업
    Route::post('/reWorkSchedule','MonitoringController@reWorkSchedule');
});

//히스토리
Route::prefix('history')->group(function(){
    //작업 히스토리 뷰
    Route::get('/historyListView', 'HistoryController@historyListView'); 
    //작업 히스토리 검색리스트
    Route::get('/historySearchList','HistoryController@historySearchList');
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
    // 모니터링 잡 스케줄 프로세스 상세
    Route::get('/processDetailPopup','PopupController@processDetailPopup');
    // 모니터링 잡 스케줄 프로세스 재작업
    Route::get('/reWorkModifi','PopupController@reWorkModifi');
    //스케줄러 -> 잡검색
    Route::get('/jobSearchView','PopupController@jobSearchView');
    //작업내역 -> 작업상세
    Route::get('/historyProcessListPopup','PopupController@historyProcessListPopup');
    //모니터링 로그 팝업
    Route::get('/monitoringLogPopup','PopupController@monitoringLogPopup');
    //모니터링 로그 ajax
    Route::get('/monitoringLogMore','PopupController@monitoringLogMore');
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
