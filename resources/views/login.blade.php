@extends('app')

@section('main')
<h1>Login</h1>
<login-form action="{{ route('login') }}" csrf="{{ csrf_token() }}"></login-form>
@endsection