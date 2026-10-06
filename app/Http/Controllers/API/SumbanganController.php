<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Sumbangan;
use App\Models\Kontainer;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SumbanganController extends Controller
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
		try {
			$sumbangans = Sumbangan::with('kontainer.lokasi.kecamatan')->get();

			// Format the datetime fields using the helper method
			$formattedSumbangans = $sumbangans->map(function ($sumbangan) {
				$lokasi = $sumbangan->kontainer->lokasi;
				$deskripsi_lokasi = $lokasi->deskripsi;

				return [
					'id_donatur' => $sumbangan->id_donatur,
					'id_kontainer' => $sumbangan->id_kontainer,
					'nama_kelurahan' => $lokasi->nama_kelurahan,
					'nama_kecamatan' => $lokasi->kecamatan->nama_kecamatan,
					'deskripsi' => $deskripsi_lokasi,
					'berat' => $sumbangan->berat,
					'photo' => $sumbangan->photo,
					'status' => $sumbangan->status,
					'keterangan' => $sumbangan->keterangan,
					'poin_reward' => $sumbangan->poin_reward,
					'created_at' => $this->formatDateAndTime($sumbangan->created_at),
					'updated_at' => $this->formatDateAndTime($sumbangan->updated_at),
				];
			});

			return response()->json($formattedSumbangans);
		} catch (Exception $exception) {
			return response()->json(['message' => 'Terjadi kesalahan'], Response::HTTP_INTERNAL_SERVER_ERROR);
		}
	}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
	{
		$id_lokasi = $request->input('id_lokasi');

		$id_kontainer = Kontainer::where('id_lokasi', $id_lokasi)->value('id_kontainer');

		$lokasi = Lokasi::find($id_lokasi);

		if (!$lokasi) {
			return response()->json(['error' => 'Lokasi not found.'], Response::HTTP_NOT_FOUND);
		}
		
		$image = $this->saveImage($request->input('image'), 'sumbangan', $request->input('id_donatur'));
		
		$nama_kelurahan = $lokasi->nama_kelurahan;
		$nama_kecamatan = $lokasi->kecamatan->nama_kecamatan;
		(int)$poin = round($request->input('berat'));

		$data = [
			'id_donatur' => $request->input('id_donatur'),
			'id_kontainer' => $id_kontainer,
			'berat' => $request->input('berat'),
			'photo' => $image,
			'keterangan' => '-',
			'poin_reward' => $poin,
		];

		try {
			$sumbangan = Sumbangan::create($data);
			return $this->showLatest($request->input('id_donatur'), $data);
		} catch (\Exception $e) {
			return response()->json(['error' => 'Failed to insert data.'], Response::HTTP_INTERNAL_SERVER_ERROR);
		}
	}

    /**
     * Display the specified resource.
     */
	public function show(string $id)
    {
        $sumbangan = Sumbangan::findOrFail($id);
        return response()->json($sumbangan, Response::HTTP_CREATED);
    }
	
	/**
     * Display the specified resource by id_donatur.
     */
    public function showByIdDonatur(string $id_donatur)
	{
		try {
			$sumbangans = Sumbangan::where('id_donatur', $id_donatur)
				->with('kontainer.lokasi.kecamatan')
				->orderBy('created_at', 'desc')->get();

			// Format the datetime fields using the helper method
			$formattedSumbangans = $sumbangans->map(function ($sumbangan) {
				$lokasi = $sumbangan->kontainer->lokasi;
				$deskripsi_lokasi = $lokasi->deskripsi;

				return [
					'id_donatur' => $sumbangan->id_donatur,
					'id_kontainer' => $sumbangan->id_kontainer,
					'nama_kelurahan' => $lokasi->nama_kelurahan,
					'nama_kecamatan' => $lokasi->kecamatan->nama_kecamatan,
					'deskripsi' => $deskripsi_lokasi,
					'berat' => $sumbangan->berat,
					'photo' => $sumbangan->photo,
					'status' => $sumbangan->status,
					'keterangan' => $sumbangan->keterangan,
					'poin_reward' => $sumbangan->poin_reward,
					'created_at' => $this->formatDateAndTime($sumbangan->created_at),
					'updated_at' => $this->formatDateAndTime($sumbangan->updated_at),
				];
			});

			return response()->json($formattedSumbangans);
		} catch (Exception $exception) {
			return response()->json(['message' => 'Terjadi kesalahan'], Response::HTTP_INTERNAL_SERVER_ERROR);
		}
	}
	
	/**
     * Display the specified resource by id_donatur limit by 4 data.
     */
    public function show4ByIdDonatur(string $id_donatur)
	{
		try {
			$sumbangans = Sumbangan::where('id_donatur', $id_donatur)
				->with('kontainer.lokasi.kecamatan')
				->orderBy('created_at', 'desc')->take(4)->get();

			// Format the datetime fields using the helper method
			$formattedSumbangans = $sumbangans->map(function ($sumbangan) {
				$lokasi = $sumbangan->kontainer->lokasi;
				$deskripsi_lokasi = $lokasi->deskripsi;

				return [
					'id_donatur' => $sumbangan->id_donatur,
					'id_kontainer' => $sumbangan->id_kontainer,
					'nama_kelurahan' => $lokasi->nama_kelurahan,
					'nama_kecamatan' => $lokasi->kecamatan->nama_kecamatan,
					'deskripsi' => $deskripsi_lokasi,
					'berat' => $sumbangan->berat,
					'photo' => $sumbangan->photo,
					'status' => $sumbangan->status,
					'keterangan' => $sumbangan->keterangan,
					'poin_reward' => $sumbangan->poin_reward,
					'created_at' => $this->formatDateAndTime($sumbangan->created_at),
					'updated_at' => $this->formatDateAndTime($sumbangan->updated_at),
				];
			});

			return response()->json($formattedSumbangans);
		} catch (Exception $exception) {
			return response()->json(['message' => 'Terjadi kesalahan'], Response::HTTP_INTERNAL_SERVER_ERROR);
		}
	}
	
	/**
     * Display the newest specified resource by id_donatur.
     */
	public function showLatest(string $id_donatur)
	{
		try {
			$latestSumbangan = Sumbangan::where('id_donatur', $id_donatur)
				->with('kontainer.lokasi.kecamatan')
				->orderBy('created_at', 'desc')
				->first();

			if (!$latestSumbangan) {
				return response()->json(['message' => 'Sumbangan tidak ditemukan'], 404);
			}

			$lokasi = $latestSumbangan->kontainer->lokasi;
			$deskripsi_lokasi = $lokasi->deskripsi;

			$id_kecamatan = $latestSumbangan->kontainer->lokasi->kecamatan->id_kecamatan;
			$nama_kelurahan = $latestSumbangan->kontainer->lokasi->nama_kelurahan;
			$nama_kecamatan = $latestSumbangan->kontainer->lokasi->kecamatan->nama_kecamatan;
			
			if($latestSumbangan->status == '0'){
				$status = 'Diproses';
			} else {
				$status = $latestSumbangan->status;
			}
			
			// Format the created_at and updated_at fields using the helper method
			$created_at = $this->formatDateAndTime($latestSumbangan->created_at);
			$updated_at = $this->formatDateAndTime($latestSumbangan->updated_at);

			$response = [
				'id_donatur' => $latestSumbangan->id_donatur,
				'id_kontainer' => $latestSumbangan->id_kontainer,
				'nama_kelurahan' => $nama_kelurahan,
				'nama_kecamatan' => $nama_kecamatan,
				'deskripsi' => $deskripsi_lokasi,
				'berat' => $latestSumbangan->berat,
				'photo' => $latestSumbangan->photo,
				'status' => $status,
				'keterangan' => $latestSumbangan->keterangan,
				'poin_reward' => $latestSumbangan->poin_reward,
				'created_at' => $created_at,
				'updated_at' => $updated_at,
			];

			return response()->json($response, Response::HTTP_OK);
		} catch (Exception $exception) {
			return response()->json(['message' => 'Terjadi kesalahan'], Response::HTTP_INTERNAL_SERVER_ERROR);
		}
	}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sumbangan = Sumbangan::findOrFail($id);
        $sumbangan->update($request->all());
        return response()->json($sumbangan, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sumbangan = Sumbangan::findOrFail($id);
        $sumbangan->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}