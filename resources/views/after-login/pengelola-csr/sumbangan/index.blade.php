@extends('components._partials.default')

@section('content')
    {{-- {{ dd($laporan) }} --}}
    <div class="container-fluid py-2 ps-4">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12 reward text-poppins">Sumbangan</div>
                </div>
                <div class="row mt-3">
                    <div class="col-xxl-11 col-xl-11 col-lg-11 col-md-12 col-sm-12 col-12">
                        <div class="container-fluid olah-donatur animate__animated animate__fadeInUp">
                            <div class="row">
                                <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-8 col-sm-12 col-12">
                                    <div class="header">
                                        Laporan Sumbangan Minyak Jelantah
                                    </div>
                                </div>
                                <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                                    <div class="right-header ms-3 ms-xxl-0 ms-xl-0 ms-lg-0 ms-md-0 ms-sm-0">
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
                                <div class="col-md-12 col-sm-12 col-12">
                                    <div class="body">
                                        <div class="table-responsive-sm table-responsive-xl table-responsive-lg table-responsive-md">
                                            <table id="table-sumbangan-csr"
                                                class="tableForPagination table align-middle mb-0 reward-table ps-6" data-id="table-sumbangan-csr">
                                                <thead>
                                                    <tr>
                                                        <th>KECAMATAN</th>
                                                        <th>KELURAHAN</th>
                                                        <th class="text-center">JUMLAH (KG)</th>
                                                        <th class="text-center">JUMLAH DONATUR</th>
                                                        <th>BULAN</th>
                                                        <th>TANGGAL PELAPORAN</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (!empty($laporan))
                                                        @foreach ($laporan as $item)
                                                            <tr class="reward-tr donatur-csr-tr">
                                                                <td class="ps-2 detail-kelurahan">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="ms-2  d-grid">
                                                                            <span class="top">
                                                                                {{ $item->nama_kecamatan }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="ps-2 detail-kelurahan">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="ms-2  d-grid">
                                                                            <span class="top">
                                                                                {{ $item->nama_kelurahan }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="subdata text-center">
                                                                    {{ $item->total_berat }}
                                                                </td>
                                                                <td class="subdata text-center">
                                                                    {{ $item->total_donatur }}
                                                                </td>
                                                                <td class="ps-4 tanggal">
                                                                    {{ numberToMonth($item->bulan) }}
                                                                </td>
                                                                <td class="ps-4 tanggal" id="tanggal">
                                                                    {{ dateFormat($item->tanggal_laporan) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
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
@stop

@section('script')
    <script>
        var tableData = [];
        const tableRows = $('#table-sumbangan-csr tbody tr');
        const originalData = $('#table-sumbangan-csr tbody').html()
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
                $('#table-sumbangan-csr tbody').html(originalData);
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

            const imageUrl = 'assets/img/default/logo_siminah.png';

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
            doc.text("LAPORAN SUMBANGAN MINYAK JELANTAH", docPageWidth, y = y + 40, { align: 'center' });
            doc.setFontSize(10);
            doc.text(tanggalHariIni, docPageWidth, y = y + 15, { align: 'center' });
            doc.setFontSize(12);
            doc.autoTable({
                headStyles: {
                    fillColor: [101, 174, 56],
                    valign: 'middle',
                    halign: 'center',
                },
                // html: '#sumbangan-table',
                head: [
                    ['NO', 'KECAMATAN', 'KELURAHAN', 'JUMLAH (KG)', 'JUMLAH DONATUR', 'BULAN' ,'TANGGAL PELAPORAN']
                ],
                body: tableDataWithRowNumbers,
                startY: y + 10,
                theme: 'striped',
                columnStyles: {
                    0: {
                        cellWidth: 40,
                    },
                    1: {
                        cellWidth: 125,
                    },
                    2: {
                        cellWidth: 125,
                    },
                    3: {
                        cellWidth: 60,
                    },
                    4: {
                        cellWidth: 60
                    },
                    5: {
                        cellWidth: 70
                    },
                    6: {
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
                    1: {
                        valign: 'middle',
                    },
                    2: {
                        valign: 'middle',
                        fontStyle: 'bold',
                    },
                    3: {
                        valign: 'middle',
                        halign: 'center',
                        fontStyle: 'bold',
                    },
                    4: {
                        valign: 'middle',
                        halign: 'center',
                        fontStyle: 'bold',
                    },
                    5: {
                        valign: 'middle',
                    },
                    6: {
                        valign: 'middle',
                    },
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
            doc.save('Laporan-sumbangan-minyak-' + tanggalHariIni.replace(' ', '-') + '.pdf');
        }

            // Pagination
            const dataId = $('.tableForPagination').data('id')
            pagination(dataId)
    </script>
@endsection
