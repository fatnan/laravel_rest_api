<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Address;
use Illuminate\Support\Facades\Http;

class GitController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user;
        $repository = $request->repository;
        // URL
        $apiURL = "https://api.github.com/repos/" .$user. "/" .$repository;
  
        // Headers
        $headers = [
            "Accept: application/vnd.github.v3+json",
        ];
  
        $response = Http::withHeaders($headers)->get($apiURL);
  
        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);
      
        return response()->json([$responseBody],200);
    }
}
