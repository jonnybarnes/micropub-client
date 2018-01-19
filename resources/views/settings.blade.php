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
    </tbody>
</table>
@endsection