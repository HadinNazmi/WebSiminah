@extends('components._partials.default')

@section('content')
    <section class="profil">
        <div class="row">
            <div class="col-md-6">
                <div class="header">
                    <h1>Halaman profil</h1>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-xxl-7 col-xl-7 col-lg-8 col-md-10 col-sm-12 col-12">
                <div class="body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profil-header">
                                <x-user.userImage width="132" height="132" />
                                <h4>Hallo, {{ $user->username }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profil-detail">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="header">
                                            <h5>Info Dasar</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="subheader">
                                            <span>Beberapa info yang meliputi identitas diri dan kontak</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="detail-data">
                                            <div class="row">
                                                <div class="col-md-5 col-sm-5 col-5">
                                                    <div class="left bottom-row">
                                                        Nama Lengkap
                                                    </div>
                                                </div>
                                                <div class="col-md-7 col-sm-7 col-7">
                                                    <div class="right bottom-row">
                                                        {{ $user->nama_admin }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5 col-sm-5 col-3">
                                                    <div class="left">
                                                        Email
                                                    </div>
                                                </div>
                                                <div class="col-md-7 col-sm-7 col-9">
                                                    <div class="right">
                                                        {{ $user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5 col-sm-5 col-5">
                                                    <div class="left">
                                                        No telepon
                                                    </div>
                                                </div>
                                                <div class="col-md-7 col-sm-7 col-7">
                                                    <div class="right">
                                                        {{ $user->no_hp }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5 col-sm-5 col-5">
                                                    <div class="left">
                                                        Tempat kerja <br> (keurahan)
                                                    </div>
                                                </div>
                                                <div class="col-md-7 col-sm-7 col-7">
                                                    <div class="right">
                                                        @if ($user->is_kecamatan == 0)
                                                            {{ $user->nama_kelurahan }}
                                                        @else
                                                            Kecamatan {{ $user->nama_kelurahan }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5 col-sm-5 col-5">
                                                    <div class="left">
                                                        Alamat
                                                    </div>
                                                </div>
                                                <div class="col-md-7 col-sm-7 col-7">
                                                    <div class="right">
                                                        {{ $user->alamat_rumah }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="update-buttom">
                                <a href="{{ route('profil.edit') }}" class="btn-profil-custom btn-primary">Ubah profil</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@stop
