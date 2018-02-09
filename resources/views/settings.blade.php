@extends('app')

@section('main')
<h1 class="is-size-3">Settings</h1>
<settings :user="{{ Auth::user() }}"></settings>
<p><a href="{{ route('dashboard') }}">Dashboard</a></p>
@endsection