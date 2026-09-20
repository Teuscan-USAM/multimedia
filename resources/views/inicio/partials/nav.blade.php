<nav class="nav-wrap" aria-label="Navegación principal">
  <a class="brand" href="{{ route('inicio.index', [], false) }}">
    <span class="brand-mark">AD</span>
    <span>EL SALVADOR</span>
  </a>

  <button class="menu-toggle" type="button" aria-controls="public-nav-links" aria-expanded="false" aria-label="Abrir menú">
    <span></span><span></span><span></span>
  </button>

  <div class="nav-links" id="public-nav-links">
    <a class="nav-link {{ request()->routeIs('inicio.index') ? 'active' : '' }}" href="{{ route('inicio.index', [], false) }}">Inicio</a>

    @php
      $isJovenesActive = request()->routeIs('inicio.jovenes');
      $isEscuelaActive = request()->routeIs('inicio.escueladominical');
      $isDeptActive = $isJovenesActive || $isEscuelaActive;
    @endphp

    <details class="nav-dropdown" {{ $isDeptActive ? 'open' : '' }}>
      <summary class="nav-link {{ $isDeptActive ? 'active' : '' }}">Departamentos</summary>
      <div class="dropdown-menu">
        <a class="nav-link {{ $isJovenesActive ? 'active' : '' }}" href="{{ route('inicio.jovenes', [], false) }}">Jóvenes</a>
        <a class="nav-link {{ $isEscuelaActive ? 'active' : '' }}" href="{{ route('inicio.escueladominical', [], false) }}">Escuela dominical</a>
      </div>
    </details>

    <a class="login-link" href="{{ route('login', [], false) }}">Iniciar sesión</a>
  </div>
</nav>

<script>
  (() => {
    const toggle = document.querySelector('.menu-toggle');
    const links = document.querySelector('#public-nav-links');

    if (!toggle || !links) return;

    toggle.addEventListener('click', () => {
      const isOpen = links.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', String(isOpen));
      toggle.setAttribute('aria-label', isOpen ? 'Cerrar menú' : 'Abrir menú');
    });

    links.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        links.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-label', 'Abrir menú');
      });
    });

    // Cerrar el dropdown al hacer clic fuera
    document.addEventListener('click', (e) => {
      const dropdowns = document.querySelectorAll('.nav-dropdown');
      dropdowns.forEach(dropdown => {
        if (!dropdown.contains(e.target)) {
          dropdown.removeAttribute('open');
        }
      });
    });
  })();
</script>