@extends('statement-analyzer::layouts.app')

@section('content')
<statement v-bind:settings="{{ $settings }}"></statement>
@endsection