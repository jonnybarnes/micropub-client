@extends('app')

@section('head')
<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.44.0/mapbox-gl.js'></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v0.44.0/mapbox-gl.css">
@endsection

@section('main')
<h1>New Note</h1>
@if ($errors->has('micropub'))
    @foreach ($errors->get('micropub') as $message)
        <div class="alert">
            {{ $message }}
        </div>
    @endforeach
@endif
@if ($errors->has('status'))
    @foreach($errors->get('status') as $status)
        <div class="status">
            {{ $status }}
        </div>
    @endforeach
@endif
<new-note-form action="{{ route('post-note') }}" csrf="{{ csrf_token() }}" media-endpoint="{{ $mediaEndpoint }}" :targets="{{ $targets }}" token="{{ $token }}"></new-note-form>
@endsection