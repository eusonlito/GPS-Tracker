@extends('layouts.in')

@section('body')
<div class="intro-y box p-5">
    <form method="POST" action="{{ route('role.store') }}">
        @csrf
        <input type="hidden" name="_action" value="create" />

        <!-- Role Name -->
        <div class="form-group mb-4">
            <label class="form-label required">{{ __('role-create.Name') }}</label>
            <input type="text"
                name="name"
                class="form-control form-control-lg {{ $errors->has('name') ? 'border-red-500' : '' }}"
                value="{{ old('name') }}"
                required>
            @if($errors->has('name'))
            <div class="text-red-500 mt-1">{{ $errors->first('name') }}</div>
            @endif
        </div>

        <!-- Enterprise ID -->
        <div class="form-group mb-4">
            <label class="form-label required">{{ __('role-create.Enterprise') }}</label>
            <select name="enterprise_id"
                class="form-control form-control-lg {{ $errors->has('enterprise_id') ? 'border-red-500' : '' }}"
                required>
                <option value="">{{ __('role-create.Select Enterprise') }}</option>
                @foreach($enterprises as $enterprise)
                <option value="{{ $enterprise['id'] }}" {{ old('enterprise_id') == $enterprise['id'] ? 'selected' : '' }}>
                    {{ $enterprise['name'] }}
                </option>
                @endforeach
            </select>
            @if($errors->has('enterprise_id'))
            <div class="text-red-500 mt-1">{{ $errors->first('enterprise_id') }}</div>
            @endif
        </div>

        <!-- Description -->
        <div class="form-group mb-4">
            <label class="form-label">{{ __('role-create.Description') }}</label>
            <textarea name="description"
                class="form-control form-control-lg {{ $errors->has('description') ? 'border-red-500' : '' }}"
                rows="3">{{ old('description') }}</textarea>
            @if($errors->has('description'))
            <div class="text-red-500 mt-1">{{ $errors->first('description') }}</div>
            @endif
        </div>

        <!-- Privilege Level -->
        <div class="form-group mb-4">
            <label class="form-label required">{{ __('role-create.Privilege Level') }}</label>
            <select name="highest_privilege_role"
                class="form-control form-control-lg {{ $errors->has('highest_privilege_role') ? 'border-red-500' : '' }}"
                required>
                @foreach($privileges as $value => $label)
                <option value="{{ $value }}" {{ old('highest_privilege_role') == $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
                @endforeach
            </select>
            @if($errors->has('highest_privilege_role'))
            <div class="text-red-500 mt-1">{{ $errors->first('highest_privilege_role') }}</div>
            @endif
        </div>

        <!-- Buttons -->
        <div class="flex justify-end space-x-2 mt-5">
            <a href="{{ route('role.index') }}" class="btn bg-white">
                {{ __('common.Cancel') }}
            </a>
            <button type="submit" class="btn btn-primary">
                {{ __('role-create.Save') }}
            </button>
        </div>
    </form>
</div>
@endsection