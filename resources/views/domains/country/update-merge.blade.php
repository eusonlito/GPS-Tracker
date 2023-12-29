@extends ('domains.country.update-layout')

@section ('content')

<div class="box p-5 mt-5">
    <input type="search" class="form-control form-control-lg" placeholder="{{ __('country-update-merge.filter') }}" data-table-search="#country-update-merge-table" />
</div>

<form method="post">
    <input type="hidden" name="_action" value="updateMerge" />

    <div class="box p-5 mt-5">
        <div class="overflow-auto scroll-visible header-sticky">
            <table id="country-update-merge-table" class="table table-report font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
                <thead>
                    <tr>
                        <th class="text-left">{{ __('country-update-merge.name') }}</th>
                        <th class="text-left">{{ __('country-update-merge.alias') }}</th>
                        <th>{{ __('country-update-merge.created_at') }}</th>
                        <th>{{ __('country-update-merge.updated_at') }}</th>
                        <th>{{ __('country-update-merge.select') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($list as $each)

                    @php ($link = route('country.update', $each->id))

                    <tr>
                        <td class="text-left"><a href="{{ $link }}" class="block">{{ $each->name }}</a></td>
                        <td class="text-left"><a href="{{ $link }}" class="block">{{ implode(', ', $each->alias ?? []) }}</a></td>
                        <td class="w-1" data-table-sort-value="{{ $each->created_at }}"><a href="{{ $link }}" class="block">@dateLocal($each->created_at)</a></td>
                        <td class="w-1" data-table-sort-value="{{ $each->updated_at }}"><a href="{{ $link }}" class="block">@dateLocal($each->updated_at)</a></td>
                        <td class="w-1">
                            @if ($each->id !== $row->id)
                            <input type="checkbox" name="ids[]" value="{{ $each->id }}" />
                            @endif
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('country-update-merge.merge') }}</button>
        </div>
    </div>
</form>

@stop
