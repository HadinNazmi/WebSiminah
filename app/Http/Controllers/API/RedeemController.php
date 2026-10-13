<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Redeem;
use App\Models\Donatur;
use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

class RedeemController extends Controller
{
	private function formatDateAndTime($datetime)
	{
		setlocale(LC_TIME, 'id_ID');
		return $datetime->formatLocalized('%A, %e %B %Y - %H:%M');
	}
	
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $redeems = Redeem::all();
        return response()->json($redeems);
    }
	
	public function showByIdDonatur($id_donatur)
	{
		$redeems = Redeem::where('id_donatur', $id_donatur)
			->with(['reward' => function ($q) {
				$q->select('id_reward', 'nama_reward', 'jumlah_poin');
			}])
			->get()
			->map(function ($redeem) {
				return [
					"id_redeem" => $redeem->id_redeem,
					"id_donatur" => $redeem->id_donatur,
					"id_reward" => $redeem->reward->id_reward,
					"nama_reward" => $redeem->reward->nama_reward,
					"poin_reward" => (int)$redeem->reward->jumlah_poin,
					"status" => $redeem->status,
					"created_at" => $this->formatDateAndTime($redeem->created_at),
					"updated_at" => $this->formatDateAndTime($redeem->updated_at),
				];
			});

		return response()->json($redeems);
	}

    /**
     * Store a newly created resource in storage.
     */
        public function store(Request $request)
    {
        $validated = $request->validate([
            'id_donatur' => 'required|string',
            'id_reward'  => 'required|string',
        ]);

        try {
            return \Illuminate\Support\Facades\DB::transaction(function () use ($validated) {
                $donatur = Donatur::lockForUpdate()->find($validated['id_donatur']);
                $reward = Reward::find($validated['id_reward']);

                if (!$donatur || !$reward) {
                    return response()->json(['message' => 'Donatur atau reward tidak ditemukan'], Response::HTTP_NOT_FOUND);
                }

                $biaya = (int) $reward->jumlah_poin;
                if ($donatur->poin < $biaya) {
                    return response()->json(['message' => 'Poin tidak cukup'], Response::HTTP_BAD_REQUEST);
                }

                $donatur->poin = $donatur->poin - $biaya;
                $donatur->save();

                $redeem = Redeem::create([
                    'id_redeem'      => (string) \Illuminate\Support\Str::uuid(),
                    'id_donatur'     => $donatur->id_donatur,
                    'id_reward'      => $reward->id_reward,
                    'tanggal_redeem' => now()->toDateString(),
                    'status'         => 'diproses',
                ]);

                return response()->json($redeem, Response::HTTP_CREATED);
            });
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Gagal menukar poin: ' . $e->getMessage());
            return response()->json(['message' => 'Penukaran gagal, poin tidak dikurangi.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $redeem = Redeem::findOrFail($id);
        return response()->json($redeem);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $redeem = Redeem::findOrFail($id);
        $redeem->update($request->all());
        return response()->json($redeem, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $redeem = Redeem::findOrFail($id);
        $redeem->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
