@props(['name', 'label', 'disabled' => false])

@if ($disabled === false)
    <div class="form-control-admin animate__animated animate__fadeInUp">
        <label for="{{ $label }}" class="form-label">{{ $label }}</label>
        <select class="form-select" aria-label="Default select example" name="{{ $name }}" required>
            <option selected>Pilih {{ $label }}</option>
            {{ $slotOptions }}
        </select>
    </div>
@else
    <div class="form-control-admin animate__animated animate__fadeInUp">
        <label for="{{ $label }}" class="form-label">{{ $label }}</label>
        <select class="form-select" aria-label="Default select example" name="{{ $name }}" required disabled>
            <option selected>Pilih {{ $label }}</option>
            {{ $slotOptions }}
        </select>
    </div>
@endif
