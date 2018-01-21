@extends('app')

@section('main')
<h1>Dashboard</h1>
@if ($errors->has('dashboard'))
    @foreach ($errors->get('dashboard') as $message)
        <div class="alert">
            {{ $message }}
        </div>
    @endforeach
@endif
<p>Hi <code>{{ Auth::user()->me }}</code></p>
<form action="{{ route('logout') }}" method="post">
    {{ csrf_field() }}
    <button type="submit">Logout</button>
</form>
<p><a href="{{ route('settings') }}">Settings</a></p>
<p><a href="{{ route('note') }}">New Note</a></p>
@endsection