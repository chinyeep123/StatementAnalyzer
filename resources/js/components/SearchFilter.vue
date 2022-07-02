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
                <slot name="panel-body"></slot>
                <!--buttons-->
                <div class="buttons-block">
                    <button type="button" name="foo1"
                        class="btn btn-rounded-x btn-secondary js-reset-filter-side-panel" @click.prevent="$emit('reset')">Reset</button>
                    <input type="hidden" name="action" value="search">
                    <input type="hidden" name="source" :value="this.sourceForFilterPanels">
                    <button type="button"
                        class="btn btn-rounded-x btn-danger js-ajax-ux-request apply-filter-button"
                        @click.prevent="$emit('search')">Apply Filter</button>
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
        sourceForFilterPanels: {
            type: String,
            required: false
        },
    },
    data() {
        return {
        }
    },
    methods: {
    }
}
</script>