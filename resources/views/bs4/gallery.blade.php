<?php

/**
 * @var array $photos
 */
foreach ($photos as $key=>$photo) {
    if (is_string($photo)) {
        $photos[$key]=(object)array('image'=>$photo,'title'=>null,'description'=>null);
    }
}

?>

<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">

    <ol class="carousel-indicators">
        @foreach( $photos as $photo )
            <li data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
        @endforeach
    </ol>

    <div class="carousel-inner" role="listbox">
        @foreach( $photos as $photo )
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <img class="d-block mx-auto img-fluid" src="{{ $photo->image }}" alt="{{ $photo->title }}">
                <div class="carousel-caption d-none d-md-block">
                    <h3>{{ $photo->title }}</h3>
                    <p>{{ $photo->description }}</p>
                </div>
            </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>