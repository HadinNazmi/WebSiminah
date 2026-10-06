@props(['label', 'type' => 'text', 'name', 'placeholder', 'value' => '', 'disabled' => false])

@if ($disabled === false)
    <div class="form-control-admin animate__animated animate__fadeInUp">
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
        <input type="{{ $type }}" class="form-control" id="{{ $name }}" placeholder="{{ $placeholder }}"
            name="{{ $name }}" value="{{ $value }}" required>
    </div>
@else
    <div class="form-control-admin animate__animated animate__fadeInUp">
        <label for="{{ $name }}" class="form-label">{{ $label }}</label>
        <input type="{{ $type }}" class="form-control" id="{{ $name }}"
            placeholder="{{ $placeholder }}" name="{{ $name }}" value="{{ $value }}" required disabled>
    </div>
@endif
