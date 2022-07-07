<template>
    <div class="col-md-12  col-lg-7 p-b-9 align-self-center text-right" id="list-page-actions-container">
        <div id="list-page-actions">
            <!--SEARCH BOX-->
            <div class="header-search" id="header-search">
                <i class="sl-icon-magnifier"></i>
                <input type="text" 
                    class="form-control search-records list-actions-search" 
                    id="search_query" 
                    name="search_query" 
                    placeholder="Search"
                    v-model="search"
                    @change="onSearch"
                >
            </div>
            
            <!--TOGGLE STATS-->
            <button type="button" data-toggle="tooltip" title="Quick Stats" class="list-actions-button btn btn-page-actions waves-effect waves-dark js-toggle-stats-widget update-user-ux-preferences" @click.prevent="onShowStat">
                <i class="ti-stats-up"></i>
            </button>
            
            <!--IMPORTING-->
            <button type="button" title="Import" :id="`${this.module}-import-button`"
                class="p-t-5 data-toggle-tooltip list-actions-button btn btn-page-actions waves-effect waves-dark edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal" data-footer-visibility="hidden" data-top-padding="none"
                :data-action-url="`import/${this.module}`" data-action-method="POST" data-loading-target="commonModalBody"
                data-action-ajax-loading-target="commonModalBody" :data-modal-title="`Import ${getFirstUpper(this.module)}`"
                :data-url="`import/${this.module}/create`">
                <i class="growicon-0191-folder-download"></i>
            </button>

            <!--FILTERING-->
            <button type="button" data-toggle="tooltip" title="Filter" class="list-actions-button btn btn-page-actions waves-effect waves-dark js-toggle-side-panel" :data-target="'sidepanel-filter-'+ this.module">
                <i class="mdi mdi-filter-outline"></i>
            </button>
            
            <!--ADD NEW ITEM-->
            <button type="button" class="btn btn-danger btn-add-circle edit-add-modal-button js-ajax-ux-request reset-target-modal-form" @click.prevent="onShowCreateModal" data-project-progress="0">
                <i class="ti-plus"></i>
            </button>
            
            <slot name="extra"></slot>
            <!--add new button (link)-->
        </div>
    </div>
</template>

<script>
import _ from 'lodash';
export default {
    name: 'Actions',
    components: {
    },
    props: {
        module: {
            type: String,
            required: true,
        },
        url: {
            type: String,
            required: true,
        },
        modalTarget: {
            type: String,
            required: false
        },
        canImport: {
            type: Boolean,
            required: false,
            default: false
        },
        searchQuery: {
            type: String,
            required: false,
        }
    },
    data() {
      return {
        search: this.searchQuery,
      };
    },
    methods: {
        getURL(string) {
            return `${this.url}/${this.module}${string}`;
        },
        getFirstUpper(string) {
            return _.capitalize(string);
        },
        onSearch() {
            this.$emit('search', this.search);
        },
        onShowStat() {
            this.$emit('show-stat')
        },
        onShowCreateModal() {
            this.$emit('show-create')
        },
    }
}
</script>