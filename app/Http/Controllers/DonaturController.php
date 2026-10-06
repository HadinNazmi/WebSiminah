<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Lokasi;
use App\Models\Kontainer;
use App\Models\Donatur;
use App\Models\Sumbangan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class DonaturController extends Controller
{
    public function index()
    {
        try {

            if (auth()->user()->role == 'admin_kelurahan') {
                $id_lokasi = DB::table('adminkelurahan')
                    ->where('id_user', Auth::id())
                    ->value('id_lokasi');
                $donatur = Donatur::with([
                    'sumbangan'
                    => function ($query) {
                        $query->where('status', 'terverifikasi');
                    }
                ])
                    ->select('donatur.id_donatur', 'nama_donatur', 'donatur.poin', 'kelurahan', 'donatur.photo', 'id_lokasi', 'donatur.updated_at as last')
                    ->withSum([
                        'sumbangan' => function ($query) {
                            $query->where('status', 'terverifikasi');
                        }
                    ], 'berat')
                    ->withSum([
                        'sumbangan' => function ($query) {
                            $query->where('status', 'terverifikasi');
                        }
                    ], 'poin_reward')
                    ->withCount([
                        'sumbangan as total_donasi' => function ($query) {
                            $query->where('status', 'terverifikasi');
                        }
                    ], 'id_donatur')
                    ->withMax([
                        'sumbangan as newest_tanggal' => function ($query) {
                            $query->where('status', 'terverifikasi');
                        }
                    ], 'created_at')
                    ->withMax('sumbangan as online_terakhir', 'created_at')
                    ->join('sumbangan', 'donatur.id_donatur', '=', 'sumbangan.id_donatur')
                    ->join('kontainer', 'sumbangan.id_kontainer', '=', 'kontainer.id_kontainer')
                    ->where('id_lokasi', $id_lokasi)
                    ->where('status', 'terverifikasi')
                    ->groupBy('donatur.photo', 'donatur.id_donatur', 'donatur.poin', 'nama_donatur', 'kelurahan', 'id_lokasi', 'last')
                    ->orderByDesc('sumbangan_sum_berat')
                    ->get();
                $donatur->each(function ($item) {
                    if ($item->sumbangan_sum_berat == null) {
                        $item->sumbangan_sum_berat = 0;
                    }

                    if ($item->sumbangan_sum_poin_reward == null) {
                        $item->sumbangan_sum_poin_reward = 0;
                    }
                    if ($item->newest_tanggal === null) {
                        $item->newest_tanggal = '-';
                    }
                    if ($item->online_terakhir === null) {
                        $item->online_terakhir = Carbon::parse($item->last);
                    }
                    $item->online_terakhir = Carbon::now()->diffInDays($item->online_terakhir);
                });
                return view('after-login.admin-kelurahan.donatur.index', ['donatur' => $donatur]);
            } else {
                $donatur = Donatur::select('donatur.id_donatur', 'nama_donatur', 'kelurahan', 'donatur.photo', 'donatur.updated_at as last')
                    ->leftJoin('sumbangan', function ($join) {
                        $join->on('donatur.id_donatur', '=', 'sumbangan.id_donatur')
                            ->where('sumbangan.status', '=', 'terverifikasi');
                    })
                    ->withSum([
                        'sumbangan' => function ($query) {
                            $query->where('status', 'terverifikasi');
                        }
                    ], 'berat')
                    ->withSum([
                        'sumbangan' => function ($query) {
                            $query->where('status', 'terverifikasi');
                        }
                    ], 'poin_reward')
                    ->withCount([
                        'sumbangan as total_donasi' => function ($query) {
                            $query->where('status', 'terverifikasi');
                        }
                    ], 'id_donatur')
                    ->withMax([
                        'sumbangan as newest_tanggal' => function ($query) {
                            $query->where('status', 'terverifikasi');
                        }
                    ], 'created_at')
                    ->withMax('sumbangan as online_terakhir', 'created_at')
                    ->groupBy('donatur.photo', 'donatur.id_donatur', 'nama_donatur', 'kelurahan', 'last')
                    ->orderByDesc('sumbangan_sum_berat')
                    ->get();
                $donatur->each(function ($item) {
                    if ($item->sumbangan_sum_berat === null) {
                        $item->sumbangan_sum_berat = 0;
                    }
                    if ($item->sumbangan_sum_poin_reward === null) {
                        $item->sumbangan_sum_poin_reward = 0;
                    }
                    if ($item->newest_tanggal === null) {
                        $item->newest_tanggal = '-';
                    }
                    if ($item->online_terakhir === null) {
                        $item->online_terakhir = Carbon::parse($item->last);
                    }
                    $item->online_terakhir = Carbon::now()->diffInDays($item->online_terakhir);
                    // $item->delete = $item->total_donasi === 0 ? true : false;
                });

                return view('after-login.pengelola-csr.donatur.index', ['donatur' => $donatur]);
            }
        } catch (Exception $exception) {
            return redirect()->back()->with('message', 'Data tidak ditemukan');
        }
    }

    public function getById($id)
    {
        try {
            $donatur = Donatur::find($id);
            return view('after-login.admin-kelurahan.donatur.index', ['donatur' => $donatur]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', 'Data tidak ditemukan');
        }
    }

    public function create()
    {
        return view('after-login.admin-kelurahan.donatur.tambah');
    }
    public function store(Request $request)
    {

        $this->validate($request, [
            'no_hp' => 'required',
            'nama_donatur' => 'required',
            'alamat_donatur' => 'required',
            'kelurahan' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required',
        ]);
        try {
            $photo = $request->file('photo');
            $photo->storeAs('public/donatur', $photo->hashName());
            Donatur::create([
                'no_hp' => $request->no_hp,
                'nama_donatur' => $request->nama_donatur,
                'alamat_donatur' => $request->alamat_donatur,
                'kelurahan' => $request->kelurahan,
                'photo' => $request->photo->hashName(),
                'password' => $request->password,
            ]);
            return redirect()->route('donatur')->with('message', 'Donatur berhasil ditambahkan');
        } catch (Exception $exception) {
            return view(
                'after-login.pengelola-csr.donatur.index',
                ['message' => 'Tidak ada data']
            );
        }
    }
    public function edit($id)
    {
        try {
            $donatur = Donatur::find($id);
            return view('after-login.admin-kelurahan.donatur.edit', ['donatur' => $donatur]);
        } catch (Exception $exception) {
            return redirect()->route('donatur')->with('message', 'Gagal mengedit donatur');
        }
    }
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'no_hp' => 'required',
            'nama_donatur' => 'required',
            'alamat_donatur' => 'required',
            'kelurahan' => 'required',
            'password' => 'required',
        ]);
        try {
            $donatur = Donatur::findOrFail($id);
            if ($request->hasFile('photo')) {

                $image_path = public_path('storage/public/donatur' . $donatur->photo);
                if (file_exists($image_path)) {
                    Storage::delete('public/donatur/' . $donatur->photo);
                }
                $photo = $request->file('photo');
                $photo->storeAs('public/donatur', $photo->hashName());
                $donatur->photo = $request->photo->hashName();
            }
            $donatur->no_hp = $request->no_hp;
            $donatur->nama_donatur = $request->nama_donatur;
            $donatur->kelurahan = $request->kelurahan;
            $donatur->password = $request->password;
            $donatur->save();
            return redirect()->route('donatur')->with('message', 'Donatur berhasil diedit');
        } catch (Exception $exception) {
            return redirect()->back()->with('message', 'Donatur tidak berhasil diedit');
        }
    }
    public function destroy($id)
    {
        try {
            $donatur = Donatur::find($id);
            $donatur->sumbangan()->delete();
            $donatur->delete();
            return redirect()->route('donatur')->with('message', 'Donatur berhasil dihapus');
        } catch (Exception $exception) {
            return redirect()->back()->with('message', 'Donatur tidak berhasil dihapus');
        }
    }

    public function detail($id)
    {
        try {
            $donatur = Donatur::findOrFail($id);
            $riwayat = Sumbangan::with(['kontainer', 'kontainer.lokasi', 'kontainer.lokasi.kecamatan'])
                ->where('id_donatur', $id)
                ->orderByDesc('created_at')
                ->get();

            $riwayat->each(function ($item) {
                if ($item->kontainer->lokasi->is_kecamatan == 1) {
                    $item->kontainer->lokasi->nama_kelurahan = $item->kontainer->lokasi->kecamatan->nama_kecamatan;
                }
            });
            $total = Donatur::with([
                'sumbangan' => function ($query) {
                    $query->where('status', 'terverifikasi');
                }
            ])
                ->select('donatur.id_donatur')
                ->withSum([
                    'sumbangan' => function ($query) {
                        $query->where('status', 'terverifikasi');
                    }
                ], 'berat')
                ->withCount([
                    'sumbangan as total_donasi' => function ($query) {
                        $query->where('status', 'terverifikasi');
                    }
                ], 'id_donatur')
                ->groupBy('donatur.id_donatur')
                ->find($id);

            $total->each(function ($item) {
                if ($item->sumbangan_sum_berat == null) {
                    $item->sumbangan_sum_berat = 0;
                }
            });
            if (!$riwayat->isEmpty()) {
                $deleted =  Carbon::now()->diffInDays(Carbon::parse($riwayat[0]->created_at)->format('Y-m-d H:i:s'));
            } else {
                $deleted =  Carbon::now()->diffInDays($donatur->updated_at->format('Y-m-d H:i:s'));
            }

            if ($deleted >= 90 && $total[0]->sumbangan_sum_berat === null) {
                $deleted = 'true';
            } else {
                $deleted = 'false';
            }
            // dd($deleted);
            if (auth()->user()->role == 'admin_kelurahan') {
                return view('after-login.admin-kelurahan.donatur.detail', ['donatur' => $donatur, 'riwayat' => $riwayat, 'total' => $total]);
            } else {
                return view('after-login.pengelola-csr.donatur.detail', ['donatur' => $donatur, 'riwayat' => $riwayat, 'total' => $total, 'deleted' => $deleted]);

            } 
        }catch (Exception $exception) {
            return redirect()->back()->with('message', 'Tidak ada detail donatur');
        }
    }
}