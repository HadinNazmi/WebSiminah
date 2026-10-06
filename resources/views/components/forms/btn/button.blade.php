@props(['color', 'title', 'type' => 'button', 'id' => ''])

@if ($id === '')
    <button type="{{ $type }}"
        class="forms-sumbit text-capitalize">{{ $title }}</button>
@else
    <button type="{{ $type }}"
        class="forms-sumbit text-capitalize" id="{{ $id }}">{{ $title }}</button>
@endif
