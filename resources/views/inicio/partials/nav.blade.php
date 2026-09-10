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
    <details class="nav-dropdown" {{ request()->routeIs('inicio.jovenes', 'inicio.escueladominical') ? 'open' : '' }}>
      <summary class="nav-link {{ request()->routeIs('inicio.jovenes', 'inicio.escueladominical') ? 'active' : '' }}">Departamentos</summary>
      <div class="dropdown-menu">
        <a class="nav-link {{ request()->routeIs('inicio.jovenes') ? 'active' : '' }}" href="{{ route('inicio.jovenes', [], false) }}">Jóvenes</a>
        <a class="nav-link {{ request()->routeIs('inicio.escueladominical') ? 'active' : '' }}" href="{{ route('inicio.escueladominical', [], false) }}">Escuela dominical</a>
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
  })();
</script>
