<template>
<!-- main content -->
<div class="container-fluid">

    <!--page heading-->
    <div class="row page-titles">

        <!-- Page Title & Bread Crumbs -->
        <Breadcrumbs :tabs="this.settings.tabs" :activeTab="this.settings.active_tab" />
        <!--Page Title & Bread Crumbs -->


        <!-- action buttons -->
        <Actions :url="this.settings.url" :module="this.settings.module" :modalTarget="statementModal" :canImport="this.settings.can_import">
            <template #extra>
                <button class="btn btn-lg btn-success" data-toggle="modal" :data-target="'#' + tagModal" :data-action-ajax-loading-target="tagModal" data-project-progress="0">Add Tag</button>
            </template>
        </Actions>
        <!-- action buttons -->

    </div>
    <!--page heading-->

    <!--stats panel-->
    <Stats v-if="this.settings.is_team" :settings="this.settings" />
    <!--stats panel-->

    <!-- page content -->
    <!--statements table-->
    <div class="row">
        <div class="col-12">
            <div class="col-12 align-self-center hidden checkbox-actions  box-shadow-minimum" :id="this.settings.module + '-checkbox-actions-container'">
                <!--button-->
                <div v-if="this.settings.is_team" class="x-buttons">
                    <button type="button" class="btn btn-sm btn-default waves-effect waves-dark confirm-action-danger" data-type="form" data-ajax-type="POST" :data-form-id="this.settings.module + '-list-table'" :data-url="getURL('/delete?type=bulk')" data-confirm-title="Delete Selected Items" data-confirm-text="Are you sure?" :id="'checkbox-actions-delete-' + this.settings.module">
                        <i class="sl-icon-trash"></i> Delete
                    </button>
                </div>
                <div v-else class="x-notice">
                    No actions are available
                </div>
            </div>
            <div class="card" :id="this.settings.module + '-table-wrapper'">
                <div class="card-body">
                    <not-found  v-if="!settings.statements.data.length" />
                    <div v-else class="table-responsive list-table-wrapper min-h-400">
                        <table :id="this.settings.module + '-list-table'" class="table m-t-0 m-b-0 table-hover no-wrap contact-list" data-page-size="10">
                            <thead>
                                <tr>
                                    <th class="list-checkbox-wrapper">
                                        <!--list checkbox-->
                                        <span class="list-checkboxes display-inline-block w-px-20">
                                            <input type="checkbox" :id="'listcheckbox-' + this.settings.module" :name="'listcheckbox-' + this.settings.module" class="listcheckbox-all filled-in chk-col-light-blue" :data-actions-container-class="this.settings.module + '-checkbox-actions-container'" :data-children-checkbox-class="'listcheckbox-' + this.settings.module">
                                            <label :for="'listcheckbox-' + this.settings.module"></label>
                                        </span>
                                    </th>
                                    <th :class="this.settings.module + '_col_account_number'"><a class="js-ajax-ux-request js-list-sorting" id="sort_account_number" href="javascript:void(0)" :data-url="getURL('?action=sort&amp;orderby=account_number&amp;sortorder=asc&amp;ref=list')">Account Number<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <!--  -->
                                    <th :class="this.settings.module + '_col_date'"><a class="js-ajax-ux-request js-list-sorting" id="sort_date" href="javascript:void(0)" :data-url="getURL('?action=sort&amp;orderby=date&amp;sortorder=asc&amp;ref=list')">Date<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th :class="this.settings.module + '_col_description'"><a class="js-ajax-ux-request js-list-sorting" id="sort_description" href="javascript:void(0)" :data-url="getURL('?action=sort&amp;orderby=description&amp;sortorder=asc&amp;ref=list')">Description<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th :class="this.settings.module + '_col_money_in_currency'"><a class="js-ajax-ux-request js-list-sorting" id="sort_money_in_currency" href="javascript:void(0)" :data-url="getURL('?action=sort&amp;orderby=money_in_currency&amp;sortorder=asc&amp;ref=list')">Currency<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th :class="this.settings.module + '_col_money_in'"><a class="js-ajax-ux-request js-list-sorting" id="sort_money_in" href="javascript:void(0)" :data-url="getURL('?action=sort&amp;orderby=money_in&amp;sortorder=asc&amp;ref=list')">Money In<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th :class="this.settings.module + '_col_money_out_currency'"><a class="js-ajax-ux-request js-list-sorting" id="sort_money_out_currency" href="javascript:void(0)" :data-url="getURL('?action=sort&amp;orderby=money_out_currency&amp;sortorder=asc&amp;ref=list')">Currency<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th :class="this.settings.module + '_col_money_out'"><a class="js-ajax-ux-request js-list-sorting" id="sort_money_out" href="javascript:void(0)" :data-url="getURL('?action=sort&amp;orderby=money_out&amp;sortorder=asc&amp;ref=list')">Money Out<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th :class="this.settings.module + '_col_balance_currency'"><a class="js-ajax-ux-request js-list-sorting" id="sort_balance_currency" href="javascript:void(0)" :data-url="getURL('?action=sort&amp;orderby=balance_currency&amp;sortorder=asc&amp;ref=list')">Currency<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th :class="this.settings.module + '_col_balance'"><a class="js-ajax-ux-request js-list-sorting" id="sort_balance" href="javascript:void(0)" :data-url="getURL('?action=sort&amp;orderby=balance&amp;sortorder=asc&amp;ref=list')">Balance<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th :class="this.settings.module + '_col_action'"><a href="javascript:void(0)">Action</a></th>
                                </tr>
                            </thead>
                            <TableRows :settings="this.settings" @on-edit="onEdit"/>
                            <tfoot v-if="settings.statements.from != settings.statements.last_page">
                                <tr>
                                    <td colspan="20">
                                        <!--load more button-->
                                        <!-- dynamic load more button-->
                                        <div class="autoload loadmore-button-container" id="team_see_more_button">
                                            <a :data-url="getURL('?visibility_left_menu_toggle_button=visible&amp;projects_menu_list%5B0%5D=1&amp;resource_query=ref%3Dlist&amp;page=2&amp;action=load')" data-loading-target="temp-td-container" href="javascript:void(0)" class="btn btn-rounded btn-secondary js-ajax-ux-request" id="load-more-button">show more</a>
                                        </div>
                                        <!-- /#dynamic load more button-->                            
                                        <!--load more button-->
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--statements table-->
    
    <!--filter-->
    <SearchFilter v-if="this.settings.is_team" :sourceForFilterPanels="this.settings.source_for_filter_panels" :url="this.settings.url" :module="this.settings.module" />
    <!--filter-->
    <!--page content -->
    <Modal
        :id="statementModal"
        :title="modalTitle"
        @on-close="onCloseStatement"
        @on-submit="onSubmitStatement"
    >
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
                    <input type="text" name="modal_date" class="form-control form-control-sm pickadate" :class="{'error' : errors.has('date')}"
                        autocomplete="off" placeholder="" aria-invalid="true"
                        >
                    <input class="mysql-date" type="hidden" name="date" id="modal_date">
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
    <Modal
        :id="tagModal"
        title="Add New Tag"
        @on-close="onClose"
        @on-submit="onSubmitTag"
    >
        <template #body>
            <!-- parent id -->
            <div class="form-group row">
                <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Parent</label>
                <div class="col-sm-12 col-lg-9">
                    <select name="parent_id" id="parent_id"
                        class="form-control form-control-sm js-select2-basic-search select2-hidden-accessible"
                        :data-ajax--url="'/api/' + settings.module_tag + '/getAll'"
                        v-model="tag.parent_id"></select>
                </div>
            </div>

            <!-- name -->
            <div class="form-group row">
                <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Name*</label>
                <div class="col-sm-12 col-lg-9">
                    <input type="text" name="name" class="form-control form-control-sm" :class="{'error' : errors.has('name')}"
                        id="name" autocomplete="off" placeholder="" aria-invalid="true"
                        v-model="tag.name">
                    <span class="text-bold text-danger" v-if="errors.has('name')" v-text="errors.get('name')"></span>
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
<!--main content -->
</template>

<script>
    import Modal from '../../components/Modal.vue';
    import NotFound from '../../components/NotFound';
    import Breadcrumbs from '../../components/Breadcrumbs';
    import Actions from '../../components/Actions';
    import Stats from '../../components/Stats';
    import SearchFilter from '../../components/SearchFilter';
    import Errors from '../../components/Errors';
    import TableRows from './components/TableRows';
    import axios from 'axios';
    import _ from 'lodash';
    
    export default {
        props: {
            settings: {
                type: Object,
                required: true,
            }
        },
        components: {
            Modal,
            NotFound,
            Breadcrumbs,
            Actions,
            Stats,
            SearchFilter,
            TableRows,
        },
        head: {
        },

        data() {
            return {
                statementModal: "statement-modal",
                tagModal: "tag-modal",
                modalTitle: "Create Statement",
                title: "Statement",
                tag: {
                    name: "",
                    parent_id: "",
                },
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
            getURL(string) {
                return `${this.settings.url}/${this.settings.module}${string}`;
            },
            onEdit(statement) {
                this.modalTitle = "Edit Statement";
                this.statement = {
                    id: statement.id,
                    account_number: statement.account_number,
                    date: statement.date,
                    description: statement.description,
                    money_in_currency: statement.money_in_currency,
                    money_in: statement.money_in,
                    money_out_currency: statement.money_out_currency,
                    money_out: statement.money_out,
                    balance_currency: statement.balance_currency,
                    balance: statement.balance,
                };
                $('.pickadate').datepicker({
                    format: NX.date_picker_format,
                    language: "lang",
                    autoclose: true,
                    class: "datepicker-default",
                    todayHighlight: true,
                }).datepicker("setDate", new Date(this.statement.date));

                $(`#${this.statementModal}`).modal('show');
            },
            onClose() {
                this.errors = new Errors();
                this.tag = {
                    name: "",
                    parent_id: "",
                };
            },
            onSubmitTag() {
			    // NXAJAX.loadingAnimation('show');
                axios
                .post(`${this.settings.module_tag}`, this.tag)
                .then(response => {
                    NX.notification({
                        type: 'success',
                        message: response.data.message
                    });
			        $('.modal').modal('hide');
                    location.reload();
			        // NXAJAX.loadingAnimation('hide');
                })
                .catch(error => {
                    this.errors.record(error.response.data.errors);
                    NX.notification({
                        type: 'error',
                        message: error.response.data.message
                    });
                });
            },
            onCloseStatement() {
                this.modalTitle = "Create Statement";
                this.errors = new Errors();
                this.statement = {
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
                document.querySelector("input[name=date]").value = "";
                document.querySelector("input[name=modal_date]").value = "";
            },
            onSubmitStatement() {   
                this.statement.date = document.querySelector("input[name=date]").value;
                if(_.includes(_.lowerCase(this.modalTitle), 'edit')) {
                    axios
                    .patch(`${this.settings.module}/${this.statement.id}`, this.statement)
                    .then(response => {
                        NX.notification({
                            type: 'success',
                            message: response.data.message
                        });
                        $('.modal').modal('hide');
                        location.reload();
                    })
                    .catch(error => {
                        this.errors.record(error.response.data.errors);
                        NX.notification({
                            type: 'error',
                            message: error.response.data.message
                        });
                    });
                } else {
                    axios
                    .post(`${this.settings.module}`, this.statement)
                    .then(response => {
                        NX.notification({
                            type: 'success',
                            message: response.data.message
                        });
                        $('.modal').modal('hide');
                        location.reload();
                    })
                    .catch(error => {
                        this.errors.record(error.response.data.errors);
                        NX.notification({
                            type: 'error',
                            message: error.response.data.message
                        });
                    });
                }
            },
        },

    }
</script>
