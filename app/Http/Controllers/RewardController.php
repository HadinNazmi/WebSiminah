<?php

namespace App\Http\Controllers;

use App\Http\Resources\RewardResource;
use App\Models\Reward;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RewardController extends Controller
{
    public function index()
    {
        try {
            $rewards = Reward::where('status', '!=', 'deleted')->orderBy('masa_berlaku')->get();

            $rewards = $rewards->map(function ($reward) {
                if (now() < $reward->masa_berlaku) {
                    $reward->status_aktif = 'aktif';
                } else {
                    $reward->status_aktif = 'tidak aktif';
                }
                return $reward;
            });
            if (auth()->user()->role == 'admin_kelurahan') {
                return view(
                    'after-login.admin-kelurahan.hadiah.index',
                    ['reward' => RewardResource::collection($rewards)]
                );
            } else {
                return view(
                    'after-login.pengelola-csr.hadiah.index',
                    ['reward' => RewardResource::collection($rewards)]
                );
            }
        } catch (QueryException | ModelNotFoundException $exception) {
            if (auth()->user()->role == 'admin_kelurahan') {
                return view(
                    'after-login.admin-kelurahan.hadiah.detail',
                    ['message' => 'Tidak ada data']
                );

            } else {
                return view(
                    'after-login.pengelola-csr.hadiah.index',
                    ['message' => 'Tidak ada data']
                );

            }
        }
    }

    public function create()
    {
        return view('after-login.pengelola-csr.hadiah.tambah');
    }

    public function store(Request $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            'nama_reward' => 'required',
            'stok' => 'required',
            'jumlah_poin' => 'required',
            'masa_berlaku' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return view(
                'after-login.pengelola-csr.hadiah.detail',
                ['message' => 'Halaman tidak ditemukan']
            );
        }
        try {
            $gambar = $request->file('gambar');
            $gambar->storeAs('public/reward', $gambar->hashName());
            Reward::create([
                //'id_reward' => $request->id_reward,
                'nama_reward' => $request->nama_reward,
                'stok' => $request->stok,
                'jumlah_poin' => $request->jumlah_poin,
                'masa_berlaku' => $request->masa_berlaku . ' 23:59:59',
                'gambar' => $request->gambar->hashName(),
                'status' => '-',
            ]);
            return redirect()->route('reward')->with('tambah_alert', 'success');
        } catch (QueryException | ModelNotFoundException $exception) {
            return view(
                'after-login.pengelola-csr.hadiah.detail'
            )->with('tambah_alert', 'error');
        }
    }
    public function edit($id)
    {
        try {
            $reward = Reward::find($id);
            return view('after-login.pengelola-csr.hadiah.edit', ['reward' => $reward]);
        } catch (QueryException | ModelNotFoundException $exception) {
            return view(
                'after-login.pengelola-csr.hadiah.detail',
                ['message' => 'Tidak bisa diedit']
            );
        }
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            //'id_reward' => 'required',
            'nama_reward' => 'required',
            'stok' => 'required',
            'masa_berlaku' => 'required',
            'jumlah_poin' => 'required',
        ]);
        if ($validator->fails()) {
            return view(
                'after-login.pengelola-csr.hadiah.detail',
                ['message' => 'Data tidak lengkap']
            );
        }
        try {
            $reward = Reward::findOrFail($id);
            if ($request->hasFile('gambar')) {
                $image_path = public_path('storage/public/reward' . $reward->gambar);
                if (file_exists($image_path)) {
                    Storage::delete('public/reward/' . $reward->gambar);
                }
                $gambar = $request->file('gambar');
                $gambar->storeAs('public/reward', $gambar->hashName());
                $reward->gambar = $request->gambar->hashName();
            }
            $reward->nama_reward = $request->nama_reward;
            $reward->stok = $request->stok;
            $reward->masa_berlaku = $request->masa_berlaku . ' 23:59:59';
            $reward->jumlah_poin = $request->jumlah_poin;
            $reward->save();
            return redirect()->route('reward')->with('edit_alert', 'success');
        } catch (QueryException | ModelNotFoundException $exception) {
            return view(
                'after-login.pengelola-csr.hadiah.detail'
            )->with('edit_alert', 'error');
        }
    }
    public function destroy($id)
    {
        try {
            $reward = Reward::find($id);
            $reward->status = 'deleted';
            $reward->save();
            return redirect()->route('reward')->with('delete_alert', 'success');
        } catch (ModelNotFoundException | QueryException $exception) {
            return view(
                'after-login.pengelola-csr.hadiah.detail',
                ['message' => 'Tidak berhasil dihapus']
            );
        }
    }
}
