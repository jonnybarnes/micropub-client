@extends('app')

@section('main')
<h1>Dashboard</h1>
<p>Hi <code>{{ Auth::user()->me }}</code></p>
<p><a href="{{ route('settings') }}">Settings</a></p>
<p><a href="{{ route('note') }}">New Note</a></p>
@endsection