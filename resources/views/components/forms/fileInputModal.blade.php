@props(['name'])

<div class="mb-3 animate__animated animate__fadeInDown modal-input-wrapper form-control modal-input border" id="btnFile"
    onclick="triggerFileInput()">
    <input type="file" id="fileInput" name="{{ $name }}">
    <p id="myFileNameContainer" class="text-secondary">
        Pilih gambar
    </p>

    <span class="material-symbols-outlined border btn-upload-file">
        upload
    </span>
</div>
