<nav>
    <ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('about') }}">About</a></li>
        <li><a href="{{ route('education') }}">Education</a></li>
        <li><a href="{{ route('projects.index') }}">Projects</a></li>

        @auth
            <li><a href="{{ route('profile.saya') }}">Profil Saya</a></li>
        @endauth

        <li class="nav-auth">
            @auth
                <span>Halo, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
            @endauth
        </li>
    </ul>
</nav>