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

#map-container {
    position: relative;
    display: flex;
    flex-direction: row-reverse;
    height: 400px;
}

#map {
    position: relative;
    display: flex;
    flex: 1;
    height: 100%;
    width: 100%;
}

.filter-options {
    width: 150px;
    background: rgba(255, 255, 255, 0.8);
    padding: 10px;
    border-radius: 5px;
    z-index: 1000;
    overflow-y: auto;
    position: absolute;
    top: 0;
    left: 0;
    max-height: 300px;
}

.checkbox-list {
    overflow-y: auto;
}

.checkbox-list label {
    display: block;
    margin-bottom: 8px;
}

</style>

<div class="container-fluid py-4">
    <div class="row animate__animated animate__fadeInUp">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
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
                        <p class="text-sm mb-0 text-capitalize">Donatur bulan {{$bulanTahun}}</p>
                        <h4 class="mb-0"><span id="state2" countTo="{{ $totalDonatur }}"></span> Orang</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    <p class="mb-0"><span
                            class="{{ $perbandinganDonatur < 0 ? 'text-danger' : 'text-success' }} text-sm font-weight-bolder">{{ $donaturAktifBulanIni }}
                        </span> donatur aktif bulan ini</p>
                </div>
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
                        <p class="text-sm mb-0 text-capitalize">Reward hampir habis</p>
                        <h4 class="mb-0"><span id="state4" countTo="{{$reward}}"></span> Reward</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <a href="{{ route('hadiah') }}">
                    <div class="card-footer p-3">
                        <p class="mb-0">Kelola Reward <i class="material-icons text-sm">open_in_new</i></p>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">warning</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-0 text-capitalize">request ganti kontainer</p>
                        <h4 class="mb-0"><span id="state3" countTo="{{$hampirPenuh}}"></span> Permintaan</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <a href="{{ route('kontainer') }}">
                    <div class="card-footer p-3">
                        <p class="mb-0">Kelola Kontainer <i class="material-icons text-sm">open_in_new</i></p>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="row mt-2 animate__animated animate__fadeInUp">
        <div class="col-lg-6 col-md-6 mt-4 mb-4">
            <div class="card z-index-2">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 me-3 float-start">
                        <i class="material-icons opacity-10">leaderboard</i>
                    </div>
                    <div class="d-block d-md-flex">
                        <div class="me-auto">
                            <h6 class="mb-0">Total Sumbangan</h6>
                            <p class="mb-0 text-sm">5 Kelurahan dengan sumbangan terbanyak</p>
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
                        <p class="mb-0 text-sm"> data per tanggal {{ $tanggal }} </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 mt-4 mb-4">
            <div class="card z-index-2">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 me-3 float-start">
                        <i class="material-icons opacity-10">splitscreen</i>
                    </div>
                    <div class="d-block d-md-flex">
                        <div class="me-auto">
                            <h6 class="mb-0">Progress Kontainer</h6>
                            <p class="mb-0 text-sm">5 Kontainer Hampir penuh</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3 pt-0">
                    <div class="chart">
                        <canvas id="myChart1" class="chart-canvas" height="230"></canvas>
                    </div>
                    <hr class="dark horizontal">
                    <div class="d-flex ">
                        <i class="material-icons text-sm my-auto me-1">schedule</i>
                        <p class="mb-0 text-sm"> data per tanggal {{ $tanggal }} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4 animate__animated animate__fadeInUp">
        <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-lg-6 col-7">
                            <h6>Sebaran Lokasi Kontainer</h6>
                            <p class="text-sm mb-0">
                                <i class="fa fa-map-marker text-info" aria-hidden="true"></i>
                                <span class="font-weight-bold ms-1">{{ $totalKontainer }} Lokasi</span> pada
                                {{$bulanTahun}}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-9 col-md-12">
                            <div id="map-container">
                                <div id="map" style="height: 400px;"></div>
                                <div class="filter-options">
                                    <h6>Kecamatan</h6>
                                    <div class="checkbox-list">
                                        @foreach ($totalKontainerKecamatan as $data)
                                        <label>
                                            <input type="checkbox" class="kecamatan-checkbox" data-id="{{ $data->id_kecamatan }}" checked>
                                            {{ $data->nama_kecamatan }}
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12">
                            <div class="table-responsive" style="max-height: 400px; overflow-y: auto; overflow-x: hidden;">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <th>Kecamatan</th>
                                        <th>Jumlah</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($totalKontainerKecamatan as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-0">
                                                    <i class="material-icons text-lg me-1 my-auto">location_on</i>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $item->nama_kecamatan }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="text-align: center;">
                                                <h6 class="mb-0 text-sm" >
                                                    {{ $item->kontainer_count }}
                                                </h6>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr class="dark horizontal">
                    <div class="col-lg-12 col-md-12">
                        <div class="d-flex mt-3">
                            <i class="material-icons text-sm my-auto me-1">schedule</i>
                            <p class="mb-0 text-sm"> updated 4 min ago </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-lg-4 col-md-6">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6>Riwayat Aktivitas</h6>
                    <p class="text-sm">
                        <i class="fa fa-bell text-info" aria-hidden="true"></i>
                        <span class="font-weight-bold">0</span> notifikasi bulan {{$bulanTahun}}
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="timeline timeline-one-side">
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="material-icons text-success text-gradient">notifications</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">$2400, Design changes</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">22 DEC 7:20 PM</p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="material-icons text-danger text-gradient">code</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">New order #1832412</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 11 PM</p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="material-icons text-info text-gradient">shopping_cart</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Server payments for April</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 9:34 PM</p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="material-icons text-warning text-gradient">credit_card</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">New card added for order
                                    #4395133
                                </h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">20 DEC 2:20 AM</p>
                            </div>
                        </div>
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="material-icons text-primary text-gradient">key</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Unlock packages for development
                                </h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">18 DEC 4:54 AM</p>
                            </div>
                        </div>
                        <div class="timeline-block">
                            <span class="timeline-step">
                                <i class="material-icons text-dark text-gradient">payments</i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">New order #9583120</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">17 DEC</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</div>

<script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/countup.min.js') }}"></script>

<script>
var ctx = document.getElementById("chart-bars1").getContext("2d");

new Chart(ctx, {
    type: "bar",
    data: {
        labels: @json($chartData['labels']),
        datasets: [{
            label: "Total Sumbangan",
            tension: 1,
            borderWidth: 0,
            borderRadius: 5,
            borderSkipped: false,
            backgroundColor: "#145ea8",
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
</script>

<script>
function updateChart(selectedLokasiId) {
    $.ajax({
        url: '/dashboard/fetchChartData/' + selectedLokasiId,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            updateMyChart1(data);
        },
        error: function(xhr, textStatus, errorThrown) {
            console.error('Error fetching data: ' + errorThrown);
        }
    });
}

var ctx1 = document.getElementById('myChart1').getContext('2d');
var colors1 = ['rgba(101, 174, 56, 1)', 'rgba(0, 0, 0, 0)'];
var cutout1 = '85%';

new Chart(ctx1, {
    type: "bar",
    data: {
        labels: @json($chartData2['labels2']),
        datasets: [
            {
            label: "Total Isi",
            weight: 5,
            borderWidth: 0,
            borderRadius: 5,
            data: @json($chartData2['values2']),
            backgroundColor: @json($chartData2['colors']),
            borderSkipped: false,
            maxBarThickness: 12,
            z: 2,
        }],
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false,
            }
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
                    beginAtZero: true,
                    padding: 10,
                    color: "#9ca2b7",
                    font: {
                        size: 12,
                        weight: 300,
                        family: "Poppins",
                        style: 'normal',
                        lineHeight: 2
                    },
                },
            },
            x: {
                min:0,
                max:30,
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
</script>

<script>
var map = L.map('map').setView([1.6692, 101.4478], 11);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
    maxZoom: 16,
}).addTo(map);

map.removeControl(map.zoomControl);

map.addControl(new L.Control.Fullscreen({ position: 'topright' }));

L.control.zoom({ position: 'topright' }).addTo(map);

var mapData = {!! $mapData !!};

var kecamatanMarkers = {};

for (var i = 0; i < mapData.length; i++) {
    var marker = mapData[i];

    var popupContent = '<div class="custom-popup">' +
        '<h3 class="custom-popup-title">' + marker.nama + '</h3>' + '<hr class="dark horizontal">' +
        '<p class="custom-popup-lat">Total Donatur: ' + marker.total_donatur + ' Orang</p>' +
        '<p class="custom-popup-lng">Total Berat: ' + marker.total_berat + ' L</p>' +
        '</div>';

    var newMarker = L.marker([marker.lat, marker.lng])
        .addTo(map)
        .bindPopup(popupContent, {
            className: 'custom-popup'
        });

    if (!kecamatanMarkers[marker.id_kec]) {
        kecamatanMarkers[marker.id_kec] = [];
    }
    kecamatanMarkers[marker.id_kec].push(newMarker);
}

function filterMarkers() {
    var selectedKecamatanIds = [];
    $('.kecamatan-checkbox:checked').each(function() {
        selectedKecamatanIds.push($(this).data('id'));
    });

    for (var kecamatanId in kecamatanMarkers) {
        kecamatanMarkers[kecamatanId].forEach(function(marker) {
            map.removeLayer(marker);
        });
    }

    selectedKecamatanIds.forEach(function(kecamatanId) {
        kecamatanMarkers[kecamatanId].forEach(function(marker) {
            map.addLayer(marker);
        });
    });
}

filterMarkers();

$('.kecamatan-checkbox').change(function() {
    filterMarkers();
});
</script>

<x-sweetalert />

<script>
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
<script>
    // Wait for the document to be ready
    $(document).ready(function() {
        // Initialize Smooth Scrollbar on the element with class "scrollable-content"
        new SmoothScrollbar('.scrollable-content');
    });
</script>
@stop