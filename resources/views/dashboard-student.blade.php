@extends('layouts.app')

@section('content')
<div>
    <dashboard-student
        :user="{{ $user }}"
        :student="{{ $student }}"
        :section="{{ $section }}"
    ></dashboard-student>
</div>
@endsection
