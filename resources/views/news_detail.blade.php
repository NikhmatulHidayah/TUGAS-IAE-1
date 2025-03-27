@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Berita</h2>
    <br><br>
    <div class="row">
        @foreach($news['data']['posts'] as $post)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ $post['thumbnail'] }}" class="card-img-top" alt="Thumbnail">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post['title'] }}</h5>
                        <p class="card-text">{{ $post['description'] }}</p>
                        <a href="{{ $post['link'] }}" target="_blank" class="btn btn-primary">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
