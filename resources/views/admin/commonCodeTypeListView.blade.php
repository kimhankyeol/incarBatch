@php
$i = 0;
$len = count($data);
@endphp
@foreach ($data as $code)
@if ($i == 0) {
    <option value="{{$code->WorkLarge}}" selected>{{$code->ShortName}}</option>  
@else
<option value="{{$code->WorkLarge}}">{{$code->ShortName}}</option>  
@endIf
@php
    $i++;
@endphp
@endforeach