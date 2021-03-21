<?php
$style = array_replace_recursive([
    'main.bg'   => 'light',
    'main.size' => null,
    'main.text' => null,
    'body.class'=>null,
    'body.footer.type' => 'light'
], $style ?? []);

$id=$id??rand(0,99999);

$rightHeader=$rightHeader??'';

?>

@if(!empty($style['main.size']))
    <div class="{{$style['main.size']}}">
        @endif
        <div class="card bg-{{$style['main.bg']}} mb-3 pb-2">
            @if(!empty($header)||!empty($rightHeader))
                <div class="card-header"
                     type="button" data-toggle="collapse" data-target="#collapse-{{$id}}" aria-expanded="false" aria-controls="collapseExample"
                     style="cursor: pointer;"
                >
                    @if($header){!! $header !!}@endif
                    @if($rightHeader)<div class="float-right">{!! $rightHeader !!}</div>@endif
                </div>
            @endif
            <div class="collapse" id="collapse-{{$id}}">
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
        </div>
        @if(!empty($style['main.size']))
    </div>
@endif