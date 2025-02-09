<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'addBg' : '' }}" href="{{ route('home') }}">
        <i class="bi bi-grid"></i>
        <span>{{ trans('lang.dashboard') }}</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed {{ Route::currentRouteName() == 'drivers.index' ? 'addBg' : '' }}" data-bs-target="#sellers" data-bs-toggle="collapse" href="#">
        <i class="bi bi-sliders"></i><span>{{ trans('lang.users') }}</span><i class="bi bi-chevron-down {{ app()->getLocale() == 'en' ? 'ms-auto' : 'me-auto' }}"></i>
      </a>
      <ul id="sellers" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ route('drivers.index') }}">
            <i class="bi bi-circle"></i><span>{{ trans('lang.user_list') }}</span>
          </a>
        </li>
        <li>
          <a href="{{ route('drivers.create') }}">
            <i class="bi bi-circle"></i><span>{{ trans('lang.user_create') }}</span>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed {{ Route::currentRouteName() == 'companies.index' ? 'addBg' : '' }}" data-bs-target="#company" data-bs-toggle="collapse" href="#">
        <i class="bi bi-sliders"></i><span>{{ trans('lang.companies') }}</span><i class="bi bi-chevron-down {{ app()->getLocale() == 'en' ? 'ms-auto' : 'me-auto' }}"></i>
      </a>
      <ul id="company" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ route('companies.index') }}">
            <i class="bi bi-circle"></i><span>{{ trans('lang.company_list') }}</span>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed {{ Route::currentRouteName() == 'vehicles.index' ? 'addBg' : '' }}" data-bs-target="#vehicles" data-bs-toggle="collapse" href="#">
        <i class="bi bi-sliders"></i><span>{{ trans('lang.vehicles') }}</span><i class="bi bi-chevron-down {{ app()->getLocale() == 'en' ? 'ms-auto' : 'me-auto' }}"></i>
      </a>
      <ul id="vehicles" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ route('vehicles.index') }}">
            <i class="bi bi-circle"></i><span>{{ trans('lang.vehicle_list') }}</span>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed {{ Route::currentRouteName() == 'wallet.index' ? 'addBg' : '' }}" data-bs-target="#wallet" data-bs-toggle="collapse" href="#">
        <i class="bi bi-sliders"></i><span>{{ trans('lang.wallet') }}</span><i class="bi bi-chevron-down {{ app()->getLocale() == 'en' ? 'ms-auto' : 'me-auto' }}"></i>
      </a>
      <ul id="wallet" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ route('wallet.index') }}">
            <i class="bi bi-circle"></i><span>{{ trans('lang.wallet_list') }}</span>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed {{ Route::currentRouteName() == 'car_types.index' ? 'addBg' : '' }}" data-bs-target="#car_type" data-bs-toggle="collapse" href="#">
        <i class="bi bi-sliders"></i><span>{{ trans('lang.car_type') }}</span><i class="bi bi-chevron-down {{ app()->getLocale() == 'en' ? 'ms-auto' : 'me-auto' }}"></i>
      </a>
      <ul id="car_type" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
          <a href="{{ route('car_types.index') }}">
            <i class="bi bi-circle"></i><span>{{ trans('lang.car_type_list') }}</span>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="{{ route('logout') }}"  onclick="event.preventDefault();
      document.getElementById('logout-form').submit();">
        <i class="bi bi-box-arrow-in-right"></i>
        {{ trans('lang.logout') }}
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
         @csrf
        </form>
      </a>
    </li>

  </ul>

</aside><!-- End Sidebar-->
