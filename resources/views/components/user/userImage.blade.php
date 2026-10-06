@props([
    'src' => 'donatur/default/profile.png',
    'alt' => '',
    'width' => '44px',
    'height' => '44px',
    'role' => 'donatur',
])

@if ($role === 'donatur')
    @if (checkFileIsExist($src))
        <img class="user-image" src="{{ asset('storage/' . $src) }}" alt="{{ $alt }}" width="{{ $width }}"
            height="{{ $height }}">
    @else
        <img class="user-image" src="{{ asset('assets/img/default/donatur_profil.jpg') }}" alt="{{ $alt }}" width="{{ $width }}"
            height="{{ $height }}">
    @endif
@else
    <img class="user-image" src="{{ asset('assets/img/default/admin_profil.png') }}"
        alt="Gambar {{ auth()->user()->name }}" width="{{ $width }}" height="{{ $height }}">
@endif
