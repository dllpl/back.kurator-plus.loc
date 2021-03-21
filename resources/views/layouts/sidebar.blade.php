<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="{{route('home')}}">
                    <i class="nav-icon icon-speedometer"></i> Главная
                </a>
            </li>
            @role('root')
                <li class="nav-title">Admin</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin:user.index')}}">
                        <i class="nav-icon icon-user"></i> Пользователи
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin:organization.index')}}">
                        <i class="nav-icon far fa-building"></i> Организации
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin:role.index')}}">
                        <i class="nav-icon icon-lock"></i> Роли
                    </a>
                </li>
            @endrole
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
