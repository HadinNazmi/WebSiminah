<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
	public function index()
	{
		try {
			$lokasi = Lokasi::with(['kecamatan:id_kecamatan,nama_kecamatan'])
				->withCount([
					'kontainer' => function ($query) {
						$query->where('keterangan', '!=', 'deleted');
					}
				])
				->where('status', '!=', 'deleted')
				->get();

			// Modify the data directly
			$lokasi->transform(function ($item) {
				$item->nama_kecamatan = $item->kecamatan->nama_kecamatan;
				unset($item->kecamatan);
				return $item;
			});

			return response()->json($lokasi);
		} catch (Exception $exception) {
			return response()->json(['message' => 'Tidak ada data'], 404);
		}
	}

    public function dataLokasi()
	{
		try {
			$lokasi = Lokasi::with(['kecamatan:id_kecamatan,nama_kecamatan'])
				->withCount([
					'kontainer' => function ($query) {
						$query->where('keterangan', '!=', 'deleted');
					}
				])
				->where('status', '!=', 'deleted')
				->get();

			// Modify the data directly
			$lokasi->transform(function ($item) {
				$item->nama_kecamatan = $item->kecamatan->nama_kecamatan;
				unset($item->kecamatan);
				unset($item->longitude);
				unset($item->latitude);
				return $item;
			});

			return response()->json($lokasi);
		} catch (Exception $exception) {
			return response()->json(['message' => 'Tidak ada data'], 404);
		}
	}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $lokasis = Lokasi::create($request->all());
        return response()->json($lokasis, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lokasis = Lokasi::findOrFail($id);
        return response()->json($lokasis, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lokasis = Lokasi::findOrFail($id);
        $lokasis->update($request->all());
        return response()->json($lokasis, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lokasis = Lokasi::findOrFail($id);
        $lokasis->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
