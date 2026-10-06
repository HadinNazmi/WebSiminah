@extends('components._partials.default')

@section('content')
    <div class="container-fluid py-2 ps-4">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12 reward text-poppins">Kontainer</div>
                </div>
                <div class="row mt-3">
                    <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                        <div class="container-fluid kontainer-kelurahan">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="header">
                                        Kapasitas kontainer
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="body">
                                        <div class="row">
                                            <div class="chart-container">
                                                <div class="chart-content">
                                                    <canvas id="myChart2"></canvas>
                                                    <div
                                                        class="chart-background {{ $kontainer[0]->sumbangan_persentase < 75 ? 'bg-transparent-success' : 'bg-transparent-danger' }}">
                                                    </div>
                                                    <div
                                                        class="chart-percentage {{ $kontainer[0]->sumbangan_persentase < 75 ? 'text-success' : 'text-danger' }}">
                                                        {{ number_format($kontainer[0]->sumbangan_persentase, 1) }}%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="footer d-flex align-items-center">
                                        <canvas
                                            class="circle {{ $kontainer[0]->sumbangan_persentase < 75 ? 'bg-success' : 'bg-danger' }}"></canvas>
                                        <span class="ms-2">Kontainer
                                            {{ $kontainer[0]->sumbangan_persentase < 75 ? 'dapat diisi' : 'hampir penuh' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12">
                        <div class="left-side-kontainer-kelurahan">
                            <div class="row">
                                <div class="col-12 mt-md-4 mt-4 mt-xxl-0 mt-xl-0 mt-lg-0">
                                    <div class="notifikasi-kontainer animate__animated animate__fadeInUp">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="header">
                                                    Notifikasi
                                                </div>
                                            </div>
                                        </div>
                                        <div class="body">
                                            <div class="row">
                                                @if (!empty($notifikasi))
                                                    @foreach ($notifikasi as $key => $item)
                                                        @if ($item->status === 'HAMPIR PENUH')
                                                            <div class="col-md-12">
                                                                <x-notifikasi.kontainer action="disable" type="warning"
                                                                    notifikasi="Kontainer Utama hampir penuh"
                                                                    type_detail="Ajukan kontainer yang baru supaya dapat terus menerima sumbangan" />
                                                            </div>
                                                        @else
                                                            <div class="col-md-12">
                                                                <x-notifikasi.kontainer action="disable" type="success"
                                                                    notifikasi="Kontainer Utama dapat diisi"
                                                                    type_detail="Belum membutuhkan pergantian kontainer" />
                                                            </div>
                                                        @endif
                                                        @if ($key === 0)
                                                        @break
                                                    @endif
                                                @endforeach
                                            @else
                                                <div class="col-md-12">
                                                    <x-notifikasi.kontainer action="disable" type="success"
                                                        kelurahan="Kontainer masih dapat diisi"
                                                        type_detail="Seluruh kontainer ready" />
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="table-kontainer-kelurahan animate__animated animate__fadeInUp">
                                            <div class="main-table">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-8 col-sm-12 col-12">
                                                                <div class="header">
                                                                    Riwayat penggantian kontainer
                                                                </div>
                                                            </div>
                                                            @if (!empty($notifikasi))
                                                                @if ($notifikasi[0]->status === 'HAMPIR PENUH')
                                                                    @if ($permintaan->isEmpty())
                                                                        <div class="col-md-4 header-button"
                                                                            id="btnAjukanPergantian">
                                                                            <div class="btn-reward btn-kontainer-kelurahan 
                                                                btn-info
                                                                position-relative cursor-pointer"
                                                                                onclick="AjukanPergantianKontainer('{{ route('kontainer.storePermintaan', ['id_kontainer' => $kontainer[0]->id_kontainer]) }}')">
                                                                                <span
                                                                                    class="position-relative add-reward">
                                                                                    Ajukan pergantian
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    @elseif($permintaan->isNotEmpty())
                                                                        @if ($permintaan[0]->status_permintaan !== 'diajukan' && $permintaan[0]->status_permintaan !== 'diproses')
                                                                            <div class="col-md-4 header-button"
                                                                                id="btnAjukanPergantian">
                                                                                <div class="btn-reward btn-kontainer-kelurahan 
                                                                btn-info
                                                                position-relative cursor-pointer"
                                                                                    onclick="AjukanPergantianKontainer('{{ route('kontainer.storePermintaan', ['id_kontainer' => $kontainer[0]->id_kontainer]) }}')">
                                                                                    <span
                                                                                        class="position-relative add-reward">
                                                                                        Ajukan pergantian
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @endif

                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="body overflowy-kontainer-kelurahan">
                                                            <x-forms.table id="table-penggantian-kontainer">
                                                                @slot('headSlot')
                                                                    <th>WAKTU PERMINTAAN PERGANTIAN</th>
                                                                    <th>STATUS</th>
                                                                    <th>AKSI</th>
                                                                @endslot

                                                                @slot('bodySlot')
                                                                    @if (!empty($permintaan))
                                                                        @foreach ($permintaan as $item)
                                                                            <tr class="reward-tr permintaan-tr">
                                                                                <td class="ps-4 tanggal">
                                                                                    {{ datetimeFormat($item->created_at) }}
                                                                                </td>
                                                                                <td class="ps-4 ">                                                           <span
                                                                                        class="btn-status {{ strtolower($item->status_permintaan) === 'diterima' ? 'bg-success' : (strtolower($item->status_permintaan) === 'ditolak' ? 'bg-danger' : 'bg-warning') }}">
                                                                                        {{ $item->status_permintaan }}
                                                                                    </span>
                                                                                </td>
                                                                                <td class="ps-4">
                                                                                    <span
                                                                                        class="{{ strtolower($item->status_permintaan) === 'diproses' ? 'btn-permintaan-proses' : (strtolower($item->status_permintaan) === 'ditolak' ? 'btn-permintaan-terima' : 'btn-permintaan-terima') }}"
                                                                                        @if (strtolower($item->status_permintaan) === 'diproses') onclick="terimaPergantianKontainer('{{ route('kontainer.updatePermintaan', ['id' => $item->id_permintaan]) }}')" @endif>
                                                                                        @if (strtolower($item->status_permintaan) === 'diterima')
                                                                                            Selesai
                                                                                        @else
                                                                                            Kontainer diterima
                                                                                        @endif
                                                                                    </span>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- forms update-permintaan --}}
    <form action="" id="updatePengajuanGantiKontainer" method="POST">
        @csrf
    </form>
    <form action="" id="updateTerimaKontainer" method="POST">
        @csrf
        @method('PUT')
    </form>

    <style>
        .chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .chart-content {
            position: relative;
            display: block;
            width: 250px;
            height: 250px;
        }

        .chart-content canvas {
            display: block;
            max-width: 100%;
            max-height: 100%;
            border-radius: 50%;
            z-index: 2;
        }

        .chart-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* background-color: rgba(101, 174, 56, 0.25); */
            border-radius: 50%;
            z-index: 1;
            pointer-events: none;
        }

        .chart-percentage {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 32px;
            font-weight: bold;
            /* color: #65AE38; */
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous" async></script>


    <script>
        var ctx1 = document.getElementById('myChart2').getContext('2d');
        var data1 = [{!! json_encode($kontainer[0]->sumbangan_persentase) !!}, {!! json_encode(100 - $kontainer[0]->sumbangan_persentase) !!}];
        var colors1 = data1[0] <= 75 ? ['rgba(10, 164, 56, 1)', 'rgba(0, 0, 0, 0)'] : ['#d12031', 'rgba(0, 0, 0, 0)'];
        var cutout1 = '85%';
        var myChart1 = new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: ['Terisi', 'kosong'],
                datasets: [{
                    label: 'Total',
                    data: data1,
                    backgroundColor: colors1,
                    cutout: cutout1,
                    borderRadius: 50,
                    borderWidth: 0,
                    hoverOffset: 0
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                layout: {
                    padding: 0
                },
                plugins: {
                    legend: false
                }
            }
        });
    </script>
@stop
