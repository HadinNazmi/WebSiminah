@if (!empty(session('login_alert')))
    @if (session('login_alert') === 'success')
        <script>
            Swal.fire(
                'Login!',
                'Login berhasil',
                'success',
            );
        </script>
    @elseif(session('login_alert') === 'error')
        <script>
            Swal.fire(
                'Login!',
                'Username atau Password salah!',
                'error',
            );
        </script>
    @endif
@elseif (!empty(session('logout_alert')))
    @if (session('logout_alert') === 'success')
        <script>
            Swal.fire(
                'Logout!',
                'Logout berhasil',
                'success',
            );
        </script>
    @endif
@elseif(!empty(session('tambah_alert')))
    @if (session('tambah_alert') === 'success')
        <script>
            Swal.fire(
                'Tambah!',
                'Tambah data berhasil',
                'success',
            );
        </script>
    @elseif(session('tambah_alert') === 'error')
        <script>
            Swal.fire(
                'Tambah!',
                'Terjadi error pada saat tambah data!',
                'error',
            );
        </script>
    @endif
@elseif(!empty(session('verifikasi_alert')))
    @if (session('verifikasi_alert') === 'success')
        <script>
            Swal.fire(
                'Verifikasi!',
                'Verifikasi sumbangan berhasil',
                'success',
            );
        </script>
    @elseif(session('verifikasi_alert') === 'error')
        <script>
            Swal.fire(
                'Verifikasi!',
                'Terjadi error pada saat verifikasi sumbangan!',
                'error',
            );
        </script>
    @elseif(session('verifikasi_alert') === 'tolak')
        <script>
            Swal.fire(
                'Verifikasi!',
                'Sumbangan di tolak',
                'success',
            );
        </script>
    @endif
@elseif(!empty(session('edit_alert')))
    @if (session('edit_alert') === 'success')
        <script>
            Swal.fire(
                'Edit!',
                'Edit data berhasil',
                'success',
            );
        </script>
    @elseif(session('edit_alert') === 'error')
        <script>
            Swal.fire(
                'Edit!',
                'Terjadi error pada saat edit data!',
                'error',
            );
        </script>
    @elseif(session('edit_alert') === 'incomplete')
        <script>
            Swal.fire(
                'Edit!',
                'Pastikan data unique!',
                'error',
            );
        </script>
    @endif
@elseif(!empty(session('delete_alert')))
    @if (session('delete_alert') === 'success')
        <script>
            Swal.fire(
                'Hapus!',
                'Hapus data berhasil',
                'success',
            );
        </script>
    @elseif(session('delete_alert') === 'error')
        <script>
            Swal.fire(
                'Hapus!',
                'Terjadi error pada saat hapus data!',
                'error',
            );
        </script>
    @endif
@elseif(!empty(session('permintaan_alert')))
    @if (session('permintaan_alert') === 'success')
        <script>
            Swal.fire(
                'Permintaan!',
                'Permintaan di terima',
                'success',
            );
        </script>
    @elseif(session('permintaan_alert') === 'error')
        <script>
            Swal.fire(
                'Permintaan!',
                'Terjadi error pada saat aksi permintaan!',
                'error',
            );
        </script>
    @endif
@elseif(!empty(session('lokasi_alert')))
    @if (session('lokasi_alert') === 'success')
        <script>
            Swal.fire(
                'Lokasi!',
                'Lokasi baru berhasil diinputkan',
                'success',
            );
        </script>
    @elseif(session('lokasi_alert') === 'error')
        <script>
            Swal.fire(
                'Lokasi!',
                'Terjadi error pada saat penambahan lokasi!',
                'error',
            );
        </script>
    @endif
    {{-- Swal.fire({
        position: 'bottom-end',
        title: 'Your work has been saved',
        showConfirmButton: false,
        timer: 3000,
        background: 'rgba(52, 181, 58, 0.2)',
        backdrop: false,
    }) --}}
@endif
