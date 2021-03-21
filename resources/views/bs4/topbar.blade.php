<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">
        {{$title}}
    </a>
    <ul class="navbar-nav mr-auto">
        @foreach($menus as $key=>$menu)
            <li class="nav-item">
                <a class="nav-link" href="{{ $menu }}">{{ $key }}</a>
            </li>
        @endforeach
    </ul>
    <ul class="navbar-nav ml-auto">
        @foreach($menus_right as $key=>$menu)
            <li class="nav-item">
                <a class="nav-link" href="{{ $menu }}">{{ $key }}</a>
            </li>
        @endforeach
    </ul>

</nav>
