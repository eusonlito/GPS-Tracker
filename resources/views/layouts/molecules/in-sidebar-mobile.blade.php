<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">
        <a href="{{ route('dashboard.index') }}" class="logo {{ str_starts_with($ROUTE, 'dashboard.') ? 'active' : '' }}">
            @svg('/build/images/logo.svg')
        </a>

        <h1 class="flex-1 px-4 truncate">{{ Meta::get('title') }}</h1>

        <a href="javascript:;" id="mobile-menu-toggler">
            @icon('menu', 'w-8 h-8 text-white')
        </a>
    </div>

    <ul class="border-t hidden">
        {!! str_replace('side-', '', view('layouts.molecules.in-sidebar-menu')) !!}
    </ul>
</div>
