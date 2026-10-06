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
		$donatur = Donatur::find($request->id_donatur);
		$reward = Reward::find($request->id_reward);

		if (!$donatur || !$reward) {
			return response()->json(['message' => 'Donatur tidak ada'], Response::HTTP_NOT_FOUND);
		}

		if ($donatur->poin >= $reward->jumlah_poin) {
			$currentPoin = $donatur->poin - $reward->jumlah_poin;
			$donatur->update(['poin' => $currentPoin]);
			$donatur->save();
			$redeem = Redeem::create($request->all());

			return response()->json($redeem, Response::HTTP_CREATED);
		} else {
			return response()->json(['message' => 'Poin tidak cukup'], Response::HTTP_BAD_REQUEST);
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
