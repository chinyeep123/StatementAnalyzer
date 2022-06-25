<div class="row">
    <div class="col-lg-12">

        <!-- parent id -->
        <div class="form-group row">
            <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Parent</label>
            <div class="col-sm-12 col-lg-9">
                <select name="parent_id" id="parent_id"
                    class="clients_and_projects_toggle form-control form-control-sm js-select2-basic-search select2-hidden-accessible"
                    data-ajax--url="{{ route('api.statement-tags.getAll') }}"></select>
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.invoice_id')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon" id="basic-addon1">{{ config('system.settings_invoices_prefix') }}</span>
                    <input type="number" name="payment_invoiceid" id="payment_invoiceid"
                        class="form-control  form-control-sm" placeholder="" aria-describedby="basic-addon1">
                </div>
            </div>
        </div>

        <!-- name -->
        <div class="form-group row">
            <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Name*</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" name="name" class="form-control form-control-sm"
                    id="name" autocomplete="off" placeholder="" aria-describedby="basic-addon1">
            </div>
        </div>
        <input type="hidden" name="ref" value="">
        <!--notes-->
        <div class="row">
            <div class="col-12">
                <div><small><strong>* Required</strong></small></div>
            </div>
        </div>
    </div>
</div>