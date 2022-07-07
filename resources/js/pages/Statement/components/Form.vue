<template>
    <div>
        <Modal 
        modalID="statement-modal"
        :title="title"
        :show="show"
        @close="close"
        @submit="onSubmit">
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
                <!-- debit currency -->
                <div class="form-group row">
                    <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Debit Currency</label>
                    <div class="col-sm-12 col-lg-9">
                        <input type="text" name="debit_currency" class="form-control form-control-sm" :class="{'error' : errors.has('debit_currency')}"
                            id="debit_currency" autocomplete="off" placeholder="" aria-invalid="true"
                            v-model="statement.debit_currency">
                    </div>
                </div>
                <!-- debit -->
                <div class="form-group row">
                    <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Debit</label>
                    <div class="col-sm-12 col-lg-9">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="basic-addon2">$</span>
                            <input type="number" name="debit" class="form-control form-control-sm" :class="{'error' : errors.has('debit')}"
                                id="debit" autocomplete="off" placeholder="" aria-invalid="true"
                                v-model="statement.debit">
                        </div>
                    </div>
                </div>
                <!-- credit currency -->
                <div class="form-group row">
                    <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Credit Currency</label>
                    <div class="col-sm-12 col-lg-9">
                        <input type="text" name="credit_currency" class="form-control form-control-sm" :class="{'error' : errors.has('credit_currency')}"
                            id="credit_currency" autocomplete="off" placeholder="" aria-invalid="true"
                            v-model="statement.credit_currency">
                    </div>
                </div>
                <!-- credit -->
                <div class="form-group row">
                    <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Credit</label>
                    <div class="col-sm-12 col-lg-9">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="basic-addon2">$</span>
                            <input type="number" name="credit" class="form-control form-control-sm" :class="{'error' : errors.has('credit')}"
                                id="credit" autocomplete="off" placeholder="" aria-invalid="true"
                                v-model="statement.credit">
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
                    debit_currency: "",
                    debit: "",
                    credit_currency: "",
                    credit: "",
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
                    debit_currency: "",
                    debit: "",
                    credit_currency: "",
                    credit: "",
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
