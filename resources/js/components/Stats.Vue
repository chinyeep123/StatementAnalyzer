<template>
    <div 
        class="stats-wrapper" 
        :id="moduleName + '-stats-wrapper'"
        v-show="show"
    >
        <!--WIDGET NOTES: stats displayed on top of result tables and list pages-->
        <div class="card-group table-stats-cards" id="list-pages-stats-widget">
            <div v-for="(stat, index) in this.stats" class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h3 id="stats-widget-value-1">{{ stat.value }}</h3>
                                            <h6 class="card-subtitle" id="stats-widget-title-1">{{ stat.title }}</h6>
                                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div :class="'progress-bar ' + stat.color + ' h-px-4 w-100'" :id="'stats-widget-percentage-' + (index + 1)" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>    
    </div>
</template>

<script>
    export default {
        name: 'Stats',
        props: {
            moduleName: {
                type: String,
                required: true,
            },
            stats: {
                type: Array,
                required: true,
            },
            show: {
                type: Boolean,
                required: true,
                default: false,
            },
        },
        head: {
        },
        computed: {
        },

        methods: {
        },

    }
</script>
