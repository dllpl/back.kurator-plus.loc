<?php
$action=$action??'#';
$attributes=$attributes??'';
$small=$small??false;
$title=$title??'';
?>
<a @if($title)title="{{$title}}"@endif href="{{$action}}" class="btn btn-light border-dark {{$small?'btn-sm':''}}" {!! $attributes !!}><img src="{{$image}}" /></a>
