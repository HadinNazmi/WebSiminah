@extends('errors.layout')
@section('errors')
    <div class="error-404">
        <div class="contain d-flex align-items-center justify-content-center flex-column">
        <img src="{{ asset('assets/img/default/error.png') }}" alt="404">
            <h1>Oh tidak!</h1>
            <h5>Halaman yang anda cari tidak ditemukan</h5>
            <a href="{{ route('dashboard') }}">Kembali ke dashboard</a>
        </div>
    </div>
@endsection
