@extends('pages.import.wrapper')
<!--SECOND STEP FORM-->
@section('second-step-form')
<div class="form-group row">
    <label class="col-sm-12 text-left control-label col-form-label required">{{ cleanLang(__('lang.account_number')) }}*</label>
    <div class="col-sm-12">
        <input type="text" name="account_number" id="account_number" class="form-control form-control-sm"
            autocomplete="off" placeholder="" value="" aria-describedby="basic-addon2">
    </div>
</div>
@endsection