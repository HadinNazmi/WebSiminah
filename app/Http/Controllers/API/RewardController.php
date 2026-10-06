<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;

class RewardController extends Controller
{
	private function formatDate($datetime)
	{
		if (is_string($datetime)) {
			$datetime = new Carbon($datetime);
		}
		
		$datetime->locale('id');
		return $datetime->Format('d F Y');
	}
	
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
		try {
			$rewards = Reward::all();

			$formattedRewards = $rewards->map(function ($reward) {
				return [
					"id_reward" => $reward->id_reward,
					"nama_reward" => $reward->nama_reward,
					"stok" => $reward->stok,
					"jumlah_poin" => $reward->jumlah_poin,
					"masa_berlaku" => $this->formatDate($reward->masa_berlaku),
					"gambar" => $reward->gambar,
					"status" => $reward->status,
					"created_at" => $reward->created_at,
					"updated_at" => $reward->updated_at,
				];
			});

			return response()->json($formattedRewards);
		} catch (Exception $exception) {
			return response()->json(['message' => 'Terjadi kesalahan'], Response::HTTP_INTERNAL_SERVER_ERROR);
		}
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $reward = Reward::create($request->all());
        return response()->json($reward, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reward = Reward::findOrFail($id);
        return response()->json($reward);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $reward = Reward::findOrFail($id);
        $reward->update($request->all());
        return response()->json($reward, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reward = Reward::findOrFail($id);
        $reward->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
