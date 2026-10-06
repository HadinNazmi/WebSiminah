@extends('components._partials.default')

@section('content')
    <div class="container-fluid py-2 ps-4">
        <div class="row">
            <div class="col-lg-12 page-header text-poppins">
                <a href="{{ route('donatur') }}" class="text-secondary link-secondary">Donatur</a>
                <span>
                    <b>
                        &nbsp;/ Detail Donatur
                    </b>
                </span>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12 detail-donatur-wrapper margin-left-24 animate__animated animate__fadeInLeft">
                <div class="detail-donatur-card">
                    <div class="row header">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center align-items-center">
                                    <x-user.userImage src="{{ 'donatur/' . $donatur->photo }}" width="119" height="119" alt="Gambar {{ $donatur->nama_donatur }}"/>
                                </div>
                                <div class="col-md-12 d-flex justify-content-center align-items-center">
                                    <span>
                                        {{ $donatur->nama_donatur }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row summary">
                        <div class="col-md-6 col-sm-6 col-6">
                            <div class="row">
                                <div class="col-md-3 col-sm-3 col-3 icon">
                                    <span class="material-symbols-outlined">
                                        water_drop
                                    </span>
                                </div>
                                <div class="col-md-9 col-sm-9 col-9 sum">
                                    <div class="row">
                                        <div class="col-md-12 top">
                                            {{ $total->sumbangan_sum_berat }} Kg
                                        </div>
                                        <div class="col-md-12 bottom">
                                            Jumlah Donasi
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-6">
                            <div class="row">
                                <div class="col-md-3 col-sm-3 col-3 icon">
                                    <span class="material-symbols-outlined">
                                        place_item
                                    </span>
                                </div>
                                <div class="col-md-9 col-sm-9 col-9 sum">
                                    <div class="row">
                                        <div class="col-md-12 top">
                                            {{ $total->total_donasi }}
                                        </div>
                                        <div class="col-md-12 bottom">
                                            Total Donasi
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row detail">
                        <div class="col-md-12 col-sm-12 col-12 header">
                            <span>
                                Detail
                            </span>
                        </div>
                        <div class="col-md-12 col-sm-12 col-12 line">
                            <hr>
                        </div>
                        <div class="col-md-12 col-sm-12 col-12 user-detail">
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="head">Nama: </span>
                                    <span class="body">{{ $donatur->nama_donatur }}</span>
                                </div>
                                {{-- <div class="col-md-12">
                                    <span class="head">Email: </span>
                                    <span class="body">{{ $donatur->email }}</span>
                                </div> --}}
                                <div class="col-md-12">
                                    <span class="head">Kontak: </span>
                                    <span class="body">{{ $donatur->no_hp }}</span>
                                </div>
                                <div class="col-md-12">
                                    <span class="head">Jalan: </span>
                                    <span class="body">{{ $donatur->alamat_donatur  }}</span>
                                </div>
                                <div class="col-md-12">
                                    <span class="head">Kelurahan: </span>
                                    <span class="body">{{ $donatur->kelurahan }}</span>
                                </div>
                                {{-- <div class="col-md-12">
                                    <span class="head">Kecamatan: </span>
                                    <span class="body">Dumai Timur</span>
                                </div>
                                <div class="col-md-12">
                                    <span class="head">Kota: </span>
                                    <span class="body">Dumai</span>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-8 col-xl-7 col-lg-7 col-md-6 col-md-7 col-sm-12 col-12 mt-md-0 mt-sm-3 mt-4">
                <div class="row riwayat-donatur-wrapper animate__animated animate__fadeInRight ">
                    <div class="col-md-12">
                        <div class="container-fluid">
                            <h1>Riwayat Donasi</h1>
                        </div>
                    </div>
                    {{-- {{ dd($riwayat) }} --}}

                    <div class="col-md-12 col-sm-12 col-12">
                        <x-forms.table id="table-detail-donatur">
                            @slot('headSlot')
                                <th class="text-semi-dark">LOKASI KONTAINER</th>
                                <th class="text-semi-dark text-center ">JUMLAH KONTAINER</th>
                                <th class="text-semi-dark">TANGGAL</th>
                                <th class="text-semi-dark text-center ">WAKTU</th>
                                <th class="text-semi-dark">STATUS</th>
                            @endslot

                            @slot('bodySlot')
                                @if (!empty($riwayat))
                                    @foreach ($riwayat as $item)
                                        <tr class="reward-row table-row-image">
                                            <td class="ps-3 text-semi-dark">
                                                {{ $item->kontainer->lokasi->nama_kelurahan }}
                                            </td>
                                            <td class="text-center text-semi-dark text-inter-regular text-14">
                                                {{ $item->berat }} kg
                                            </td>
                                            <td class="ps-2 text-semi-dark text-inter-regular text-14">
                                                {{ dateFormat($item->created_at)}}
                                            </td>
                                            <td class="text-center  text-semi-dark-68 text-inter-regular text-14">
                                                {{ date('h:i', strtotime($item->created_at)) }}
                                            </td>
                                            <td class="ps-2">
                                                @if (strtolower($item->status) === 'ditolak')
                                                    <div
                                                        class="btn-reward btn-table-custom bg-danger
                                                position-relative">
                                                        <span class="position-relative add-reward">
                                                            Ditolak
                                                        </span>
                                                    </div>
                                                @elseif(strtolower($item->status) === 'terverifikasi')
                                                    <div
                                                        class="btn-reward btn-table-custom bg-success
                                                position-relative">
                                                        <span class="position-relative add-reward">
                                                            Terverifikasi
                                                        </span>
                                                    </div>
                                                @else
                                                    <div
                                                        class="btn-reward btn-table-custom 
                                                position-relative">
                                                        <span class="position-relative add-reward">
                                                            Menunggu konfirmasi
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

@stop

@section('script')
    <script>
        const dataId = $('.tableForPagination').data('id')
        pagination(dataId)
    </script>
@endsection