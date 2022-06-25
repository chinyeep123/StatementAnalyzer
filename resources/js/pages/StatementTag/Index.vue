<template>
<!-- main content -->
<div class="container-fluid">

    <!--page heading-->
    <div class="row page-titles">

        <!-- Page Title & Bread Crumbs -->
        <Breadcrumbs :tabs="this.settings.tabs" :activeTab="this.settings.active_tab" />
        <!--Page Title & Bread Crumbs -->


        <!-- action buttons -->
        <Actions :url="this.settings.url" :module="this.settings.module" />
        <!-- action buttons -->

    </div>
    <!--page heading-->

    <!--stats panel-->
    <Stats v-if="this.settings.is_team" :settings="this.settings" />
    <!--stats panel-->

    <!-- page content -->
    <!-- table-->
    <div class="row">
        <div class="col-12">
            <div class="col-12 align-self-center hidden checkbox-actions  box-shadow-minimum" :id="this.settings.module + '-checkbox-actions-container'">
                <!--button-->
                <div v-if="allow_edit" class="x-buttons">
                    <button type="button" class="btn btn-sm btn-default waves-effect waves-dark confirm-action-danger" data-type="form" data-ajax-type="POST" :data-form-id="this.settings.module + '-list-table'" :data-url="this.settings.url + '/' + this.settings.module + '/delete?type=bulk'" data-confirm-title="Delete Selected Items" data-confirm-text="Are you sure?" :id="'checkbox-actions-delete-' + this.settings.module">
                        <i class="sl-icon-trash"></i> Delete
                    </button>
                </div>
                <div v-else class="x-notice">
                    No actions are available
                </div>
            </div>
            <div class="card" :id="this.settings.module + '-table-wrapper'">
                <div class="card-body">
                    <not-found  v-if="!settings.statement_tags.length" />
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
                                    <th :class="this.settings.module + '_col_parent_id'"><a class="js-ajax-ux-request js-list-sorting" id="sort_bill_parentid" href="javascript:void(0)" :data-url="this.settings.url + '/' + this.settings.module + '?action=sort&amp;orderby=bill_parentid&amp;sortorder=asc&amp;ref=list'">Parent<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th :class="this.settings.module + '_col_name'"><a class="js-ajax-ux-request js-list-sorting" id="sort_bill_name" href="javascript:void(0)" :data-url="this.settings.url + '/' + this.settings.module + '?action=sort&amp;orderby=bill_name&amp;sortorder=asc&amp;ref=list'">Name<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                    </th>
                                    <th :class="this.settings.module + '_col_action'"><a href="javascript:void(0)">Action</a></th>
                                </tr>
                            </thead>
                            <tbody :id="this.settings.module + '-td-container'">
                                <!--ajax content here-->
                                <!--each row-->
                                <tr v-for="(tag, index) in settings.statement_tags" :id="settings.module + '_' + index">
                                    <td :class="settings.module + '_col_checkbox checkitem'" :id="settings.module + '_col_checkbox_' + index">
                                        <!--list checkbox-->
                                        <span class="list-checkboxes display-inline-block w-px-20">
                                            <input type="checkbox" :id="'listcheckbox-' + settings.module + '-' + index" :name="'ids['+ index +']'" :class="'listcheckbox listcheckbox-' + settings.module + ' filled-in chk-col-light-blue'" :data-actions-container-class="settings.module + '-checkbox-actions-container'">
                                            <label :for="'listcheckbox-' + settings.module + '-' + index"></label>
                                        </span>
                                    </td>
                                    <td :class="settings.module + '_col_parent_id'" :id="settings.module + '_col_parent_id_' + index">
                                        {{ tag.parent_id > 0 ? tag.parent_id : "Non-Set" }} 
                                    </td>
                                    <td :class="settings.module + '_col_name'" :id="settings.module + '_col_name_' + index">
                                        {{ tag.name }}
                                    </td>
                                    <td :class="settings.module + '_col_action actions_column'" :id="settings.module + '_col_action_' + index">
                                        <!--action button-->
                                        <span class="list-table-action dropdown font-size-inherit">

                                            <!--client options-->
                                            <!--delete-->
                                            <button type="button" title="Delete" class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger" data-confirm-title="Delete Invoice" data-confirm-text="Are you sure?" data-ajax-type="DELETE" :data-url="settings.url + '/' + settings.module + '/' + index">
                                                <i class="sl-icon-trash"></i>
                                            </button>
                                            <!--edit-->
                                            <a :href="'/' + settings.module + '/' + index +'/edit'" title="Edit" class="data-toggle-action-tooltip btn btn-outline-info btn-circle btn-sm">
                                                <i class="sl-icon-note"></i>
                                            </a>
                                            <a :href="'/' + settings.module + '/' + index" title="View" class="data-toggle-action-tooltip btn btn-outline-info btn-circle btn-sm">
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
                                            <a :data-url="this.settings.url + '/' + this.settings.module + '?visibility_left_menu_toggle_button=visible&amp;projects_menu_list%5B0%5D=1&amp;resource_query=ref%3Dlist&amp;page=2&amp;action=load'" data-loading-target="temp-td-container" href="javascript:void(0)" class="btn btn-rounded btn-secondary js-ajax-ux-request" id="load-more-button">show more</a>
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
    <!-- table-->
    
    <!--filter-->
    <SearchFilter v-if="this.settings.is_team" :sourceForFilterPanels="this.settings.source_for_filter_panels" :url="this.settings.url" :module="this.settings.module" />
    <!--filter-->
    <!--page content -->

</div>
<!--main content -->
</template>

<script>
    import NotFound from '../../components/NotFound';
    import Breadcrumbs from '../../components/Breadcrumbs';
    import Actions from '../../components/Actions';
    import Stats from '../../components/Stats';
    import SearchFilter from '../../components/SearchFilter';
    export default {
        name: 'StatementTag',
        props: {
            settings: {
                type: Object,
                required: true,
            }
        },
        components: {
            NotFound,
            Breadcrumbs,
            Actions,
            Stats,
            SearchFilter,
        },
        head: {
            title() {
                return {
                    inner: 'StatementTag'
                }
            }
        },
        data() {
            return {
                allow_edit: true,
            }
        },
        computed: {
        },

        methods: {
        },

    }
</script>
