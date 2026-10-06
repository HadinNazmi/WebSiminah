@extends('components._partials.default')

@section('content')
    <div class="container-fluid py-2 ps-4">
        <div class="row">
            <div class="col-md-12 page-header text-poppins">
                <a href="{{ route('lokasi') }}" class="text-secondary link-secondary">Lokasi</a>
                <span>
                    <b>
                        &nbsp;/ Tambah
                    </b>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="container-fluid lokasi">
                <form action="{{ route('lokasi.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                        <div class="row header d-flex justify-content middle">
                            <div class="col-md-9 col-sm-9 col-7 title">
                                <h3 class="align-middle">Tambah lokasi pengumpulan minyak</h3>
                            </div>
                            <div class="col-md-3 col-sm-3 col-5 button d-flex align-items-center justify-content-end">
                                {{-- <button type="submit">ss</button> --}}
                                <x-forms.btn.button type="submit" color="primary" title="Simpan"
                                    id="sumbit-tambah-lokasi" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-11 line">
                        <div class="container-fluid body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <x-forms.formControlAdmin label="Alamat lengkap" name="deskripsi"
                                                placeholder="Detail alamat pengumpulan minyak" />
                                            <p class="text-danger" id="jalan-error"></p>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <x-forms.formControlAdmin label="Kecamatan" name="nama_kecamatan"
                                                placeholder="Pilih kecamatan" />
                                            <p class="text-danger" id="kecamatan-exist"></p>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <x-forms.formControlAdmin label="Kelurahan" name="nama_kelurahan"
                                                placeholder="Pilih kelurahan" />
                                            <p class="text-danger" id="kelurahan-exist"></p>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <x-forms.formControlAdmin label="Koordinat" name="koordinat"
                                                placeholder="Koordinat (Longitude, Latitude)" />
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div id="isKelurahanKontainer">
                                                <x-forms.label title="Tingkat Wilayah" />
                                                <x-forms.radioButton />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row d-none">
                                        <div class="col-md-12">
                                            <x-forms.formControlAdmin label="Latitude" name="latitude"
                                                placeholder="Pilih latitude" />
                                        </div>
                                    </div>
                                    <div class="row d-none">
                                        <div class="col-md-12">
                                            <x-forms.formControlAdmin label="Longitude" name="longitude"
                                                placeholder="Pilih longitude" />
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="container-maps">
                                            <div class="col-md-12 mt-4 mt-xxl-0 mt-xl-0 mt-lg-0 mt-md-0">
                                                <div class="d-flex">
                                                    <div class="left">Atur Pin Point</div>
                                                    <div class="right">
                                                        &nbsp;&nbsp;(Opsional)
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-1">
                                                <div class="maps" id="maps">
                                                </div>
                                            </div>
                                            <div class="col-xxl-12 mt-4">
                                                <x-gambar.uploadLokasi />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script type='text/javascript'
        src='https://www.bing.com/api/maps/mapcontrol?callback=GetMap&key={{ env('BING_API_KEY') }}' async defer></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
        crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/maps.js') }}"></script>
@endsection
