@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Pilih Category Berita</h2>
    <br><br>
    <div class="row">
    @foreach($allPaths as $path)
    <div class="col-md-4">
        <a href="{{ route('news.detail', ['path' => $path['path']]) }}" class="text-decoration-none">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ ucfirst(trim($path['name'], '/')) }}</h5>
                </div>
            </div>
        </a>
    </div>
@endforeach
    </div>
</div>
@endsection
