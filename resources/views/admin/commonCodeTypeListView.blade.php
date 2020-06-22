@php
$i = 0;
$len = count($data);
@endphp
@foreach ($data as $code)
@if ($i == 0) {
    <option value="{{$code->WorkLarge}}" selected>{{$code->shortname}}</option>  
@else
    <option value="{{$code->WorkLarge}}">{{$code->shortname}}</option>  
@endIf
@php
    $i++;
@endphp
@endforeach