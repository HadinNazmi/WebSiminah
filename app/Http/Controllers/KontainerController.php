<?php

namespace App\Http\Controllers;

use App\Enums\KontainerStatus;
use App\Enums\KontainerStatusEnum;
use Exception;
use stdClass;
use Carbon\Carbon;
use App\Models\Lokasi;
use App\Models\Donatur;
use App\Models\Kontainer;
use App\Models\Sumbangan;
use App\Models\Permintaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\QueryException;
use App\Http\Resources\KontainerResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class KontainerController extends Controller
{
    public function index()
    {
        try {
            if (auth()->user()->role == 'admin_kelurahan') {
                $id_lokasi = DB::table('adminkelurahan')
                    ->where('id_user', Auth::id())
                    ->value('id_lokasi');
                $id_kontainer = DB::table('kontainer') // 1 to 1 id_lokasi
                    ->where('id_lokasi', $id_lokasi)
                    ->value('id_kontainer');
                $currentContainer = Permintaan::where('id_kontainer', $id_kontainer)
                    ->where('status_permintaan', 'diterima')
                    ->max('updated_at');
                if ($currentContainer === null) {
                    $currentContainer = Kontainer::where('id_kontainer', $id_kontainer)->max('updated_at');
                }
                $kontainer = Kontainer::with('lokasi')
                    ->where('kontainer.id_lokasi', $id_lokasi)
                    ->where('kontainer.keterangan', '<>', 'deleted')
                    ->withSum([
                        'sumbangan' => function ($query) use ($currentContainer) {
                            $query->where('status', 'terverifikasi')
                                ->where('updated_at', '>=', $currentContainer);
                        }
                    ], 'berat')
                    ->get();

                $existingRequest = Permintaan::where('id_kontainer', $id_kontainer)
                    ->where('status_permintaan', 'diajukan')
                    ->first();

                if ($existingRequest) {
                    $existingRequest = true;
                } else {
                    $existingRequest = false;
                }
                //UNTUK HITUNG PERSENTASE dan BUAT NOTIFIKASI
                $notifikasi = [];
                $kontainer->each(function ($item) use (&$notifikasi) {
                    if ($item->sumbangan_sum_berat == null) {
                        $item->sumbangan_sum_berat = 0;
                        $item->sumbangan_persentase = 0;
                    } else {
                        $item->sumbangan_persentase = $item->sumbangan_sum_berat / $item->kapasitas * 100;
                        if ($item->sumbangan_sum_berat >= $item->kapasitas * 2 / 4) {
                            $object = new stdClass();
                            $object->id_kontainer = $item->id_kontainer;
                            $object->id_lokasi = $item->id_lokasi;
                            // $object->status = 'hampir penuh'; 
                            $object->status = KontainerStatus::HAMPIR;
                            $notifikasi[] = $object;
                        }
                    }
                });
                $permintaan = Permintaan::with('lokasi')->where('id_lokasi', $id_lokasi)->orderByDesc('created_at')->get();
                $cekPermintaan = Permintaan::with('lokasi')
                    ->where('id_lokasi', $id_lokasi)
                    ->where('status_permintaan', 'diajukan')
                    ->get();

                if ($cekPermintaan->isEmpty()) {
                    $cekPermintaan = false;
                    //return false, show button
                } else {
                    $cekPermintaan = true;
                    //return true, permintaan sudah ada, jangan show button
                }
                return view('after-login.admin-kelurahan.kontainer.index', [
                    'kontainer' => $kontainer,
                    'notifikasi' => $notifikasi,
                    'permintaan' => $permintaan,
                    'cekKontainer' => $existingRequest,
                    'cekPermintaan' => $cekPermintaan,
                    'id_kontainer' => $id_kontainer
                ]);
            } else {
                $kontainer = Kontainer::with('lokasi', 'lokasi.kecamatan')
                    ->where('kontainer.keterangan', '<>', 'deleted')
                    ->get();

                $kontainer->each(function ($item) {
                    $currentContainer = Permintaan::where('id_kontainer', $item->id_kontainer)
                        ->where('status_permintaan', 'diterima')
                        ->max('updated_at');
                    if ($currentContainer === null) {
                        $currentContainer = $item->updated_at;
                    } else {
                        $currentContainer = max($currentContainer, $item->updated_at);
                    }

                    $totalBerat = Sumbangan::where('id_kontainer', $item->id_kontainer)
                        ->where('updated_at', '>=', $currentContainer)
                        ->where('status', 'terverifikasi')
                        ->sum('berat');
                    $item->sumbangan_sum_berat = $totalBerat;
                    if ($item->sumbangan_sum_berat == null) {
                        $item->sumbangan_sum_berat = 0;
                        $item->sumbangan_persentase = 0;
                    } else {
                        $item->sumbangan_persentase = $item->sumbangan_sum_berat / $item->kapasitas * 100;
                    }

                    $item->sumbangan_max_updated_at = Sumbangan::where('id_kontainer', $item->id_kontainer)
                        ->where('status', 'terverifikasi')
                        ->max('updated_at');
                    if ($item->sumbangan_max_updated_at == null) {
                        $item->sumbangan_max_updated_at = 'belum pernah diisi';
                    }
                });
                $permintaan = Permintaan::with('lokasi', 'lokasi.kecamatan')->orderByDesc('created_at')->get();
                $notifikasi = [];
                $permintaan->each(function ($item) use (&$notifikasi) {
                    if (in_array($item->status_permintaan, ['diajukan', 'Diajukan'])) {
                        $item->status_permintaan = 'menunggu konfirmasi';
                        if ($item->lokasi->is_kecamatan == 1) {
                            $item->lokasi->nama_kelurahan = "Kecamatan " . $item->lokasi->kecamatan->nama_kecamatan;
                        } else {
                            $item->lokasi->nama_kelurahan = "Kelurahan " . $item->lokasi->nama_kelurahan;
                        }
                        $notifikasi[] = [
                            'id_permintaan' => $item->id_permintaan,
                            'nama_kelurahan' => $item->lokasi->nama_kelurahan,
                        ];
                    }
                });

                return view('after-login.pengelola-csr.kontainer.index', ['kontainer' => $kontainer, 'permintaan' => $permintaan, 'notifikasi' => $notifikasi]);
            }
        } catch (Exception $exception) {
            return redirect('kontainer')->with('message', 'Tidak ada data Kontainer');
        }
    }

    public function isPermintaanDiajukan($id_kontainer)
    {
        $existingRequest = Permintaan::where('id_kontainer', $id_kontainer)
            ->where('status_permintaan', 'diajukan')
            ->first();

        return $existingRequest ? true : false;
    }

    public function updatePermintaan($id)
    {
        try {
            $permintaan = Permintaan::findOrFail($id);
            $permintaan->status_permintaan = 'diterima';
            $permintaan->save();
            return redirect()->route('kontainer')->with('permintaan_alert', 'success');
            ;
        } catch (Exception $exception) {
            return redirect()->back()->with('permintaan_alert', 'error');
            ;
        }
    }

    public function storePermintaan($id_kontainer)
    {
        try {
            $existingRequest = Permintaan::where('id_kontainer', $id_kontainer)
                ->where('status_permintaan', 'diajukan')
                ->first();

            if ($existingRequest) {
                return redirect()->back()->with('error', 'Permintaan sudah ada yang diajukan.');
            }
            $id_admin = DB::table('adminkelurahan')
                ->where('id_user', Auth::id())
                ->value('id_admin_kelurahan');
            $id_lokasi = DB::table('kontainer')
                ->where('id_kontainer', $id_kontainer)
                ->value('id_lokasi');
            Permintaan::create([
                'id_kontainer' => $id_kontainer,
                'id_lokasi' => $id_lokasi,
                'id_admin_kelurahan' => $id_admin,
                'tanggal_permintaan' => Carbon::now()->startOfDay(),
                'status_kontainer' => 'penuh',
                'status_permintaan' => 'diajukan',
            ]);

            return redirect()->route('kontainer')->with('permintaan_alert', 'success');
        } catch (Exception $exception) {
            return redirect()->back()->with('permintaan_alert', 'error');
        }
    }

    public function create()
    {
        try {
            $lokasi = Lokasi::get();
            return view('after-login.pengelola-csr.kontainer.tambah', ['lokasi' => $lokasi]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', 'Halaman tidak ditemukan');
        }
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'id_lokasi' => 'required',
            'kapasitas' => 'required|numeric',
            'keterangan' => 'required',
        ]);
        try {
            Kontainer::create([
                'id_lokasi' => $request->id_lokasi,
                'kapasitas' => $request->kapasitas,
                'keterangan' => $request->keterangan,
            ]);
            return redirect()->route('kontainer');
        } catch (Exception $exception) {
            return redirect()->back()->with('message', 'Kontainer tidak berhasil dibuat');
        }
    }
    public function edit($id)
    {
        try {
            $lokasi = Lokasi::get();
            $kontainer = Kontainer::find($id);
            return view('after-login.pengelola-csr.kontainer.edit', ['kontainer' => $kontainer, 'lokasi' => $lokasi]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', 'Kontainer tidak ditemukan');
        }
    }
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'id_lokasi' => 'required',
            'kapasitas' => 'required',
            'keterangan' => 'required',
        ]);
        try {
            $kontainer = Kontainer::findOrFail($id);
            $kontainer->id_lokasi = $request->id_lokasi;
            $kontainer->kapasitas = $request->kapasitas;
            $kontainer->keterangan = $request->keterangan;
            $kontainer->save();
            return redirect()->route('kontainer');
        } catch (Exception $exception) {
            return redirect()->back()->with('message', 'Kontainer tidak berhasil diupdate');
        }
    }
    public function destroy($id)
    {
        try {
            $kontainer = Kontainer::find($id);
            $kontainer->keterangan = 'deleted';
            $kontainer->save();
            return redirect()->route('kontainer');
        } catch (Exception $exception) {
            return redirect()->back()->with('message', 'Kontainer tidak berhasil dihapus');
        }
    }

}