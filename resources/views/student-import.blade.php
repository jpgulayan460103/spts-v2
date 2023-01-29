@extends('layouts.app')

@section('content')
<div>
    <student-import
        :user="{{ $user }}"
        :genders="{{ $genders }}"
    />
</div>
@endsection
