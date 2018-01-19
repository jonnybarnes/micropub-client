@extends('app')

@section('main')
<h1>Settings</h1>
<table>
    <caption>User settings</caption>
    <tbody>
        <tr>
            <th>me</th>
            <td>{{ Auth::user()->me }}</td>
        </tr>
        <tr>
            <th>token</th>
            <td>{{ Auth::user()->token }}</td>
        </tr>
        <tr>
            <th>Scope</th>
            <td>{{ Auth::user()->scope }}</td>
        </tr>
        <tr>
            <th>Micropub Endpoint</th>
            <td>{{ Auth::user()->micropub_endpoint }}</td>
        </tr>
        <tr>
            <th>Media Endpoint</th>
            <td>{{ Auth::user()->media_endpoint }}</td>
        <tr>
        <tr>
            <th>Syndication Targets</th>
            <td><pre>{{ Auth::user()->syndication_targets }}</pre></td>
        </tr>
    </tbody>
</table>

<p>We can query the micropub endpoint to check what, if any, the media endpoint and syndication targets are.</p>
@if (session('error'))
<div class="alert">
    {{ session('error') }}
</div>
@endif
<form action="{{ route('micropub-query') }}" method="post">
    {{ csrf_field() }}
    <button type="submit" name="query">Query Endpoint</button>
</form>

@endsection