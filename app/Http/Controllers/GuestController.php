<?php

namespace App\Http\Controllers;

use App\Services\GuestService;
use Illuminate\Http\Request;

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
}
