@extends ('domains.user.profile-layout')

@section ('content')

<form method="post">
    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="user-telegram-username" class="form-label">{{ __('user-profile-telegram.username') }}</label>
            <input type="text" name="telegram[username]" class="form-control form-control-lg" id="user-telegram-username" value="{{ $REQUEST->input('telegram.username') }}" required>
        </div>
    </div>

    @if ($telegram_username)

    <div class="box p-5 mt-5">
        @if ($telegram_chat_id)

        <div class="p-2 text-center text-success">
            {{ __('user-profile-telegram.connected-message') }} <strong><a href="{{ $telegram_bot_link }}" target="_blank">{{ $telegram_bot }}</a></strong>
        </div>

        @else

        <div class="p-2 text-center text-danger">
            {{ __('user-profile-telegram.pending-message') }} <strong><a href="{{ $telegram_bot_link }}" target="_blank">{{ $telegram_bot }}</a></strong>
        </div>

        @endif
    </div>

    @endif

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="user-password_current" class="form-label">{{ __('user-profile-telegram.password_current') }}</label>
            <input type="password" name="password_current" class="form-control form-control-lg" id="user-password_current">
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            @if ($telegram_username && empty($telegram_chat_id))
            <button type="submit" name="_action" value="profileTelegramChatId" class="btn btn-primary">{{ __('user-profile-telegram.connect') }}</button>
            @endif

            <button type="submit" name="_action" value="profileTelegram" class="btn btn-primary">{{ __('user-profile-telegram.save') }}</button>
        </div>
    </div>
</form>

@stop
