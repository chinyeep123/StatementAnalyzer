<template>
    <div>
        <Modal 
        modalID="statement-modal"
        :title="title"
        :show="show"
        @close="close"
        @on-submit="onSubmit">
            <template #body>
                <!-- account number -->
                <div class="form-group row">
                    <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Account Number*</label>
                    <div class="col-sm-12 col-lg-9">
                        <input type="text" name="account_number" class="form-control form-control-sm" :class="{'error' : errors.has('account_number')}"
                            id="account_number" autocomplete="off" placeholder="" aria-invalid="true"
                            v-model="statement.account_number">
                        <span class="text-bold text-danger" v-if="errors.has('account_number')" v-text="errors.get('account_number')"></span>
                    </div>
                </div>
                <!-- date -->
                <div class="form-group row">
                    <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Date*</label>
                    <div class="col-sm-12 col-lg-9">
                        <Datepicker 
                        v-model="statement.date"
                        format="MM-dd-yyyy"
                        :bootstrap-styling="true"
                        :input-class="{'error' : errors.has('date') }"
                        />
                        <span class="text-bold text-danger" v-if="errors.has('date')" v-text="errors.get('date')"></span>
                    </div>
                </div>
                <!-- description -->
                <div class="form-group row">
                    <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Description*</label>
                    <div class="col-sm-12 col-lg-9">
                        <textarea class="form-control" name="description" id="description" rows="5" :class="{'error' : errors.has('description')}"
                        v-model="statement.description"></textarea>
                        <span class="text-bold text-danger" v-if="errors.has('description')" v-text="errors.get('description')"></span>
                    </div>
                </div>
                <!-- money in currency -->
                <div class="form-group row">
                    <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Money In Currency</label>
                    <div class="col-sm-12 col-lg-9">
                        <input type="text" name="money_in_currency" class="form-control form-control-sm" :class="{'error' : errors.has('money_in_currency')}"
                            id="money_in_currency" autocomplete="off" placeholder="" aria-invalid="true"
                            v-model="statement.money_in_currency">
                    </div>
                </div>
                <!-- money in -->
                <div class="form-group row">
                    <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Money In</label>
                    <div class="col-sm-12 col-lg-9">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="basic-addon2">$</span>
                            <input type="number" name="money_in" class="form-control form-control-sm" :class="{'error' : errors.has('money_in')}"
                                id="money_in" autocomplete="off" placeholder="" aria-invalid="true"
                                v-model="statement.money_in">
                        </div>
                    </div>
                </div>
                <!-- money out currency -->
                <div class="form-group row">
                    <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Money Out Currency</label>
                    <div class="col-sm-12 col-lg-9">
                        <input type="text" name="money_out_currency" class="form-control form-control-sm" :class="{'error' : errors.has('money_out_currency')}"
                            id="money_out_currency" autocomplete="off" placeholder="" aria-invalid="true"
                            v-model="statement.money_out_currency">
                    </div>
                </div>
                <!-- money out -->
                <div class="form-group row">
                    <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Money Out</label>
                    <div class="col-sm-12 col-lg-9">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="basic-addon2">$</span>
                            <input type="number" name="money_out" class="form-control form-control-sm" :class="{'error' : errors.has('money_out')}"
                                id="money_out" autocomplete="off" placeholder="" aria-invalid="true"
                                v-model="statement.money_out">
                        </div>
                    </div>
                </div>
                <!-- balance currency -->
                <div class="form-group row">
                    <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Balance Currency*</label>
                    <div class="col-sm-12 col-lg-9">
                        <input type="text" name="balance_currency" class="form-control form-control-sm" :class="{'error' : errors.has('balance_currency')}"
                            id="balance_currency" autocomplete="off" placeholder="" aria-invalid="true"
                            v-model="statement.balance_currency">
                        <span class="text-bold text-danger" v-if="errors.has('balance_currency')" v-text="errors.get('balance_currency')"></span>
                    </div>
                </div>
                <!-- balance -->
                <div class="form-group row">
                    <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Balance*</label>
                    <div class="col-sm-12 col-lg-9">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="basic-addon2">$</span>
                            <input type="number" name="balance" class="form-control form-control-sm" :class="{'error' : errors.has('balance')}"
                                id="balance" autocomplete="off" placeholder="" aria-invalid="true"
                                v-model="statement.balance">
                        </div>
                        <span class="text-bold text-danger" v-if="errors.has('balance')" v-text="errors.get('balance')"></span>
                    </div>
                </div>

                <!--notes-->
                <div class="row">
                    <div class="col-12">
                        <div><small><strong>* Required</strong></small></div>
                    </div>
                </div>
            </template>  
        </Modal>
    </div>
</template>

<script>
    import Errors from '../../../mixins/Errors';
    import Modal from '../../../components/Modal.vue';
    import Datepicker from 'vuejs-datepicker';
    import axios from 'axios';
    import _ from 'lodash';
    export default {
        props: {
            show: {
                type: Boolean,
                required: true,
                default: false,
            },
            module: {
                type: String,
                required: true,
            },
            initialStatement: {
                type: Object,
                required: false,
                default: [],
            },
        },
        components: { 
            Datepicker,
            Modal 
        },
        data() {
            return {
                title: "Create Statement",
                statement: {
                    id: "",
                    account_number: "",
                    date: "",
                    description: "",
                    money_in_currency: "",
                    money_in: "",
                    money_out_currency: "",
                    money_out: "",
                    balance_currency: "",
                    balance: "",
                },
                errors: new Errors(),
            }
        },
        methods: {
            close: function() {
                this.statement = {
                    id: "",
                    account_number: "",
                    date: "",
                    description: "",
                    money_in_currency: "",
                    money_in: "",
                    money_out_currency: "",
                    money_out: "",
                    balance_currency: "",
                    balance: "",
                };
                this.errors= new Errors()
                this.$emit('close')
            },
            onSubmit() {   
                NProgress.start();
                if(_.isNumber(this.statement.id)) {
                    axios
                    .patch(`${this.module}/${this.statement.id}`, this.statement)
                    .then(response => {
                        NX.notification({
                            type: 'success',
                            message: response.data.message
                        });
                        this.$emit('close')
                        location.reload();
                    })
                    .catch(error => {
                        this.errors.record(error.response.data.errors);
                        NX.notification({
                            type: 'error',
                            message: error.response.data.message
                        });
                    })
                    .then(function () {
                        NProgress.done();
                    });
                } else {
                    axios
                    .post(`${this.module}`, this.statement)
                    .then(response => {
                        NX.notification({
                            type: 'success',
                            message: response.data.message
                        });
                        this.$emit('close')
                        location.reload();
                    })
                    .catch(error => {
                        this.errors.record(error.response.data.errors);
                        NX.notification({
                            type: 'error',
                            message: error.response.data.message
                        });
                    })
                    .then(function () {
                        NProgress.done();
                    });
                }
            },
        },
        watch: {
            initialStatement: function(newVal) {
                if(!_.isEmpty(newVal)) 
                {
                    this.title ='Edit Statement';
                    this.statement = {...newVal};
                }
            },
            statement: function(newVal) {
                this.$emit('statementUpdated', newVal);
            },
        },
    }
</script>
