@extends('components._partials.default')

@section('content')
    
    <div class="container-fluid py-2 ps-4">
        <div class="row">
            <div class="col-md-11">
                <div class="row">
                    <div class="col-md-12 reward text-poppins">Hadiah</div>
                </div>
                <div class="row reedem-reward animate__animated animate__fadeInLeft">
                    <div class="col-xxl-9 col-xl-9 col-lg-8 col-md-8 col-sm-7 col-7">
                        <div class="table-header-redeem">
                            Verifikasi penukaran hadiah
                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-4 col-sm-5 col-5">
                        <div class="text-poppins text-14 btn-reward-position d-flex justify-content-end align-items-end">
                            <div class="btn-reward btn-custom-success position-relative">
                                <a href="{{ route('redeem.detail') }}" class="position-relative add-reward">Riwayat Penukaran</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <x-forms.table id="table-verifikasi-hadiah">
                            @slot('headSlot')
                                <th>NAMA USER</th>
                                <th class="text-center ">JUMLAH POIN</th>
                                <th>NAMA HADIAH</th>
                                <th>WAKTU PENUKARAN</th>
                                <th>AKSI</th>
                            @endslot
                            @slot('bodySlot')
                                @if (!empty($redeem))
                                    @foreach ($redeem as $item)
                                        <tr class="reward-tr table-row-image">
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <x-user.userImage src="{{ 'donatur/' . $item->donatur->photo }}" />
                                                    {{-- <x-user.userImage src="{{ $item->donatur->photo }}"/> --}}
                                                    <div class="ms-2 poppins">
                                                        {{ Str::substr($item->donatur->nama_donatur, 0, 5) }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center poppins">
                                                {{ $item->reward->jumlah_poin }}
                                            </td>
                                            <td class="ps-4">
                                                <div class="d-flex flex-column gap-0">
                                                    <span class="poppins">
                                                        {{ limitNamaHadiah($item->reward->nama_reward) }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="ps-4 tanggal">
                                                {{ datetimeFormat($item->created_at) }}
                                            </td>
                                            <td>
                                                <span class="btn-status btn-light-success cursor-pointer"
                                                    onclick="konfirmasiPenukaranHadiah('{{ route('redeem.update', ['id' => $item->id_redeem]) }}')">KONFIRMASI</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center">Data tidak ditemukan</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endif
                            @endslot
                        </x-forms.table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-11">
                <div class="row reedem-reward animate__animated animate__fadeInLeft">
                    <div class="col-xxl-10 col-xl-10 col-xl-10 col-md-10 col-sm-10 col-10">
                        <div class="table-header-redeem">
                            Daftar hadiah
                        </div>
                    </div>
                    <div class="col-md-12">
                        <x-forms.table id="table-detail-donatur" class="tableForPagination2">
                            @slot('headSlot')
                                <th>NAMA HADIAH</th>
                                <th class="text-center ">STOK HADIAH</th>
                                <th class="text-center">POIN</th>
                                <th>MASA BERLAKU</th>
                                <th>GAMBAR</th>
                            @endslot

                            @slot('bodySlot')
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

    <x-modals.detailGambarModal modalName="detail-image" title="Detail gambar reward">
        @slot('slotBody')
            <div class="modal-detail-gambar">
                <img src="#" alt="gambar" id="modal-image-sumbangan">
            </div>
        @endslot
        </x-modals.Modal>
    <form id="formKonfirmasiPenukaranHadiah" action="" method="POST">
        @csrf
    </form>
    
@stop

@section('script')
    <script>
        const dataId = $('.tableForPagination').data('id')
        pagination(dataId)
        const dataId2 = $('.tableForPagination2').data('id')
        pagination(dataId2)
    </script>
@endsection