@if (strtolower($type) == 'kontainer')

    {{-- <progress class="progress-{{ $color }} progress-kontainer" value="{{ $value }}" max="{{ $max }}"></progress> --}}

    @if ($value >= $max * 0.75)
        <progress class="progress-red" value="{{ $value }}" max="{{ $max }}"></progress>
    @elseif($value >= $max * 0.5 && $value <= $max * 0.75)
        <progress class="progress-yellow" value="{{ $value }}" max="{{ $max }}"></progress>
    @else
        <progress class="progress-green" value="{{ $value }}" max="{{ $max }}"></progress>
    @endif
@else
    @if ($value <= $max / 2)
        <progress class="progress-red" value="{{ $value }}" max="{{ $max }}"></progress>
    @else
        <progress class="progress-green" value="{{ $value }}" max="{{ $max }}"></progress>
    @endif

@endif
    