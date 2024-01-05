<nav class="side-nav">
    <ul>
        <li>
            <a href="{{ route('dashboard.index') }}" class="logo {{ str_starts_with($ROUTE, 'dashboard.') ? 'active' : '' }}">
                @svg('/build/images/logo.svg')
            </a>
        </li>

        @include ('layouts.molecules.in-sidebar-menu')
    </ul>
</nav>
