const job = {
  //조회
  search: function(page){
      var searchWord = $('#searchWord').val();
      var WorkLarge = $('#workLargeVal option:selected').val();
      var WorkMedium = $('#workMediumVal option:selected').val();
      // 대분류 , 중분류 전체 선택일떄 아닐떄 경우의 수
      location.href="/job/jobListView?searchWord="+searchWord+"&WorkLarge="+WorkLarge+"&WorkMedium="+WorkMedium+"&page="+page;
  },
  //등록
  register:function(){
     //변수 선언
      var Job_Name=$('#Job_Name').val();
      var Job_Sulmyung=$('#Job_Sulmyung').val();     
      var Job_Params="";
      var Job_ParamSulmyungs="";
      var Job_WorkLargeCtg=$('#workLargeVal option:selected').val();
      var Job_WorkMediumCtg=$('#workMediumVal option:selected').val();

      //유효성 체크 여부
      var jobValCheck=false;
      //잡 파라미터 존재 유무 변수, 하나라도 빈값이 있는지 체크해주기 위해 jobParamIndex
      var jobParamExist=false;
      var jobParamIndex=0;
      
      //유효성 (입력여부 공백이 있는지 없는지만 체크)
      jobValCheck=job.validation(Job_Name,Job_Sulmyung,Job_WorkLargeCtg,Job_WorkMediumCtg);
      console.log("유효성:",jobValCheck);
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
                  jobParamIndex++;
              }
            });
            //변수 설명에 빈값이 있는지 없는지
            if(jobParamIndex==0){
                //입력된 잡파라미터의 타입, 설명을 1||2||3 이런변수 형태로 바꾸기위해
                Job_Params =$('select[name=Job_Params] option:selected').map(function(){
                  return $(this).val();
                }).get().join('\|\|');

                Job_ParamSulmyungs =$('input[name=Job_paramSulmyungs]').map(function(){
                  return $(this).val();
                }).get().join('\|\|');
                $.ajax({
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  url:'/job/jobRegister',
                  method:"post",
                  data:{
                      'Job_Name':Job_Name,
                      'Job_Sulmyung':Job_Sulmyung,
                      'Job_RegId':1611698,
                      'Job_Params':Job_Params,
                      'Job_ParamSulmyungs':Job_ParamSulmyungs,
                      'Job_WorkLargeCtg':Job_WorkLargeCtg,
                      'Job_WorkMediumCtg':Job_WorkMediumCtg
                  },
                  success:function(resp){
                    if(resp.msg=="success"){
                      alert("잡이 등록되었습니다.");
                      location.href="/job/jobDetailView?Job_Seq="+resp.lastJobSeq;
                    }else{
                      alert("잡 등록 실패");
                      location.href="/job/jobListView";
                    }
                  },error:function(error){
                    console.error(error);
                  }
                })
            }else{
              alert("파라미터 설명이 입력되지 않았습니다.")
              return false;
            }
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
                  'Job_RegId':1611698,
                  'Job_Params':Job_Params,
                  'Job_ParamSulmyungs':Job_ParamSulmyungs,
                  'Job_WorkLargeCtg':Job_WorkLargeCtg,
                  'Job_WorkMediumCtg':Job_WorkMediumCtg
              },
              success:function(resp){
                if(resp.msg=="success"){
                    alert("잡이 등록되었습니다.");
                    location.href="/job/jobDetailView?Job_Seq="+resp.lastJobSeq;
                }else{
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
      }else{
        return false;
      }
      
  },
  //수정
  update:function(Job_Seq){
      var Job_Name=$('#Job_Name').val();
      var Job_Sulmyung=$('#Job_Sulmyung').val();     
      var Job_Params="";
      var Job_ParamSulmyungs="";
      var Job_WorkLargeCtg=$('#Job_WorkLargeCtg').val();
      var Job_WorkMediumCtg=$('#Job_WorkMediumCtg').val();
      //유효성 체크 여부
      var jobValCheck=false;
      //잡 파라미터 존재 유무 변수, 하나라도 빈값이 있는지 체크해주기 위해 jobParamIndex
      var jobParamExist=false;
      var jobParamIndex=0;
      
      //유효성 (입력여부 공백이 있는지 없는지만 체크)
      jobValCheck=job.validation(Job_Name,Job_Sulmyung,Job_WorkLargeCtg,Job_WorkMediumCtg);
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
          var result = confirm('잡을 수정하시겠습니까?');
          if(result){
            $('input[name=Job_paramSulmyungs]').each(function(){
              if (!$.trim($(this).val()).length) {
                jobParamIndex++;
              }
            });
            //변수 설명에 빈값이 있는지 없는지
            if(jobParamIndex==0){
                 //입력된 잡파라미터의 타입, 설명을 1||2||3 이런변수 형태로 바꾸기위해
                 Job_Params =$('select[name=Job_Params] option:selected').map(function(){
                  return $(this).val();
                }).get().join('\|\|');

                Job_ParamSulmyungs =$('input[name=Job_paramSulmyungs]').map(function(){
                  return $(this).val();
                }).get().join('\|\|');
         
               
                $.ajax({
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  url:'/job/jobUpdate',
                  method:"post",
                  data:{
                      'Job_Seq':Job_Seq,
                      'Job_Name':Job_Name,
                      'Job_Sulmyung':Job_Sulmyung,
                      'Job_RegId':1611698,
                      'Job_Params':Job_Params,
                      'Job_ParamSulmyungs':Job_ParamSulmyungs,
                      'Job_WorkLargeCtg':Job_WorkLargeCtg,
                      'Job_WorkMediumCtg':Job_WorkMediumCtg
                  },
                  success:function(resp){
                    if(resp.msg=="success"){
                      alert("잡이 수정되었습니다.");
                      location.href="/job/jobDetailView?Job_Seq="+Job_Seq;
                    }else if(resp.msg=="notChg"){
                      var result = confirm("잡 수정사항이 없습니다. 진행하시겠습니까?");
                      if(result){
                        location.href="/job/jobDetailView?Job_Seq="+Job_Seq;
                      }else{
                        return false;
                      }
                    }
                    else{
                      alert("잡 수정 실패");
                      location.href="/job/jobListView";
                    }
                  },error:function(error){
                    console.error(error);
                  }
                })
            }else{
              alert("파라미터 설명이 입력되지 않았습니다.")
              return false;
            }
          }else{
            //잡등록 x
            console.log('잡 파라미터는 있는데 confirm에서 아니오/취소 누른경우');
            return false;
          }
        //잡 파라미터 수정사항 없는경우
        }else{
          var result = confirm('잡 파라미터없이 잡을 수정하시겠습니까?');
          if(result){
            $.ajax({
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              url:'/job/jobUpdate',
              method:"post",
              data:{
                  'Job_Seq':Job_Seq,
                  'Job_Name':Job_Name,
                  'Job_Sulmyung':Job_Sulmyung,
                  'Job_RegId':1611698,
                  'Job_Params':Job_Params,
                  'Job_ParamSulmyungs':Job_ParamSulmyungs,
                  'Job_WorkLargeCtg':Job_WorkLargeCtg,
                  'Job_WorkMediumCtg':Job_WorkMediumCtg
              },
              success:function(resp){
                if(resp.msg=="success"){
                  alert("잡이 수정되었습니다.");
                  location.href="/job/jobDetailView?Job_Seq="+Job_Seq;
                }else if(resp.msg=="notChg"){
                  var result = confirm("잡 수정사항이 없습니다. 진행하시겠습니까?");
                  if(result){
                    location.href="/job/jobDetailView?Job_Seq="+Job_Seq;
                  }else{
                    return false;
                  }
                }
                else{
                  alert("잡 수정 실패");
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
      }else{
        return false;
      }
  },
  //삭제
  delete:function(){

  },
  //잡 유효성 검사
  validation:function(Job_Name,Job_Sulmyung,Job_WorkLargeCtg,Job_WorkMediumCtg){
    if(Job_Name==""){
      alert('잡 명이 입력되지 않았습니다.');
      $('#Job_Name').focus();
      return false;
    }else if(Job_Sulmyung==""){
      alert('잡 설명이 입력되지 않았습니다.');
      $('#Job_Sulmyung').focus();
      return false;
    }else if(Job_WorkLargeCtg=="all"){
      alert('업무 대분류를 선택해주세요');
      return false;
    }else if(Job_WorkMediumCtg=="all"){
      alert('업무 중분류를 선택해주세요');
      return false;
    }else{
      return true;
    }
  },
  //파라미터 추가
  addDivParam: function () {
    if(document.getElementsByName('Job_Params').length>9){
      alert('잡 파라미터는 최대 10개 까지 등록가능 합니다.')
      return false;
    }
    var jobParamDiv = document.createElement("div");
    var jobParamDiv2 = document.createElement("div");
    var delBtn = document.createElement("button");
    //onchange 걸어야됨
    var jobParamInputText =
        '<select name="Job_Params" class="col-md-2 form-control form-control-sm"><option value="paramNum" selected>숫자</option><option value="paramStr">문자</option></select>' +
        '<input type="text" name="Job_paramSulmyungs" class="col-md-6 form-control form-control-sm" placeholder="설명">';
    jobParamDiv.className = "d-inline-flex w-50 delYN mb-2";
    jobParamDiv.style.cssFloat="left";
    jobParamDiv2.className = "col-md-3 small align-self-center text-center";
    jobParamDiv2.innerHTML = "잡 파라미터";
    delBtn.type = "button";
    delBtn.className ="col-md-auto delParam btn-danger form-control-sm text-center";
    delBtn.innerText = "삭제";
    jobParamDiv.appendChild(jobParamDiv2);
    jobParamDiv.innerHTML += jobParamInputText;
    jobParamDiv.appendChild(delBtn);
    document.getElementById("jobParams").appendChild(jobParamDiv);
    document.getElementById("jobParams").scrollIntoView();
    
  },
  //파라미터 삭제
  deleteDivParam: $(document).ready(function(){
    $(document).on('click','.delParam',function(event){
      var delIndex = $('.delParam').index(this);
      $('.delYN').eq(delIndex).remove();
    })
  }),
  //스케줄 검색
  scheduleSearch:function(page){
    var searchWord = $('#searchWord').val();
    var WorkLarge = $('#workLargeVal option:selected').val();
    var WorkMedium = $('#workMediumVal option:selected').val();
    // 대분류 , 중분류 전체 선택일떄 아닐떄 경우의 수
    location.href="/schedule/scheduleListView?searchWord="+searchWord+"&WorkLarge="+WorkLarge+"&WorkMedium="+WorkMedium+"&page="+page;
  },
  //스케줄 잡선택
  jobselect:function(job_id,job_name,job_seq){
    opener.document.getElementById("jobSc_id").value = job_id;
    opener.document.getElementById("jobSc_name").value = job_name;
    $.ajax({
      url:"/schedule/jobselect",
      method:"get",
      data:{
          'job_seq':job_seq
      },
      success:function(data){
        opener.document.getElementById('jobparams').innerHTML = data.returnHTML;
        window.close();
        console.log("성공");
      },error:function(err){
        console.log("error");
      }
    })
  },
  //잡 스케줄 등록 
  scRegister:function(){
    var P_Seq = [];
    var Log_File = [];
    var SC_P_ReworkYN=[];
    var gusungData = document.getElementsByClassName("gusungData");
    for(var i=0; i<gusungData.length;i++){
      if(gusungData[i].children[0].children[0].children[0].checked){
        P_Seq.push(gusungData[i].children[0].children[0].children[0].value);
        // SC_P_ReworkYN.push(gusungData[i].children[6].children[0].dataset['value']);
        //Sc_LogFile value를 받아옴
        Log_File.push(gusungData[i].children[7].children[0].children[0].value);
      } 
    }
    // console.table(gusungData[0].children[6].children[0].getAttribute);
    // return false;
    var jobSc_id = $('#jobSc_id').val();//잡 id
    var job_seq = $('#scExecJob').val();//잡 seq
    var jobSc_name = $('#jobSc_name').val();//잡 명
    var Sc_Sulmyung = $('#Sc_Sulmyung').val();// 스케줄 설명

    var Day = $('#Day').val();//매 n일
     
    var nowDateTime = new Date().format("yyyy-MM-dd HH:mm:ss");

    var yoilArr = new Array();
    var Sc_Status = "301";
    //each로 loop를 돌면서 checkbox의 check된 값을 가져와 담아준다.
    $("input:checkbox[name=yoil]:checked").each(function(){
      yoilArr.push($(this).val());
    });//요일 arr
    const yoil = yoilArr.join(",");
    var Job_paramSulmyungs = document.getElementsByName("Sc_Param");
    
    var res = new Array();
    for (var i = 0; i < Job_paramSulmyungs.length; i++) {
      res.push(Job_paramSulmyungs[i].value);
    }
    const Sc_Param = res.join("||");

    var startdate=$('#startdate').val();
    var starttime=$('#starttm').val();

    var Sc_CronTime = new Date(startdate+" "+starttime).format("yyyy-MM-dd HH:mm:ss");

    var year = new Date(startdate+" "+starttime).format("yyyy");
    var month = new Date(startdate+" "+starttime).format("MM");
    var day = new Date(startdate+" "+starttime).format("dd");
  
    var hour = new Date(startdate+" "+starttime).format("HH");
    var min = new Date(startdate+" "+starttime).format("mm");
    var enddate=$('#enddate').val();
    var endtime=$('#endtm').val();
    var Sc_CronEndTime =  new Date(enddate+" "+endtime).format("yyyy-MM-dd HH:mm:ss");
    var jugiNum=$('#jugiChange option:selected').val();

    scValCheck=job.Scvalidation(jobSc_id,jobSc_name,Sc_Sulmyung,Day,yoilArr,Sc_Param,startdate,enddate,nowDateTime,Sc_CronTime,Sc_CronEndTime,Log_File,jugiNum);

    if(scValCheck){
      var result = confirm('스케줄을 등록하시겠습니까?');
      if(result){
        if(jugiNum==1){
          var Sc_Crontab = " ";
          var Sc_CronSulmyung ="한번 실행";
          var Sc_Status = "301"
        }else if(jugiNum==2){
          //11월 12월은 회사일정이 바쁜시기이므로  종료일시+ 3개월 해줘야함
          if(month=="11"||month=="12"){
            Sc_CronEndTime.setMonths(Sc_CronEndTime.getMonths()+3);
          }
          if($('#Day').val()==1){
            var Sc_Crontab = min + " " + hour + " " + "*" + " " + "*" + " " + "*" + " ";
            var Sc_CronSulmyung = hour+":"+min+"에 매일 실행";
            var Sc_Status = "302"
          }else{
            var Sc_Crontab = min + " " + hour + " " + "*/"+$('#Day').val() + " " + "*" + " " + "*" + " ";
            var Sc_CronSulmyung = hour+":"+min+"에 "+$('#Day').val()+"일 마다 실행";
            var Sc_Status = "302"
          }
        }else if(jugiNum==3){
          //11월 12월은 회사일정이 바쁜시기이므로  종료일시+ 3개월 해줘야함
          if(month=="11"||month=="12"){
            Sc_CronEndTime.setMonths(Sc_CronEndTime.getMonths()+3);
          }
          var Sc_Crontab = min + " " + hour + " " + "*" + " " + "*" + " " + yoil + " ";
          var Sc_Status = "303"
          for(var i=0;i<yoilArr.length;i++){
            if(yoilArr[i]==0||yoilArr[i]==1){
              yoilArr[i]="일";
            }else if(yoilArr[i]==1){
              yoilArr[i]="월";
            }else if(yoilArr[i]==2){
              yoilArr[i]="화";
            }else if(yoilArr[i]==3){
              yoilArr[i]="수";
            }else if(yoilArr[i]==4){
              yoilArr[i]="목";
            }else if(yoilArr[i]==5){
              yoilArr[i]="금";
            }else if(yoilArr[i]==6){
              yoilArr[i]="토";
            }
          }
          const yoilArr1 = yoilArr.join(",");
          var Sc_CronSulmyung = hour+":"+min+"에 "+"매주 "+yoilArr1+"요일 마다 실행";
        }else if(jugiNum==4){
          //11월 12월은 회사일정이 바쁜시기이므로  종료일시+ 3개월 해줘야함
          if(month=="11"||month=="12"){
            Sc_CronEndTime.setMonths(Sc_CronEndTime.getMonths()+3);
          }
          var Sc_Crontab = min + " " + hour + " " + day + " " + "*" + " " + "*" + " ";
          var Sc_CronSulmyung = "매달 "+day+"일"+hour+":"+min+" 마다 실행";
          var Sc_Status = "304"
        }else if(jugiNum==5){
          //11월 12월은 회사일정이 바쁜시기이므로  종료일시+ 3개월 해줘야함
          if(month=="11"||month=="12"){
            Sc_CronEndTime.setMonths(Sc_CronEndTime.getMonths()+3);
          }
          var Sc_Crontab = min + " " + hour + " " + day + " " + month + " " + "*" + " ";
          var Sc_CronSulmyung = "매년 "+month+"월 "+day+"일 "+hour+":"+min+"마다 실행";
          var Sc_Status = "305"
        }else if(jugiNum==6){
          var Sc_Crontab = " ";
          var Sc_CronSulmyung ="즉시 실행";
          var Sc_Status = "306"
          var Sc_CronTime=new Date();
      
          //즉시실행은 1분을 더해야함
          Sc_CronTime.setMinutes(Sc_CronTime.getMinutes()+1);
          Sc_CronTime = Sc_CronTime.format('yyyy-MM-dd HH:mm:ss');
          Sc_CronEndTime = Sc_CronTime;
        }
        if(P_Seq.length!=0){
          $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url:'/schedule/scheduleRegister',
            method:"post",
            data:{
              'job_seq':job_seq,
              'Sc_Sulmyung':Sc_Sulmyung,
              'Sc_Crontab':Sc_Crontab,
              'Sc_Param':Sc_Param,
              'Sc_Status':Sc_Status,
              'Sc_RegId':1611698,
              'Sc_CronTime':Sc_CronTime,
              'Sc_CronEndTime':Sc_CronEndTime,
              'Sc_CronSulmyung':Sc_CronSulmyung,
              'P_Seq':P_Seq,
              'Log_File':Log_File
            },
            success:function(data){
                alert("등록되었습니다.");
                location.href = "/schedule/scheduleDetailView?Sc_Seq="+data.last_sc_seq+"&Job_Seq="+data.Job_Seq;
            },error:function(error){
              console.error(error);
            }
          })
        }else{
          alert("실행할 프로그램을 선택해주세요");
          return false;
        }
      }
    }
  },
 //잡 스케줄 삭제 
 scheduleDump:function(){
  var Sc_Seq=$('#Sc_Seq').val();
  var Sc_Status=$('#Sc_Status').val();
  var result = confirm('스케줄을 삭제하시겠습니까?');
  if(result){
    if(Sc_Status==901||Sc_Status==902){
      $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:'/schedule/scheduleDump',
        method:"post",
        data:{
          'Sc_Seq':Sc_Seq,
          'Sc_Status':Sc_Status
        },
        success:function(data){
          alert("삭제되었습니다.");
          console.log(data.Sc_Seq);
          location.href = "/schedule/scheduleListView";
        },error:function(error){
          console.error(error);
        }
      })
    }else{
      alert("스케줄을 삭제할 수 있는 상태가 아닙니다.");
      return false;
    }
  }
 },
  //스케줄링 유효성 검사
  Scvalidation:function(jobSc_id,jobSc_name,Sc_Sulmyung,Day,yoilArr,Sc_Param,startdate,enddate,nowDateTime,Sc_CronTime,Sc_CronEndTime,Log_File,jugiNum){
    if(jobSc_id==""){
      alert('잡 명이 입력되지 않았습니다.');
      $('#Job_Name').focus();
      return false;
    }else if(Sc_Sulmyung==""){
      alert('스케줄 설명이 입력되지 않았습니다.');
      return false;
    }else if(jugiNum!=6){ //즉시실행 아니면
      if(nowDateTime > Sc_CronTime){
        alert('현재시간 이전에 등록할 수 없습니다.');
        return false;
      }
    }else if($('input:radio[id="Everyday"]').is(':checked')&&Day==""){
      alert('일을 입력해주세요');
      return false;
    }else if($('input:radio[id="Everyweek"]').is(':checked')&&yoilArr.length==""){
        alert('요일을 체크해주세요');
        return false;
    }else if(Sc_CronTime > Sc_CronEndTime){
      alert('종료 시간이 시작 시간보다 빠를 수 없습니다.');
      return false;
    }else {
      //Arr2에 /를 기준으로 split하여 저장. split 사용하면 나누어진 문자열은 각각 배열로 들어감
      var Sc_Param2 = Sc_Param.split("||");
      console.log(Sc_Param2);
      for (var i = 0; i < Sc_Param2.length; i++) {
          if (Sc_Param2[i] == "") {
              alert("잡 파라미터를 입력하세요");
              return false;
          }
      }
      for(var i = 0 ;i < Log_File.length; i++){
        if(Log_File[i]==""){
          alert('로그파일 경로를 입력하세요.');
          return false;
        }
      }
    }
    return 1;
  },
  //잡구성 팝업 이동
  jobGusung:function(Job_Seq){
    window.open('/popup/jobGusung?Job_Seq='+Job_Seq, '잡 구성', 'top=10, left=10, width=1400, height=720, status=no, location=no, directories=no, status=no, menubar=no, toolbar=no, scrollbars=yes, resizable=no');
  }
};
