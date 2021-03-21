<?php
$style = array_replace_recursive([
    'size'=>12,
    'class'=>'',
    'label.size' => 2,
    'label.class' => '',
    'body.class' => '',
], $style ?? []);
$name=($name)??'';
$for=($for)??'';
$slot=$slot??'&nbsp;';

?>
<div class="form-group row col-{{$style['size']}} {{$style['class']}}">
    @if($style['label.size']>0)
        <label class="col-sm-{{$style['label.size']}} {{$style['label.class']}} col-form-label" for="{!! $for !!}">{!! $name !!}</label>
    @endif
    <div class="col-sm-{{12-$style['label.size']}} {{$style['body.class']}}">
        {{$slot}}
    </div>
</div>