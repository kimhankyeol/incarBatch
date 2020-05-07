<h6 class = "m-0 font-weight-bold text-primary" style="padding:0rem 1.25rem">
    @if($msg=="success")
            <div class="custom-control" style="display: flex; justify-content: space-around;">
                 <p class="font-weight-bold text-primary">로그 파일 명 : {{$logfilename}}</p>
                <div class="custom-control font-weight-bold text-primary"> @if(isset($fileSize)) 로그 크기:  @if(round($fileSize/1024/1024,2)>1) {{round($fileSize/1024/1024,2)}} MB @else 1 MB 이하 @endIf @endIf</div>
                로그 수정 시간: {{$lastmod}}
            </div>
            <div style="display: flex; justify-content: space-around;">
                <div class="custom-control custom-checkbox">
                    {{-- # 로그 set num 라인에 숫자 찍는거 setNum  @if($setNum==1) ? value="1" : value="0" @endIf--}}
                    <input id="headTail" type="checkbox" class="custom-control-input"  @if($headTail=="tail") ? value="tail" checked : value="head" @endIf >
                    <label class="custom-control-label font-weight-bold text-primary" for="headTail">아래서부터 출력</label>
                </div> 
                <div class="custom-control custom-checkbox">
                    {{-- # 로그 set num 라인에 숫자 찍는거 setNum  @if($setNum==1) ? value="1" : value="0" @endIf--}}
                    <input id="setNum" type="checkbox" class="custom-control-input"  @if($setNum==1) ? value="1" checked : value="0" @endIf >
                    <label class="custom-control-label font-weight-bold text-primary" for="setNum">라인 숫자 출력</label>
                </div> 
                <div class="custom-control" style="sp">
                    로그 라인 수 <input id="lineNum" type="text" class=" bg-light border-primary" numberOnly value="{{$line}}"> / {{$lineTotal}} 
                    검색어 <input id="logSearchWord" type="text" class=" bg-light border-primary" @if(isset($logSearchWord)) ?  value={{$logSearchWord}} : value="" @endIf > 
                    <div class="btn btn-primary" onclick="tailAddSearch()">
                        <i class="fas fa-search fa-sm"></i>
                    </div>
                </div>
            </div>
    {{-- 조회된값이 라인 토탈값을 넘었을때 --}}
    @elseif($msg=="lineExcess")
        <div class="custom-control" style="display: flex; justify-content: space-around;">
            <p class="font-weight-bold text-primary">로그 파일 명 : {{$logfilename}}</p>
           <div class="custom-control font-weight-bold text-primary"> @if(isset($fileSize)) 로그 크기:  @if(round($fileSize/1024/1024,2)>1) {{round($fileSize/1024/1024,2)}} MB @else 1 MB 이하 @endIf @endIf</div>
           로그 수정 시간: {{$lastmod}}
       </div>
       <div style="display: flex; justify-content: space-around;">
           <div class="custom-control custom-checkbox">
               {{-- # 로그 set num 라인에 숫자 찍는거 setNum  @if($setNum==1) ? value="1" : value="0" @endIf--}}
               <input id="headTail" type="checkbox" class="custom-control-input"  @if($headTail=="tail") ? value="tail" checked : value="head" @endIf >
               <label class="custom-control-label font-weight-bold text-primary" for="headTail">아래서부터 출력</label>
           </div> 
           <div class="custom-control custom-checkbox">
               {{-- # 로그 set num 라인에 숫자 찍는거 setNum  @if($setNum==1) ? value="1" : value="0" @endIf--}}
               <input id="setNum" type="checkbox" class="custom-control-input"  @if($setNum==1) ? value="1" checked : value="0" @endIf >
               <label class="custom-control-label font-weight-bold text-primary" for="setNum">라인 숫자 출력</label>
           </div> 
           <div class="custom-control">
               로그 라인 수 <input id="lineNum" type="text" class=" bg-light border-primary" numberOnly value="{{$lineTotal}}"> / {{$lineTotal}} 
           </div>
           <div class="custom-control">
               검색어 <input id="logSearchWord" type="text" class=" bg-light border-primary" @if(isset($logSearchWord)) ?  value={{$logSearchWord}} : value="" @endIf > 
           </div>
           <div class="custom-control">
               <div class="btn btn-primary" onclick="tailAddSearch()">
                   <i class="fas fa-search fa-sm"></i>
               </div>
           </div>
       </div>
    @elseif($msg=="notFound")
    <div class="custom-control" style="display: flex; justify-content: space-around;">
        <p class="font-weight-bold text-primary">로그 파일 명 : {{$logfilename}}</p>
       <div class="custom-control font-weight-bold text-primary"> @if(isset($fileSize)) 로그 크기:  @if(round($fileSize/1024/1024,2)>1) {{round($fileSize/1024/1024,2)}} MB @else 1 MB 이하 @endIf @endIf</div>
       로그 수정 시간: {{$lastmod}}
   </div>
   <div style="display: flex; justify-content: space-around;">
       <div class="custom-control custom-checkbox">
           {{-- # 로그 set num 라인에 숫자 찍는거 setNum  @if($setNum==1) ? value="1" : value="0" @endIf--}}
           <input id="headTail" type="checkbox" class="custom-control-input"  @if($headTail=="tail") ? value="tail" checked : value="head" @endIf >
           <label class="custom-control-label font-weight-bold text-primary" for="headTail">아래서부터 출력</label>
       </div> 
       <div class="custom-control custom-checkbox">
           {{-- # 로그 set num 라인에 숫자 찍는거 setNum  @if($setNum==1) ? value="1" : value="0" @endIf--}}
           <input id="setNum" type="checkbox" class="custom-control-input"  @if($setNum==1) ? value="1" checked : value="0" @endIf >
           <label class="custom-control-label font-weight-bold text-primary" for="setNum">라인 숫자 출력</label>
       </div> 
       <div class="custom-control">
           로그 라인 수 <input id="lineNum" type="text" class=" bg-light border-primary" numberOnly value="{{$lineTotal}}"> / {{$lineTotal}} 
       </div>
       <div class="custom-control">
           검색어 <input id="logSearchWord" type="text" class=" bg-light border-primary" @if(isset($logSearchWord)) ?  value={{$logSearchWord}} : value="" @endIf > 
       </div>
       <div class="custom-control">
           <div class="btn btn-primary" onclick="tailAddSearch()">
               <i class="fas fa-search fa-sm"></i>
           </div>
       </div>
   </div>
    @endIf
</h6>
<div id= "Job_logarea" class= "form-control" style="white-space: pre-line; height:300px ;overflow:scroll;"readonly>
    <?php
        if($msg=="notExec"){
            //잡실행이 안된상태 잡실행 등록이 안되면 상태모니터링 테이블에도 정보가 없음
            echo "해당 내역의 조회되는 로그파일을 찾을 수 없습니다.";
        }else if($msg=="success"){
            if($headTail=="tail"){
                 //상태모니터링 테이블에 정보가 있고 , 로그파일도 있는 상태   | nl
                if($setNum==1){
                    if(!isset($logSearchWord)){
                        $exe= shell_exec("tail -n ".$line." ".$logfile." | nl");
                    }else{
                        $exe= shell_exec("grep ".$logSearchWord." ".$logfile." |  tail -n ".$line." | nl");
                        $exe= str_replace($logSearchWord,'<span style="color:red">'.$logSearchWord.'</span>',$exe);
                    }
                }else{
                    if(!isset($logSearchWord)){
                        $exe= shell_exec("tail -n ".$line." ".$logfile);
                    }else{
                        $exe= shell_exec("grep ".$logSearchWord." ".$logfile." |  tail -n ".$line);
                        $exe= str_replace($logSearchWord,'<span style="color:red">'.$logSearchWord.'</span>',$exe);
                    }
                }
                echo $exe;
                echo "<div class='font-weight-bold text-primary text-center'>검색된 로그의 마지막 부분 입니다.</div>";
            }else if($headTail=="head"){
                //상태모니터링 테이블에 정보가 있고 , 로그파일도 있는 상태   | nl
                if($setNum==1){
                    if(!isset($logSearchWord)){
                        $exe= shell_exec("head -n ".$line." ".$logfile." | nl");
                    }else{
                        $exe= shell_exec("grep ".$logSearchWord." ".$logfile." |  head -n ".$line." | nl");
                        $exe= str_replace($logSearchWord,'<span style="color:red">'.$logSearchWord.'</span>',$exe);
                    }
                }else{
                    if(!isset($logSearchWord)){
                        $exe= shell_exec("head -n ".$line." ".$logfile);
                    }else{
                        $exe= shell_exec("grep ".$logSearchWord." ".$logfile." |  head -n ".$line);
                        $exe= str_replace($logSearchWord,'<span style="color:red">'.$logSearchWord.'</span>',$exe);
                    }
                }
                echo "<div class=' font-weight-bold text-primary text-center'>검색된 로그의 시작 부분 입니다.</div>";
                echo $exe;
            }
          
        }else if($msg=="lineExcess"){
            //성공 + 로그 더보기를 클릭했을떄 총 라인수를 초과한 상태
            if($headTail=="tail"){
                 //상태모니터링 테이블에 정보가 있고 , 로그파일도 있는 상태   | nl
                 if($setNum==1){
                    if(!isset($logSearchWord)){
                        $exe= shell_exec("tail -n ".$lineTotal." ".$logfile." | nl");
                    }else{
                        $exe= shell_exec("grep ".$logSearchWord." ".$logfile." |  tail -n ".$lineTotal." | nl");
                        $exe= str_replace($logSearchWord,'<span style="color:red">'.$logSearchWord.'</span>',$exe);
                    }
                }else{
                    if(!isset($logSearchWord)){
                        $exe= shell_exec("tail -n ".$lineTotal." ".$logfile);
                    }else{
                        $exe= shell_exec("grep ".$logSearchWord." ".$logfile." |  tail -n ".$lineTotal);
                        $exe= str_replace($logSearchWord,'<span style="color:red">'.$logSearchWord.'</span>',$exe);
                    }
                }
                echo "<div class='font-weight-bold text-primary text-center'>검색된 로그의 시작 부분 입니다.</div>";
                echo $exe;
                echo "<div class=' font-weight-bold text-primary text-center'>검색된 로그의 마지막 부분 입니다.</div>";;
            }else if($headTail=="head"){
                //상태모니터링 테이블에 정보가 있고 , 로그파일도 있는 상태   | nl
                if($setNum==1){
                    if(!isset($logSearchWord)){
                        $exe= shell_exec("head -n ".$lineTotal." ".$logfile." | nl");
                    }else{
                        $exe= shell_exec("grep ".$logSearchWord." ".$logfile." |  head -n ".$lineTotal." | nl");
                        $exe= str_replace($logSearchWord,'<span style="color:red">'.$logSearchWord.'</span>',$exe);
                    }
                }else{
                    if(!isset($logSearchWord)){
                        $exe= shell_exec("head -n ".$lineTotal." ".$logfile);
                    }else{
                        $exe= shell_exec("grep ".$logSearchWord." ".$logfile." |  head -n ".$lineTotal." | nl");
                        $exe= str_replace($logSearchWord,'<span style="color:red">'.$logSearchWord.'</span>',$exe);
                    }
                }
                echo "<div class='font-weight-bold text-primary text-center'>검색된 로그의 시작 부분 입니다.</div>";
                echo $exe;
                echo "<div class='font-weight-bold text-primary text-center'>검색된 로그의 마지막 부분 입니다.</div>";
            }
        }else if($msg=="notFound"){
            echo '<div style="text-align: center;color:blue"> 로그에서 '.$logSearchWord.'로 검색된 결과가 없습니다.</div>';
        }
    ?>
</div>
<?php
    if($msg=="notExec"){
    }else if($msg=="success"){
        echo '<div class="col-md-12 text-center"> <input type="button" class="mt-3 btn btn-info " value="로그 더보기 +"  onclick="tailAdd()"/></div>';
    }else if($msg=="lineExcess"){
        
    }else if($msg=="notFound"){

    }
?>
<script>
$("input:text[numberOnly]").on("keyup", function() {
    $(this).val($(this).val().replace(/[^0-9]/g,""));
});    
</script>