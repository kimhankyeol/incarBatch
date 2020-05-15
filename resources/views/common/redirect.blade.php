@php
// $close 팝업 닫는 여부
if(isset($close)){
    echo("<script>
       alert('".$msg."');
       window.close();
    </script>");
}else {
    echo("<script>
        alert('".$msg."');
        location.href='".$url."';
    </script>");
}
 
@endphp