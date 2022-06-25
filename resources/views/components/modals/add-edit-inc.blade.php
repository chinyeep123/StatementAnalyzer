<div class="row" id="js-trigger-statements" data-client-id="{{ $statement->id ?? '' }}">
    <div class="col-lg-12">

        <!--account number-->
        <div class="form-group row">
            <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Account Number*</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" name="account_number" id="account_number" class="form-control form-control-sm"
                    autocomplete="off" placeholder="" value="{{ $statement->account_number ?? '' }}" aria-describedby="basic-addon2">
            </div>
        </div>

        <!--date-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.date')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" class="form-control form-control-sm pickadate" autocomplete="off" name="date"
                    value="{{ runtimeDatepickerDate($statement->date ?? '') }}">
                <input class="mysql-date" type="hidden" name="date" id="date"
                    value="{{ $statement->date ?? '' }}">
            </div>
        </div>

        <!--description-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">{{ cleanLang(__('lang.description')) }}*</label>
            <div class="col-sm-12 col-lg-9">
                <textarea class="w-100" id="description" rows="5"
                    name="description">{{ $statement->description ?? '' }}</textarea>
            </div>
        </div>
        
        <!--money in currency-->
        <div class="form-group row">
            <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Money In Currency</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" name="money_in_currency" id="money_in_currency" class="form-control form-control-sm"
                    autocomplete="off" placeholder="" value="{{ $statement->money_in_currency ?? '' }}" aria-describedby="basic-addon2">
            </div>
        </div>

        <!--money in-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label">Money In</label>
            <div class="col-sm-12 col-lg-9">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"
                        id="basic-addon2">{{ config('system.settings_system_currency_symbol') }}</span>
                    <input type="number" name="money_in" id="money_in" class="form-control form-control-sm"
                        value="{{ $statement->money_in ?? '' }}" aria-describedby="basic-addon2">
                </div>
            </div>
        </div>
        
        <!--money out currency-->
        <div class="form-group row">
            <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Money Out Currency</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" name="money_out_currency" id="money_out_currency" class="form-control form-control-sm"
                    autocomplete="off" placeholder="" value="{{ $statement->money_out_currency ?? '' }}" aria-describedby="basic-addon2">
            </div>
        </div>

        <!--money out-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label">Money Out</label>
            <div class="col-sm-12 col-lg-9">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"
                        id="basic-addon2">{{ config('system.settings_system_currency_symbol') }}</span>
                    <input type="number" name="money_out" id="money_out" class="form-control form-control-sm"
                        value="{{ $statement->money_out ?? '' }}" aria-describedby="basic-addon2">
                </div>
            </div>
        </div>
        
        <!--balance currency-->
        <div class="form-group row">
            <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Balance Currency*</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" name="balance_currency" id="balance_currency" class="form-control form-control-sm"
                    autocomplete="off" placeholder="" value="{{ $statement->balance_currency ?? '' }}">
            </div>
        </div>

        <!--balance-->
        <div class="form-group row">
            <label
                class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Balance*</label>
            <div class="col-sm-12 col-lg-9">
                <div class="input-group input-group-sm">
                    <span class="input-group-addon"
                        id="basic-addon2">{{ config('system.settings_system_currency_symbol') }}</span>
                    <input type="number" name="balance" id="balance" class="form-control form-control-sm"
                        value="{{ $statement->balance ?? '' }}" aria-describedby="basic-addon2">
                </div>
            </div>
        </div>

        <!--pass source-->
        <input type="hidden" name="source" value="{{ request('source') }}">
        <input type="hidden" name="ref" value="{{ request('ref') }}">

        <div class="row">
            <div class="col-12">
                <div><small><strong>* {{ cleanLang(__('lang.required')) }}</strong></small></div>
            </div>
        </div>
    </div>
</div>