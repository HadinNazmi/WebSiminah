@extends('components._partials.default')

@section('content')

<style>
.chart-background-green {
    width: 100%;
    height: 100%;
    background-color: rgba(101, 174, 56, 0.25);
    border-radius: 50%;
    position: relative;
}

.chart-background-yellow {
    width: 100%;
    height: 100%;
    background-color: rgba(255, 167, 38, 0.25);
    border-radius: 50%;
    position: relative;
}

.chart-background-red {
    width: 100%;
    height: 100%;
    background-color: rgba(209, 32, 49, 0.25);
    border-radius: 50%;
    position: relative;
}

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

.chart-content {
    width: 215px;
    height: 215px;
}

.chart-percentage {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 32px;
    font-weight: bold;
    color: #65AE38;
}

.custom-icon {
    color: #65AE38;
}

.custom-icon2 {
    color: #FFBD3D;
}

.custom-icon3 {
    color: #E31E18;
}


.custom-popup {
    background-color: #fff;
    font-family: 'poppins', sans-serif;
    border-radius: 10px;
}

.custom-popup .custom-popup-title {
    margin: 0;
    font-size: 18px;
    font-weight: 500;
}

.custom-popup .custom-popup-lat,
.custom-popup .custom-popup-lng {
    margin: 5px 0;
    font-size: 14px;
}
</style>

<div class="container-fluid py-4">
    <div class="row animate__animated animate__fadeInUp">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">local_drink</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Donasi bulan {{$bulanTahun}}</p>
                        <h4 class="mb-0"><span id="state1" countTo="{{ $totalSumbangan }}"></span> Kg</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0"><span
                            class="{{ $perbandinganSumbangan < 0 ? 'text-danger' : 'text-success' }} text-sm font-weight-bolder">
                            {{ $perbandinganSumbangan }}
                            Kg
                        </span> dari bulan lalu</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">people</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Total Donatur</p>
                        <h4 class="mb-0"><span id="state2" countTo="{{ $totalDonatur }}"></span> Orang</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0"><span
                            class="{{ $donaturAktifBulanIni < 0 ? 'text-danger' : 'text-success' }} text-sm font-weight-bolder">
                            {{ $donaturAktifBulanIni }}
                        </span> donatur aktif bulan {{$bulanTahun}}</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">vertical_align_bottom</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Donasi belum terverifikasi</p>
                        <h4 class="mb-0"><span id="state3" countTo="{{$pengajuanBelumVerif}}"></span> Donasi</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <a href="{{ route('sumbangan') }}">
                    <div class="card-footer p-3">
                        <p class="mb-0">Kelola Sumbangan <i class="material-icons text-sm">open_in_new</i></p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">redeem</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">Redeem belum terverifikasi</p>
                        <h4 class="mb-0"><span id="state5" countTo="{{$redeemBelumVerif}}"></span> Redeem</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <a href="{{ route('redeem') }}">
                    <div class="card-footer p-3">
                        <p class="mb-0">Kelola Redeem <i class="material-icons text-sm">open_in_new</i></p>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="row mt-4 animate__animated animate__fadeInUp">
        <div class="col-lg-6 col-md-6 mt-4 mb-4">
            <div class="card z-index-2">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 me-3 float-start">
                        <i class="material-icons opacity-10">leaderboard</i>
                    </div>
                    <div class="d-block d-md-flex">
                        <div class="me-auto">
                            <h6 class="mb-0">Total Sumbangan</h6>
                            <p class="mb-0 text-sm">5 donatur dengan sumbangan terbanyak</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3 pt-0">
                    <div class="chart">
                        <canvas id="chart-bars1" class="chart-canvas" height="230"></canvas>
                    </div>
                    <hr class="dark horizontal">
                    <div class="d-flex ">
                        <i class="material-icons text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm"> data per tanggal {{ $tanggal }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 mt-4 mb-4">
            <div class="card z-index-2">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 me-3 float-start">
                        <i class="material-icons opacity-10">data_usage</i>
                    </div>
                    <div class="d-block d-md-flex">
                        <div class="me-auto">
                            <h6 class="mb-0">Progress Kontainer</h6>
                            <p class="mb-0 text-sm">Kontainer Periode {{$tanggalGantiKontainer}}</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3 pt-0">
                    <div class="row mt-0 mb-0">
                        <div class="col-md-7 text-center">
                            <div class="chart-container">
                                <canvas id="myChart1"
                                    class="chart-content mx-auto chart-canvas {{ $bgColor }}"></canvas>
                            </div>
                            <h4 class="font-weight-bold mt-n8">
                                <span id="percentageProgress"><span id="state4"
                                        countTo="{{$percentageProgress}}"></span>%</span>
                                <span id="progressText" class="d-block text-body text-sm">{{ $progress[0] }} /
                                    {{$progress[0]+$progress[1]}}</span>
                            </h4>
                        </div>
                        <div class="col-5">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <tbody>
                                        @foreach($kontainerData['labels'] as $index => $label)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-0">
                                                    <i class="material-icons text-lg me-1 my-auto">person</i>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ getFirstName($label) }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <h6 class="mb-0 text-sm">
                                                    @if(isset($kontainerData['values'][$index]))
                                                    {{ $kontainerData['values'][$index] }} Kg
                                                    @else
                                                    N/A
                                                    @endif
                                                </h6>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr class="dark horizontal mt-7">
                    <div class="d-flex">
                        <i id="indicator" class="material-icons text-sm my-auto me-1 {{$iconColor}}">brightness_1</i>
                        <p id="indicatorText" class="mb-0 text-sm">{{$status}}</p>
                        <i id="lokasi" class="material-icons position-relative ms-auto text-lg me-1 my-auto">place</i>
                        <p id="lokasiText" class="text-sm my-auto"> {{$namaKel}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/countup.min.js') }}"></script>

<script>
var ctx = document.getElementById("chart-bars1").getContext("2d");

new Chart(ctx, {
    type: "bar",
    data: {
        labels: @json(array_map(function($label) {
            return getFirstName($label);
        }, $chartData['labels'])),
        datasets: [{
            label: "Total Sumbangan",
            tension: 1,
            borderWidth: 0,
            borderRadius: 5,
            borderSkipped: false,
            backgroundColor: "rgba(209, 32, 49, 1)",
            data: @json($chartData['values']),
            maxBarThickness: 12
        }, ],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false,
            }
        },
        interaction: {
            intersect: false,
            mode: 'index',
        },
        scales: {
            y: {
                grid: {
                    drawBorder: false,
                    display: true,
                    drawOnChartArea: true,
                    drawTicks: false,
                    borderDash: [5, 5],
                    color: '#c1c4ce5c'
                },
                ticks: {
                    suggestedMin: 0,
                    suggestedMax: 500,
                    beginAtZero: true,
                    padding: 10,
                    color: "#9ca2b7",
                    font: {
                        size: 10,
                        weight: 300,
                        family: "Poppins",
                        style: 'normal',
                        lineHeight: 2
                    },
                },
            },
            x: {
                grid: {
                    drawBorder: false,
                    display: true,
                    drawOnChartArea: true,
                    drawTicks: false,
                    borderDash: [5, 5],
                    color: '#c1c4ce5c'
                },
                ticks: {
                    display: true,
                    color: '#9ca2b7',
                    padding: 10,
                    font: {
                        size: 12,
                        weight: 300,
                        family: "Poppins",
                        style: 'normal',
                        lineHeight: 2
                    },
                }
            },
        },
    },
});

var ctx1 = document.getElementById('myChart1').getContext('2d');
var colors1 = @json($color);
var cutout1 = '85%';

var myChart1 = new Chart(ctx1, {
    type: 'doughnut',
    data: {
        labels: ['Terisi', 'kosong'],
        datasets: [{
            label: 'Total',
            data: @json($progress),
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
        interaction: {
            intersect: false,
            mode: 'index',
        },
        plugins: {
            legend: false
        }
    }
});

if (document.getElementById('state1')) {
    var initialValue = parseFloat(document.getElementById("state1").getAttribute("countTo")).toFixed(2);

    const countUp = new CountUp('state1', initialValue, {
        useGrouping: false,
        separator: '',
        decimalPlaces: 1,
        duration: 1
    });

    if (!countUp.error) {
        countUp.start();
    } else {
        console.error(countUp.error);
    }
}
if (document.getElementById('state2')) {
    var initialValue = parseFloat(document.getElementById("state2").getAttribute("countTo")).toFixed(2);

    const countUp = new CountUp('state2', initialValue, {
        useGrouping: false,
        separator: '',
        duration: 1
    });

    if (!countUp.error) {
        countUp.start();
    } else {
        console.error(countUp.error);
    }
}
if (document.getElementById('state3')) {
    var initialValue = parseFloat(document.getElementById("state3").getAttribute("countTo")).toFixed(2);

    const countUp = new CountUp('state3', initialValue, {
        useGrouping: false,
        separator: '',
        decimalPlaces: 0,
        duration: 1
    });

    if (!countUp.error) {
        countUp.start();
    } else {
        console.error(countUp.error);
    }
}
if (document.getElementById('state4')) {
    var initialValue = parseFloat(document.getElementById("state4").getAttribute("countTo")).toFixed(2);

    const countUp = new CountUp('state4', initialValue, {
        useGrouping: false,
        separator: '',
        decimalPlaces: 2,
        duration: 1
    });

    if (!countUp.error) {
        countUp.start();
    } else {
        console.error(countUp.error);
    }
}
if (document.getElementById('state5')) {
    var initialValue = parseFloat(document.getElementById("state5").getAttribute("countTo")).toFixed(2);

    const countUp = new CountUp('state5', initialValue, {
        useGrouping: false,
        separator: '',
        decimalPlaces: 0,
        duration: 1
    });

    if (!countUp.error) {
        countUp.start();
    } else {
        console.error(countUp.error);
    }
}
</script>

@stop