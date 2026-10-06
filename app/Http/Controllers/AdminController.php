<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use App\Models\Adminkelurahan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        try {
            $user = User::rightJoin('adminkelurahan', 'adminkelurahan.id_user', '=', 'users.id')
                ->leftJoin('lokasi', 'lokasi.id_lokasi', '=', 'adminkelurahan.id_lokasi')
                ->leftJoin('kecamatan', 'kecamatan.id_kecamatan', '=', 'lokasi.id_kecamatan') // Join ke tabel kecamatan
                ->select('users.id', 'users.name', 'users.username', 'users.email', 'users.role', 'adminkelurahan.*', 'lokasi.nama_kelurahan','lokasi.is_kecamatan' ,'kecamatan.nama_kecamatan') // Memilih kolom yang diinginkan
                ->orderByDesc('nama_admin')
                ->get();
            $user->each(function ($item) {
                if ($item->is_kecamatan == 1) {
                    $item->nama_kelurahan = "Kecamatan " . $item->nama_kecamatan;
                }
            });
            return view('after-login.pengelola-csr.admin.index', ['user' => $user]);
        } catch (Exception $exception) {
            return view(
                'after-login.pengelola-csr.admin.index',
                ['message' => 'Tidak ada data']
            );
        }

    }

    public function create()
    {
        try {
            $lokasi = Lokasi::with('kecamatan')->get();
            $lokasi->each(function ($item) {
                if ($item->is_kecamatan == 1) {
                    $item->nama_kelurahan = 'Kecamatan ' . $item->kecamatan->nama_kecamatan;
                } else {
                    $item->nama_kelurahan = 'Kelurahan ' . $item->nama_kelurahan;

                }
            });
            return view('after-login.pengelola-csr.admin.tambah', ['lokasi' => $lokasi]);
        } catch (Exception $exception) {
            return view(
                'after-login.pengelola-csr.admin.index',
                ['message' => 'Gagal menambah admin']
            );
        }
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'no_hp' => 'required',
            'id_lokasi' => 'required',
            'alamat_rumah' => 'required',
            'username' => 'required',
            'email' => 'required',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->with('tambah_alert', 'incomplete');
        }

        try {
            $existingUser = User::where('username', $request->username)->first();
            if ($existingUser) {
                return redirect()->back()->with('tambah_alert', 'error');
            } else {
                $nama_kelurahan = Lokasi::find($request->id_lokasi)->nama_kelurahan;
                $form_nama_kelurahan = strtolower(str_replace(' ', '', $nama_kelurahan));
                $user2 = User::create([
                    'name' => $request->name,
                    'username' => $request->username,
                    'email' => $request->email,
                    'role' => 'admin_kelurahan',
                    'password' => Hash::make('admin' . $form_nama_kelurahan),
                ]);
                Adminkelurahan::create([
                    'id_user' => $user2->id,
                    'id_lokasi' => $request->id_lokasi,
                    'nama_admin' => $request->name,
                    'alamat_rumah' => $request->alamat_rumah,
                    'no_hp' => $request->no_hp,
                ]);
                return redirect()->route('admin')->with('tambah_alert', 'success');
            }
        } catch (Exception $exception) {
            return redirect()->back()->with('message', 'Tidak berhasil ditambahkan');
        }
    }
    public function edit($id)
    {
        try {
            $lokasi = Lokasi::with('kecamatan')->get();
            $lokasi->each(function ($item) {
                if ($item->is_kecamatan == 1) {
                    $item->nama_kelurahan = 'Kecamatan ' . $item->kecamatan->nama_kecamatan;
                } else {
                    $item->nama_kelurahan = 'Kelurahan ' . $item->nama_kelurahan;

                }
            });
            $user = User::rightJoin('adminkelurahan', 'adminkelurahan.id_user', '=', 'users.id')
                ->leftJoin('lokasi', 'lokasi.id_lokasi', '=', 'adminkelurahan.id_lokasi')
                ->select('users.id', 'users.name', 'users.username', 'users.email', 'users.role', 'adminkelurahan.*', 'lokasi.nama_kelurahan')
                ->where('id', $id)
                ->get();
            return view('after-login.pengelola-csr.admin.edit', ['user' => $user, 'lokasi' => $lokasi]);
        } catch (Exception $exception) {
            return redirect()->back()->with('message', 'Data tidak ditemukan');
        }
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'id_lokasi' => 'required',
            'alamat_rumah' => 'required',
            'no_hp' => 'required',
            'email' => 'required',
            'username' => 'required',
        ]);
        try {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->save();

            $user2 = Adminkelurahan::where('id_user', $id)->get()[0];
            $user2->id_lokasi = $request->id_lokasi;
            $user2->nama_admin = $request->name;
            $user2->alamat_rumah = $request->alamat_rumah;
            $user2->no_hp = $request->no_hp;
            $user2->save();
            return redirect()->route('admin')->with('edit_alert', 'success');
        } catch (Exception $exception) {
            return redirect()->back()->with(
                ['edit_alert' => 'incomplete']
            );
        }
    }

    public function resetPassword($id, Request $request) //with check password admin csr
    {
        try {
            $inputPassword = $request->input('pwd');
            if (Hash::check($inputPassword, Auth::user()->password)) {
                $user = User::findOrFail($id);
                $id_lokasi = Adminkelurahan::where('id_user', $user->id)->id_lokasi;
                $nama_kelurahan = Lokasi::findOrFail($id_lokasi)->nama_kelurahan;
                $form_nama_kelurahan = strtolower(str_replace(' ', '', $nama_kelurahan));
                $user->password = Hash::make('admin' . $form_nama_kelurahan);
                $user->save();
                return redirect()->route('admin')->with('message', 'Password berhasil direset');
            } else {
                return redirect()->back()->with('message', 'Password saat ini salah. Password tidak berhasil direset.');
            }
        } catch (Exception $exception) {
            return redirect()->back()->with(
                ['message' => 'Password tidak berhasil direset']
            );
        }
    }

    public function cek_kelurahan($id)
    {
        $kelurahan = Lokasi::leftJoin('kecamatan', 'kecamatan.id_kecamatan', '=', 'lokasi.id_kecamatan')
            ->where('lokasi.id_kecamatan', $id)
            ->select('lokasi.*', 'kecamatan.nama_kecamatan')
            ->get();

        foreach ($kelurahan as $item) {
            if ($item->is_kecamatan == 1) {
                $item->nama_kelurahan = "Kecamatan " . $item->nama_kecamatan;
            }
        }
    }

    public function destroy($id)
    {
        try {
        $user2 = Adminkelurahan::where('id_user', $id);
        $user2->delete();
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin')->with('delete_alert', 'succcess');
        } catch (Exception $exception) {
            return redirect()->route('admin')->with(
                ['delete_alert' => 'error']
            );
        }
    }
}