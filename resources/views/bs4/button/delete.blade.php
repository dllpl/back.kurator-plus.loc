<?php
$action=$action??'#';
$attributes=$attributes??'';
$small=$small??false;
?>

<form action="{{$action}}" method="post" class="d-inline">
    {{method_field('DELETE')}}
    {{ csrf_field() }}
    <button type="submit" class="btn btn-danger {{$small?'btn-sm':''}}" {!! $attributes !!}>X</button>
</form>