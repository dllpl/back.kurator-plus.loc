<div class="jumbotron">
    <h1 class="display-4">{{$code}}</h1>
    <p class="lead">{{$message}}</p>
    <hr class="my-4">
    {{$slot}}
    @if(url()->current()!==url()->previous())
        <a class="btn btn-primary btn-lg" href="{{url()->previous()}}" role="button">Вернуться назад</a>
    @endif
</div>