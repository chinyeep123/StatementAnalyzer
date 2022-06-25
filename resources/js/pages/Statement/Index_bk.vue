<template>
    <div class="row">
                    <a :href="getURL(`/${statement.id}/edit`)" title="Edit" class="data-toggle-action-tooltip btn btn-outline-info btn-circle btn-sm">
                        <i class="sl-icon-note"></i>
                    </a>
                    <a href="javascript:void(0)" title="Edit" class="data-toggle-action-tooltip btn btn-outline-info btn-circle btn-sm" @click="edit(statement)">
        <div class="col-12">
            <div class="col-12 align-self-center hidden checkbox-actions  box-shadow-minimum" :id="this.module + '-checkbox-actions-container'">
                <!--button-->
                <div v-if="allow_edit" class="x-buttons">
                    <button type="button" class="btn btn-sm btn-default waves-effect waves-dark confirm-action-danger" data-type="form" data-ajax-type="POST" :data-form-id="this.module + '-list-table'" :data-url="this.url + '/' + this.module + '/delete?type=bulk'" data-confirm-title="Delete Selected Items" data-confirm-text="Are you sure?" :id="'checkbox-actions-delete-' + this.module">
                        <i class="sl-icon-trash"></i> Delete
                    </button>
                </div>
                <div v-else class="x-notice">
                    No actions are available
                </div>
            </div>
            <div class="card" :id="this.module + '-table-wrapper'">
                <div class="card-body">
                    <not-found  v-if="data" />
                    <div v-else class="table-responsive list-table-wrapper min-h-400">
                        <table id="invoices-list-table" class="table m-t-0 m-b-0 table-hover no-wrap contact-list" data-page-size="10">
                            <thead>
                                <tr>
                                    <th class="list-checkbox-wrapper">
                                        <!--list checkbox-->
                                        <span class="list-checkboxes display-inline-block w-px-20">
                                            <input type="checkbox" id="listcheckbox-invoices" name="listcheckbox-invoices" class="listcheckbox-all filled-in chk-col-light-blue" data-actions-container-class="invoices-checkbox-actions-container" data-children-checkbox-class="listcheckbox-invoices">
                                            <label for="listcheckbox-invoices"></label>
                                        </span>
                                    </th>
                                    <th class="invoices_col_id"><a class="js-ajax-ux-request js-list-sorting" id="sort_bill_invoiceid" href="javascript:void(0)" :data-url="this.url + '/' + this.module + '?action=sort&amp;orderby=bill_invoiceid&amp;sortorder=asc&amp;ref=list'">ID<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th class="invoices_col_date"><a class="js-ajax-ux-request js-list-sorting" id="sort_bill_date" href="javascript:void(0)" :data-url="this.url + '/' + this.module + '?action=sort&amp;orderby=bill_date&amp;sortorder=asc&amp;ref=list'">Date<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th class="invoices_col_company"><a class="js-ajax-ux-request js-list-sorting" id="sort_client" href="javascript:void(0)" :data-url="this.url + '/' + this.module + '?action=sort&amp;orderby=client&amp;sortorder=asc&amp;ref=list'">Company Name<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a></th>
                                    <th class="invoices_col_project"><a class="js-ajax-ux-request js-list-sorting" id="sort_project" href="javascript:void(0)" :data-url="this.url + '/' + this.module + '?action=sort&amp;orderby=project&amp;sortorder=asc&amp;ref=list'">Project<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th class="invoices_col_amount"><a class="js-ajax-ux-request js-list-sorting" id="sort_bill_final_amount" href="javascript:void(0)" :data-url="this.url + '/' + this.module + '?action=sort&amp;orderby=bill_final_amount&amp;sortorder=asc&amp;ref=list'">Amount<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th class="invoices_col_payments"><a class="js-ajax-ux-request js-list-sorting" id="sort_payments" href="javascript:void(0)" :data-url="this.url + '/' + this.module + '?action=sort&amp;orderby=payments&amp;sortorder=asc&amp;ref=list'">Payments<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th class="invoices_col_balance hidden"><a class="js-ajax-ux-request js-list-sorting" id="sort_balance" href="javascript:void(0)" :data-url="this.url + '/' + this.module + '?action=sort&amp;orderby=balance&amp;sortorder=asc&amp;ref=list'">Balance<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th class="invoices_col_status"><a class="js-ajax-ux-request js-list-sorting" id="sort_bill_status" href="javascript:void(0)" :data-url="this.url + '/' + this.module + '?action=sort&amp;orderby=bill_status&amp;sortorder=asc&amp;ref=list'">Status<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th class="invoices_col_action"><a href="javascript:void(0)">Action</a></th>
                                </tr>
                            </thead>
                            <tbody id="invoices-td-container">
                                <!--ajax content here-->
                                <!--each row-->
                                <tr id="invoice_53">
                                    <td class="invoices_col_checkbox checkitem" id="invoices_col_checkbox_53">
                                        <!--list checkbox-->
                                        <span class="list-checkboxes display-inline-block w-px-20">
                                            <input type="checkbox" id="listcheckbox-invoices-53" name="ids[53]" class="listcheckbox listcheckbox-invoices filled-in chk-col-light-blue" data-actions-container-class="invoices-checkbox-actions-container">
                                            <label for="listcheckbox-invoices-53"></label>
                                        </span>
                                    </td>
                                    <td class="invoices_col_id" id="invoices_col_id_53">
                                        <a href="/invoices/53">
                                            INV-2021-1003 
                                        </a>
                                    </td>
                                    <td class="invoices_col_date" id="invoices_col_date_53">
                                        01-01-2021
                                    </td>
                                        <td class="invoices_col_company" id="invoices_col_company_53">
                                        <a href="/clients/0">---</a>
                                    </td>
                                            <td class="invoices_col_project" id="invoices_col_project_53">
                                        <a href="/projects/">---</a>
                                    </td>
                                    
                                    <td class="invoices_col_amount" id="invoices_col_amount_53">
                                        $0.00</td>
                                        <td class="invoices_col_payments" id="invoices_col_payments_53">
                                        <a :href="this.url + '/' + this.module + '?filter_payment_invoiceid=53'">$0.00</a>
                                    </td>
                                        <td class="invoices_col_balance hidden" id="invoices_col_balance_53">
                                        $0.00
                                    </td>
                                    <td class="invoices_col_status" id="invoices_col_status_53">

                                        <span class="label label-outline-default">Draft</span>

                                        
                                    </td>
                                    <td class="invoices_col_action actions_column" id="invoices_col_action_53">
                                        <!--action button-->
                                        <span class="list-table-action dropdown font-size-inherit">

                                            <!--client options-->
                                            <!--delete-->
                                            <button type="button" title="Delete" class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger" data-confirm-title="Delete Invoice" data-confirm-text="Are you sure?" data-ajax-type="DELETE" :data-url="this.url + '/' + this.module + '/53'">
                                                <i class="sl-icon-trash"></i>
                                            </button>
                                            <!--edit-->
                                            <a href="/invoices/53/edit-invoice" title="Edit" class="data-toggle-action-tooltip btn btn-outline-info btn-circle btn-sm">
                                                <i class="sl-icon-note"></i>
                                            </a>
                                            <a href="/invoices/53" title="View" class="data-toggle-action-tooltip btn btn-outline-info btn-circle btn-sm">
                                                <i class="ti-new-window"></i>
                                            </a>

                                            <!--more button (team)-->
                                            <span class="list-table-action dropdown font-size-inherit">
                                                <button type="button" id="listTableAction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="More" class="data-toggle-action-tooltip btn btn-outline-default-light btn-circle btn-sm">
                                                    <i class="ti-more"></i>
                                                </button>
                                            </span>
                                            <!--more button-->
                                        </span>
                                        <!--action button-->
                                    </td>
                                </tr>
                                <!--each row-->                    
                                <!--ajax content here-->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="20">
                                        <!--load more button-->
                                        <!-- dynamic load more button-->
                                        <div class="autoload loadmore-button-container" id="team_see_more_button">
                                            <a :data-url="this.url + '/' + this.module + '?visibility_left_menu_toggle_button=visible&amp;projects_menu_list%5B0%5D=1&amp;resource_query=ref%3Dlist&amp;page=2&amp;action=load'" data-loading-target="temp-td-container" href="javascript:void(0)" class="btn btn-rounded btn-secondary js-ajax-ux-request" id="load-more-button">show more</a>
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
</template>

<script>
    import NotFound from '../../components/NotFound'
    export default {
        props: {
            module: {
                type: String,
                required: true,
            },
            url: {
                type: String,
                required: true,
            },
            // allow_edit: {
            //     type: Boolean,
            //     required: false,
            //     default: true
            // }
        },
        components: {
            NotFound,
        },
        head: {
            title() {
                return {
                    inner: 'StatementAnalyzer'
                }
            }
        },

        data() {
            return {
                allow_edit: false,
                data: false,
            }
        },
        computed: {
        },

        methods: {
        },

    }
</script>
