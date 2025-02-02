@include('layouts.header')

<nav id="navbar-main" class="navbar is-fixed-top">
  <div class="navbar-brand">
    <a class="navbar-item mobile-aside-button">
      <span class="icon"><i class="mdi mdi-forwardburger mdi-24px"></i></span>
    </a>
    <div class="navbar-item">
      <div class="control"><input placeholder="Search everywhere..." class="input"></div>
    </div>
  </div>
  <div class="navbar-brand is-right">
    <a class="navbar-item --jb-navbar-menu-toggle" data-target="navbar-menu">
      <span class="icon"><i class="mdi mdi-dots-vertical mdi-24px"></i></span>
    </a>
  </div>
  <div class="navbar-menu" id="navbar-menu">
    <div class="navbar-end">
      
      <div class="navbar-item dropdown has-divider has-user-avatar">
        <a class="navbar-link">
          <div class="user-avatar">
            <img src="" alt="John Doe" class="rounded-full">
          </div>
          <div class="is-user-name"><span>{{$user->name}}</span></div>
          <span class="icon"><i class="fa-solid fa-chevron-down"></i></span>
        </a>
      </div>
      <a href="#" class="navbar-item has-divider desktop-icon-only">
        <span class="icon"><i class="fa-regular fa-address-card"></i></span>
        <span>About</span>
      </a>
      <a href="#" class="navbar-item has-divider desktop-icon-only">
        <span class="icon"><i class="fa-regular fa-circle-question"></i></span>
        <span>GitHub</span>
      </a>
      <a href="{{ route('signout') }}" title="Log out" class="navbar-item desktop-icon-only">
        <span class="icon"><i class="fa-solid fa-right-from-bracket"></i></span>
        <span>Log out</span>
      </a>
    </div>
  </div>
</nav>
<aside class="aside is-placed-left is-expanded">
  <div class="aside-tools">
    <div>
      Admin <b class="font-black">One</b>
    </div>
  </div>
  <div class="menu is-menu-main">
    <p class="menu-label">General</p>
    <ul class="menu-list">
      <li class="--set-active-index-html">
        <a href="{{ route('administrator.dashboard') }}">
          <span class="icon"><i class="fa-solid fa-display"></i></span>
          <span class="menu-item-label">Dashboard</span>
        </a>
      </li>
      <li class="--set-active-tables-html">
        <a href="{{ route('administrator.courses') }}">
          <span class="icon"><i class="fa-brands fa-discourse"></i></span>
          <span class="menu-item-label">Courses</span>
        </a>
      </li>
      <li class="--set-active-tables-html">
        <a href="{{ route('administrator.members') }}">
          <span class="icon"><i class="fa-regular fa-user"></i></span>
          <span class="menu-item-label">Members</span>
        </a>
      </li>
      <li class="--set-active-tables-html">
        <a href="{{ route('administrator.categories') }}">
          <span class="icon"><i class="fa-solid fa-tower-observation"></i></span>
          <span class="menu-item-label">Categories</span>
        </a>
      </li>
      <li class="--set-active-tables-html">
        <a href="{{ route('administrator.bookings') }}">
          <span class="icon"><i class="fa-solid fa-utensils"></i></span>
          <span class="menu-item-label">Bookings</span>
        </a>
      </li>
      <li class="--set-active-tables-html">
        <a href="{{ route('administrator.reviews') }}">
          <span class="icon"><i class="fa-regular fa-comment"></i></span>
          <span class="menu-item-label">Reviews</span>
        </a>
      </li>
      <li class="--set-active-tables-html">
        <a href="{{ route('administrator.payments') }}">
          <span class="icon"><i class="fa-regular fa-credit-card"></i></span>
          <span class="menu-item-label">Payments</span>
        </a>
      </li>
      <li class="--set-active-tables-html">
        <a href="{{ route('administrator.account') }}">
          <span class="icon"><i class="fa-regular fa-user"></i></span>
          <span class="menu-item-label">Account</span>
        </a>
      </li>
    </ul>
    <p class="menu-label">About</p>
    <ul class="menu-list">
      <li>
        <a href="#" class="has-icon">
          <span class="icon"><i class="fa-regular fa-address-card"></i></span>
          <span class="menu-item-label">About</span>
        </a>
      </li>
      <li>
        <a href="{{ route('signout') }}" class="has-icon">
          <span class="icon"><i class="fa-solid fa-right-from-bracket"></i></span>
          <span class="menu-item-label">Sign Out</span>
        </a>
      </li>
    </ul>
  </div>
</aside>
<section class="is-hero-bar">
  <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
    <h1 class="title">
      Profile
    </h1>
    <button class="button light">Button</button>
  </div>
</section>
<section class="section main-section">
@yield('content')
</section>
@include('layouts.footer')