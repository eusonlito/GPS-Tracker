@extends ('domains.profile.update-layout')

@section ('content')

<form method="post">
    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="profile-update-telegram-username" class="form-label">{{ __('profile-update-telegram.username') }}</label>
            <input type="text" name="telegram[username]" class="form-control form-control-lg" id="profile-update-telegram-username" value="{{ $REQUEST->input('telegram.username') }}">
        </div>
    </div>

    @if ($telegram_username)

    <div class="box p-5 mt-5">
        @if ($telegram_chat_id)

        <div class="p-2 text-center text-success">
            {{ __('profile-update-telegram.connected-message') }} <strong><a href="{{ $telegram_bot_link }}" target="_blank">{{ $telegram_bot }}</a></strong>
        </div>

        @else

        <div class="p-2 text-center text-danger">
            {{ __('profile-update-telegram.pending-message') }} <strong><a href="{{ $telegram_bot_link }}" target="_blank">{{ $telegram_bot }}</a></strong>
        </div>

        @endif
    </div>

    @endif

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="profile-update-password_current" class="form-label">{{ __('profile-update-telegram.password_current') }}</label>
            <input type="password" name="password_current" class="form-control form-control-lg" id="profile-update-password_current">
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            @if ($telegram_username && empty($telegram_chat_id))
            <button type="submit" name="_action" value="updateTelegramChatId" class="btn btn-primary">{{ __('profile-update-telegram.connect') }}</button>
            @endif

            <button type="submit" name="_action" value="updateTelegram" class="btn btn-primary">{{ __('profile-update-telegram.save') }}</button>
        </div>
    </div>
</form>

@stop
