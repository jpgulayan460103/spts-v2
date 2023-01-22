@extends('layouts.app')

@section('content')
<div>
    <dashboard-teacher :user="{{ $user }}"></dashboard-teacher>
</div>
@endsection
