<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar mt-0">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Homepage
                        </p>
                    </a>
                </li>

                <li class="nav-header">GENERAL</li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link @if (Request::is('dashboard')) active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('collection.index') }}" class="nav-link @if (Request::is('dashboard/collection') || Request::is('dashboard/collection/*')) active @endif">
                        <i class="nav-icon fas fa-heart"></i>
                        <p>My Collection</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('favorite.index') }}" class="nav-link @if (Request::is('dashboard/favorite') || Request::is('dashboard/favorite/*')) active @endif">
                        <i class="nav-icon fas fa-bookmark"></i>
                        <p>My Favorite</p>
                    </a>
                </li>

                @if (Auth::user()->role != 'admin')
                    <li class="nav-item">
                        <a href="{{ route('user.posts.index') }}" class="nav-link @if (Request::is('dashboard/posts') || Request::is('dashboard/posts/*')) active @endif">
                            <i class="nav-icon fas fa-book"></i>
                            <p>My Posts</p>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->role == 'admin')
                    <li class="nav-header">ADMINISTRATOR</li>
                    {{-- manage diskusi --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.posts.index') }}" class="nav-link @if (Request::is('dashboard/admin/posts') || Request::is('dashboard/admin/posts/*')) active @endif">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Manage Posts</p>
                        </a>
                    </li>

                    <li class="nav-header">Master Data</li>
                    {{-- manage pengguna --}}
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}"
                            class="nav-link @if (Request::is('dashboard/admin/users') || Request::is('dashboard/admin/users/*')) active @endif">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Manage Users</p>
                        </a>
                    </li>

                    {{-- manage kategori --}}
                    <li class="nav-item">
                        <a href="{{ route('categories.index') }}"
                            class="nav-link @if (Request::is('dashboard/admin/categories') || Request::is('dashboard/admin/categories/*')) active @endif">
                            <i class="nav-icon fas fa-folder"></i>
                            <p>Manage Categories</p>
                        </a>
                    </li>
                @endif

                <li class="nav-header">SETTINGS AND PRIVACY</li>
                {{-- account --}}
                <li class="nav-item">
                    <a href="{{ route('account') }}" class="nav-link @if (Request::is('dashboard/settings-and-privacy/account') || Request::is('dashboard/settings-and-privacy/account/*')) active @endif">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Account</p>
                    </a>
                </li>

                {{-- privacy --}}
                <li class="nav-item">
                    <a href="{{ route('privacy') }}" class="nav-link @if (Request::is('dashboard/settings-and-privacy/privacy') || Request::is('dashboard/settings-and-privacy/privacy/*')) active @endif">
                        <i class="nav-icon fas fa-lock"></i>
                        <p>Privacy</p>
                    </a>
                </li>

                {{-- security --}}
                <li class="nav-item">
                    <a href="{{ route('security') }}" class="nav-link @if (Request::is('dashboard/settings-and-privacy/security') || Request::is('dashboard/settings-and-privacy/security/*')) active @endif">
                        <i class="nav-icon fas fa-shield-alt"></i>
                        <p>Security</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
