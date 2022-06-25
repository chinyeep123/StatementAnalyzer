<template>
    <div class="modal" :id="this.id" role="dialog" data-backdrop="static" :aria-labelledby="this.id" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" :id="this.id + 'Label'">{{ title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" @click.prevent="$emit('on-close')">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <slot name="body"></slot>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" @click.prevent="$emit('on-close')">Close</button>
                <button type="button" class="btn btn-rounded-x btn-danger waves-effect text-left" @click.prevent="$emit('on-submit')">Submit</button>
            </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: 'Modal',
    props: {
        title: {
            type: String,
            required: true,
        },
        id: { 
            type: String,
            required: true,
        }
    },
    data() {
        return {
        }
    },
    methods: {
    },
    computed: {
    }
}
</script>