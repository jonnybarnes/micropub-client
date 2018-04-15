@extends('app')

@section('main')
<h1>Welcome</h1>
<login-form action="{{ route('login') }}" csrf="{{ csrf_token() }}"></login-form>
@endsection