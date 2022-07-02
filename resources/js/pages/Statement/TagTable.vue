<template>
    <div>
        <Modal 
        modalID="tag-list-modal"
        :large="true"
        :submit="false"
        :title="title"
        :show="show"
        @close="close">
            <template #body>
                <div class="col-md-12 p-b-9 align-self-center text-right">
                    <button class="btn btn-lg btn-success" @click.stop="toggle({id: tagModal, data: {}})" data-project-progress="0">Add Tag</button>
                </div>
                <div :class="`card count-${statement_tags.length}`" :id="settings.module_tag + '-table-wrapper'">
                    <div class="card-body">
                        <not-found  v-if="!statement_tags.length" />
                        <div v-else class="table-responsive list-table-wrapper min-h-400">
                            <table :id="settings.module_tag + '-list-table'" class="table m-t-0 m-b-0 table-hover no-wrap contact-list" data-page-size="10">
                                <thead>
                                    <tr>
                                        <th :class="settings.module_tag + '_col_parent_id'"><a id="sort_parent_id" href="javascript:void(0)" @click.prevent="sortBy('parent_id')">Parent<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                        </th>
                                        <th :class="settings.module_tag + '_col_name'"><a id="sort_name" href="javascript:void(0)" @click.prevent="sortBy('name')">Name<span class="sorting-icons"><i class="ti-arrows-vertical"></i></span></a>
                                        </th>
                                        <th :class="settings.module_tag + '_col_action'"><a href="javascript:void(0)">Action</a></th>
                                    </tr>
                                </thead>
                                <tbody :id="settings.module_tag + '-td-container'">
                                    <tr v-for="(tag, index) in statement_tags" :id="settings.module_tag + '_' + tag.id">
                                        <td :class="settings.module_tag + '_col_parent_id'" :id="settings.module_tag + '_col_parent_id_' + tag.id">
                                            {{ tag.parent_id? tag.parent.name : '-' }}
                                        </td>
                                        <td :class="settings.module_tag + '_col_name'" :id="settings.module_tag + '_col_name_' + tag.id">
                                            {{ tag.name }}
                                        </td>
                                        <td :class="settings.module_tag + '_col_action actions_column'" :id="settings.module_tag + '_col_action_' + tag.id">
                                            <!--action button-->
                                            <span class="list-table-action dropdown font-size-inherit">

                                                <!--client options-->
                                                <!--delete-->
                                                <button type="button" title="Delete" class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger" :data-confirm-title="'Delete '+ startToUpper(title)" data-confirm-text="Are you sure?" data-ajax-type="DELETE" :data-url="getURL(`/${tag.id}`)">
                                                    <i class="sl-icon-trash"></i>
                                                </button>
                                                <!--edit-->
                                                <a href="javascript:void(0)" title="Edit" class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm" @click.prevent="toggle({id: tagModal, data: tag})">
                                                    <i class="sl-icon-note"></i>
                                                </a>
                                            </span>
                                            <!--action button-->
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot v-if="filter_params.page != filter_params.last_page">
                                    <tr>
                                        <td colspan="20">
                                            <!--load more button-->
                                            <!-- dynamic load more button-->
                                            <div class="text-center loadmore-button-container" id="team_see_more_button">
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
            </template>  
        </Modal>


        <TagForm
        :show="showModal(tagModal)" 
        @close="toggle({id: tagModal, data: {}})"
        :initialTag="tag"
        :settings="this.settings"
        />
    </div>
</template>

<script>
    import NotFound from '../../components/NotFound';
    import Modal from '../../components/Modal.vue';
    import Errors from '../../mixins/Errors';
    import TagForm from './TagForm.vue';
    import axios from 'axios';
    import _ from 'lodash';
    import Select2 from 'v-select2-component';
    export default {
        props: {
            show: {
                type: Boolean,
                required: true,
                default: false,
            },
            settings: {
                type: Object,
                required: true,
            },
        },
        components: { 
            NotFound,
            Modal,
            TagForm,
            Select2,
        },
        data() {
            return {
                activeModal: 0,
                tagModal: "tag-modal",
                title: "Statement Tags",
                filter_params: {
                    page: 1,
                    last_page: 1,
                },
                tag: {
                    id: "",
                    name: "",
                    parent_id: 0,
                },
                ajaxParent: {
                    url: `/feed/${this.settings.module_tag}/all`,
                    processResults: function (data) {
                    // Tranforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data.map(x => {return {id:x.id, text: x.value}})
                    };
                    }
                },
                statement_tags: [],
                errors: new Errors(),
            }
        },
        mounted() {
            this.initial();
        },
        methods: {
            getURL(string) {
                return `${this.settings.url}/${this.settings.module_tag}${string}`;
            },
            startToUpper(string) {
                return _.startCase(string);
            },
            showModal: function(id) {
                return this.activeModal === id 
            },
            toggle: function ({id, data}) {
                if(this.activeModal !== 0) {
                    this.activeModal = 0
                    return false
                }
                this.tag = data;
                this.activeModal = id
            },
            close: function() {
                this.$emit('close')
            },
            initial() {
                NProgress.start();
                axios
                .get(`${this.settings.module_tag}`, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                    },
                })
                .then(response => {
                    this.statement_tags = response.data.statement_tags.data;
                    this.filter_params.page = response.data.statement_tags.current_page;
                    this.filter_params.last_page = response.data.statement_tags.last_page;
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
                .get(`${this.settings.module_tag}`, {
                    params: this.filter_params,
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                    },
                })
                .then(response => {
                    this.filter_params.page = response.data.statement_tags.current_page;
                    this.filter_params.last_page = response.data.statement_tags.last_page;

                    response.data.statement_tags.data.forEach((value) => {
                        this.stats = response.data.stats;
                        this.statement_tags.push(value)
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
                .get(`${this.settings.module_tag}`, {
                    params: {
                        orderby: value,
                        sortorder: this.currentSortOrder
                    },
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                    },
                })
                .then(response => {
                    this.currentSortOrder = this.currentSortOrder == 'asc'? 'desc' : 'asc';
                    this.filter_params.page = response.data.statement_tags.current_page;
                    this.statement_tags = response.data.statement_tags.data;

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
        },
    }
</script>
