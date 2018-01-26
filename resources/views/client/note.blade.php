@extends('app')

@section('main')
<h1>New Note</h1>
@if ($errors->has('micropub'))
    @foreach ($errors->get('micropub') as $message)
        <div class="alert">
            {{ $message }}
        </div>
    @endforeach
@endif
@if (session('status'))
<div class="alert">
    {{ session('error') }}
</div>
@endif
<new-note-form action="{{ route('post-note') }}" csrf="{{ csrf_token() }}" media="{{ $mediaEndpoint }}" :targets="{{ $targets }}"></new-note-form>
@endsection