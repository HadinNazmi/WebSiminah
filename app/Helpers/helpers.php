<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

function isRouteActive($routeName)
{
    return request()->route()->getName() === $routeName;
}

function isAdminKelurahan()
{
    return auth()->check() && auth()->user()->role == 'admin_kelurahan';
}

function isAdminCsr()
{
    return auth()->check() && auth()->user()->role == 'admin_csr';
}

function datetimeFormat($timestamp)
{
    if ($timestamp !== '-' && $timestamp !== "belum pernah diisi") {
        $data = date('h:i', strtotime($timestamp)) . ', ' . date('d M Y', strtotime($timestamp));
    } else {
        $data = '-';
    }
    return $data;
}

function dateFormat($timestamp)
{
    if ($timestamp !== '-') {
        $data = date('d F Y', strtotime($timestamp));
    } else {
        $data = '-';
    }
    return $data;
}

function getFirstName($name)
{
    $data = explode(' ', $name);
    return substr($data[0], 0, 7);
}

function checkFileIsExist($path)
{
    if (file_exists(public_path('storage/lokasi/' . $path))) {
        return true;
    } else {
        return false;
    }
}

function limitAlamatLength($data)
{
    $words = explode(" ", $data);
    if (count($words) > 30) {
        return implode(" ", array_slice($words, 0, 30)) . "...";
    } else {
        return implode(" ", array_slice($words, 0, 2));
    }
}

function limitNamaLokasi($data)
{
    $rs = mb_substr($data, 0, 15);
    return $rs;
}
function limitNamaHadiah($data)
{
    return mb_substr($data, 0, 15);
}

function isKecamatan($isKecamatan, $kecamatan, $kelurahan)
{
    if ($isKecamatan === 1) {
        return "Kecamatan " . $kecamatan;
    } else {
        return "Kelurahan " . $kelurahan;
    }
}

function limitNameOfRegion($text)
{
    $limited_text = substr($text, 0, 30);
    return $limited_text;
}

function numberToMonth($number)
{
    $monthList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    return $monthList[$number - 1];
}

function checkNumberIsZero($number)
{
    $all_zeros = true;
    foreach ($number as $digit) {
        if ($digit['berat'] != 0) {
            $all_zeros = false;
            break;
        }
    }

    if ($all_zeros) {
        return true;
    } else {
        return false;
    }

}