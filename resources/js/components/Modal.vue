<template>
    <transition name="modal">
        <div class="modal-mask" v-show="show" :id="this.modalID">
            <div class="modal-container">
            
                <div class="modal-dialog"
                :class="{'modal-xl' : large}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal-label">{{ title }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" @click.prevent="$emit('close')">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <slot name="body"></slot>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" @click.prevent="$emit('close')">Close</button>
                            <button type="button" class="btn btn-rounded-x btn-danger waves-effect text-left" @click.prevent="$emit('on-submit')" v-show="this.submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </transition>
</template>
<script>
export default {
    name: 'Modal',
    props: {
        modalID: {
            type: String,
            required: true,
        },
        title: {
            type: String,
            required: false,
        },
        show: {
            type: Boolean,
            required: false,
        },
        large: {
            type: Boolean,
            required: false,
            default: false
        },
        submit: {
            type: Boolean,
            required: false,
            default: true
        },
    },
    data() {
        return {
        }
    },
    methods: {
        close: function() {
            this.$emit('close')
        }
    },
    computed: {
    },
    mounted: function () {
        document.addEventListener("keydown", (e) => {
            if (this.show && e.keyCode == 27) {
                this.close()
            }
        })
    },

}
</script>
