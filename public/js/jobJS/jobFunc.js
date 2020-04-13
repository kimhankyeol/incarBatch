
const job = {
    //조회
    search: function(page){
        var searchWord = document.getElementById('searchWord').value
        location.href="/job/jobListView?searchWord="+searchWord+'&page='+page;
    },
    //등록
    register:function(){
       //변수 선언
        var Job_Name=$('#Job_Name').val();
        var Job_Sulmyung=$('#Job_Sulmyung').val();     
        //시간계산 분단위 ()
        var Job_YesangTime= job.timeCalc($('#Job_YesangTime1').val(),$('#Job_YesangTime2').val(),$('#Job_YesangTime3').val());
        var Job_YesangMaxTime=job.timeCalc($('#Job_YesangMaxTime1').val(),$('#Job_YesangMaxTime2').val(),$('#Job_YesangMaxTime3').val());
        var Job_Params="";
        var Job_ParamSulmyungs="";
        //유효성 체크 여부
        var jobValCheck=false;
        //잡 파라미터 존재 유무 변수
        var jobParamExist=false;
        console.log("잡 최대 예상시간:"+Job_YesangMaxTime);
        //유효성 (입력여부 공백이 있는지 없는지만 체크)
        jobValCheck=job.validation(Job_Name,Job_Sulmyung,Job_YesangTime,Job_YesangMaxTime);
        console.log(jobValCheck);
        ////////////////////////////////////////////////////////////////////
        //1. 잡상태에 따라 등록 여부 갈림
        //2. 구성 프로세스가 있는지 없는지 등록여부 갈림
        //3. 작업로그 디렉터리 입력하고    용량이 몇 기가 남았다 여기 디렉토리에 등록하겠습니까 용량체크 도 해줘야됨

        ///////////////////////////////////////////////////////////////////
        //잡 파라미터가 있으면
        if($('input[name=Job_paramSulmyungs]').length>0){
          jobParamExist=true;
        } 
        //잡 파라미터가 없으면
        if($('input[name=Job_paramSulmyungs]').length==0){
          jobParamExist=false;
        }
        //유효성 체크 여부 반환값이 true가 된후
        if(jobValCheck){
          //잡 파라미터의 유무에 따라 confirm 창을 나눠서 보여줌
          if(jobParamExist){
            var result = confirm('잡을 등록하시겠습니까?');
            if(result){
              $('input[name=Job_paramSulmyungs]').each(function(){
                if (!$.trim($(this).val()).length) {
                    alert('변수 설명을 입력해주세요');
                    return false;
                }else{
                  //입력된 잡파라미터의 타입, 설명을 1||2||3 이런변수 형태로 바꾸기위해
                  Job_Params =$('select[name=Job_Params] option:selected').map(function(){
                    return $(this).val();
                  }).get().join('\|\|');
      
                  Job_ParamSulmyungs =$('input[name=Job_paramSulmyungs]').map(function(){
                    return $(this).val();
                  }).get().join('\|\|');
                
                  return true;
                }
              });
                $.ajax({
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  url:'/job/jobRegister',
                  method:"post",
                  data:{
                      'Job_Name':Job_Name,
                      'Job_Sulmyung':Job_Sulmyung,
                      'Job_RegId':111,
                      'Job_Params':Job_Params,
                      'Job_ParamSulmyungs':Job_ParamSulmyungs,
                      'Job_YesangTime':Job_YesangTime,
                      'Job_YesangMaxTime':Job_YesangMaxTime
                  },
                  success:function(resp){
                    if(resp.msg=="success"){
                      const result = confirm('잡 초기구성을 위해 잡 상세 페이지로 이동하시겠습니까?')
                      if(result){
                        location.href="/job/jobDetailView?Job_Seq="+resp.lastJobSeq;
                      }else{
                      }
                    }else if(resp.msg=="faile"){
                      alert("잡 등록 실패");
                      location.href="/job/jobListView";
                    }
                  },error:function(error){
                    console.error(error);
                  }
                })
            }else{
              //잡등록 x
              console.log('잡 파라미터는 있는데 confirm에서 아니오/취소 누른경우');
              return false;
            }
          //잡 파라미터가 없는경우
          }else{
            var result = confirm('잡 파라미터없이 잡을 등록하시겠습니까?');
            if(result){
              $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:'/job/jobRegister',
                method:"post",
                data:{
                    'Job_Name':Job_Name,
                    'Job_Sulmyung':Job_Sulmyung,
                    'Job_RegId':111,
                    'Job_Params':Job_Params,
                    'Job_ParamSulmyungs':Job_ParamSulmyungs,
                    'Job_YesangTime':Job_YesangTime,
                    'Job_YesangMaxTime':Job_YesangMaxTime
                },
                success:function(resp){
                  if(resp.msg=="success"){
                    const result = confirm('잡 초기구성을 위해 잡 상세 페이지로 이동하시겠습니까?')
                    if(result){
                      location.href="/job/jobDetailView?Job_Seq="+resp.lastJobSeq;
                    }else{
                    }
                  }else if(resp.msg=="faile"){
                    alert("잡 등록 실패");
                    location.href="/job/jobListView";
                  }
                },error:function(error){
                  console.error(error);
                }
              })
            }else{
              console.log('잡 파라미터는 없는데 confirm에서 아니오/취소 누른경우');
              return false;
            }
          }
        }
        
    },
    //수정
    update:function(){

    },
    //삭제
    delete:function(){

    },
    //잡 유효성 검사
    validation:function(Job_Name,Job_Sulmyung,Job_YesangTime,Job_YesangMaxTime){
      if(Job_Name==""){
        alert('잡 명이 입력되지 않았습니다.');
        $('#Job_Name').focus();
        return false;
      }else if(Job_Sulmyung==""){
        alert('잡 설명이 입력되지 않았습니다.');
        $('#Job_Sulmyung').focus();
        return false;
      }else if(Job_YesangTime==0){
        alert('잡 예상 시간이 입력되지 않았습니다.');
        $('#Job_YesangTime').focus();
        return false;
      }else if(Job_YesangMaxTime==0){
        alert('잡 예상 최대 시간이 입력되지 않았습니다.');
        $('#Job_YesangMaxTime').focus();
        return false;
      }else{
        return true;
      }
    },
    //분 계산 변수 ( 일 , 시 , 분) 경우는 7가지 
    //1.아무것도 입력받지 않았을떄   2.일만 입력 받았을떄 3. 시만 입력 받았을떄 4. 분만 입력 받았을떄 4. 일 ,시 만 입력받았을때 5. 시,분만 입력 받았을떄   6.일,분만입력받았을떄 7. 일시분 다입력
    timeCalc:function(d,h,m){
      if(d==""&&h==""&&m==""){
        return 0;
      }else if(d!=""&&h==""&&m==""){
        return parseInt(d)*24*60;
      }else if(d==""&&h!=""&&m==""){
        return parseInt(h)*60
      }else if(d==""&&h==""&&m!=""){
        return parseInt(m)
      }else if(d!=""&&h!=""&&m==""){
        return parseInt(d)*24*60+parseInt(h)*60;
      }else if(d==""&&h!=""&&m!=""){
        return parseInt(h)*60+parseInt(m);
      }else if(d!=""&&h!=""&&m!=""){
        return parseInt(d)*24*60+parseInt(h)*60+parseInt(m);
      }
    },
    //잡 구성 팝업 버튼
    jobProcessConf:function(){
      alert("구성");
    },
    //파라미터 추가
    addDivParam:function(){
        var jobParamDiv = document.createElement('div');
        var jobParamDiv2 = document.createElement('div');
        var delBtnDiv = document.createElement('div');
        //onchange 걸어야됨
        var jobParamInputText = '<select name="Job_Params" class="col-md-3  form-control form-control-sm" > <option value="paramDate" selected>날짜</option><option value="paramNum">숫자</option><option value="paramStr">문자</option></select>'+
        '<input type="text" name="Job_paramSulmyungs" class="col-md-4  form-control form-control-sm" placeholder="설명">';
        jobParamDiv.className="row delYN";
        jobParamDiv.style.paddingBottom="10px";
        jobParamDiv2.className="col-md-2 small align-self-center text-center"
        jobParamDiv2.innerHTML="잡 파라미터";
        
        delBtnDiv.className="delParam btn-danger  form-control form-control-sm col-md-2 text-center" ;
        delBtnDiv.onclick=job.deleteDivParam;
        delBtnDiv.innerText="삭제";

        jobParamDiv.appendChild(jobParamDiv2);
        jobParamDiv.innerHTML+=jobParamInputText;
        jobParamDiv.appendChild(delBtnDiv);
       
        document.getElementById('jobParams').appendChild(jobParamDiv);
    },
    //파라미터 삭제
    deleteDivParam:function(){
        var delIndex = $('.delParam').index(this);
        $('.delYN').eq(delIndex).remove();
    }
};