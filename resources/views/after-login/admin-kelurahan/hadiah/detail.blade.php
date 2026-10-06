@extends('components._partials.default')

@section('content')

    <div class="container-fluid py-2 ps-4">
        
        <div class="row">
            <div class="col-xxl-11 col-xl-11 col-lg-12 col-md-12 col-sm-12 col-12" >
                <div class="row">
                    <div class="col-lg-12 page-header text-poppins">
                        <a href="{{ route('redeem') }}" class="text-secondary link-secondary">Hadiah</a>
                        <span>
                            <b>
                                &nbsp;/ Riwayat Penukaran
                            </b>
                        </span>
                    </div>
                </div>
                <div class="row reedem-reward animate__animated animate__fadeInLeft">
                    <div class="col-xxl-9 col-xl-9 col-lg-8 col-md-8 col-sm-7 col-7">
                        <div class="table-header-redeem">
                            Riwayat penukaran hadiah
                        </div>
                    </div>
                    <div class="col-md-12">
                        <x-forms.table id="table-detail-reward">
                        
                            @slot('headSlot')
                                <th>NAMA USER</th>
                                <th class="text-center ">JUMLAH POIN</th>
                                <th>NAMA HADIAH</th>
                                <th>WAKTU PENUKARAN</th>
                                <th class="text-center ">TOTAL PENUKARAN</th>
                                <th class="text-center ">STATUS PENUKARAN</th>
                            @endslot
                            @slot('bodySlot')
                                @if (!empty($redeem))
                                    {{-- {{ dd($redeem[0]) }} --}}
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
                                                        {{ $item->reward->nama_reward }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="ps-4">
                                                {{ datetimeFormat($item->created_at) }}
                                            </td>
                                            <td class="text-center">
                                                {{ $item->redeem_count }} Kali
                                            </td>
                                            <td class="text-center ">
                                                <span class="btn-status {{ ($item->status === 'selesai') ? 'bg-success' : (($item->status === 'ditolak') ? 'bg-danger' : 'bg-danger') }}">
                                                    {{ $item->status }}
                                                </span>
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