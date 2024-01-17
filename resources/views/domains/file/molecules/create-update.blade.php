<div class="box p-5 mt-5">
    <div class="lg:grid grid-cols-12 gap-6 p-2">
        @foreach ($files as $i => $each)

        <div class="col-span-4">
            <label for="files-{{ $i }}-file" class="form-label block truncate" title="{{ $each->name }}">{{ $each->name }}</label>

            <div class="input-group input-file-custom" data-input-file-custom>
                <input type="text" value="{{ $each->name }}" class="form-control form-control-lg truncate" title="{{ $each->name }}" readonly />

                <label for="files-{{ $i }}-file" class="input-group-text input-group-text-lg border-0">@icon('upload', 'w-5 h-5')</label>
                <input type="hidden" name="files[{{ $i }}][id]" value="{{ $each->id }}" />
                <input type="file" name="files[{{ $i }}][file]" id="files-{{ $i }}-file" class="hidden" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" />

                <a href="{{ route('file.view', [$each->id, $each->name]) }}" class="input-group-text input-group-text-lg" target="_blank" tabindex="-1">@icon('external-link', 'w-5 h-5')</a>

                <label class="input-group-text input-group-text-lg" title="{{ __('file-create.delete') }}">
                    <input type="checkbox" name="files[{{ $i }}][delete]" value="1">
                    @icon('trash', 'ml-1 w-5 h-5')
                </label>
            </div>
        </div>

        @endforeach

        @for ($i = count($files); $i < 3; $i++)

        <div class="col-span-4">
            <label for="files-{{ $i }}-file" class="form-label block truncate">{{ __('file-create.add-attachemnt') }}</label>

            <div class="input-group input-file-custom" data-input-file-custom>
                <input type="text" class="form-control form-control-lg truncate" readonly />
                <label for="files-{{ $i }}-file" class="input-group-text input-group-text-lg border-0">@icon('upload', 'w-5 h-5')</label>
                <input type="file" name="files[{{ $i }}][file]" id="files-{{ $i }}-file" class="hidden" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" />
            </div>
        </div>

        @endfor
    </div>
</div>
