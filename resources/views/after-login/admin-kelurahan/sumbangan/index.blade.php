@extends('components._partials.default')

@section('content')

    {{-- {{ dd($persentase) }} --}}

    <div class="container-fluid py-2 ps-4">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12 reward text-poppins">Sumbangan</div>
                </div>
                <div class="row mt-3">
                    <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="container-fluid sumbangan-kelurahan">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="header">
                                        Total verifikasi
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="body">
                                        <div class="row">
                                            <div class="chart-container">
                                                <div class="chart-content">
                                                    <canvas id="myChart2"></canvas>
                                                    <div class="chart-background"></div>
                                                    <div class="chart-circle-white"></div>
                                                    <div class="chart-circle-colored"></div>
                                                    <div class="chart-percentage">{{ number_format($persentase, 1) }}%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="footer">
                                        <div class="row">
                                            <div class="col-md-6 col-6 col-sm-6">
                                                <canvas class="circle fill"></canvas>
                                                <span>Sudah</span>
                                            </div>
                                            <div class="col-md-6 col-6 col-sm-6">
                                                <canvas class="circle transparent"></canvas>
                                                <span>Belum</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- {{ dd($sumbanganHarian) }} --}}
                    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="total-sumbangan mt-sm-4 mt-4 mt-md-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="header">
                                        Total sumbangan (persentase)
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="body">
                                        <div class="chartPie">
                                            @if (checkNumberIsZero($sumbanganHarian))
                                                <div class="defaultChartPie">
                                                </div>
                                            @else
                                                <canvas id="myPieChart"></canvas>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="footer">
                                        <div class="row">
                                            <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 d-flex">
                                                <div class="senin">
                                                    Senin
                                                </div>
                                                <div class="selasa">
                                                    Selasa
                                                </div>
                                                <div class="rabu">
                                                    Rabu
                                                </div>
                                                <div class="kamis">
                                                    Kamis
                                                </div>
                                            </div>
                                            <div class="col-xxl-12 col-xl-12 col-lg-5 col-md-12 d-flex">
                                                <div class="jumat">
                                                    Jumat
                                                </div>
                                                <div class="sabtu">
                                                    Sabtu
                                                </div>
                                                <div class="minggu">
                                                    Minggu
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-5 col-xl-5 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="table-sumbangan-kelurahan mt-xl-0 mt-xxl-0 mt-xl-0 mt-sm-4 mt-4 mt-md-4">
                            <div class="main-table">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-7 col-7">
                                                <div class="header">
                                                    Riwayat verifikasi
                                                </div>
                                            </div>
                                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-5 col-5">
                                                <div class="header-button">
                                                    <a href="{{ route('sumbangan.detail') }}">Detail lanjut</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="body overflowy-kontainer-kelurahan">
                                                <x-forms.table>
                                                    @slot('headSlot')
                                                        <th>NAMA</th>
                                                        <th>WAKTU VERIFIKASI</th>
                                                        <th>STATUS</th>
                                                    @endslot

                                                    @slot('bodySlot')
                                                        {{-- {{ dd($riwayat) }} --}}
                                                        @if (!empty($riwayat))
                                                            @foreach ($riwayat as $item)
                                                                <tr class="verifikasi-tr">
                                                                    <td class="ps-4 nama">
                                                                        <div class="d-flex align-items-center justify-center">
                                                                            <x-user.userImage
                                                                                src="{{ 'donatur/' . $item->donatur->photo }}" />
                                                                            <div class="ms-2">
                                                                                <span
                                                                                    class="top">{{ getFirstName($item->donatur->nama_donatur) }}</span><br>
                                                                                <span class="bottom">{{ $item->berat }}
                                                                                    Kg</span>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td class="ps-4 tanggal">
                                                                        {{ datetimeFormat($item->updated_at) }}
                                                                    </td>
                                                                    <td class="ps-4 ">
                                                                        @if (strtolower($item->status) === 'terverifikasi')
                                                                            <div
                                                                                class="btn-reward btn-table-custom bg-success
                                                                    position-relative">
                                                                                <span class="position-relative add-reward">
                                                                                    Terverifikasi
                                                                                </span>
                                                                            </div>
                                                                        @else
                                                                            <div
                                                                                class="btn-reward btn-table-custom bg-danger
                                                                    position-relative">
                                                                                <span class="position-relative add-reward">
                                                                                    Ditolak
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
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-12 col-sm-12">
                            <div class="verifikasi-donasi mt-xxl-2 mt-xl-2 mt-lg-2 mt-md-4 mt-sm-4 mt-4 ">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="header">
                                            Verifikasi donasi
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    {{-- {{ dd($verifikasiStatus) }} --}}
                                    <div class="col-md-12">
                                        <div class="body mt-2">
                                            <x-forms.table id="table-verifikasi-donasi">
                                                @slot('headSlot')
                                                    <th>NAMA DONATUR</th>
                                                    <th class="text-center ">JUMLAH DONASI</th>
                                                    <th>KELURAHAN</th>
                                                    <th>WAKTU DONASI</th>
                                                    <th>FOTO DONASI</th>
                                                    <th>AKSI</th>
                                                @endslot

                                                @slot('bodySlot')
                                                    @if (!empty($verifikasiStatus))
                                                        @foreach ($verifikasiStatus as $item)
                                                            <tr class="verifikasi-row">
                                                                <td class="ps-4 nama">
                                                                    <div class="d-flex align-items-center justify-center">
                                                                        <x-user.userImage
                                                                            src="{{ 'donatur/' . $item->donatur->photo }}" />
                                                                        <span
                                                                            class="ps-2">{{ getFirstName($item->donatur->nama_donatur) }}</span>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center berat">
                                                                    {{ $item->berat }} Kg
                                                                </td>
                                                                <td class="ps-4 kelurahan">
                                                                    {{ $item->donatur->kelurahan }}
                                                                </td>
                                                                <td class="ps-4 tanggal">
                                                                    {{ datetimeFormat($item->created_at) }}
                                                                </td>
                                                                <td class="ps-4">
                                                                    <div class="foto-donasi cursor-pointer">
                                                                        <img src="{{ asset('storage/sumbangan/' . $item->photo) }}"
                                                                            alt="gambar sumbangan" data-bs-toggle="modal"
                                                                            data-bs-target="#detailImage"
                                                                            id="gambar-sumbangan"
                                                                            onclick="detailSumbangan('{{ asset('storage/sumbangan/' . $item->photo) }}')">
                                                                    </div>
                                                                </td>
                                                                <td class="ps-4 ">
                                                                    <div class="d-flex">
                                                                        <div class="btn-reward btn-table-custom bg-success
                                                                position-relative"
                                                                            onclick="verifikasiSumbangan('{{ route('sumbangan.update', ['id' => $item->id_donatur, 'created_at' => $item->created_at]) }}')">
                                                                            <span
                                                                                class="position-relative add-reward cursor-pointer">
                                                                                Verifikasi
                                                                            </span>
                                                                        </div>
                                                                        <div class="btn-reward btn-table-custom bg-danger
                                                                position-relative ms-1"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#deskripsi-penolakan"
                                                                            onclick="TolakSumbangan('{{ route('sumbangan.update', ['id' => $item->id_donatur, 'created_at' => $item->created_at]) }}')">
                                                                            <span
                                                                                class="position-relative add-reward cursor-pointer">
                                                                                Tolak
                                                                            </span>
                                                                        </div>

                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td>Tidak ada</td>
                                                            <td>data ditemukan</td>
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
                    </div>
                </div>
            </div>
        </div>
        {{-- Verifikasi status forms --}}
        <form method="POST" action="" id="verifikasiStatusForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="terverifikasi">
        </form>
        {{-- Modal --}}
        <x-modals.detailGambarModal modalName="detailImage" title="Detail gambar sumbangan">
            @slot('slotBody')
                <div class="modal-detail-gambar">
                    <img src="" alt="gambar" id="modal-image-sumbangan">
                </div>
            @endslot
            </x-modals.Modal>

            {{-- Modal tolak --}}
            <x-modals.Modal modalName="deskripsi-penolakan" route="sumbangan.update" title="Deskripsi penolakan">
                @slot('slotMethod')
                    <form action="" id="FormPenolakanSumbangan" method="POST">
                        @csrf
                        @method('PUT')
                    @endslot

                    @slot('slotBody')
                        <input type="hidden" name="status" value="ditolak">
                        <div class="form-floating border rounded">
                            <textarea class="form-control ps-2" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 200px"
                                name="keterangan"></textarea>
                            <label for="floatingTextarea2">Deskripsi</label>
                        </div>
                    @endslot

                    @slot('slotFooter')
                        <x-forms.btn.button type="submit" color="danger" title="Simpan" />
                    @endslot
            </x-modals.Modal>
            <style>
                .chart-container {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }

                .chart-content {
                    position: relative;
                    display: block;
                    width: 194px;
                    height: 194px;
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
                    background-color: rgba(20, 94, 168, 0.10);
                    border-radius: 50%;
                    z-index: 1;
                    pointer-events: none;
                }

                .chart-percentage {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    font-size: 22px;
                    font-family: DM Sans font-weight: bold;
                    color: white;
                    z-index: 5;
                }

                .chart-circle-colored {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    width: 86px;
                    height: 86px;
                    border-radius: 50%;
                    background-color: #145EA8;
                    z-index: 4;
                }

                .chart-circle-white {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    width: 165px;
                    height: 165px;
                    border-radius: 50%;
                    background-color: white;
                    z-index: 3;
                }

                .chartPie {
                    width: 396px !important;
                    height: 396px !important;
                }

                .defaultChartPie {
                    width: 196px;
                    height: 196px;
                    border-radius: 50%;
                    background-color: #eaeaea;
                    margin-left: 25%;
                }
            </style>


            <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
            <script src="https://code.jquery.com/jquery-3.4.1.min.js"
                integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous" async></script>


            <script>
                var ctx1 = document.getElementById('myChart2').getContext('2d');
                var data1 = [{!! json_encode(number_format($persentase, 1)) !!}, {!! json_encode(100 - number_format($persentase, 1)) !!}];;
                var colors1 = ['#145EA8', 'rgba(20, 94, 168, 0.10)'];
                var cutout1 = '85%';
                var myChart1 = new Chart(ctx1, {
                    type: 'doughnut',
                    data: {
                        // labels: ['Terverifikasi', 'Belum terverifikasi'],
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
                            legend: false,
                            tooltip: {
                                enabled: false
                            }
                        }
                    }
                });
            </script>
            {{-- {{ dd($sumbanganHarian) }} --}}
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>

            <script>
                var ctx = document.getElementById("myPieChart").getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        datasets: [{
                            data: [
                                {!! json_encode($sumbanganHarian[1]['berat']) !!}, // senin
                                {!! json_encode($sumbanganHarian[2]['berat']) !!},
                                {!! json_encode($sumbanganHarian[3]['berat']) !!},
                                {!! json_encode($sumbanganHarian[4]['berat']) !!},
                                {!! json_encode($sumbanganHarian[5]['berat']) !!}, // jumat
                                {!! json_encode($sumbanganHarian[6]['berat']) !!}, // sabtu
                                {!! json_encode($sumbanganHarian[0]['berat']) !!} // minggu
                            ],
                            backgroundColor: [
                                "#D12031", //senin
                                "#EAC500", //selasa
                                "#9747FF", //rabu
                                "#65AE38", //kamis
                                "#145EA8", // jumat
                                "#A8AE38", //sabtu
                                "#E5E5E5", // minggu
                            ],
                            borderWidth: 0,
                            borderAlign: 'inner'
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            display: false
                        },
                        tooltips: {
                            enabled: false
                        },
                        plugins: {
                            datalabels: {
                                formatter: (value, ctx) => {
                                    let sum = ctx.dataset._meta[0].total;
                                    let percentage = (value * 100 / sum).toFixed(0) + "%";
                                    if (value === 0) {
                                        return '';
                                    } else {
                                        return percentage;
                                    }
                                },
                                color: '#000',
                                font: {
                                    size: 12 // Adjust the font size as needed
                                }
                            }
                        }
                    }
                });
            </script>



        @stop

        @section('script')
            <script>
                function TolakSumbangan(action) {
                    const FormPenolakanSumbangan = document.querySelector('#FormPenolakanSumbangan')

                    FormPenolakanSumbangan.action = action;
                    FormPenolakanSumbangan.sumbit()
                }
            </script>
        @endsection
