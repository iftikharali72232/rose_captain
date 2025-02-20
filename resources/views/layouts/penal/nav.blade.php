<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('home') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('img/logo.png') }}" alt="Logo">
            <span class="d-none d-lg-block text-green">
                {{ trans('lang.app_name') }}{{ Session::get('branch_id') }}
            </span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn text-green"></i>
    </div>

    @php
        use App\Models\User;
        $new_users = User::where('is_read', 0)
            ->where('user_type', '!=', 0)
            ->orderBy('id', 'desc')
            ->get(['id', 'name', 'user_type', 'created_at']);
    @endphp

    <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="POST" action="#">
            @csrf
            <input type="text" name="query" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
    </div>

    <a href="{{ url('lang/en') }}" class="mx-30px {{ app()->getLocale() == 'en' ? 'text-green' : 'text-muted' }}">
        English
    </a>
    <a href="{{ url('lang/ar') }}" class="{{ app()->getLocale() == 'ar' ? 'text-green' : 'text-muted' }}">
        العربية
    </a>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <!-- Notification Bell Icon -->
            <li class="nav-item dropdown">
                <a class="nav-link nav-icon text-white" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <span class="badge bg-primary badge-number bg-success">{{ $new_users->count() }}</span>
                </a>

                <ul
                    class="dropdown-menu {{ app()->isLocale('ar') ? 'dropdown-menu-start' : 'dropdown-menu-end' }} dropdown-menu-arrow notifications">
                    <li class="dropdown-header">
                        {{ trans('lang.you_have') }} {{ $new_users->count() }} {{ trans('lang.new_notifications') }}
                        <a href="#"><span
                                class="badge rounded-pill bg-primary p-2 ms-2">{{ trans('lang.read_all') }}</span></a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    @forelse($new_users as $user)
                        <li class="notification-item">
                            <a href="#">
                                <i class="bi bi-person-circle text-primary"></i>
                                <div>
                                    <h4>{{ $user->name }}</h4>
                                    <p>{{ trans('lang.new_user_registered') }}</p>
                                    <p class="small text-muted">{{ $user->created_at->diffForHumans() }}</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                    @empty
                        <li class="dropdown-footer">
                            <p class="text-center">{{ trans('lang.no_new_notifications') }}</p>
                        </li>
                    @endforelse
                </ul>
            </li>
        </ul>

        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
               document.getElementById('logout-form').submit();">
                {{ trans('lang.logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </nav>
</header>
