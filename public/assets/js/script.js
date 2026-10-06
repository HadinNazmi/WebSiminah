const nav = document.querySelector("#navbarBlur");

window.addEventListener("scroll", () => {
    if (document.body.scrollTop > 0 || document.documentElement.scrollTop > 0) {
        nav.classList.add("blur");
        nav.classList.add("shadow-blur");
    } else {
        nav.classList.remove("blur");
        nav.classList.remove("shadow-blur");
    }
});

// edit reward
function editDataReward(nama, stok, poin, masa_berlaku, route) {
    // console.log(id);
    var editNama = (document.getElementById("editNama").value = nama);
    var editStok = (document.getElementById("editStok").value = stok);
    var editPoin = (document.getElementById("editPoin").value = poin);
    var masa_berlaku = (document.querySelector("#editMasaBerlaku").value =
        masa_berlaku.split(" ")[0]);
    var actionForms = document.querySelector("#modal-forms-edit");
    actionForms.action = route;
}

// Swal.fire({
//     position: 'bottom-end',
//     title: 'Your work has been saved',
//     showConfirmButton: false,
//     timer: 3000,
//     background: 'rgba(52, 181, 58, 0.2)',
//     backdrop: false,
// })

// Sweetalert2
// Example delete function  for delete
function deleteReward(route) {
    Swal.fire({
        title: "Apakah ingin melanjutkan?",
        text: "Data selanjutnya tidak dapat direcovery",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, lanjut hapus",
        cancelButtonText: "Tidak",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            const deleteData = document.querySelector("#deleteData");
            deleteData.action = route;
            deleteData.submit();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire("Dibatalkan", "Data tidak jadi dihapus", "info");
            // Perform any additional actions if deletion is cancelled
        }
    });
}

function detailSumbangan(src) {
    let modalImage = document.getElementById("modal-image-sumbangan");

    modalImage.src = src;
}

function detailGambarReward(src) {
    let modalImage = document.getElementById("modal-image-sumbangan");

    modalImage.src = src;
    // console.log(src)
}

function updatePermintaanKontainer(href) {
    Swal.fire({
        title: "Apakah ingin melanjutkan?",
        text: "Permintaan akan diterima",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, terima permintaan",
        cancelButtonText: "Tidak",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            let updatePermintaanKontainer = document.querySelector(
                "#updatePermintaanKontainer"
            );

            updatePermintaanKontainer.action = href;
            updatePermintaanKontainer.submit();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire("Dibatalkan", "Data tidak jadi dihapus", "info");
            // Perform any additional actions if deletion is cancelled
        }
    });
}

// inputUbahGambarAdmin
function buttonUbahGambarAdmin() {
    const input = document.querySelector("#inputUbahGambarAdmin").click();
}

// Verifikasi sumbangan

function verifikasiSumbangan(route) {
    Swal.fire({
        title: "Lanjutkan verifikasi?",
        text: "Anda tidak dapat membatalkan status kembali",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Lanjutkan verifikasi",
    }).then((result) => {
        if (result.isConfirmed) {
            const verifikasiStatusForm = document.querySelector(
                "#verifikasiStatusForm"
            );
            verifikasiStatusForm.action = route;
            verifikasiStatusForm.submit();
        }
    });
}

function AjukanPergantianKontainer(action) {
    Swal.fire({
        title: "Apakah ingin melanjutkan?",
        text: "Pengajuan akan menunggu persetujuan admin CSR",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, lanjutkan",
        cancelButtonText: "Tidak",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            let updatePengajuanGantiKontainer = document.querySelector(
                "#updatePengajuanGantiKontainer"
            );
            updatePengajuanGantiKontainer.action = action;
            console.log(updatePengajuanGantiKontainer);
            updatePengajuanGantiKontainer.submit();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire("Dibatalkan", "Pengajuan dibatalkan", "info");
            // Perform any additional actions if deletion is cancelled
        }
    });
}

function Logout() {
    Swal.fire({
        title: "Apakah ingin keluar?",
        text: "Anda akan dimintai login kembali",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Logout",
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("logout-form").submit();
        }
    });
}

function hapusLokasi(url) {
    Swal.fire({
        title: "Apakah ingin melanjutkan?",
        text: "Data lokasi beserta turunan nya akan dihapus",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, hapus",
        cancelButtonText: "Tidak",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            let formsDeleteLokasi =
                document.querySelector("#formsDeleteLokasi");
            formsDeleteLokasi.action = url;
            // console.log(formsDeleteLokasi);
            formsDeleteLokasi.submit();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire("Dibatalkan", "Data tidak jadi dihapus", "info");
            // Perform any additional actions   if deletion is cancelled
        }
    });
}

function deleteRecord(url) {
    Swal.fire({
        title: "Apakah ingin melanjutkan?",
        text: "Data akun akan dihapus",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, hapus",
        cancelButtonText: "Tidak",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            let formDeleteAdmin = document.querySelector("#formDeleteAdmin");
            formDeleteAdmin.action = url;
            // console.log(formDeleteAdmin);
            formDeleteAdmin.submit();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire("Dibatalkan", "Data tidak jadi dihapus", "info");
            // Perform any additional actions   if deletion is cancelled
        }
    });
}

function deleteDonaturPasif(url) {
    Swal.fire({
        title: "Apakah ingin melanjutkan?",
        text: "Donatur akan dihapus permanent",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, hapus",
        cancelButtonText: "Tidak",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            let formDeleteDonaturPasif = document.querySelector(
                "#formDeleteDonaturPasif"
            );
            formDeleteDonaturPasif.action = url;
            console.log(formDeleteDonaturPasif);
            formDeleteDonaturPasif.submit();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire("Dibatalkan", "Data tidak jadi dihapus", "info");
            // Perform any additional actions   if deletion is cancelled
        }
    });
}

function showDetailGambarLokasi(source) {
    const DetailGambarLokasi = document.querySelector("#DetailGambarLokasi");
    DetailGambarLokasi.src = source;
}

// Drag n Drop Image
let dropArea = document.querySelector("#dropAndDropArea");
let insertGambarLokasi = document.querySelector("#insertGambarLokasi");

// Prevent the default behavior of file dragging over the drop area
dropArea.addEventListener("dragover", (event) => {
    event.preventDefault();
    dropArea.classList.add("drag-over");
});

dropArea.addEventListener("dragleave", () => {
    dropArea.classList.remove("drag-over");
});

// Handle the file drop event
dropArea.addEventListener("drop", (event) => {
    event.preventDefault();
    dropArea.classList.remove("drag-over");
    const file = event.dataTransfer.files[0];
    insertGambarLokasi.files = event.dataTransfer.files;
    // console.log(insertGambarLokasi.files[0]);
    handleImage(file);
});

// Handle file input change (when a file is selected through the file input)
insertGambarLokasi.addEventListener("change", () => {
    const file = insertGambarLokasi.files[0];
    handleImage(file);
});

// Function to handle the uploaded image
function handleImage(file) {
    const element = document.getElementById("insertGambarContainer");
    // Get the computed style for the element
    const computedStyle = window.getComputedStyle(element);
    const widthString = computedStyle.getPropertyValue("width");
    const heightString = computedStyle.getPropertyValue("height");
    const containerWidth = parseFloat(widthString);
    const containerHeight = parseFloat(heightString);

    if (file && file.type.startsWith("image/")) {
        const reader = new FileReader();

        reader.onload = (event) => {
            const image = new Image();
            image.src = event.target.result;
            image.onload = () => {
                const imageWidth = image.width;
                const imageHeight = image.height;

                // Calculate the scaling factors
                const widthScale = containerWidth / imageWidth;
                const heightScale =
                    (containerHeight - (containerHeight * 10) / 100) /
                    imageHeight;

                // Use the smaller scaling factor to maintain aspect ratio
                const scale = Math.min(widthScale, heightScale);

                // Calculate the scaled dimensions
                const scaledWidth = Math.round(imageWidth * scale);
                const scaledHeight = Math.round(imageHeight * scale);

                // Apply the scaled dimensions to the image
                image.width = scaledWidth;
                image.height = scaledHeight;
                dropArea.innerHTML = "";
                dropArea.appendChild(image);
            };
        };

        reader.readAsDataURL(file);
    } else {
        alert("Please select a valid image file.");
    }
}

// get action for image
const insertGambarContainer = document.querySelector("#insertGambarContainer");
insertGambarContainer.addEventListener("click", () => {
    insertGambarLokasi.click();
});

function konfirmasiPenukaranHadiah(url) {
    Swal.fire({
        title: "Apakah ingin melanjutkan?",
        text: "Permintaan redeem akan diselesaikan",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, verifikasi",
        cancelButtonText: "Tidak",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            let form = document.querySelector("#formKonfirmasiPenukaranHadiah");
            form.action = url;
            form.submit();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire("Dibatalkan", "Verifikasi reedem dibatalkan", "info");
        }
    });
}

function pagination(dataId) {
    const dataTableConfig = {
        destroy: true,
        searching: false,
        ordering: false,
        paging: true,
        lengthChange: false,
        pageLength: 5,
        info: false,
        language: {
            paginate: {
                first: "&laquo;",
                previous: "&lt;",
                next: "&gt;",
                last: "&raquo;",
            },
        },
    };
    
    if (dataId === "table-detail-donatur") {
        $.fn.dataTable.ext.classes.sPageButton = "btn-paginate";
        dataTableConfig.pageLength = 7;
        $("#table-detail-donatur").DataTable(dataTableConfig);
    } else if (dataId === "table-verifikasi-donasi") {
        $.fn.dataTable.ext.classes.sPageButton = "btn-paginate";
        $("#table-verifikasi-donasi").DataTable(dataTableConfig);
    } else if (dataId === "table-penggantian-kontainer") {
    } else if (dataId === "table-index-donatur") {
        $.fn.dataTable.ext.classes.sPageButton = "btn-paginate";
        dataTableConfig.pageLength = 8;
        $("#table-index-donatur").DataTable(dataTableConfig);
    } else if (dataId === "tabel-index-reward") {
        $.fn.dataTable.ext.classes.sPageButton = "btn-paginate";
        dataTableConfig.pageLength = 8;
        $("#tabel-index-reward").DataTable(dataTableConfig);
    } else if (dataId === "tabel-index-admin") {
        $.fn.dataTable.ext.classes.sPageButton = "btn-paginate";
        dataTableConfig.pageLength = 6;
        $("#tabel-index-admin").DataTable(dataTableConfig);
    } else if (dataId === "tabel-manajemen-permintaan") {
        $.fn.dataTable.ext.classes.sPageButton = "btn-paginate";
        dataTableConfig.pageLength = 7;
        $("#tabel-manajemen-permintaan").DataTable(dataTableConfig);
    } else if (dataId === "tabel-index-lokasi") {
        $.fn.dataTable.ext.classes.sPageButton = "btn-paginate";
        dataTableConfig.pageLength = 3;
        $("#tabel-index-lokasi").DataTable(dataTableConfig);
    } else if (dataId === "table-penggantian-kontainer") {
        $.fn.dataTable.ext.classes.sPageButton = "btn-paginate";
        dataTableConfig.pageLength = 1;
        $("#table-penggantian-kontainer").DataTable(dataTableConfig);
    } else if (dataId === "table-detail-donatur") {
        $.fn.dataTable.ext.classes.sPageButton = "btn-paginate";
        dataTableConfig.pageLength = 4;
        $("#table-detail-donatur").DataTable(dataTableConfig);
    } else if (dataId === "table-detail-reward") {
        $.fn.dataTable.ext.classes.sPageButton = "btn-paginate";
        dataTableConfig.pageLength = 7;
        $("#table-detail-reward").DataTable(dataTableConfig);
    } else if (dataId === "table-sumbangan-csr"){
        $.fn.dataTable.ext.classes.sPageButton = "btn-paginate";
        dataTableConfig.pageLength = 10;
        $("#table-sumbangan-csr").DataTable(dataTableConfig);
    } else if (dataId === "table-detail-sumbangan-kelurahan"){
        $.fn.dataTable.ext.classes.sPageButton = "btn-paginate";
        dataTableConfig.pageLength = 8;
        $("#table-detail-sumbangan-kelurahan").DataTable(dataTableConfig);
    } else if (dataId === "table-manajemen-kontainer-csr"){
        $.fn.dataTable.ext.classes.sPageButton = "btn-paginate";
        dataTableConfig.pageLength = 4;
        $("#table-manajemen-kontainer-csr").DataTable(dataTableConfig);
    } else if (dataId === "table-verifikasi-hadiah"){
        $.fn.dataTable.ext.classes.sPageButton = "btn-paginate";
        dataTableConfig.pageLength = 3;
        $("#table-verifikasi-hadiah").DataTable(dataTableConfig);
    }
}

function terimaPergantianKontainer(action){
    Swal.fire({
        title: "Apakah ingin melanjutkan?",
        text: "Terima kontainer!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, terima",
        cancelButtonText: "Tidak",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            let updateTerimaKontainer = document.querySelector('#updateTerimaKontainer')
            updateTerimaKontainer.action = action
            updateTerimaKontainer.submit()
            // console.log(updateTerimaKontainer);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire("Dibatalkan", "Kontainer tidak diterima", "info");
        }
    });
}