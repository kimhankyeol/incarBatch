<!DOCTYPE html>
<html lang="en">
@include('common.head')
<body class="bg-gradient-primary">
    <div class="container info-popup">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">온라인 배치 프로그램</h1>
                                    </div>
                                    <form class="user">
                                        <div class="form-group">
                                            <input id="USER_SAWONNUM" type="text" class="form-control form-control-user" aria-describedby="emailHelp" placeholder="사원번호">
                                        </div>
                                        <div class="form-group">
                                            <input id="USER_PASSWORD" type="password" class="form-control form-control-user" placeholder="비밀번호">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">아이디 저장</label>
                                            </div>
                                        </div>
                                    <button type="button" class="btn btn-primary btn-user btn-block" onclick="login.loginCheck()">로그인</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>