<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class api_controller extends Controller
{
    public function getWeatherAll(){
        return view("weather");
    }

    public function getNewsAll()
    {
        $response = Http::get('https://api-berita-indonesia.vercel.app/');
        $data = $response->json();

        $endpoints = $data['endpoints'] ?? [];

        $allPaths = [];
        foreach ($endpoints as $endpoint) {
            foreach ($endpoint['paths'] ?? [] as $path) {
                $allPaths[] = $path;
            }
        }

        return view('news', compact('allPaths'));
    }

    public function show(Request $request)
    {
        // Ambil path dari query parameter
        $path = $request->query('path');
    
        // Validasi: Pastikan path tidak kosong dan merupakan string
        if (!$path || !is_string($path)) {
            abort(400, "Invalid path provided");
        }
    
        // Gabungkan dengan base API
        $apiUrl = $path;

        //dd($apiUrl);
    
        // Ambil data dari API
        $response = Http::get($apiUrl);
        
        if ($response->failed()) {
            abort(500, "Failed to fetch news");
        }
    
        $news = $response->json();
        //dd($news);
    
        return view('news_detail', compact('news'));
    }
    
}
