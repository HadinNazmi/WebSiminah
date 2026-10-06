@php
    if (isRouteActive('login')) {
        $title = 'login';
    }elseif (isRouteActive('dashboard')) {
        $title = 'dashboard';
    }elseif (isRouteActive('sumbangan')) {
        $title = 'sumbangan';
    }elseif (isRouteActive('lokasi') || isRouteActive('lokasi.create') || isRouteActive('lokasi.edit')) {
        $title = 'lokasi';
    }elseif (isRouteActive('lokasi') || isRouteActive('lokasi.create') || isRouteActive('lokasi.edit')) {
        $title = 'lokasi';
    }elseif (isRouteActive('donatur') || isRouteActive('donatur.create') || isRouteActive('donatur.edit') || isRouteActive('donatur.getById')) {
        $title = 'donatur';
    }elseif (isRouteActive('kontainer') || isRouteActive('kontainer.create') || isRouteActive('kontainer.edit')) {
        $title = 'kontainer';
    }elseif (isRouteActive('reward')) {
        $title = 'reward';
    }elseif (isRouteActive('redeem')) {
        $title = 'redeem';
    }    elseif (isRouteActive('profil') || isRouteActive('profil.edit')) {
        $title = 'profil';
    }elseif (isRouteActive('admin') || isRouteActive('admin.edit') || isRouteActive('admin.create')) {
        $title = 'admin';
    }
    else {
        $title = '';
    }
@endphp

<title>
    SIMINAH 
    @if ($title !== '')
        |
    @endif
    {{ ucfirst($title) }}
</title>
