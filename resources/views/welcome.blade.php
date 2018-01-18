@extends('app')

@section('main')
<h1>Welcome</h1>
@if (session('error'))
<div class="error">
    {{ session('error') }}
</div>
@endif
<form action="{{ route('login') }}" method="post">
    {{ csrf_field() }}
    <div>
        <label for="me">Homepage:</label>
        <input type="url" name="me" id="me">
    </div>
    <div>
        <button type="submit">Login</button>
    </div>
</form>
@endsection