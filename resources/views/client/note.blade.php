@extends('app')

@section('main')
<h1>New Note</h1>
<form action="{{ route('post-note') }}" method="post">
    <div>
        <label for="note">Note:</label>
        <textarea name="note" id="note"></textarea>
    </div>
    <div>
        <fieldset>
            <legend>Syndication</legend>
            @foreach ($targets as $target)
            <label for="{{ $target['uid'] }}">{{  $target['name'] }}:</label>
            <input id="{{ $target['uid'] }}" name="mp-syndicate-to[]" type="checkbox" value="$target['uid']">
            @endforeach
        </fieldset>
    </div>
    <button type="submit" name="submit">Submit</button>
</form>
@endsection