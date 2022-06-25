<template>
<!-- right-sidebar -->
<div class="right-sidebar" :id="'sidepanel-filter-' + this.module">
    <form>
        <div class="slimscrollright">
            <!--title-->
            <div class="rpanel-title">
                <i class="icon-Filter-2"></i>Filter {{ this.module }}
                <span>
                    <i class="ti-close js-close-side-panels" :data-target="'sidepanel-filter-' + this.module"></i>
                </span>
            </div>
            <!--title-->
            <!--body-->
            <div class="r-panel-body">
                <!--categorgies-->
                <div class="filter-block">
                    <div class="title">
                        Categories
                    </div>
                    <div class="fields">
                        <div class="row">
                            <div class="col-md-12">
                                <select name="filter_bill_categoryid" id="filter_bill_categoryid"
                                    class="form-control form-control-sm select2-basic select2-multiple select2-hidden-accessible"
                                    multiple="multiple" tabindex="-1" aria-hidden="true">
                                    <option v-for="(category, index) in this.categories" :key="'category-' + index">
                                        {{ $category.name}}
                                    </option>
                                </select>
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
                                <select name="filter_bill_tagid" id="filter_bill_tagid"
                                    class="form-control form-control-sm select2-basic select2-multiple select2-hidden-accessible"
                                    multiple="multiple" tabindex="-1" aria-hidden="true">
                                    <option v-for="(tag, index) in this.tags" :key="'tag-' + index">
                                        {{ $tag.name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>


                <!--buttons-->
                <div class="buttons-block">
                    <button type="button" name="foo1"
                        class="btn btn-rounded-x btn-secondary js-reset-filter-side-panel">Reset</button>
                    <input type="hidden" name="action" value="search">
                    <input type="hidden" name="source" :value="this.sourceForFilterPanels">
                    <button type="button"
                        class="btn btn-rounded-x btn-danger js-ajax-ux-request apply-filter-button"
                        :data-url="getURL('search')" data-type="form" data-ajax-type="GET">Apply Filter</button>
                </div>
            </div>
            <!--body-->
        </div>
    </form>
</div>
<!--sidebar-->
</template>

<script>
export default {
    name: 'SearchFilter',
    props: {
        module: {
            type: String,
            required: true,
        },
        url: {
            type: String,
            required: true,
        },
        sourceForFilterPanels: {
            type: String,
            required: false
        },
        categories: {
            type: Array,
            required: false
        },
        tags: {
            type: Array,
            required: false
        },
    },
    data() {
        return {
        }
    },
    methods: {
        getURL(string) {
            return `${this.url}/${this.module}/${string}`;
        },
    }
}
</script>