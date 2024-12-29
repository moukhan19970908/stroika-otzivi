<?php

namespace App\Http\Controllers;

use App\Services\GuestService;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


class GuestController extends Controller
{
    public function getProfile($id,GuestService $service){
        return response()->json($service->getProfileById($id));
    }

    public function getUserComments($id,GuestService $service){
        try {
            return response()->json($service->getUserComments($id));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function searchAddress(Request $request){
        $text = $request->input('query');
        $url = "https://search-maps.yandex.ru/v1/?text=$text&type=geo&lang=ru_RU&apikey=a2a65f21-06cb-4434-b4cf-88a0d11d7f9a";
        $client = new Client();
         try {
            $response = $client->request('GET', $url);

            $data = $response->getBody()->getContents();

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
