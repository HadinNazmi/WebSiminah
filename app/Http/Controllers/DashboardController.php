<?php

namespace App\Http\Controllers;

use stdClass;
use Carbon\Carbon;
use App\Models\Lokasi;
use App\Models\Donatur;
use App\Models\Kontainer;
use App\Models\Sumbangan;
use App\Models\Permintaan;
use App\Models\Reward;
use App\Models\Redeem;
use Illuminate\Http\Request;
use App\Enums\KontainerStatus;
use App\Models\Adminkelurahan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{

    public function index()
    {
        $role=Auth::user()->role;

        $now = Carbon::now();
        $now->locale('id');
        
        $bulanTahun = $now->isoFormat('MMMM');
        $tanggal = $now->isoFormat('d MMMM Y');

        $currentMonth = [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()];
        $previousMonth = [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()];

        $mapData = [];
        $chartData = [];

        $map = Kontainer::with('lokasi')
            ->leftJoin('sumbangan', function ($join) use ($currentMonth) {
                $join->on('kontainer.id_kontainer', '=', 'sumbangan.id_kontainer')
                    ->whereBetween('sumbangan.created_at', $currentMonth)
                    ->where('sumbangan.status', 'terverifikasi');
            })
            ->groupBy('kontainer.id_kontainer')
            ->select(
                'kontainer.id_kontainer',
                Sumbangan::raw('COUNT(DISTINCT sumbangan.id_donatur) AS total_donatur'),
                Sumbangan::raw('COALESCE(ROUND(SUM(sumbangan.berat), 2), 0) AS total_berat')
            )
            ->get();

        foreach ($map as $item) {
            $kontainer = Kontainer::find($item->id_kontainer);
            if ($kontainer && $kontainer->lokasi) {
                $lokasi = $kontainer->lokasi;
                $mapData[] = [
                    'id_kec' => $lokasi->id_kecamatan,
                    'nama' => $lokasi->nama_kelurahan,
                    'lat' => $lokasi->latitude,
                    'lng' => $lokasi->longitude,
                    'total_donatur' => $item->total_donatur,
                    'total_berat' => $item->total_berat,
                ];
            }
        }
        // dd($mapData);

        $totalDonatur = Donatur::count();
        $totalDonaturBulanini = Donatur::whereBetween('created_at', $currentMonth)->count();
        
        
        if ($role == 'admin_kelurahan') {

            $id_lokasi = Adminkelurahan::where('id_user', Auth::id())->value('id_lokasi');

            $id_kontainer = Kontainer::where('id_lokasi', $id_lokasi)->value('id_kontainer');
            
            $namaKel = Lokasi::where('id_lokasi', $id_lokasi)->value('nama_kelurahan');

            $totalSumbangan = Sumbangan::whereBetween('updated_at', $currentMonth)
                ->where('id_kontainer', $id_kontainer)
                ->where('sumbangan.status', 'terverifikasi')
                ->sum('berat');

            $totalSumbanganBulanLalu = Sumbangan::whereBetween('updated_at', $previousMonth)
                ->where('id_kontainer', $id_kontainer)
                ->where('sumbangan.status', 'terverifikasi')
                ->sum('berat');

            $percentageChangeSumbangan = $totalSumbangan - $totalSumbanganBulanLalu;
            
            $totalDonatur = Sumbangan::where('id_kontainer', $id_kontainer)
                ->distinct('id_donatur')
                ->count();

            $donaturAktifBulanIni = Sumbangan::whereBetween('sumbangan.updated_at', $currentMonth)
                ->where('id_kontainer', $id_kontainer)
                ->where('sumbangan.status', 'terverifikasi')
                ->distinct('id_donatur')
                ->count();

            $pengajuanBelumVerif = Sumbangan::whereBetween('created_at', $currentMonth)
                ->where('id_kontainer', $id_kontainer)
                ->where('sumbangan.status', 'diproses')
                ->count();

            $currentContainer = Permintaan::where('id_kontainer', $id_kontainer)
                ->where('status_permintaan', 'diterima')
                ->max('updated_at');
            if ($currentContainer === null) {
                $currentContainer = Kontainer::where('id_kontainer', $id_kontainer)->max('updated_at');
            }
            $currentContainer1 = Carbon::parse($currentContainer);
            $currentContainer1->locale('id');
            $tanggalGantiKontainer = $currentContainer1->translatedFormat('d F Y, H:i');

            $top_donatur = Lokasi::join('kontainer', 'lokasi.id_lokasi', '=', 'kontainer.id_lokasi')
                ->join('sumbangan', 'kontainer.id_kontainer', '=', 'sumbangan.id_kontainer')
                ->join('donatur', 'sumbangan.id_donatur', '=', 'donatur.id_donatur')
                ->where('lokasi.id_lokasi', $id_lokasi)
                ->whereBetween('sumbangan.updated_at', $currentMonth)
                ->where('sumbangan.status', 'terverifikasi')
                ->groupBy('donatur.nama_donatur')
                ->select('donatur.nama_donatur', 
                         Sumbangan::raw('COALESCE(SUM(sumbangan.berat), 0) AS total_berat'))
                ->orderByDesc('total_berat')
                ->limit(5)
                ->get();
            $labels = $top_donatur->pluck('nama_donatur');
            $values = $top_donatur->pluck('total_berat');

            $donasiInKontainer = Lokasi::join('kontainer', 'lokasi.id_lokasi', '=', 'kontainer.id_lokasi')
                ->join('sumbangan', 'kontainer.id_kontainer', '=', 'sumbangan.id_kontainer')
                ->join('donatur', 'sumbangan.id_donatur', '=', 'donatur.id_donatur')
                ->where('lokasi.id_lokasi', $id_lokasi)
                ->where('sumbangan.updated_at', '>=', $currentContainer)
                ->where('sumbangan.status', 'terverifikasi')
                ->groupBy('donatur.nama_donatur')
                ->select('donatur.nama_donatur', 
                Sumbangan::raw('COALESCE(SUM(sumbangan.berat), 0) AS total_berat'))
                ->orderByDesc('total_berat')
                ->get();

            $totalSumbangan1 = Sumbangan::where('id_kontainer', $id_kontainer)
            ->where('updated_at', '>=', $currentContainer)
            ->where('status', 'terverifikasi')
            ->sum('berat');

            $labels2 = $donasiInKontainer->pluck('nama_donatur');
            $values2 = $donasiInKontainer->pluck('total_berat');
                
            (float)$totalKapasitasKontainer = Kontainer::where('id_lokasi', $id_lokasi)->value('kapasitas');

            $progress = [
                $totalSumbangan1,
                $totalKapasitasKontainer - $totalSumbangan1
            ];

            $percentageProgress = number_format(($totalSumbangan1 / $totalKapasitasKontainer) * 100, 2);

            $backgroundColor = '';
            $status = '';

            if ($percentageProgress <= 50.0) {
                $color = ['rgba(101, 174, 56, 1)', 'rgba(0, 0, 0, 0)'];
                $bgColor = 'chart-background-green';
                $iconColor = 'custom-icon';
                $status = 'Aman';
            } elseif ($percentageProgress > 50.0 && $percentageProgress <= 80.0) {
                $color = ['rgba(255, 167, 38, 1)', 'rgba(0, 0, 0, 0)'];
                $bgColor = 'chart-background-yellow';
                $status = 'Mulai Penuh';
                $iconColor = 'custom-icon2';
            } else {
                $color = ['rgba(209, 32, 49, 1)', 'rgba(0, 0, 0, 0)'];
                $bgColor = 'chart-background-red';
                $status = 'Perlu penjemputan';
                $iconColor = 'custom-icon3';
            }

            $redeemBelumVerif = Redeem::with('reward', 'donatur')->whereHas('donatur.sumbangan.kontainer', function ($query) use ($id_lokasi) {
                    $query->where('id_lokasi', $id_lokasi);
                })
                    ->where('status', '!=', 'selesai')
                ->count();

            $data = [
                'mapData' => json_encode($mapData),
                'chartData' => [
                    'labels' => $labels->toArray(),
                    'values' => $values->toArray()
                ],
                'kontainerData' => [
                    'labels' => $labels2->toArray(),
                    'values' => $values2->toArray()
                ],
                'color' => $color,
                'bgColor' => $bgColor,
                'status' => $status,
                'iconColor' => $iconColor,
                'totalDonatur' => $totalDonatur,
                'donaturAktifBulanIni' => $donaturAktifBulanIni,
                'totalSumbangan' => $totalSumbangan,
                'perbandinganSumbangan' => $percentageChangeSumbangan,
                'bulanTahun' => $bulanTahun,
                'progress' => $progress,
                'percentageProgress' => $percentageProgress,
                'lokasi' => $lokasi,
                'pengajuanBelumVerif' => $pengajuanBelumVerif,
                'namaKel' => $namaKel,
                'tanggal' => $tanggal,
                'tanggalGantiKontainer' => $tanggalGantiKontainer,
                'donasiKontainer' => $donasiInKontainer,
                'redeemBelumVerif' => $redeemBelumVerif,
            ];

            return view('after-login.admin-kelurahan.dashboard.dashboard', $data);
        }else{

            $topLokasi = Lokasi::join('kontainer', 'lokasi.id_lokasi', '=', 'kontainer.id_lokasi')
                ->join('sumbangan', 'kontainer.id_kontainer', '=', 'sumbangan.id_kontainer')
                ->whereBetween('sumbangan.updated_at', $currentMonth)
                ->where('sumbangan.status', 'terverifikasi')
                ->groupBy('lokasi.nama_kelurahan')
                ->select('lokasi.nama_kelurahan', Sumbangan::raw('COALESCE(SUM(sumbangan.berat), 0) AS total_berat'))
                ->orderByDesc('total_berat')
                ->limit(5)
                ->get();

            $totalSumbangan = Sumbangan::whereBetween('updated_at', $currentMonth)
                ->where('sumbangan.status', 'terverifikasi')
                ->sum('berat');

            $totalSumbanganBulanLalu = Sumbangan::whereBetween('updated_at', $previousMonth)
                ->where('sumbangan.status', 'terverifikasi')
                ->sum('berat');

            $percentageChangeSumbangan = $totalSumbangan - $totalSumbanganBulanLalu;
            
            $hampirPenuh = Permintaan::where('status_permintaan', 'diajukan')
                ->count();

            $labels = $topLokasi->pluck('nama_kelurahan');
            $values = $topLokasi->pluck('total_berat');
            
            $containerIds = Kontainer::pluck('id_kontainer');
            $topKontainerData = [];
            
            foreach ($containerIds as $id_kontainer) {
                $currentContainer = Permintaan::where('id_kontainer', $id_kontainer)
                    ->where('status_permintaan', 'diterima')
                    ->max('updated_at');
                if ($currentContainer === null) {
                    $currentContainer = Kontainer::where('id_kontainer', $id_kontainer)->max('updated_at');
                }

                $topKontainer = Lokasi::join('kontainer', 'lokasi.id_lokasi', '=', 'kontainer.id_lokasi')
                    ->join('sumbangan', 'kontainer.id_kontainer', '=', 'sumbangan.id_kontainer')
                    ->where('sumbangan.id_kontainer', $id_kontainer)
                    ->where('sumbangan.updated_at', '>=', $currentContainer)
                    ->where('sumbangan.status', 'terverifikasi')
                    ->groupBy('lokasi.nama_kelurahan')
                    ->select('lokasi.nama_kelurahan', Sumbangan::raw('COALESCE(SUM(sumbangan.berat), 0) AS total_berat'))
                    ->get();

                $topKontainerData[$id_kontainer] = $topKontainer;
            }
            
            $data = [];
            foreach ($topKontainerData as $id_kontainer => $items) {
                foreach ($items as $item) {
                    $data[] = [
                        'nama_kelurahan' => $item->nama_kelurahan,
                        'total_berat' => $item->total_berat,
                    ];
                }
            }

            usort($data, function ($a, $b) {
                return $b['total_berat'] - $a['total_berat'];
            });

            $top5Data = array_slice($data, 0, 5);

            $labels2 = [];
            $values2 = [];

            foreach ($top5Data as $item) {
                $labels2[] = $item['nama_kelurahan'];
                $values2[] = $item['total_berat'];
            }

            $barColors = [];
            foreach ($values2 as $item) {
                if ($item > 15 && $item < 25) {
                    $barColors[] = '#FFBD3D';
                } elseif ($item >= 25) {
                    $barColors[] = '#E31E18';
                } else {
                    $barColors[] = '#00C17C';
                }
            }

            $totalDonatur = Sumbangan::distinct('id_donatur')
                ->where('status', 'terverifikasi')
                ->count();

            $donaturAktifBulanIni = Sumbangan::whereBetween('sumbangan.updated_at', $currentMonth)
                ->where('sumbangan.status', 'terverifikasi')
                ->distinct('id_donatur')
                ->count();

            $rewardHampirHabis = Reward::where('stok', '<=', 5)->count();
            
            $totalKontainer = Kontainer::count();

            $totalKontainerKecamatan = Kontainer::join('lokasi', 'kontainer.id_lokasi', '=', 'lokasi.id_lokasi')
                ->groupBy('lokasi.id_kecamatan')
                ->select(
                    'lokasi.id_kecamatan',
                    DB::raw('COUNT(kontainer.id_kontainer) as kontainer_count'),
                    DB::raw('(SELECT nama_kecamatan FROM kecamatan WHERE kecamatan.id_kecamatan = lokasi.id_kecamatan) as nama_kecamatan')
                )
                ->get();

            $data = [
                'mapData' => json_encode($mapData),
                'chartData' => [
                    'labels' => $labels->toArray(),
                    'values' => $values->toArray()
                ],
                'chartData2' => [
                    'labels2' => $labels2,
                    'values2' => $values2,
                    'colors' => $barColors
                ],
                'totalDonatur' => $totalDonatur,
                'donaturAktifBulanIni' => $donaturAktifBulanIni,
                'perbandinganDonatur' => $totalDonaturBulanini,
                'totalSumbangan' => $totalSumbangan,
                'perbandinganSumbangan' => $percentageChangeSumbangan,
                'totalKontainer' => $totalKontainer,
                'bulanTahun' => $bulanTahun,
                'lokasi' => $lokasi,
                'hampirPenuh' => $hampirPenuh,
                'tanggal' => $tanggal,
                'reward' => $rewardHampirHabis,
                'totalKontainerKecamatan' => $totalKontainerKecamatan
            ];

            return view('after-login.pengelola-csr.dashboard.dashboard', $data);
        }

    }    
}