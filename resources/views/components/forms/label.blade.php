@props(['for' => '', 'title'])

@if (!empty($for))
    <label class="custom-label" for="{{ $for }}">{{ $title }}</label>
@else
    <label class="custom-label">{{ $title }}</label>
@endif
