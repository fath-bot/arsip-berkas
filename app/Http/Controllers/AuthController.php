<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        try {
            $client = new Client();
            $response = $client->post('https://map.bpkp.go.id/api/v5/login', [ // GANTI DENGAN URL API SEBENARNYA
                'form_params' => [
                    'username' => $request->username,
                    'password' => $request->password,
                    'kelas_user' => 0,
                ],
                'headers' => [
                    'Accept' => 'application/json',
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            // Coba ambil nama dan nip dari response (ubah sesuai struktur response API kamu)
            $userName = $data['message']['name'] ?? null;
            $userNip  = $data['message']['nipbaru'] ?? null;

            // Simpan ke session jika datanya tersedia
            if ($userName && $userNip) {
                session([
                    'user_name' => $userName,
                    'user_nip' => $userNip,
                ]);
            }

            return response()->json($data);

        } catch (ClientException $e) {
            $errorResponse = $e->getResponse();
            $errorContent = $errorResponse->getBody()->getContents();

            return response()->json(
                json_decode($errorContent, true),
                $errorResponse->getStatusCode()
            );
        }
    }
}
