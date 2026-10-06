<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\Kontainer;
use App\Models\Lokasi;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LokasiController extends Controller
{
    public function index()
    {
        try {
            $lokasi = Lokasi::with('kecamatan')->withCount([
                'kontainer' => function ($query) {
                    $query->where('keterangan', '!=', 'deleted');
                }
            ])
                ->where('status', '!=', 'deleted')
                ->get();
            return view('after-login.pengelola-csr.lokasi.index', ['lokasi' => $lokasi]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', 'Tidak ada data');
        }
    }

    public function create()
    {
        try {
            return view('after-login.pengelola-csr.lokasi.tambah');
        } catch (Exception $exception) {
            return redirect()->back()->with('message', 'Halaman tidak ditemukan');
        }
    }

    public function cekLokasi(Request $request)
    {
        $namaKelurahan = strtolower(str_replace(' ', '', $request->nama_kelurahan));
        $lokasi = Lokasi::whereRaw('LOWER(REPLACE(nama_kelurahan, " ", "")) = ?', [$namaKelurahan])
            ->where(function ($query) {
                $query->where('is_kecamatan', 1)
                    ->orWhere('is_kecamatan', 0);
            })
            ->where('status', '!=', 'deleted')
            ->get();
        // return response()->json($lokasi);
        $result = new \stdClass(); // Membuat objek baru untuk hasil kembalian

        if ($lokasi->count() >= 2) {
            $result->submit = false;
            $result->tingkat_wilayah = false;
            $result->is_kecamatan = false;
        } else if ($lokasi->count() == 1) {
            $is_kecamatan = $lokasi->first()->is_kecamatan;
            if ($is_kecamatan == 1) {
                $result->submit = true;
                $result->tingkat_wilayah = false;
                $result->is_kecamatan = 1;
            } else {
                $result->submit = true;
                $result->tingkat_wilayah = false;
                $result->is_kecamatan = 0;
            }
        } else {
            $result->submit = true;
            $result->tingkat_wilayah = true;
            $result->is_kecamatan = true;
        }
        return response()->json($result);
    }
    public function store(Request $request)
    {
        // try {
            $this->validate($request, [
                'nama_kelurahan' => 'required',
                'nama_kecamatan' => 'required',
                'is_kecamatan' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'deskripsi' => 'required',
            ]);

            $nama_kecamatan = strtolower(str_replace(' ', '', $request->nama_kecamatan));
            $kecamatan = Kecamatan::whereRaw('LOWER(REPLACE(nama_kecamatan, " ", "")) = ?', [$nama_kecamatan])
                ->first();
            if (!$kecamatan) {
                $create_kecamatan = Kecamatan::create([
                    'nama_kecamatan' => $request->nama_kecamatan,
                ]);
                $id_kecamatan = $create_kecamatan->id_kecamatan;
            } else {
                $id_kecamatan = $kecamatan->id_kecamatan;
            }
            $gambar = $request->file('gambar');
            $gambar->storeAs('public/lokasi', $gambar->hashName());
            $lokasi = Lokasi::create([
                'nama_kelurahan' => $request->nama_kelurahan,
                'id_kecamatan' => $id_kecamatan,
                'is_kecamatan' => $request->is_kecamatan,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'gambar' => $request->gambar->hashName(),
                'deskripsi' => $request->deskripsi,
                'status' => '-',
            ]);

            Kontainer::create([
                'id_lokasi' => $lokasi->id_lokasi,
                'kapasitas' => '30',
                'keterangan' => '-',
            ]);
            return redirect()->route('lokasi')->with('lokasi_alert', 'success');

        // } catch (Exception $exception) {
        //     return redirect()->back()->with('lokasi_alert', 'error');
        // }
    }
    public function edit($id)
    {
        try {
            $lokasi = lokasi::find($id);
            return view('after-login.pengelola-csr.lokasi.edit', ['lokasi' => $lokasi]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', 'Lokasi tidak ditemukan');
        }
    }

    public function update($id, Request $request)
    {
        // dd($id);
        $this->validate($request, [
            'id_lokasi' => 'required',
            'nama_kelurahan' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'deskripsi' => 'required',
        ]);
        try {
            $lokasi = Lokasi::findOrFail($id);
            if ($request->hasFile('gambar')) {
                $image_path = public_path('storage/lokasi' . $lokasi->gambar);
                if (file_exists($image_path)) {
                    Storage::delete('public/lokasi/' . $lokasi->gambar);
                }
                $gambar = $request->file('gambar');
                $gambar->storeAs('public/lokasi', $gambar->hashName());
                $lokasi->gambar = $request->gambar->hashName();
            }
            $lokasi->nama_kelurahan = $request->nama_kelurahan;
            $lokasi->latitude = $request->latitude;
            $lokasi->longitude = $request->longitude;
            $lokasi->deskripsi = $request->deskripsi;
            $lokasi->save();
            return redirect()->route('lokasi')->with('edit_alert', 'success');
        } catch (Exception $exception) {
            return redirect()->back()->with('edit_alert', 'error');
        }
    }
    public function destroy($id)
    {
        try {
            $lokasi = Lokasi::find($id);
            $lokasi->status = 'deleted';
            $lokasi->save();
            Kontainer::where('id_lokasi', $id)
                ->where('keterangan', '!=', 'deleted')
                ->update(['keterangan' => 'deleted']);

            return redirect()->route('lokasi')->with('delete_alert', 'success');
        } catch (Exception $exception) {
            return redirect()->back()->with('delete_alert', 'error');
        }
    }
}