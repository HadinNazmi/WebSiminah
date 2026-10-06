@props(['name'])

<div class="mb-3 animate__animated animate__fadeInDown modal-input-wrapper form-control modal-input border" id="btnFile"
    onclick="triggerFileEdit()">
    <input type="file" id="fileEdit" name="{{ $name }}">
    <p id="myFileInputNameContainer" class="text-secondary">
        Pilih gambar
    </p>

    <span class="material-symbols-outlined border btn-upload-file">
        upload
    </span>
</div>
