@extends('components._partials.default')

@section('content')
    <div class="container-fluid py-2 ps-4">
        <div class="row">
            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="row">
                    <div class="col-lg-12 reward text-poppins">Donatur</div>
                </div>
                <div class="row reedem-reward animate__animated animate__fadeInUp">
                    <div class="col-lg-9">
                        <div class="table-header-redeem">
                            Data donatur
                        </div>
                    </div>
                    {{-- @dd($donatur) --}}
                    <div class="col-lg-12">
                        <x-forms.table id="table-index-donatur">
                            @slot('headSlot')
                                <th>NAMA DONATUR</th>
                                <th class="text-center">JUMLAH DONASI</th>
                                <th class="text-center">JUMLAH POIN</th>
                                <th>KELURAHAN</th>
                                <th>WAKTU DONASI</th>
                                <th class="text-center ">TOTAL DONASI</th>
                                <th>AKSI</th>
                            @endslot
                            
                            @slot('bodySlot')
                                @if (!empty($donatur))
                                    @foreach ($donatur as $item)
                                        <tr class="table-row-image donatur-row">
                                            <td class="ps-4 data-14">
                                                <div class="d-flex align-items-center">
                                                    <x-user.userImage src="{{ 'donatur/' . $item->photo }}" alt="Gambar {{ $item->nama_donatur }}"/>
                                                    <div class="ms-3">
                                                        <span>
                                                            {{ Str::substr($item->nama_donatur, 0, 5) }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center data-14">

                                                @if ($item->sumbangan_sum_berat === 0 || $item->sumbangan_sum_berat === null)
                                                    -
                                                @else
                                                    {{ $item->sumbangan_sum_berat }} Kg
                                                @endif
                                            </td>
                                            <td class="text-center data-14">
                                                {{ $item->poin }}
                                            </td>
                                            <td class="ps-4 data-14">
                                                {{ $item->kelurahan }}
                                            </td>
                                            <td class="ps-4 data-14">
                                                {{ datetimeFormat($item->newest_tanggal) }}
                                            </td>
                                            <td class="text-center data-14">
                                                @if ($item->total_donasi === 0)
                                                    -
                                                @else
                                                    {{ $item->total_donasi }} Kali
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-reward btn-list position-relative">
                                                    <a href="{{ route('donatur.getById', ['id' => $item->id_donatur]) }}"
                                                        class="position-relative add-reward">DETAIL
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>{{ $message }}</td>
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
    </div>

@stop

@section('script')
    <script>
        const dataId = $('.tableForPagination').data('id')
        pagination(dataId)
    </script>
@endsection
