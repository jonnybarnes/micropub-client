@extends('app')

@section('main')
<h1>New Note</h1>
<form action="{{ route('post-note') }}" method="post">
    <div>
        <label for="note">Note:</label>
        <textarea name="note" id="note"></textarea>
    </div>
    <button type="submit" name="submit">Submit</button>
</form>
@endsection