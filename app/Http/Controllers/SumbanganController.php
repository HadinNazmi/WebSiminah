<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Exception;
use Carbon\Carbon;
use App\Models\Lokasi;
use Nette\IOException;
use App\Models\Donatur;
use Barryvdh\DomPDF\PDF;
use App\Models\Kontainer;
use App\Models\Sumbangan;
use Illuminate\Http\Request;
use App\Models\Adminkelurahan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SumbanganController extends Controller
{

    public function index(request $Request)
    {
        try {
            if (auth()->user()->role == 'admin_kelurahan') {
                //Sumbangan Belum Terverifikasi
                $id_lokasi = DB::table('adminkelurahan')
                    ->where('id_user', Auth::id())
                    ->value('id_lokasi');
                $now = Carbon::now();
                $lastWeekStart = $now->subDays(6 + $now->dayOfWeek)->startOfDay()->format('Y-m-d');
                $lastWeekEnd = $now->copy()->addDays(7)->endOfDay()->format('Y-m-d');

                $SumbanganHarian = Sumbangan::where('status', 'terverifikasi')
                    ->whereHas('kontainer.lokasi', function ($query) use ($id_lokasi) {
                        $query->where('id_lokasi', $id_lokasi);
                    })
                    ->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
                    ->selectRaw('DAYOFWEEK(created_at) as day_of_week, sum(berat) as total_berat')
                    ->groupBy('day_of_week')
                    ->orderBy('day_of_week')
                    ->get();
                $daysOfWeek = range(1, 7);
                // Initialize an empty result array
                $result = [];
                // Loop through each day of the week
                foreach ($daysOfWeek as $dayOfWeek) {
                    // Check if the queried data has a matching day of the week
                    $matchingData = $SumbanganHarian->where('day_of_week', $dayOfWeek)->first();

                    // If matching data is found, add it to the result
                    if ($matchingData) {
                        $result[] = [
                            'dayofweek' => $matchingData->day_of_week,
                            'berat' => $matchingData->total_berat,
                        ];
                    } else {
                        // If no matching data is found, add an entry with berat = 0
                        $result[] = [
                            'dayofweek' => $dayOfWeek,
                            'berat' => 0,
                        ];
                    }
                }
                $riwayat = Sumbangan::with('donatur', 'kontainer')
                    ->whereHas('kontainer.lokasi', function ($query) use ($id_lokasi) {
                        $query->where('id_lokasi', $id_lokasi);
                    })
                    ->whereIn('status', ['terverifikasi', 'Terverifikasi', 'Ditolak', 'ditolak'])
                    ->orderByDesc('created_at')
                    ->take(10)
                    ->get();
                $verifikasiStatus = Sumbangan::with('donatur')
                    ->whereNotIn('status', ['terverifikasi', 'Terverifikasi', 'Ditolak', 'ditolak']) //belum terverifikasi
                    ->whereHas('kontainer.lokasi', function ($query) use ($id_lokasi) {
                        $query->where('id_lokasi', $id_lokasi);
                    })
                    ->orderBy('created_at')
                    ->get();
                //Persentase Terverifikasi
                $TotalTerverifikasi = Sumbangan::whereIn('status', ['terverifikasi', 'Terverifikasi', 'Ditolak', 'ditolak'])
                    ->whereHas('kontainer.lokasi', function ($query) use ($id_lokasi) {
                        $query->where('id_lokasi', $id_lokasi);
                    })->count();
                $TotalSumbangan = Sumbangan::whereHas('kontainer.lokasi', function ($query) use ($id_lokasi) {
                    $query->where('id_lokasi', $id_lokasi);
                })->count();
                if ($TotalSumbangan == 0) {
                    $persentase = 0;
                } else {
                    $persentase = $TotalTerverifikasi / $TotalSumbangan * 100;
                }
                $verifikasiStatus->each(function ($item) {
                    if (in_array($item->verifikasiStatus, [''])) {
                        $item->status = 'belum verifikasi';
                    }
                });
                return view('after-login.admin-kelurahan.sumbangan.index', ['verifikasiStatus' => $verifikasiStatus, 'persentase' => $persentase, 'riwayat' => $riwayat, 'sumbanganHarian' => $result]);
            } else {
                $laporan = Kontainer::join('lokasi', 'kontainer.id_lokasi', '=', 'lokasi.id_lokasi')
                    ->leftJoin('sumbangan', function ($join) {
                        $join->on('kontainer.id_kontainer', '=', 'sumbangan.id_kontainer')
                            ->where('sumbangan.status', '=', 'terverifikasi');
                    })
                    ->join('kecamatan', 'lokasi.id_kecamatan', '=', 'kecamatan.id_kecamatan') // Join with kecamatan
                    ->select('kontainer.id_kontainer', 'lokasi.nama_kelurahan', 'lokasi.is_kecamatan', 'kecamatan.nama_kecamatan') // Select the kecamatan's name
                    ->selectRaw('SUM(COALESCE(sumbangan.berat, 0)) as total_berat')
                    ->selectRaw('COALESCE(COUNT(DISTINCT sumbangan.id_donatur), 0) as total_donatur')
                    ->selectRaw('MAX(COALESCE(sumbangan.updated_at, "-")) as tanggal_laporan')
                    ->selectRaw('YEAR(COALESCE(sumbangan.created_at, NOW())) as tahun, MONTH(COALESCE(sumbangan.created_at, NOW())) as bulan')
                    ->groupBy('kontainer.id_kontainer', 'lokasi.nama_kelurahan', 'lokasi.is_kecamatan', 'kecamatan.nama_kecamatan', 'tahun', 'bulan')
                    ->orderByDesc('total_berat')
                    ->orderBy('tahun')
                    ->orderBy('bulan')
                    ->get();
                return view('after-login.pengelola-csr.sumbangan.index', ['laporan' => $laporan]);
            }
        } catch (Exception $exception) {
            if (auth()->user()->role == 'admin_kelurahan') {
                return view('after-login.admin-kelurahan.sumbangan.index')->with('message', 'Tidak ada data');
            } else {
                return view('after-login.pengelola-csr.sumbangan.index')->with('message', 'Tidak ada data');
            }
        }
    }
    public function filterData(Request $request)
    {
        try {
            // $monthA = '07';
            // $monthB = '09';
            // $yearA = '2023';
            // $yearB = '2023';
            $monthA = $request->input('month_a'); //dari bulan A
            $monthB = $request->input('month_b'); // dari tahun A
            $yearA = $request->input('year_a'); //sampai bulan B
            $yearB = $request->input('year_b'); //sampai tahun B

            $filteredLaporan = Kontainer::join('lokasi', 'kontainer.id_lokasi', '=', 'lokasi.id_lokasi')
                ->leftJoin('sumbangan', function ($join) {
                    $join->on('kontainer.id_kontainer', '=', 'sumbangan.id_kontainer')
                        ->where('sumbangan.status', '=', 'terverifikasi');
                })
                ->join('kecamatan', 'lokasi.id_kecamatan', '=', 'kecamatan.id_kecamatan')
                ->select('kontainer.id_kontainer', 'lokasi.nama_kelurahan', 'lokasi.is_kecamatan', 'kecamatan.nama_kecamatan')
                ->selectRaw('SUM(COALESCE(sumbangan.berat, 0)) as total_berat')
                ->selectRaw('COALESCE(COUNT(DISTINCT sumbangan.id_donatur), 0) as total_donatur')
                ->selectRaw('MAX(COALESCE(sumbangan.updated_at, "-")) as tanggal_laporan')
                ->selectRaw('YEAR(COALESCE(sumbangan.created_at, NOW())) as tahun, MONTH(COALESCE(sumbangan.created_at, NOW())) as bulan')
                ->whereBetween('sumbangan.created_at', ["$yearA-$monthA-01", "$yearB-$monthB-31"])
                ->groupBy('kontainer.id_kontainer', 'lokasi.nama_kelurahan', 'lokasi.is_kecamatan', 'kecamatan.nama_kecamatan', 'tahun', 'bulan')
                ->orderByDesc('total_berat')
                ->orderBy('tahun')
                ->orderBy('bulan')
                ->get();
            return response()->json(['filteredData' => $filteredLaporan]);
        } catch (Exception $exception) {
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }
    public function edit($id, $created_at)
    {
        try {
            $sumbangan = Sumbangan::where('created_at', $created_at)
                ->where('id_donatur', $id)
                ->first();
            return view('after-login.admin-kelurahan.sumbangan.edit', ['sumbangan' => $sumbangan])->with('verifikasi_alert', 'success');
        } catch (ModelNotFoundException | QueryException $exception) {
            return redirect()->back()->with('verifikasi_alert', 'error');
        }
    }
    public function update($id, $created_at, Request $request)
    {
        $this->validate($request, [
            'status' => 'required',
        ]);
        // try {
        if ($request->status === 'ditolak') {
            $this->validate($request, [
                'keterangan' => 'required|string',
            ]);
            Sumbangan::where('created_at', $created_at)
                ->where('id_donatur', $id)
                ->update(['status' => $request->status, 'keterangan' => $request->keterangan]);
            return redirect()->route('sumbangan')->with('verifikasi_alert', 'tolak');
        } else {
            Sumbangan::where('created_at', $created_at)
                ->where('id_donatur', $id)
                ->update(['status' => $request->status]);
            $sumPoin = Sumbangan::where('created_at', $created_at)
                ->where('id_donatur', $id)
                ->value('poin_reward');
            if ($sumPoin !== null) {
                // Update the poin attribute of the Donatur
                Donatur::where('id_donatur', $id)
                    ->increment('poin', $sumPoin);
            }
            Notifikasi::create([
                'id_donatur' => $id,
                'jenis' => 'sumbangan_verifikasi',
                'keterangan' => 'sumbangan berhasil diverifikasi',
                'is_read' => 0,
            ]);
            Notifikasi::create([
                'id_donatur' => $id,
                'jenis' => 'reward_poin',
                'keterangan' => 'Anda berhasil mendapat ' . $sumPoin . ' poin',
                'is_read' => 0,
            ]);
            return redirect()->route('sumbangan')->with('verifikasi_alert', 'success');
        }
        // } catch (Exception $exception) {
        //     return redirect()->back()->with('verifikasi_alert', 'error');
        // }
    }

    public function detail()
    {
        try {
            $id_lokasi = DB::table('adminkelurahan')
                ->where('id_user', Auth::id())
                ->value('id_lokasi');
            $riwayat = Sumbangan::with('donatur', 'kontainer')
                ->whereHas('kontainer.lokasi', function ($query) use ($id_lokasi) {
                    $query->where('id_lokasi', $id_lokasi);
                })
                ->whereIn('status', ['terverifikasi', 'Terverifikasi', 'Ditolak', 'ditolak'])
                ->orderByDesc('created_at')
                ->get();
            return view('after-login.admin-kelurahan.sumbangan.detail', ['riwayat' => $riwayat]);
        } catch (Exception $exception) {
            return view('after-login.admin-kelurahan.sumbangan.index')->with('message', 'Tidak ada data');

        }
    }
}