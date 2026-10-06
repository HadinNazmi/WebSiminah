@extends('components._partials.default')

@section('content')
    <div class="container-fluid py-2 ps-4">
        <div class="row">
            <div class="col-md-12 page-header text-poppins">
                Halaman profil
            </div>
        </div>
        <div class="row">
            <div class="container-fluid edit-profil">
                <form action="{{ route('admin.store') }}" method="POST">
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
                            <div class="row">
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
                            </div>
                            <div class="row">
                                <div class="col-md-4 section-1">
                                    <x-forms.formControlAdmin label="Nama" name="name" placeholder="Nama lengkap" />
                                </div>
                                <div class="col-md-4 section-2">
                                    <x-forms.formControlAdmin label="Email" name="email" placeholder="Email" />
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-4 section-1">
                                    <x-forms.formControlAdmin label="Username" name="username" placeholder="Username" />
                                </div>
                                <div class="col-md-4 section-2">
                                    <x-forms.formControlAdmin label="No Telepon" name="no_hp"
                                        placeholder="Nomor telepon" />
                                </div>
                                {{-- <div class="col-md-4 section-2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <x-forms.formControlAdmin label="No Telepon" name="no_hp" placeholder="Nomor telepon"/>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-4 section-1">
                                    <x-forms.formControlAdmin label="Alamat" name="alamat_rumah"
                                        placeholder="Alamat tempat tinggal Admin Kelurahan" />
                                </div>
                                <div class="col-md-4 section-2">
                                    <x-forms.selectOption name="id_lokasi" label="Kelurahan">
                                        @slot('slotOptions')
                                            {{-- {{ dd($lokasi) }} --}}
                                            @if (!empty($lokasi))
                                                @foreach ($lokasi as $item)
                                                    <option value="{{ $item->id_lokasi }}">{{ $item->nama_kelurahan }}</option>
                                                @endforeach
                                            @endif
                                        @endslot
                                    </x-forms.selectOption>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 bottom-line">
                        <div class="row header d-flex justify-content middle">
                            <div class="col-md-12 col-sm-12 col-12 button d-flex justify-content-end">
                                <a href="{{ route('profil') }}" class="bottom-btn-batal">Batal</a>
                                <button class="ms-2 simpan-buttom" type="submit">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
