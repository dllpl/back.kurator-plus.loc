<?php
$style = array_replace_recursive([
    'main.bg'     => null,
    'main.class'  => null,
    'main.size'   => null,
    'main.text'   => null,
    'head.bg'     => null,
    'body.class'  => null,
    'footer.type' => null
], $style ?? []);

$rightHeader = $rightHeader ?? '';

?>

@if(!empty($style['main.size']))
    <div class="{{$style['main.size']}}">
        @endif
        <div class="card bg-{{$style['main.bg']}} {{$style['main.class']}} mb-3">
            @if(!empty($header)||!empty($rightHeader))
                <div class="card-header {{$style['head.bg']?'bg-'.$style['head.bg']:''}}">
                    @if($header){!! $header !!}@endif
                    @if($rightHeader)
                        <div class="float-right">{!! $rightHeader !!}</div>@endif
                </div>
            @endif
            <div class="card-body {{$style['body.class']}}">
                @if(!empty($title))
                    <h5 class="card-title">{!! $title !!}</h5>
                @endif
                @if(!empty($slot))
                    {!! $slot !!}
                @endif
            </div>
            @if(!empty($footer))
                <div class="card-footer bg-transparent border-{{$style['footer.type']}}">{!! $footer !!}</div>
            @endif
        </div>
        @if(!empty($style['main.size']))
    </div>
@endif