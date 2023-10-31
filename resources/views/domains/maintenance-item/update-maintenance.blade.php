@extends ('domains.maintenance-item.update-layout')

@section ('content')

<div class="flex-grow mt-5">
    <input type="search" class="form-control form-control-lg" placeholder="{{ __('maintenance-item-update-maintenance.filter') }}" data-table-search="#maintenance-item-list-table" />
</div>

<div class="overflow-auto scroll-visible header-sticky">
    <table id="maintenance-item-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                <th class="text-left">{{ __('maintenance-item-update-maintenance.vehicle') }}</th>
                <th class="text-left">{{ __('maintenance-item-update-maintenance.mainteance') }}</th>
                <th class="text-left">{{ __('maintenance-item-update-maintenance.workshop') }}</th>
                <th>{{ __('maintenance-item-update-maintenance.date_at') }}</th>
                <th>{{ __('maintenance-item-update-maintenance.quantity') }}</th>
                <th>{{ __('maintenance-item-update-maintenance.amount_gross') }}</th>
                <th>{{ __('maintenance-item-update-maintenance.amount_net') }}</th>
                <th>{{ __('maintenance-item-update-maintenance.tax_percent') }}</th>
                <th>{{ __('maintenance-item-update-maintenance.subtotal') }}</th>
                <th>{{ __('maintenance-item-update-maintenance.tax_amount') }}</th>
                <th>{{ __('maintenance-item-update-maintenance.total') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($maintenancesPivot as $each)

            @php ($link = route('maintenance.update.item', $each->maintenance->id))

            <tr>
                <td><a href="{{ $link }}" class="block text-left">{{ $each->maintenance->vehicle->name }}</a></td>
                <td><a href="{{ $link }}" class="block text-left">{{ $each->maintenance->name }}</a></td>
                <td><a href="{{ $link }}" class="block text-left">{{ $each->maintenance->workshop }}</a></td>
                <td data-table-sort-value="{{ $each->maintenance->date_at }}"><a href="{{ $link }}" class="block">@dateLocal($each->maintenance->date_at)</a></td>
                <td data-table-sort-value="{{ $each->quantity }}"><a href="{{ $link }}" class="block">@number($each->quantity, 2)</a></td>
                <td data-table-sort-value="{{ $each->amount_gross }}"><a href="{{ $link }}" class="block">@unitHumanRaw('money', $each->amount_gross, 2)</a></td>
                <td data-table-sort-value="{{ $each->amount_net }}"><a href="{{ $link }}" class="block">@unitHumanRaw('money', $each->amount_net, 2)</a></td>
                <td data-table-sort-value="{{ $each->tax_percent }}"><a href="{{ $link }}" class="block">@number($each->tax_percent, 2)</a></td>
                <td data-table-sort-value="{{ $each->subtotal }}"><a href="{{ $link }}" class="block">@unitHumanRaw('money', $each->subtotal, 2)</a></td>
                <td data-table-sort-value="{{ $each->tax_amount }}"><a href="{{ $link }}" class="block">@unitHumanRaw('money', $each->tax_amount, 2)</a></td>
                <td data-table-sort-value="{{ $each->total }}"><a href="{{ $link }}" class="block">@unitHumanRaw('money', $each->total, 2)</a></td>
            </tr>

            @endforeach
        </tbody>

        <tfoot class="bg-white">
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>{{ $total['quantity'] }}</th>
                <th>@unitHumanRaw('money', $total['amount_gross'])</th>
                <th>@unitHumanRaw('money', $total['amount_net'])</th>
                <th></th>
                <th>@unitHumanRaw('money', $total['subtotal'])</th>
                <th>@unitHumanRaw('money', $total['tax_amount'])</th>
                <th>@unitHumanRaw('money', $total['total'])</th>
            </tr>
        </tfoot>
    </table>
</div>

@stop
