@props(['modalName', 'title'])

<div class="modal fade" id="{{ $modalName }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-csm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title text-poppins c-fs20 c-fwb" id="exampleModalLabel">{{ $title }}</h1>
                <button type="button" class="btn-close me-2" data-bs-dismiss="modal" aria-label="Close">
                    <span class="material-symbols-outlined text-dark">
                        close
                    </span>
                </button>
            </div>
            <div class="modal-body">
                {{ $slotBody }}
            </div>
        </div>
    </div>
</div>
