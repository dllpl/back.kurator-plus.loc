<?php
$action=$action??'';
$method=$method??'GET';
$method=mb_strtoupper($method);
$formMethod=(in_array($method,['GET','POST']))?$method:'POST';
?>
<form action="{{$action}}" method="{{$formMethod}}">
    {{csrf_field()}}
    @if($formMethod!==$method)
        {{ method_field($method) }}
    @endif
    @if(!empty($slot))
        {!! $slot !!}
    @endif
</form>