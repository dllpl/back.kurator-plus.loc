<?php
$action=$action??'#';
$attributes=$attributes??'';
$small=$small??false;
?>
<a title="Редактировать" href="{{$action}}" class="btn btn-warning {{$small?'btn-sm':''}}" {!! $attributes !!}><i class="far fa-edit"></i></a>
