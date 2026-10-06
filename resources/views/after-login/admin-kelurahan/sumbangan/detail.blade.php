@extends('components._partials.default')

@section('content')
    <div class="container-fluid py-2 ps-4">
        <div class="row">
            <div class="col-lg-12 page-header text-poppins">
                <a href="{{ route('sumbangan') }}" class="text-secondary link-secondary">Sumbangan</a>
                <span>
                    <b>
                        &nbsp;/ Detail Sumbangan
                    </b>
                </span>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-xxl-11 col-12">
                <div class="row detail-riwayat-sumbangan animate__animated animate__fadeInUp ">
                    <div class="col-md-7">
                        <div class="container-fluid">
                            <h1>Riwayat Donasi</h1>
                        </div>
                    </div>
                    <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12">
                        <div class="right-header ms-3 ms-xxl-0 ms-xl-0 ms-lg-0 ms-md-0">
                            <x-forms.inputDate id="date-range-picker" />
                            <div class="header-button">
                                <div
                                    class="text-poppins text-14 btn-reward-position d-flex justify-content-end align-items-end">
                                    <a href="#"
                                        class="btn-reward 
                                    btn-semi-success d-flex align-items-center export-btn"
                                        onclick="generate()">
                                        EXPORT
                                        <span class="material-symbols-outlined">
                                            download
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- {{ dd($riwayat) }} --}}

                    <div class="col-md-12">
                        <div class="body overflowy-kontainer-kelurahan">
                            <x-forms.table id="table-detail-sumbangan-kelurahan">
                                @slot('headSlot')
                                    <th>NAMA</th>
                                    <th class="text-center">BERAT SUMBANGAN (Kg)</th>
                                    <th>WAKTU SUMBANGAN</th>
                                    <th>WAKTU VERIFIKASI</th>
                                    <th>STATUS</th>
                                @endslot

                                @slot('bodySlot')
                                    @if (!empty($riwayat))
                                        @foreach ($riwayat as $item)
                                            <tr class="verifikasi-tr">
                                                <td class="ps-4 nama">
                                                    <div class="d-flex align-items-center justify-center">
                                                        <span class="top">{{ $item->donatur->nama_donatur }}</span>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    {{ $item->berat }}
                                                </td>
                                                <td class="ps-4 tanggal">
                                                    {{ datetimeFormat($item->created_at) }}
                                                </td>
                                                <td class="ps-4 tanggal" id="tanggal">
                                                    {{ dateFormat($item->updated_at) }}
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

@stop

@section('script')
    <script>
        const dataId = $('.tableForPagination').data('id')
        pagination(dataId)
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.6/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        var tableData = [];
        const tableRows = $('#table-detail-sumbangan-kelurahan tbody tr');
        const originalData = $('#table-detail-sumbangan-kelurahan tbody').html()
        $(function() {
            const picker = $('#date-range-picker').daterangepicker({
                locale: {
                    cancelLabel: 'Clear'
                },
                opens: 'left',
                startDate: moment().subtract(7, 'days'),
                endDate: moment(),
                locale: {
                    format: 'YYYY-MM-DD'
                }
            }, function(start, end, label) {
                filterTableByDateRange(start, end);
            });

            picker.on('cancel.daterangepicker', function(ev, picker) {
                $('#table-detail-sumbangan-kelurahan tbody').html(originalData);
                console.log(ev);
                console.log(picker);
                tableData = [];
                setDefaultData()
            });
        });


        var tableDataWithRowNumbers;

        function filterTableByDateRange(startDate, endDate) {
            tableData = [];
            for (let i = 0; i < tableRows.length; i++) {
                const row = tableRows[i];
                const data = row.querySelector('td#tanggal').textContent;
                const momentObj = moment(data, 'DD MMMM YYYY');
                const rowDate = momentObj.format('YYYY-MM-DD');
                if (rowDate >= startDate.format('YYYY-MM-DD') && rowDate <= endDate.format('YYYY-MM-DD')) {
                    row.style.display = '';
                    const rowData = [];
                    const cells = row.querySelectorAll('td');
                    for (let j = 0; j < cells.length; j++) {
                        rowData.push(cells[j].textContent.trim());
                    }
                    tableData.push(rowData);
                } else {
                    row.style.display = 'none';
                }
            }
            tableDataWithRowNumbers;
            tableDataWithRowNumbers = tableData.map(function(row, index) {
                return [index + 1].concat(row).slice(0);
            });
        }


        // get current Time
        var tanggalHariIni = new Date();
        var options = {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        };
        var tanggalHariIni = tanggalHariIni.toLocaleDateString('id-ID', options);


        function setDefaultData() {
            for (let i = 0; i < tableRows.length; i++) {
                const row = tableRows[i];
                const data = row.querySelector('td#tanggal').textContent;
                if (true) {
                    row.style.display = '';
                    const rowData = [];
                    const cells = row.querySelectorAll('td');
                    for (let j = 0; j < cells.length; j++) {
                        rowData.push(cells[j].textContent.trim());
                    }
                    tableData.push(rowData);
                } else {
                    row.style.display = 'none';
                }
            }
            tableDataWithRowNumbers;
            tableDataWithRowNumbers = tableData.map(function(row, index) {
                return [index + 1].concat(row).slice(0);
            });
        }

        setDefaultData()

        function generate() {
            var doc = new jsPDF('p', 'pt', 'a4');
            // get file ukuran page
            const docPageWidth = doc.internal.pageSize.getWidth()/2;
            const imageWidth = 141;
            const imageHeight = 71;

            const imageUrl = '../assets/img/default/logo_siminah.png';

            // Create an HTML `img` element to load the image
            const img = new Image();

            // Load the image from the URL
            img.crossOrigin = 'Anonymous'; // Important for cross-origin images
            img.src = imageUrl;

            // When the image is loaded, encode it as Base64
            img.onload = function() {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0, img.width, img.height);
                const base64Image = canvas.toDataURL('image/png');
            };


            var htmlstring = '';
            var tempVarToCheckPageHeight = 0;
            var pageHeight = 0;
            pageHeight = doc.internal.pageSize.height;
            specialElementHandlers = {
                // element with id of "bypass" - jQuery style selector  
                '#bypassme': function(element, renderer) {
                    // true = "handled elsewhere, bypass text extraction"  
                    return true
                }
            };
            margins = {
                top: 150,
                bottom: 60,
                left: 40,
                right: 40,
                width: 600
            };
            var y = 80;

            doc.setLineWidth(2);
            doc.addImage(img, 'PNG', docPageWidth - 75, 10, 150, 81);
            doc.setFontSize(16);
            doc.text("Data sumbangan kelurahan", docPageWidth, y = y + 20, { align: 'center' });
            doc.setFontSize(10);
            doc.text(tanggalHariIni, docPageWidth, y = y + 20, { align: 'center' });
            doc.setFontSize(12);
            doc.autoTable({
                headStyles: {
                    fillColor: [101, 174, 56],
                    valign: 'middle',
                    halign: 'center',
                },
                // html: '#sumbangan-table',
                head: [
                    ['NO', 'NAMA', 'BERAT SUMBANGAN (Kg)', 'WAKTU SUMBANGAN', 'WAKTU VERIFIKASI', 'STATUS']
                ],
                body: tableDataWithRowNumbers,
                startY: y+10,
                theme: 'striped',
                columnStyles: {
                    0: {
                        cellWidth: 40,
                    },
                    1: {
                        cellWidth: 140,
                    },
                    2: {
                        cellWidth: 140,
                    },
                    3: {
                        cellWidth: 80,
                    },
                    4: {
                        cellWidth: 80
                    },
                    5: {
                        cellWidth: 60
                    },
                },
                styles: {
                    minCellHeight: 10
                },
                columnStyles: {
                    0: {
                        valign: 'middle',
                        halign: 'center',
                        fontStyle: 'bold',
                    },
                    2: {
                        valign: 'middle',
                        halign: 'center',
                        fontStyle: 'bold',
                    }
                },
                didDrawCell: function(data) {
                    if (data.section === 'body' && data.column.index !== data.table.columns.length - 1) {
                        doc.setDrawColor(200, 200, 200); // Set the color of the delimiter
                        doc.setLineWidth(0.5); // Set the width of the delimiter
                        doc.line(data.cell.x + data.cell.width, data.cell.y, data.cell.x + data.cell.width, data
                            .cell.y + data.cell.height); // Draw the delimiter
                    }
                },
            })
            doc.save('Laporan-riwayat-donasi-' + tanggalHariIni.replace(' ', '-') + '.pdf');
        }
    </script>
@endsection

