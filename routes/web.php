<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\home_controller;
use App\Http\Controllers\api_controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


Route::get('/', [home_controller::class, 'getHome']);
Route::get('/weather/all', action: [api_controller::class, 'getWeatherAll']);

Route::get('/news/all', action: [api_controller::class, 'getNewsAll']);
Route::get('/news/detail', [api_controller::class, 'show'])->name('news.detail');

function readCSV($filePath) {
    $data = [];
    if (!file_exists($filePath)) return [];
    
    if (($handle = fopen($filePath, 'r')) !== FALSE) {
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $data[] = ['code' => $row[0], 'name' => $row[1]];
        }
        fclose($handle);
    }
    return $data;
}

Route::get('/weather/provinces', function () {
    $data = readCSV(public_path('csv/kode-wilayah.csv'));
    $provinces = array_filter($data, fn($row) => preg_match('/^\d{2}$/', $row['code']));
    return response()->json(array_values($provinces));
});

Route::get('/weather/regencies', function (Request $request) {
    $provinceCode = $request->query('province');
    $data = readCSV(public_path('csv/kode-wilayah.csv'));
    $regencies = array_filter($data, fn($row) => preg_match('/^\d{2}\.\d{2}$/', $row['code']) && strpos($row['code'], $provinceCode) === 0);
    return response()->json(array_values($regencies));
});

Route::get('/weather/districts', function (Request $request) {
    $regencyCode = $request->query('regency');
    $data = readCSV(public_path('csv/kode-wilayah.csv'));
    $districts = array_filter($data, fn($row) => preg_match('/^\d{2}\.\d{2}\.\d{2}$/', $row['code']) && strpos($row['code'], $regencyCode) === 0);
    return response()->json(array_values($districts));
});

Route::get('/weather/villages', function (Request $request) {
    $districtCode = $request->query('district');
    $data = readCSV(public_path('csv/kode-wilayah.csv'));
    $villages = array_filter($data, fn($row) => preg_match('/^\d{2}\.\d{2}\.\d{2}\.\d{4}$/', $row['code']) && strpos($row['code'], $districtCode) === 0);
    return response()->json(array_values($villages));
});

Route::get('/weather/{kode}', function ($kode) {
    $response = Http::get("https://api.bmkg.go.id/publik/prakiraan-cuaca", [
        'adm4' => $kode
    ]);

    if ($response->successful()) {
        return view('weather_detail', ['weather' => $response->json()]);
    } else {
        return abort(404, "Data cuaca tidak ditemukan");
    }
});
