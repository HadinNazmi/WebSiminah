@extends('components._partials.default')

@section('content')
    {{-- {{ dd($permintaan) }} --}}
    <div class="container-fluid py-2 ps-2 ps-xxl-3 ps-xl-3 ps-lg-3 ps-md-3 ps-sm-3">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12 reward text-poppins">Olah Kontainer</div>
                </div>
                <div class="row mt-3">
                    <div class="col-xxl-7 col-xl-7 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="container-fluid manajemen-permintaan animate__animated animate__fadeInUp">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="header">
                                        Manajemen permintaan pergantian
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="body">
                                        <x-forms.table id="tabel-manajemen-permintaan">
                                            @slot('headSlot')
                                                <th>KELURAHAN</th>
                                                <th>TANGGAL PERMINTAAN</th>
                                                <th>STATUS</th>
                                            @endslot

                                            @slot('bodySlot')
                                                @if (!empty($permintaan))
                                                    @foreach ($permintaan as $item)
                                                        <tr class="reward-tr permintaan-tr">
                                                            <td class="ps-3 detail-kelurahan">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="ms-2  d-grid">
                                                                        <span class="top">
                                                                            {{ $item->lokasi->nama_kelurahan }}
                                                                        </span>
                                                                        <span class="bottom">
                                                                            {{ $item->lokasi->kecamatan->nama_kecamatan }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="ps-4 tanggal">
                                                                {{ datetimeFormat($item->created_at) }}
                                                            </td>
                                                            <td class="ps-4">
                                                                @if (strtolower($item->status_permintaan) === 'menunggu konfirmasi')
                                                                    <div
                                                                        class="btn-reward btn-table-custom     position-relative">
                                                                        <span class="position-relative add-reward">
                                                                            Menunggu Konfirmasi
                                                                        </span>
                                                                    </div>
                                                                @elseif(strtolower($item->status_permintaan) === 'diproses')
                                                                <div
                                                                        class="btn-reward btn-table-custom bg-warning position-relative">
                                                                        <span class="position-relative add-reward">
                                                                            Diproses
                                                                        </span>
                                                                    </div>
                                                                @else
                                                                    <div
                                                                        class="btn-reward btn-table-custom bg-success position-relative">
                                                                        <span class="position-relative add-reward">
                                                                            Sudah diganti
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endslot
                                        </x-forms.table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="col-xxl-5 col-xl-5 col-lg-6 col-md-12 col-sm-12 col-12 mt-xxl-0 mt-xl-0 mt-lg-0 mt-md-4 mt-sm-4">
                        <div
                            class="notifikasi-kontainer animate__animated animate__fadeInUp mt-xxl-0 mt-xl-0 mt-lg-0 mt-md-4 mt-sm-4 mt-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="header">
                                        Notifikasi
                                    </div>
                                </div>
                            </div>
                            <div class="body">
                                <div class="row">
                                    {{-- @dd($notifikasi) --}}
                                    @if (!empty($notifikasi))
                                        @foreach ($notifikasi as $item)
                                            <div class="col-md-12">
                                                <x-notifikasi.kontainer action="enable" type="danger"
                                                    notifikasi="{{ $item['nama_kelurahan'] }}"
                                                    type_detail="Meminta pengajuan pergantian kontainer"
                                                    id="{{ $item['id_permintaan'] }}" />
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-md-12">
                                            <x-notifikasi.kontainer action="disable" type="success"
                                                kelurahan="Tidak ada permintaan" type_detail="Seluruh kontainer ready" />
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="container-fluid detail-manajemen-kontainer animate__animated animate__fadeInUp">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="header">
                                        Manajemen Kontainer
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="body">
                                        <x-forms.table id="table-manajemen-kontainer-csr" class="tableForPagination2">
                                            @slot('headSlot')
                                                <th>KELURAHAN</th>
                                                <th>KAPASITAS</th>
                                                <th>TERAKHIR DIISI</th>
                                            @endslot

                                            @slot('bodySlot')
                                                @if (!empty($kontainer))
                                                    @foreach ($kontainer as $item)
                                                        <tr class="reward-tr permintaan-tr">
                                                            <td class="detail-kelurahan ps-3">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="ms-2  d-grid">
                                                                        <span class="top">
                                                                            {{ $item->lokasi->nama_kelurahan }}
                                                                        </span>
                                                                        <span class="bottom">
                                                                            {{ $item->lokasi->kecamatan->nama_kecamatan }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="ps-4 d-grid">
                                                                <span>
                                                                    {{ $item->sumbangan_sum_berat }} kg
                                                                </span>
                                                                <div class="progress-bar">
                                                                    <x-progressBar value="{{ $item->sumbangan_sum_berat }}"
                                                                        max="{{ $item->kapasitas }}" />
                                                                </div>
                                                            </td>
                                                            <td class="ps-4 tanggal">
                                                                {{ datetimeFormat($item->sumbangan_max_updated_at) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @endslot
                                        </x-forms.table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        const dataId = $('.tableForPagination').data('id')
        pagination(dataId)
        const dataId2 = $('.tableForPagination2').data('id')
        pagination(dataId2)
    </script>
@endsection
