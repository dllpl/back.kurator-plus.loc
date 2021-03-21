<?php
$action=$action??'#';
$attributes=$attributes??'';
$small=$small??false;
$title=$title??''
?>
<a title="{{$title}}" href="{{$action}}" class="btn btn-warning {{$small?'btn-sm':''}}" {!! $attributes !!}><i class="{{$icon}}"></i></a>
