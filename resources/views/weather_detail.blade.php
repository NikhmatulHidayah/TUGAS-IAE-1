<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prakiraan Cuaca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <h2 class="mb-3">Prakiraan Cuaca</h2>

    @if(isset($weather['data']))
    <div class="card p-3">
        <h4>{{ $weather['data'][0]['lokasi']['desa'] }}, {{ $weather['data'][0]['lokasi']['kecamatan'] }}, {{ $weather['data'][0]['lokasi']['kotkab'] }}, {{ $weather['data'][0]['lokasi']['provinsi'] }}</h4>
        
        @foreach($weather['data'][0]['cuaca'][0] as $cuaca)
            <div class="border-bottom py-2">
                <p><strong>Waktu:</strong> {{ $cuaca['local_datetime'] }}</p>
                <p><strong>Temperatur:</strong> {{ $cuaca['t'] }}°C</p>
                <p><strong>Kelembaban:</strong> {{ $cuaca['hu'] }}%</p>
                <p><strong>Cuaca:</strong> {{ $cuaca['weather_desc'] }}</p>
                <img src="{{ $cuaca['image'] }}" alt="Ikon Cuaca">
            </div>
        @endforeach
    </div>
@endif



    <a href="/weather/all" class="btn btn-secondary mt-3">Kembali</a>
    <a href="/" class="btn btn-secondary mt-3">Home</a>
    <br>
    <br>

</body>
</html>
