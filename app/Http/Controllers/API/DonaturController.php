<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Donatur;
use App\Models\Sumbangan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Sanctum;

class DonaturController extends Controller
{
	
	public function cekToken(Request $request)
	{
		$donatur = $request->user();
		if (!$donatur) {
			return response()->json(['error' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
        } else {
            $totalSumbangan = Sumbangan::where('id_donatur', $donatur->id_donatur)
				->where('status', 'terverifikasi')
				->sum('berat');
		
			$data = [
				'donatur' => $donatur,
				'sumbangan' => $totalSumbangan
			];
		
            return response()->json($data, Response::HTTP_OK);
        }
	}

    public function login(Request $request)
    {
        $credentials = $request->only('no_hp', 'password');
        $donatur = Donatur::where('no_hp', $credentials['no_hp'])->first();

        if ($donatur && Hash::check($credentials['password'], $donatur->password)) {
            $token = $donatur->createToken('API Token');
			
            $response = [
                'access_token' => $token->plainTextToken,
                'access_token_expires_in' => now()->addMinutes(config('sanctum.expiration'))->toDateTimeString(),
                'refresh_token' => $token->plainTextToken,
                'fresh_token_expires_in' => now()->addMinutes(config('sanctum.expiration'))->toDateTimeString(),
            ];

            return response()->json($response, Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function login2(Request $request)
    {
        $credentials = $request->only('no_hp', 'password');
        $donatur = Donatur::where('no_hp', $credentials['no_hp'])->first();
		$totalSumbangan = Sumbangan::where('id_donatur', $donatur->id_donatur)
				->where('status', 'terverifikasi')
				->sum('berat');

        if ($donatur && Hash::check($credentials['password'], $donatur->password)) {
            $token = $donatur->createToken('authToken')->plainTextToken;
			
			$data = [
				'donatur' => $donatur,
				'token' => $token,
				'sumbangan' => $totalSumbangan
			];
            return response()->json($data, Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }
        
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $donaturs = Donatur::all();
        return response()->json($donaturs);
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_donatur'   => 'required|string|max:50',
            'no_hp'          => 'required|string|max:50|unique:donatur,no_hp',
            'alamat_donatur' => 'required|string|max:50',
            'kelurahan'      => 'required|string|max:50',
            'password'       => 'required|string|min:6|max:100',
        ]);

        $donatur = Donatur::create([
            'nama_donatur'   => $validated['nama_donatur'],
            'no_hp'          => $validated['no_hp'],
            'alamat_donatur' => $validated['alamat_donatur'],
            'kelurahan'      => $validated['kelurahan'],
            'password'       => Hash::make($validated['password']),
            'photo'          => 'dummy.jpg',
            'poin'           => 0,
        ]);

        $token = $donatur->createToken('authToken')->plainTextToken;

        return response()->json([
            'donatur'   => $donatur->fresh(),
            'token'     => $token,
            'sumbangan' => 0,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $donatur = Donatur::findOrFail($id);
		$totalSumbangan = Sumbangan::where('id_donatur', $id)
				->where('status', 'terverifikasi')
				->sum('berat');
		
        return response()->json(['donatur' => $donatur, 'sumbangan' => $totalSumbangan], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
	{
		$donatur = Donatur::findOrFail($id);
		$data = $request->all();

		if ($request->filled('oldpassword')) {
			if (!Hash::check($request->input('oldpassword'), $donatur->password)) {
				return response()->json(['message' => 'Password lama salah'], Response::HTTP_UNPROCESSABLE_ENTITY);
			} else {
				if ($request->filled('password') && $request->filled('confirmnewpassword')) {
					$newPassword = $request->input('password');
					$confirmNewPassword = $request->input('confirmnewpassword');

					if ($newPassword !== $confirmNewPassword) {
						return response()->json(['message' => 'Password baru tidak sesuai'], Response::HTTP_UNPROCESSABLE_ENTITY);
					} else {
						$data['password'] = Hash::make($newPassword);
					}
				} else {
					return response()->json(['message' => 'Masukan password baru'], Response::HTTP_UNPROCESSABLE_ENTITY);
				}
			}
		} else {
			$data = $request->except('password');
		}

		$donatur->update($data);

		$totalSumbangan = Sumbangan::where('id_donatur', $donatur->id_donatur)
			->where('status', 'terverifikasi')
			->sum('berat');

		$responseData = [
			'donatur' => $donatur,
			'sumbangan' => $totalSumbangan
		];

		return response()->json($responseData, Response::HTTP_OK);
	}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $donatur = Donatur::findOrFail($id);
        $donatur->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
	
    /**
     * Log the user out (revoke the token for the current user).
     */
    public function logout(Request $request)
    {
        // Revoke the current user's tokens.
        $request->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json(['message' => 'Logged out successfully'], Response::HTTP_OK);
    }
}
