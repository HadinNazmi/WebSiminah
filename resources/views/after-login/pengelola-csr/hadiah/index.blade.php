@extends('components._partials.default')

@section('content')
    <div class="container-fluid py-2 ps-4">
        <div class="row">
            <div class="col-xxl-11 col-xl-11 col-lg-12 col-md-11 col-sm-12 col-12">
                <div class="row reedem-reward animate__animated animate__fadeInLeft">
                    <div class="col-xxl-10 col-xl-10 col-xl-10 col-md-10 col-sm-10 col-10">
                        <div class="table-header-redeem">
                            Daftar hadiah
                        </div>
                    </div>
                    <div
                        class="col-md-2 col-sm-2 col-2 text-poppins text-14 btn-reward-position d-flex justify-content-end align-items-end">
                        <div class="btn-reward bg-success btn-success position-relative">
                            <a href="#" class="position-relative add-reward" data-bs-toggle="modal"
                                data-bs-target="#add-reward">Tambah
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <x-forms.table id="tabel-index-reward">
                            @slot('headSlot')
                                <th>NAMA HADIAH</th>
                                <th class="text-center">STOK HADIAH</th>
                                <th class="text-center">POIN</th>
                                <th>MASA BERLAKU</th>
                                <th>GAMBAR</th>
                                <th>AKSI</th>
                            @endslot

                            @slot('bodySlot')
                                {{-- {{ dd($reward) }} --}}
                                @if (!empty($reward))
                                    @foreach ($reward as $item)
                                        <tr class="reward-row table-row-image">
                                            <td class="ps-4 text-14">
                                                <span class="text-poppins">
                                                    {{ $item->nama_reward }}
                                                </span>
                                            </td>
                                            <td class="text-center text-inter-regular text-14">
                                                <span>{{ $item->stok }}</span>
                                            </td>
                                            <td class="text-center text-inter-regular text-14">
                                                <span>{{ $item->jumlah_poin }}</span>
                                            </td>
                                            <td class="ps-4 text-inter-regular text-14">
                                                <span>{{ $item->masa_berlaku }}</span>
                                            </td>

                                            <td class="ps-4 text-inter-regular text-14">
                                                <div class="cursor-pointer">
                                                    <img src="{{ asset('storage/reward/' . $item->gambar) }}" alt=""
                                                        width="34" alt="gambar {{ $item->nama_reward }}"
                                                        data-bs-toggle="modal" data-bs-target="#detail-image"
                                                        onclick="detailGambarReward('{{ asset('storage/reward/' . $item->gambar) }}')">
                                                </div>
                                            </td>
                                            <td class="ps-4 text-inter-regular text-14">
                                                <div class="btn-reward btn-list position-relative">
                                                    <a href="#" class="position-relative add-reward" id="edit-reward-id"
                                                        data-bs-toggle="modal" data-bs-target="#edit-reward"
                                                        onclick="
                                                        editDataReward(
                                                            '{{ $item->nama_reward }}', 
                                                            '{{ $item->stok }}', 
                                                            '{{ $item->jumlah_poin }}',
                                                            '{{ $item->masa_berlaku }}',
                                                            '{{ route('hadiah.update', ['id' => $item->id_reward]) }}')
                                                    ">EDIT
                                                    </a>
                                                </div>
                                                &nbsp;&nbsp;&nbsp;
                                                <div class="btn-reward btn-list btn-custom-danger position-relative">
                                                    <a href="#" class="position-relative add-reward"
                                                        onclick="deleteReward('{{ route('hadiah.delete', ['id' => $item->id_reward]) }}')">DELETE</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    @if (!empty($message))
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>{{ $message }}</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endif
                                @endif
                            @endslot
                        </x-forms.table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-forms.deleted />

    {{-- Detail gambar --}}
    <x-modals.detailGambarModal modalName="detail-image" title="Detail gambar hadiah">
        @slot('slotBody')
            <div class="modal-detail-gambar">
                <img src="#" alt="gambar" id="modal-image-sumbangan">
            </div>
        @endslot
        </x-modals.Modal>

        {{-- Insert modal --}}
        <x-modals.Modal modalName="add-reward" title="Tambah hadiah">
            @slot('slotMethod')
                <form enctype="multipart/form-data" method="POST" action="{{ route('hadiah.store') }}">
                    @csrf
                @endslot

                @slot('slotBody')
                    <x-forms.input placeholder="Nama hadiah" name="nama_reward" />
                    <x-forms.input placeholder="Stok hadiah" name="stok" />
                    <x-forms.input placeholder="Poin yang dibutuhkan" name="jumlah_poin" />
                    <x-forms.input placeholder="Masa berlaku" name="masa_berlaku" type="date" />
                    <x-forms.fileInputModal name="gambar" />
                @endslot

                @slot('slotFooter')
                    <x-forms.btn.button color="danger" type="submit" title="Simpan" />
                @endslot
        </x-modals.Modal>

        {{-- Edit modal --}}
        <x-modals.Modal modalName="edit-reward" title="Ubah reward">
            @slot('slotMethod')
                <form enctype="multipart/form-data" method="POST" action="" id="modal-forms-edit">
                    @csrf
                    @method('PUT')
                @endslot

                @slot('slotBody')
                    <x-forms.input placeholder="Nama hadiah" name="nama_reward" id="editNama" />
                    <x-forms.input placeholder="Stok hadiah" name="stok" id="editStok" />
                    <x-forms.input placeholder="Poin yang dibutuhkan" name="jumlah_poin" id="editPoin" />

                    <x-forms.input placeholder="Masa berlaku" name="masa_berlaku" type="date" id="editMasaBerlaku" />
                    <x-forms.fileEditModal name="gambar" />
                @endslot

                @slot('slotFooter')
                    <x-forms.btn.button type="submit" color="danger" title="Ubah" />
                @endslot
        </x-modals.Modal>

        <script>
            // File input
            const inputGambarReward = document.getElementById("fileInput");

            function triggerFileInput() {
                inputGambarReward.click();
            }

            inputGambarReward.addEventListener("change", function() {
                const fileName = this.value.split("\\").pop();
                document.getElementById("myFileNameContainer").innerHTML = fileName;
            });

            // File edit
            function triggerFileEdit() {
                document.getElementById("fileEdit").click();
            }

            document.getElementById("fileEdit").addEventListener("change", function() {
                const fileName = this.value.split("\\").pop();
                document.getElementById("myFileInputNameContainer").innerHTML = fileName;
            })
        </script>
    @stop

    @section('script')
    <script>
        const dataId = $('.tableForPagination').data('id')
        pagination(dataId)
    </script>
@endsection