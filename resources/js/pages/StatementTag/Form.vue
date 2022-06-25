<template>
<div class="row">
    <div class="col-lg-12">

        <!-- parent id -->
        <div class="form-group row">
            <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Parent</label>
            <div class="col-sm-12 col-lg-9">
                <select name="parent_id" id="parent_id"
                    class="clients_and_projects_toggle form-control form-control-sm js-select2-basic-search select2-hidden-accessible"
                    data-projects-dropdown="filter_payment_projectid"
                    data-feed-request-type="clients_projects"
                    data-ajax--url="/feed/company_names"></select>
            </div>
        </div>

        <!-- name -->
        <div class="form-group row">
            <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Name*</label>
            <div class="col-sm-12 col-lg-9">
                <input type="text" name="name" class="form-control form-control-sm"
                    id="name" autocomplete="off" placeholder="">
            </div>
        </div>

        <!--notes-->
        <div class="row">
            <div class="col-12">
                <div><small><strong>* Required</strong></small></div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    import NotFound from '../../components/NotFound';
    import Breadcrumbs from '../../components/Breadcrumbs';
    import Actions from '../../components/Actions';
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
            SearchFilter,
        },
        head: {
        },
        data() {
            return {
            }
        },
        computed: {
        },

        methods: {
        },

    }
</script>
