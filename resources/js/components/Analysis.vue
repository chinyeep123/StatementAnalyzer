<template>
    <div 
        class="analysis-wrapper" 
        :id="moduleName + '-analysis-wrapper'"
        v-show="show"
        v-if="Object.keys(this.analysis).length"
    >
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table m-t-0 m-b-0 table-hover no-wrap">
                            <thead>
                                <th>Tag</th>
                                <th>Money In</th>
                                <th>Money Out</th>
                            </thead>
                            <tbody>
                                <template v-for="(analyzer, index) in this.analysis">
                                    <tr :id="'analyzer'+ index">
                                        <td class="text-bold">{{ analyzer.name }}</td>
                                        <td>{{ getSumDebit(analyzer) }}</td>
                                        <td>{{ getSumCredit(analyzer) }}</td>
                                    </tr>
                                    <tr v-for="(child, index1) in analyzer.childs" :id="'analyzer'+ index + 'child-' + index1">
                                        <td>- {{ child.name }}</td>
                                        <td>{{ child.debit }}</td>
                                        <td>{{ child.credit }}</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</template>

<script>
    import _ from 'lodash';
    export default {
        name: 'Analysis',
        props: {
            moduleName: {
                type: String,
                required: true,
            },
            analysis: {
                type: [Object, Array],
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
            getSumDebit(analyzer) {
                return analyzer.childs? _.sumBy(analyzer.childs, 'debit') : analyzer.debit;
            },
            getSumCredit(analyzer) {
                return analyzer.childs? _.sumBy(analyzer.childs, 'credit') : analyzer.credit;
            }
        },

    }
</script>
