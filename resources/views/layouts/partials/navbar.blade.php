<nav class="navbar navbar-expand-lg" style="background: darkorange;">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">DiskusiYuk</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link @if (Request::is('/')) active @endif" aria-current="page"
                        href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (Request::is('diskusi')) active @endif"
                        href="{{ route('diskusi') }}">Diskusi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (Request::is('katalog')) active @endif"
                        href="{{ route('katalog') }}">Katalog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if (Request::is('kontak')) active @endif"
                        href="{{ route('kontak') }}">Kontak</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                @guest
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a></li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
