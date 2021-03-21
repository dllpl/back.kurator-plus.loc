<?php
$prependText=$prependText??null;
$appendText=$appendText??null;
?>
<div class="input-group">
    @if($prependText)
        <div class="input-group-prepend">
            <div class="input-group-text">{{$prependText}}</div>
        </div>
    @endif
    {!! $slot !!}
    @if($appendText)
        <div class="input-group-append">
            <div class="input-group-text">{{$appendText}}</div>
        </div>
    @endif
</div>
