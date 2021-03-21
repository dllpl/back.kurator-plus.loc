<?php
$title=$title??'';
?>
<div class="border-top mt-3 pt-3 pl-4 pb-3 position-relative">
    <span class="badge badge-pill badge-light border position-absolute" style="top:-10px;left:10px;">{{$title}}</span>
    @if(!empty($slot))
    {!! $slot !!}
    @endif
</div>