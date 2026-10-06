<x-forms.label for="insertGambarLokasi" title="Foto Lokasi" />
<div class="insert-gambar-lokasi" id="insertGambarContainer">
    <input type="file" name="gambar" id="insertGambarLokasi" accept="image/*" value="">
    <div class="detail-text text-center" id="dropAndDropArea">
        <img class="icon" src="{{ asset('assets/img/icon/upload.svg') }}" alt="Icon upload">
        <span>Unggah Foto</span>
        <p>Pilih atau tarik foto disini</p>
    </div>
</div>
