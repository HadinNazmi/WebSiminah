@extends('components._partials.default')

@section('content')
    <div class="container-fluid py-2 ps-4">
        <div class="row">
            <div class="col-md-12 page-header text-poppins">
                Halaman profil
            </div>
        </div>
        {{-- {{ dd($user) }} --}}
        <div class="row">
            <div class="container-fluid edit-profil">
                <form action="{{ route('profil.update', ['id' => $user->id_user]) }}" method="POST">
                    @csrf
                    <div class="col-md-12">
                        <div class="row header d-flex justify-content middle">
                            <div class="col-md-9 col-sm-9 col-9 title">
                                <h3 class="align-middle">Informasi Dasar</h3>
                            </div>
                            {{-- <div class="col-md-3 col-sm-3 col-3 button d-flex justify-content-end"> --}}
                            {{-- <button type="submit">ss</button> --}}
                            {{-- <x-forms.btn.button type="submit" color="danger" title="Simpan" />
                            </div> --}}
                        </div>
                    </div>
                    <div class="col-md-12 line">
                        <div class="container-fluid body">
                            {{-- <div class="row">
                                <div class="col-md-12">
                                    <div class="ubah-gambar">
                                        <div class="gambar">
                                            <x-user.userImage width="132" height="132" />
                                        </div>
                                        <div class="detail-button">
                                            <div class="text">
                                                <div class="top">
                                                    Foto ini akan tampil kepada orang lain jika orang lain mengunjungi
                                                    profil anda
                                                </div>
                                                <div class="bottom">
                                                    Max Size 2 MB
                                                </div>
                                            </div>
                                            <div class="btn-ubah">
                                                <input type="file" class="inputFile" id="inputUbahGambarAdmin"
                                                    name="gambar">
                                                <button type="button" onclick="buttonUbahGambarAdmin()">Ubah Foto</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="row">
                                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-5 ms-xxl-1">
                                    <x-forms.formControlAdmin label="Nama" name="name" placeholder="Nama lengkap"
                                        disabled="true" value="{{ $user->nama_admin }}" />
                                </div>
                                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-5 ms-xxl-4 ms-xl-4 mt-3 mt-xxl-0 mt-xl-0 mt-lg-0 mt-md-0">
                                    <x-forms.formControlAdmin label="Username" name="username" placeholder="Username"
                                        disabled="true" value="{{ $user->username }}" />
                                </div>

                            </div>
                            <div class="row mt-4">
                                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-5 ms-xxl-1">
                                    <div class="form-control-admin animate__animated animate__fadeInUp">
                                        <label for="gantiPassword" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="passwordProfil"
                                            placeholder="Ganti password disini" name="passwordProfil" required
                                            autocomplete="new-password">
                                        <p class="text-danger position-absolute" id="PasswordNotMatch"></p>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-5 ms-xxl-4 ms-xl-4 mt-3 mt-xxl-0 mt-xl-0 mt-lg-0 mt-md-0">
                                    <div class="form-control-admin animate__animated animate__fadeInUp">
                                        <label for="konfirmasiPassword" clEditass="form-label">Konfirmasi password</label>
                                        <input type="password" class="form-control" id="konfirmasiPasswordProfil"
                                            placeholder="Ketik ulang password disini" name="password"
                                            required autocomplete>
                                        <p class="text-danger position-absolute" id="KonfirmasiPasswordNotMatch"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-5 ms-xxl-1">
                                    <x-forms.formControlAdmin label="No Telepon" name="no_hp" placeholder="Nomor telepon"
                                        disabled="true" value="{{ $user->no_hp }}" />
                                </div>
                                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-5 ms-xxl-4 ms-xl-4 mt-3 mt-xxl-0 mt-xl-0 mt-lg-0 mt-md-0">
                                    <x-forms.formControlAdmin label="Email" name="email" placeholder="Email"
                                        disabled="true" value="{{ $user->email }}" />
                                </div>
                                {{-- <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-5 ms-xxl-4 ms-xl-4 mt-3 mt-xxl-0 mt-xl-0 mt-lg-0 mt-md-0">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <x-forms.formControlAdmin label="No Telepon" name="no_hp" placeholder="Nomor telepon"/>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row mt-4">
                                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-5 ms-xxl-1">
                                    <x-forms.selectOption name="id_lokasi" label="Kelurahan" disabled="true">
                                        @slot('slotOptions')
                                            <option @if ($user->id_lokasi === $user->id_lokasi) {{ 'selected' }} @endif
                                                value="{{ $user->id_lokasi }}">{{ $user->nama_kelurahan }}</option>
                                        @endslot
                                    </x-forms.selectOption>
                                </div>
                                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-5 ms-xxl-4 ms-xl-4 mt-3 mt-xxl-0 mt-xl-0 mt-lg-0 mt-md-0">
                                    <x-forms.formControlAdmin label="Alamat" name="alamat_rumah"
                                        placeholder="Alamat tempat tinggal Admin Kelurahan" disabled="true"
                                        value="{{ $user->alamat_rumah }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 bottom-line">
                        <div class="row header d-flex justify-content middle">
                            <div class="col-md-12 col-sm-12 col-12 button d-flex justify-content-end">
                                <a href="{{ route('profil') }}" class="bottom-btn-batal">Batal</a>
                                <button class="ms-2 simpan-buttom" type="submit" id="buttonSimpanPerubahan">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let passwordProfil = document.querySelector('#passwordProfil')
        let konfirmasiPasswordProfil = document.querySelector('#konfirmasiPasswordProfil');
        let PasswordNotMatch = document.querySelector('#PasswordNotMatch');
        let KonfirmasiPasswordNotMatch = document.querySelector('#KonfirmasiPasswordNotMatch');
        let buttonSimpanPerubahan = document.querySelector('#buttonSimpanPerubahan');

        passwordProfil.addEventListener('keyup', () => {
            if (passwordProfil.value.length < 8) {
                PasswordNotMatch.innerHTML = 'Minimal password 8 karaketer'
                buttonSimpanPerubahan.disabled = true;
            } else {
                PasswordNotMatch.innerHTML = ''
                buttonSimpanPerubahan.disabled = false;
            }
        })

        konfirmasiPasswordProfil.addEventListener('keyup', () => {
            if (konfirmasiPasswordProfil.value !== '') {

                if (passwordProfil.value !== konfirmasiPasswordProfil.value) {
                    KonfirmasiPasswordNotMatch.innerHTML = 'Password tidak sama';
                    buttonSimpanPerubahan.disabled = true;
                    buttonSimpanPerubahan.style.cursor = 'not-allowed';
                } else {
                    buttonSimpanPerubahan.disabled = false;
                    KonfirmasiPasswordNotMatch.innerHTML = ''
                    buttonSimpanPerubahan.style.cursor = 'pointer';
                }
                konfirmasiPasswordProfil.innerHTML = ''
            } else {
                buttonSimpanPerubahan.disabled = false;
                KonfirmasiPasswordNotMatch.innerHTML = ''
                buttonSimpanPerubahan.style.cursor = 'pointer';
            }
        });
    </script>
@stop
