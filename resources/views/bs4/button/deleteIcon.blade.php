<?php
$action=$action??'#';
$attributes=$attributes??'';
$small=$small??false;
$method=$method??'DELETE';
$confirm=$confirm??true
?>

<form action="{{$action}}" method="post" class="d-inline" @if($confirm) onsubmit="return confirm('Уверены?')" @endif>
    {{method_field($method)}}
    {{ csrf_field() }}
    <button type="submit" class="btn btn-danger {{$small?'btn-sm':''}}" {!! $attributes !!}><i class="fas fa-trash"></i></button>
</form>