<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <a href="{{ route('home') }}" class="logo d-flex align-items-center">
      <img src="{{ asset('img/login.png') }}" alt="">
      <span class="d-none d-lg-block">TEO</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

      {{-- 🔍 Ícono de búsqueda (móvil) --}}
      <li class="nav-item d-block d-lg-none">
        <a class="nav-link nav-icon search-bar-toggle" href="#">
          <i class="bi bi-search"></i>
        </a>
      </li>

      {{-- 👤 Menú de usuario --}}
      <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          
          {{-- ✅ Mostrar foto de perfil o ícono por defecto --}}
          @if(Auth::user()->foto)
            <img src="{{ asset('fotos_perfil/' . Auth::user()->foto) }}" 
                alt="Perfil"
                class="rounded-circle"
                width="35" height="35"
                style="object-fit: cover;">
          @else
              <i class="fa-regular fa-circle-user fa-2x"></i>
          @endif

          
          <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
        </a>

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header text-center">
            <h6>{{ Auth::user()->name }}</h6>
            <span>{{ ucfirst(Auth::user()->rol) }}</span>
          </li>

          <li><hr class="dropdown-divider"></li>

          {{-- 🧍 Ir al perfil --}}
          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('perfil') }}">
              <i class="bi bi-person-circle"></i>
              <span>Mi perfil</span>
            </a>
          </li>

          <li><hr class="dropdown-divider"></li>

          {{-- 🚪 Cerrar sesión --}}
          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
              <i class="bi bi-box-arrow-right"></i>
              <span>Salir</span>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
</header>
