@extends('app')

@section('main')
<h1>Dashboard</h1>
<p>Hi <code>{{ Auth::user()->me }}</code></p>
<form action="{{ route('logout') }}" method="post">
    {{ csrf_field() }}
    <button type="submit">Logout</button>
</form>
@endsection