<template>
<!-- main content -->
<div class="container-fluid">

    <!--page heading-->
    <div class="row page-titles">

        <!-- Page Title & Bread Crumbs -->
        <Breadcrumbs :tabs="this.settings.tabs" :activeTab="this.settings.active_tab" />
        <!--Page Title & Bread Crumbs -->


        <!-- action buttons -->
        <Actions 
            :url="this.settings.url" 
            :module="this.settings.module" 
            :canImport="this.settings.can_import"
            :searchQuery="filter_params.search_query"
            @on-search="search"
            @on-show-stat="toggle('stat')"
            @on-show-create="toggleStatement({id: statementModal, data: {}})"
        >
            <template #extra>
                <button class="btn btn-lg btn-success" @click.stop="toggle(tagListingModal)" data-project-progress="0">Tag</button>
            </template>
        </Actions>
        <!-- action buttons -->

    </div>
    <!--page heading-->

    <!--stats panel-->
    <Stats 
        v-if="this.settings.is_team" 
        :moduleName="this.settings.module" 
        :stats="stats" 
        :show="show('stat')" 
    />
    <!--stats panel-->

    <!--analysis panel-->
    <Analysis 
        v-if="this.settings.is_team" 
        :moduleName="this.settings.module" 
        :analysis="analysis" 
        :show="show('stat')"
    />
    <!--analysis panel-->

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
            <div :class="`card count-${statements.length}`" :id="this.settings.module + '-table-wrapper'">
                <div class="card-body">
                    <not-found  v-if="!statements.length" />
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
                                    <th :class="this.settings.module + '_col_account_number'"><a id="sort_account_number" href="javascript:void(0)" @click.prevent="sortBy('account_number')">Account Number<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <!--  -->
                                    <th :class="this.settings.module + '_col_date'"><a id="sort_date" href="javascript:void(0)" @click.prevent="sortBy('date')">Date<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th :class="this.settings.module + '_col_description'"><a id="sort_description" href="javascript:void(0)" @click.prevent="sortBy('description')">Description<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th :class="this.settings.module + '_col_money_in_currency'"><a id="sort_money_in_currency" href="javascript:void(0)" @click.prevent="sortBy('money_in_currency')">Currency<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th :class="this.settings.module + '_col_money_in'"><a id="sort_money_in" href="javascript:void(0)" @click.prevent="sortBy('money_in')">Money In<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th :class="this.settings.module + '_col_money_out_currency'"><a id="sort_money_out_currency" href="javascript:void(0)" @click.prevent="sortBy('money_out_currency')">Currency<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th :class="this.settings.module + '_col_money_out'"><a id="sort_money_out" href="javascript:void(0)" @click.prevent="sortBy('money_out')">Money Out<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th :class="this.settings.module + '_col_balance_currency'"><a id="sort_balance_currency" href="javascript:void(0)" @click.prevent="sortBy('balance_currency')">Currency<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th :class="this.settings.module + '_col_balance'"><a id="sort_balance" href="javascript:void(0)" @click.prevent="sortBy('balance')">Balance<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th :class="this.settings.module + '_col_action'"><a href="javascript:void(0)">Action</a></th>
                                </tr>
                            </thead>
                            <TableRows 
                            :url="this.settings.url"
                            :moduleName="this.settings.module" 
                            :statements="statements"
                            @on-show-edit="toggleStatement"
                            />
                            <tfoot v-if="filter_params.page != filter_params.last_page">
                                <tr>
                                    <td colspan="20">
                                        <!--load more button-->
                                        <!-- dynamic load more button-->
                                        <div class="autoload loadmore-button-container" id="team_see_more_button">
                                            <a data-loading-target="temp-td-container" href="javascript:void(0)" class="btn btn-rounded btn-secondary js-ajax-ux-request" id="load-more-button" @click.prevent="loadMore">show more</a>
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
    <SearchFilter 
        v-if="this.settings.is_team" 
        :sourceForFilterPanels="this.settings.source_for_filter_panels" 
        :module="this.settings.module"
        @search="search('filter')"
        @reset="reset">
        <template #panel-body>

            <!--Account Number-->
            <div class="filter-block">
                <div class="title">
                    Acount Number
                </div>
                <div class="fields">
                    <div class="row">
                        <div class="col-md-12">
                            <Select2 
                                id="filter_account_number"
                                name="filter_account_number"
                                v-model="filter_params.account_number" 
                                :settings="{ ajax: ajaxAccountNumber, width: '100%' }"  
                            />
                        </div>
                    </div>
                </div>
            </div>

            <!--Categories-->
            <div class="filter-block">
                <div class="title">
                    Categories
                </div>
                <div class="fields">
                    <div class="row">
                        <div class="col-md-12">
                            <Select2 
                                id="filter_category_id"
                                name="filter_category_id"
                                v-model="filter_params.category_id" 
                                :settings="{ ajax: ajaxCategories, width: '100%' }"  
                            />
                        </div>
                    </div>
                </div>
            </div>
            
            <!--tags-->
            <div class="filter-block">
                <div class="title">
                    Tags
                </div>
                <div class="fields">
                    <div class="row">
                        <div class="col-md-12">
                            <Select2 
                                id="filter_tag_ids"
                                name="filter_tag_ids"
                                v-model="filter_params.tag_ids" 
                                :settings="{ ajax: ajaxTags, width: '100%', multiple: true }"  
                            />
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </SearchFilter>
    <!--filter-->
    <!--page content -->
    <Form
    :title="modalTitle"
    :module="this.settings.module"
    :initialStatement="statement"
    :show="show(statementModal)" 
    @close="toggleStatement({id: statementModal, data: {}})"
    />

    <TagTable
    :show="show(tagListingModal)" 
    @close="toggle(tagListingModal)"
    :settings="this.settings"
    />
</div>
<!--main content -->
</template>

<script>
    import Actions from '../../components/Actions';
    import Analysis from '../../components/Analysis';
    import Breadcrumbs from '../../components/Breadcrumbs';
    import NotFound from '../../components/NotFound';
    import SearchFilter from '../../components/SearchFilter';
    import Stats from '../../components/Stats';
    import Form from './components/Form.vue';
    import TableRows from './components/TableRows';
    import TagForm from './TagForm.vue';
    import TagTable from './TagTable.vue';
    import Errors from '../../mixins/Errors';
    import axios from 'axios';
    import _ from 'lodash';
    import Select2 from 'v-select2-component';
    
    export default {
        props: {
            settings: {
                type: Object,
                required: true,
            },
        },
        components: {
            Actions,
            Analysis,
            Breadcrumbs,
            NotFound,
            SearchFilter,
            Stats,
            Form,
            TableRows,
            TagTable,
            Select2,
        },
        head: {
        },
        data() {
            return {
                activeModal: 0,
                statementModal: "statement-modal",
                tagListingModal: "tag-listing-modal",
                modalTitle: "Create Statement",
                filter_params: {
                    category_id: "",
                    search_query: "",
                    tag_ids: "",
                    page: 1,
                    last_page: 1,
                },
                tag: {
                    name: "",
                    parent_id: 0,
                },
                statement: {
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
                statements: [],
                stats: [],
                analysis: [],
                accountOptions: [],
                currentSortColumn: '',
                currentSortOrder: 'asc',
                errors: new Errors(),
                ajaxAccountNumber: {
                    url: `/feed/${this.settings.module}/account_numbers`,
                    processResults: function (data) {
                    // Tranforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data.map(x => {return {id:x.id, text: x.value}})
                    };
                    }
                },
                ajaxCategories: {
                    url: `/feed/${this.settings.module_tag}/categories`,
                    processResults: function (data) {
                    // Tranforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data.map(x => {return {id:x.id, text: x.value}})
                    };
                    }
                },
                ajaxTags: {
                    url: `/feed/${this.settings.module_tag}/tags`,
                    data: params => {
                        return {
                            term: params.term,
                            parent_id: this.filter_params.category_id
                        };
                    },
                    processResults: function (data) {
                    // Tranforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data.map(x => {return {id:x.id, text: x.value}})
                    };
                    }
                },
            }
        },
        mounted() {
            this.initial();
        },
        methods: {
            getURL(string) {
                return `${this.settings.url}/${this.settings.module}${string}`;
            },
            show: function(id) {
                return this.activeModal === id 
            },
            toggle: function (id) {
                if(this.activeModal !== 0) {
                    this.activeModal = 0
                    return false
                }
                this.activeModal = id
            },
            toggleStatement: function ({id, data}) {
                if(this.activeModal !== 0) {
                    this.activeModal = 0
                    return false
                }
                this.statement = data;
                this.activeModal = id;
            },
            initial() {
                NProgress.start();
                axios
                .get(`${this.settings.module}`, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                    },
                })
                .then(response => {
                    this.stats = response.data.stats;
                    this.analysis = response.data.analysis;
                    this.statements = response.data.statements.data;
                    this.filter_params.page = response.data.statements.current_page;
                    this.filter_params.last_page = response.data.statements.last_page;
                })
                .catch(error => {
                })
                .then(function () {
                    NProgress.done();
                });
            },
            loadMore() {
                NProgress.start();
                this.filter_params.page = this.filter_params.page < this.filter_params.last_page? (this.filter_params.page + 1) : this.filter_params.page;
                axios
                .get(`${this.settings.module}`, {
                    params: this.filter_params,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                    },
                })
                .then(response => {
                    this.filter_params.page = response.data.statements.current_page;
                    this.filter_params.last_page = response.data.statements.last_page;

                    response.data.statements.data.forEach((value) => {
                        this.stats = response.data.stats;
                        this.statements.push(value)
                    });
                })
                .catch(error => {
                    NX.notification({
                        type: 'error',
                        message: error.response.data.message
                    });
                })
                .then(function () {
                    NProgress.done();
                });
            },
            sortBy(value) {
                NProgress.start();
                if(this.currentSortColumn != value) {
                    this.currentSortOrder = 'asc';
                }
                this.currentSortColumn = value;
                axios
                .get(`${this.settings.module}`, {
                    params: {
                        category_id: this.filter_params.category_id,
                        tag_ids: this.filter_params.tag_ids,
                        orderby: value,
                        sortorder: this.currentSortOrder
                    },
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                    },
                })
                .then(response => {
                    this.currentSortOrder = this.currentSortOrder == 'asc'? 'desc' : 'asc';
                    this.filter_params.page = response.data.statements.current_page;
                    this.stats = response.data.stats;
                    this.analysis = response.data.analysis;
                    this.statements = response.data.statements.data;

                })
                .catch(error => {
                    NX.notification({
                        type: 'error',
                        message: error.response.data.message
                    });
                })
                .then(function () {
                    NProgress.done();
                });
            },
            search(type) {
                if(type == 'filter') {
                    this.filter_params.search_query = '';
                } else {
                    this.filter_params.search_query = type;
                }
                NProgress.start();
                this.filter_params.currentSortOrder = 'asc';
                this.filter_params.page = 1;
                axios
                .get(`${this.settings.module}`, {
                    params: this.filter_params,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                    },
                })
                .then(response => {
                    this.filter_params.page = response.data.statements.current_page;
                    this.filter_params.last_page = response.data.statements.last_page;
                    this.stats = response.data.stats;
                    this.analysis = response.data.analysis;
                    this.statements = response.data.statements.data;
                })
                .catch(error => {
                    NX.notification({
                        type: 'error',
                        message: error.response.data.message
                    });
                })
                .then(function () {
                    NProgress.done();
                });
            },
            reset() {
                this.filter_params = {
                    search_query: "",
                    category_id: "",
                    tag_ids: "",
                    page: 1,
                    last_page: 1,
                };
                this.initial();
            },
            // onClose() {
            //     this.errors = new Errors();
            //     this.tag = {
            //         name: "",
            //         parent_id: "",
            //     };
            // },
            // onSubmitTag() {
			//     // NXAJAX.loadingAnimation('show');
            //     axios
            //     .post(`${this.settings.module_tag}`, this.tag)
            //     .then(response => {
            //         NX.notification({
            //             type: 'success',
            //             message: response.data.message
            //         });
			//         $('.modal').modal('hide');
            //         location.reload();
			//         // NXAJAX.loadingAnimation('hide');
            //     })
            //     .catch(error => {
            //         this.errors.record(error.response.data.errors);
            //         NX.notification({
            //             type: 'error',
            //             message: error.response.data.message
            //         });
            //     });
            // },
        },
    }
</script>
