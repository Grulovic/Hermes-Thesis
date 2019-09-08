@section('title', 'HERMES - Documentation')

@extends('layouts.layout')

@section('content')

<embed id="'pdf" src="{{url('documents/thesis.pdf')}}" width="100%" style="height: 985px;" />

@endsection