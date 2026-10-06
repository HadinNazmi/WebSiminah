<?php

namespace App\Http\Controllers;


use App\Models\Reward;
use Exception;
use App\Models\Redeem;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RedeemController extends Controller
{
    public function index()
    {
        try {
            if (auth()->user()->role == 'admin_kelurahan') {
                $id_lokasi = DB::table('adminkelurahan')
                    ->where('id_user', Auth::id())
                    ->value('id_lokasi');
                $rewards = Reward::where('status', '!=', 'deleted')->orderBy('masa_berlaku')->get();

                $rewards = $rewards->map(function ($reward) {
                    if (now() < $reward->masa_berlaku) {
                        $reward->status_aktif = 'aktif';
                    } else {
                        $reward->status_aktif = 'tidak aktif';
                    }
                    return $reward;
                });
                $redeem = Redeem::with('reward', 'donatur')->whereHas('donatur.sumbangan.kontainer', function ($query) use ($id_lokasi) {
                    $query->where('id_lokasi', $id_lokasi);
                })
                    ->where('status', '!=', 'selesai')
                    ->orderBy('created_at', 'desc')
                    ->get();
                
                return view(
                    'after-login.admin-kelurahan.hadiah.index',
                    ['redeem' => $redeem, 'reward' => $rewards]
                );
            }
            // else {
            //     $redeem = Redeem::with('reward', 'donatur')
            //         ->joinSub(
            //             Redeem::groupBy('id_donatur')
            //                 ->select('id_donatur', DB::raw('count(*) as redeem_count')),
            //             'redeem_count',
            //             function ($join) {
            //                 $join->on('redeem.id_donatur', '=', 'redeem_count.id_donatur');
            //             }
            //         )
            //         ->orderBy('status', 'asc') 
            //         ->orderBy('created_at', 'desc')
            //         ->get();

            //     return view(
            //         'after-login.pengelola-csr.hadiah.index',
            //         ['redeem' => $redeem]
            //     );
            // }
        } catch (ModelNotFoundException | QueryException $exception) {
            return view(
                'after-login.admin-kelurahan.hadiah.index',
                ['message' => 'Tidak ada data']
            );
        }
    }
    public function detail()
    {
        if (auth()->user()->role == 'admin_kelurahan') {
            $id_lokasi = DB::table('adminkelurahan')
                ->where('id_user', Auth::id())
                ->value('id_lokasi');
                
                $redeem = Redeem::with('reward', 'donatur')->whereHas('donatur.sumbangan.kontainer', function ($query) use ($id_lokasi) {
                    $query->where('id_lokasi', $id_lokasi);
                })
                ->joinSub(
                    Redeem::whereHas('donatur.sumbangan.kontainer', function ($query) use ($id_lokasi) {
                        $query->where('id_lokasi', $id_lokasi);
                    })
                        ->groupBy('id_donatur')->select('id_donatur', DB::raw('count(*) as redeem_count'))
                    ,
                    'redeem_count',
                    function ($join) {
                        $join->on('redeem.id_donatur', '=', 'redeem_count.id_donatur');
                    }
                )
                ->orderBy('status', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();
            return view(
                'after-login.admin-kelurahan.hadiah.detail',
                ['redeem' => $redeem]
            );
        }
    }
    public function update($id)
    {
        try {
            Redeem::where('id_redeem', $id)
                ->update(['status' => 'selesai']); //selesai
            return redirect()->route('redeem')->with('verifikasi_alert', 'success');
        } catch (Exception $exception) {
            return redirect()->back()->with('verifikasi_alert', 'error');
        }
    }

}