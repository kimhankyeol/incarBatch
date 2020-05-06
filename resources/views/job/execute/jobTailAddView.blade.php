<div style="display: flex; justify-content: space-between;">
    <h6 class = "m-0 font-weight-bold text-primary" style="padding:0rem 1.25rem">로그</h6>
    <div class="custom-control font-weight-bold text-primary"> @if(isset($fileSize)) 로그 크기:  @if(round($fileSize/1024/1024,2)>1) {{round($fileSize/1024/1024,2)}} MB @else 1 MB 이하 @endIf @endIf</div>
<h6 class = "m-0 font-weight-bold text-primary" style="padding:0rem 1.25rem">
    @if($msg=="success")
        <div style="display:flex">
            <div class="custom-control custom-checkbox">
                {{-- # 로그 set num 라인에 숫자 찍는거 setNum  @if($setNum==1) ? value="1" : value="0" @endIf--}}
                <input id="setNum" type="checkbox" class="custom-control-input"  @if($setNum==1) ? value="1" checked : value="0" @endIf >
                <label class="custom-control-label font-weight-bold text-primary" for="setNum">라인 숫자 출력</label>
            </div> 
            <div class="custom-control">
                로그 라인 수 <input id="lineNum" type="text" class=" bg-light border-primary" numberonly value="{{$line}}"> / {{$lineTotal}} 
            </div>
            <div class="custom-control">
                <div class="btn btn-primary" onclick="tailAddSearch()">
                    <i class="fas fa-search fa-sm"></i>
                </div>
            </div>
        </div>
    {{-- 조회된값이 라인 토탈값을 넘었을때 --}}
    @elseif($msg=="lineExcess")
        <div style="display:flex">
            <div class="custom-control custom-checkbox">
                {{-- # 로그 set num 라인에 숫자 찍는거 setNum  @if($setNum==1) ? value="1" : value="0" @endIf--}}
                <input id="setNum" type="checkbox" class="custom-control-input"  @if($setNum==1) ? value="1" checked : value="0" @endIf >
                <label class="custom-control-label font-weight-bold text-primary" for="setNum">라인 숫자 출력</label>
            </div> 
            <div class="custom-control">
                로그 라인 수 <input id="lineNum" type="text" class=" bg-light border-primary" numberonly value="{{$lineTotal}}"> / {{$lineTotal}} 
            </div>
            <div class="custom-control">
                <div class="btn btn-primary" onclick="tailAddSearch()">
                    <i class="fas fa-search fa-sm"></i>
                </div>
            </div>
        </div>
    @endIf
</h6>
</div>
<textarea class = "Job_logarea" readonly>
    <?php
        if($msg=="notExec"){
            //잡실행이 안된상태 잡실행 등록이 안되면 상태모니터링 테이블에도 정보가 없음
            echo "해당 내역의 조회되는 로그파일을 찾을 수 없습니다.";
        }else if($msg=="success"){
            //상태모니터링 테이블에 정보가 있고 , 로그파일도 있는 상태   | nl
            if($setNum==1){
                $exe= shell_exec("tail -n ".$line." i ".$logfile." | nl");
            }else{
                $exe= shell_exec("tail -n ".$line." i ".$logfile);
            }
            echo $exe; 
        }else if($msg=="lineExcess"){
            //성공 + 로그 더보기를 클릭했을떄 총 라인수를 초과한 상태
            if($setNum==1){
                $exe= shell_exec("tail -n ".$lineTotal." i ".$logfile." | nl");
            }else{
                $exe= shell_exec("tail -n ".$lineTotal." i ".$logfile);
            }
            echo $exe; 
        }
    ?>
</textarea>
<?php
    if($msg=="notExec"){
    }else if($msg=="success"){
        echo '<div class="col-md-12 text-center"> <input type="button" class="mt-3 btn btn-info " value="로그 더보기 +"  onclick="tailAdd()"/></div>';
    }else if($msg=="lineExcess"){

    }
?>

