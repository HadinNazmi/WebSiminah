@extends('components._partials.default')

@section('content')
{{-- {{ $user }} --}}
    <div class="container-fluid py-2 ps-4">
        <div class="row">
            <div class="col-md-12 page-header text-poppins">
                <a href="{{ route('admin') }}" class="text-secondary link-secondary">Admin Kelurahan</a>
                <span>
                    <b>
                        &nbsp;/ Edit
                    </b>
                </span>
            </div>
        </div>
        {{-- {{ dd($user[0]->id) }} --}}
        <div class="row">
            <div class="container-fluid manajemen-admin">
                <form method="POST" action="{{ route('admin.update', ['id' => $user[0]->id_user]) }}">
                    @csrf
                    @method('PUT')
                    <div class="col-md-12">
                        <div class="row header d-flex justify-content middle">
                            <div class="col-md-9 col-sm-9 col-9 title">
                                <h3 class="align-middle">Edit admin kelurahan</h3>
                            </div>
                            <div class="col-md-3 col-sm-3 col-3 button d-flex justify-content-end">
                                <x-forms.btn.button type="submit" color="danger" title="Simpan"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 line">
                        <div class="container-fluid body">
                            <div class="row">
                                <div class="col-md-4 col-xxl-4 col-xl-5 col-lg-5 col-md-5 ms-xxl-1">
                                    <x-forms.formControlAdmin label="Nama" name="name" placeholder="Nama lengkap"  value="{{ $user[0]->name }}"/>
                                </div>
                                <div class="col-md-4 col-xxl-4 col-xl-5 col-lg-5 col-md-5 ms-xxl-4 ms-xl-4 mt-3 mt-xxl-0 mt-xl-0 mt-lg-0 mt-md-0">
                                    <x-forms.formControlAdmin label="Email" name="email" placeholder="Email"  value="{{ $user[0]->email }}"/>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-4 col-xxl-4 col-xl-5 col-lg-5 col-md-5 ms-xxl-1">
                                    <x-forms.formControlAdmin label="Username" name="username"
                                        placeholder="Username"  value="{{ $user[0]->username }}"/>
                                </div>
                                <div class="col-md-4 col-xxl-4 col-xl-5 col-lg-5 col-md-5 ms-xxl-4 ms-xl-4 mt-3 mt-xxl-0 mt-xl-0 mt-lg-0 mt-md-0">
                                    <x-forms.formControlAdmin label="No Telepon" name="no_hp"
                                        placeholder="Nomor telepon"  value="{{ $user[0]->no_hp }}"/>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-4 col-xxl-4 col-xl-5 col-lg-5 col-md-5 ms-xxl-1">
                                    <x-forms.formControlAdmin label="Alamat" name="alamat_rumah"
                                        placeholder="Alamat tempat tinggal Admin Kelurahan"  value="{{ $user[0]->alamat_rumah }}"/>
                                </div>
                                <div class="col-md-4 col-xxl-4 col-xl-5 col-lg-5 col-md-5 ms-xxl-4 ms-xl-4 mt-3 mt-xxl-0 mt-xl-0 mt-lg-0 mt-md-0">
                                    <x-forms.selectOption name="id_lokasi" label="Kelurahan">
                                        @slot('slotOptions')
                                            @if (!empty($lokasi))
                                                @foreach ($lokasi as $item)
                                                    <option 
                                                    @if ($item->id_lokasi === $user[0]->id_lokasi)
                                                        {{ 'selected' }}
                                                    @endif value="{{ $item->id_lokasi }}">{{ $item->nama_kelurahan }}</option>
                                                @endforeach
                                            @endif
                                        @endslot
                                    </x-forms.selectOption>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop
