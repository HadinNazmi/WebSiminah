@props(['source', 'alt'])

<div class="gambar-lokasi" data-bs-toggle="modal" data-bs-target="#ModalDetailGambarLokasi">
    @if (checkFileIsExist($source))
        <img src="{{ asset('storage/lokasi/' . $source) }}" alt=""
            onclick="showDetailGambarLokasi('{{ asset('storage/lokasi/' . $source) }}')">
    @else
        <img src="{{ asset('assets/img/default/kontainer.jpg') }}" alt=""
            onclick="showDetailGambarLokasi('{{ asset('assets/img/default/kontainer.jpg') }}')">
    @endif
</div>
