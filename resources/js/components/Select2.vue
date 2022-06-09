<template>
    <div>
        <select2 class="mb-3" v-model="modelValue" @select="$emit('select', $event)" :settings="select2Settings"></select2>    
    </div>
</template>

<script>
import Select2 from 'v-select2-component'
export default {
    props: {
        value: {

        },
        endpoint: {
            
        },
        label: {
            default: 'text'
        },
    },
    components: {        
        Select2,
    },
    data() {
        return {
            modelValue: null
        }
    },
    watch: {
        modelValue() {
            this.$emit('input', this.modelValue)
        }
    },
    computed: {
        select2Settings() {
            var self = this;
            return {
                ajax: {
                    url: this.endpoint,
                    delay: 1000,
                    dataType: 'json'
                },
                minimumInputLength: 3,
                // templateResult(item) {
                //     return item[self.label]
                // },
                // templateSelection(item) {
                //     return 'SElected' + self.label + item[self.label]
                // }
            };
        }
    },
    mounted() {
    },
    methods: {
    }
}
</script>

<style>
    .select2-container { width: 100% !important; }
</style>