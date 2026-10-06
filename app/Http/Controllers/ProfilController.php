<?php

namespace App\Http\Controllers;

use App\Models\Adminkelurahan;
use Exception;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        try {

            $user = User::rightJoin('adminkelurahan', 'adminkelurahan.id_user', '=', 'users.id')
                ->leftJoin('lokasi', 'lokasi.id_lokasi', '=', 'adminkelurahan.id_lokasi')
                ->leftJoin('kecamatan', 'kecamatan.id_kecamatan', '=', 'lokasi.id_kecamatan') // Join with kecamatan
                ->select('users.*', 'adminkelurahan.*', 'lokasi.nama_kelurahan', 'kecamatan.nama_kecamatan', 'lokasi.is_kecamatan')
                ->where('users.id', Auth::id()) // Assuming 'id' is the primary key of 'users' table
                ->first();

            $user->each(function ($item) {
                if ($item->is_kecamatan == 1) {
                    $item->nama_kelurahan = $item->nama_kecamatan;
                }
            });
            return view('after-login.admin-kelurahan.profil.index', ['user' => $user]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', 'Tidak berhasil membuka profil');

        }
    }
    public function edit()
    {
        try {
            $user = User::rightJoin('adminkelurahan', 'adminkelurahan.id_user', '=', 'users.id')
                ->leftJoin('lokasi', 'lokasi.id_lokasi', '=', 'adminkelurahan.id_lokasi')
                ->leftJoin('kecamatan', 'kecamatan.id_kecamatan', '=', 'lokasi.id_kecamatan') // Join with kecamatan
                ->select('users.*', 'adminkelurahan.*', 'lokasi.nama_kelurahan', 'kecamatan.nama_kecamatan', 'lokasi.is_kecamatan')
                ->where('id', Auth::id())
                ->get()[0];
            $user->each(function ($item) {
                if ($item->is_kecamatan == 1) {
                    $item->nama_kelurahan = $item->nama_kecamatan;
                }
            });
            return view('after-login.admin-kelurahan.profil.edit', ['user' => $user]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', 'Tidak berhasil membuka profil');

        }
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:8',
        ]);
        try {
            $user = User::findOrFail($id);
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('profil')->with('edit_alert', 'success');
        } catch (Exception $exception) {
            return redirect()->back()->with('edit_alert', 'error');
        }
    }
}