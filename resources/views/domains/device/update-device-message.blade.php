@extends ('domains.device.update-layout')

@section ('content')

<form action="{{ route('device.update.device-message.create', $row->id) }}" method="post">
    <input type="hidden" name="_action" value="updateDeviceMessageCreate" />

    <div class="box p-5 mt-5">
        <div class="md:flex">
            <div class="flex-1 p-2">
                <input type="text" name="message" class="form-control form-control-lg" id="device-message-message" placeholder="{{ __('device-update-device-message.message') }}" required>
            </div>

            <div class="flex p-2">
                <button type="button" class="btn form-control-lg block" data-input-insert data-input-insert-selector="#device-message-message" data-input-insert-value="{PASSWORD}" tabindex="-1">@icon('key', 'w-5 h-5')</button>
                <button type="button" class="btn form-control-lg block ml-2" data-input-insert data-input-insert-selector="#device-message-message" data-input-insert-value="{SERIAL}" tabindex="-1">@icon('award', 'w-5 h-5')</button>
            </div>

            <div class="p-2">
                <button type="submit" class="btn btn-primary form-control-lg w-full block">{{ __('device-update-device-message.send') }}</button>
            </div>
        </div>
    </div>
</form>

<div class="overflow-auto scroll-visible header-sticky">
    <table id="device-message-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                <th class="text-left w-1">{{ __('device-update-device-message.message') }}</th>
                <th class="text-left">{{ __('device-update-device-message.response') }}</th>
                <th class="w-1">{{ __('device-update-device-message.created_at') }}</th>
                <th class="w-1">{{ __('device-update-device-message.sent_at') }}</th>
                <th class="w-1">{{ __('device-update-device-message.response_at') }}</th>
                <th class="w-1">{{ __('device-update-device-message.actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($messages as $each)

            @php ($link = route('device.update.device-message.update', [$row->id, $each->id]))

            <tr>
                <td class="text-left w-1"><span class="d-t-m-o max-w-sm" title="{{ $each->message }}">{{ $each->message }}</span></td>
                <td class="text-left"><span class="block whitespace-normal">{{ $each->response }}</span></td>
                <td class="w-1" data-table-sort-value="{{ $each->created_at }}"><span class="block">@dateWithUserTimezone($each->created_at, 'Y-m-d H:i:s')</span></td>
                <td class="w-1" data-table-sort-value="{{ $each->sent_at }}"><span class="block">@dateWithUserTimezone($each->sent_at, 'Y-m-d H:i:s')</span></td>
                <td class="w-1" data-table-sort-value="{{ $each->response_at }}"><span class="block">@dateWithUserTimezone($each->response_at, 'Y-m-d H:i:s')</span></td>
                <td class="w-1">
                    <a href="{{ $link }}" data-toggle="modal" data-target="#delete-modal" data-delete-modal-one class="text-danger">
                        @icon('trash', 'w-4 h-4')
                    </a>

                    <span class="mx-2"></span>

                    <a href="{{ $link }}" data-link-to-post='@json(['_action' => 'updateDeviceMessageDuplicate'])'>@icon('send', 'w-4 h-4')</a>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@include ('molecules.delete-modal', [
    'action' => 'updateDeviceMessageDelete'
])

@stop
