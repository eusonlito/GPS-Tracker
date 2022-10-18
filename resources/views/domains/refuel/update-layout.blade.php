@extends ('layouts.in')

@section ('body')

<div class="box flex items-center px-5">
    <div class="nav nav-tabs flex-col sm:flex-row justify-center lg:justify-start mr-auto" role="tablist">
        <a href="{{ route('refuel.update', $row->id) }}" class="py-4 sm:mr-8 {{ ($ROUTE === 'refuel.update') ? 'active' : '' }}" role="tab">{{ $row->date_at }}</a>
    </div>
</div>

<div class="tab-content">
    <div class="tab-pane active" role="tabpanel">
        @yield('content')
    </div>
</div>

@stop
