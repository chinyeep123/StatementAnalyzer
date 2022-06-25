@extends('statement-analyzer::layouts.app')

@php
@endphp

@section('content')
<!-- main content -->
<statement-tag v-bind:settings="{{ $settings }}"></statement-tag>
<!--main content -->
<!--dynamic load payment payment (dynamic_trigger_dom)-->
@if(config('visibility.dynamic_load_modal'))
<a href="javascript:void(0)" id="dynamic-payment-content"
    class="show-modal-button edit-add-modal-button js-ajax-ux-request reset-target-modal-form" data-toggle="modal" data-modal-title="{{ cleanLang(__('lang.payment')) }}"
    data-target="#plainModal" data-url="{{ url('api/statement-tags/create?ref=list') }}"
    data-loading-target="plainModalBody"></a>
@endif
@endsection