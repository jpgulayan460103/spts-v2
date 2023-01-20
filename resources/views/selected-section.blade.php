@extends('layouts.app')

@section('content')
<div>
    <selected-section
        :section="{{ $section }}"
        :class-record="{{ $class_record}}"
        :class-record-quarter="{{ $class_record_quarter}}"
        :unit="{{ $unit}}"
        type="{{ $type }}"
    />
</div>
@endsection
