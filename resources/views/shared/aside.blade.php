<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- Dashboard: todos los roles -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Finanzas: admin/pastor/miembro -->
        @can('ver-finanzas')
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#finanzas-nav" data-bs-toggle="collapse" href="#">
                <i class="fa-solid fa-coins"></i><span>Finanzas</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="finanzas-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                @if(Auth::user()->rol === 'miembro')
                    <li>
                        <a href="{{ route('ingresos.index') }}">
                            <i class="bi bi-circle"></i><span>Ingresos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('egresos.index') }}">
                            <i class="bi bi-circle"></i><span>Egresos</span>
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('categorias.index') }}">
                            <i class="bi bi-circle"></i><span>Categorías</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
        @endcan


        <!-- Configuración (admin/pastor) -->
        @can('ver-configuracion')
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#config-nav" data-bs-toggle="collapse" href="#">
                <i class="fa-solid fa-gear"></i><span>Configuración</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="config-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                @if(Auth::user()->rol === 'admin')
                    <li>
                        <a href="{{ route('iglesias.index') }}">
                            <i class="bi bi-circle"></i><span>Iglesias</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('usuarios.index') }}">
                            <i class="bi bi-circle"></i><span>Usuarios</span>
                        </a>
                    </li>
                @endif

                @if(Auth::user()->rol === 'pastor')
                    <li>
                        <a href="{{ route('departamentos.index') }}">
                            <i class="bi bi-circle"></i><span>Departamentos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categorias.index') }}">
                            <i class="bi bi-circle"></i><span>Categorías</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
        @endcan

    </ul>
</aside>
