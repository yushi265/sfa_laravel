<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <!-- Container wrapper -->
    <div class="container-fluid">
        <!-- Navbar brand -->
        <a class="navbar-brand" href="{{ route('home') }}">
            SFA
        </a>

        @auth
            <!-- Toggle button -->
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link
                            @if (Str::before(Request::path(), '/') === 'customers' ) active @endif" href="{{ route('customers.index') }}">顧客管理</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link
                            @if (Str::before(Request::path(), '/') === 'progresses' ) active @endif" href="{{ route('progresses.index') }}">進捗管理</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (Str::before(Request::path(), '/') === 'contracts' ) active @endif" href="{{ route('contracts.index') }}">成約情報</a>
                    </li>
                    @can('system-only')
                        <li class="nav-item">
                            <a class="nav-link @if (Str::before(Request::path(), '/') === 'admin' ) active @endif" href="{{ route('admin.index') }}">権限管理</a>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link @if (Str::before(Request::path(), '/')==='weathers' ) active @endif" href="{{ route('weathers') }}">天気予報</a>
                    </li>

                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-mdb-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name . '(' . Auth::user()->role->name . ')' }}
                        </a>
                        <!-- Dropdown menu -->
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    {{ __('ログアウト') }}
                                </a>
                            </li>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </ul>
            </div>
        </div>
    @endauth
    <!-- Collapsible wrapper -->
    </div>
    <!-- Container wrapper -->
</nav>
<!-- Navbar -->
