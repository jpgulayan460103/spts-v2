@extends('layouts.app')

@section('content')
<div>
    <dashboard-guardian :user="{{ $user }}"></dashboard-guardian>
</div>
@endsection
