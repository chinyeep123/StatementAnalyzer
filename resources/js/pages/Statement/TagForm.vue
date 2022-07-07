<template>
    <div>
        <Modal 
        modalID="tag-modal"
        :title="title"
        :show="show"
        @close="close"
        @submit="onSubmit">
            <template #body>
                <!-- parent id -->
                <div class="form-group row">
                    <label class="col-sm-12 col-lg-3 text-left control-label col-form-label">Parent</label>
                    <div class="col-sm-12 col-lg-9">
                        {{ tag.parent? tag.parent.name : "" }}
                        <Select2 
                            id="parent_id"
                            name="parent_id"
                            v-model="tag.parent_id" 
                            :settings="{ ajax: ajaxParent, width: '100%', dropdownParent: '#tag-modal' }"  
                        />
                    </div>
                </div>

                <!-- name -->
                <div class="form-group row">
                    <label class="col-sm-12 col-lg-3 text-left control-label col-form-label required">Name*</label>
                    <div class="col-sm-12 col-lg-9">
                        <input type="text" name="name" class="form-control form-control-sm" :class="{'error' : errors.has('name')}"
                            id="name" autocomplete="off" placeholder="" aria-invalid="true"
                            v-model="tag.name">
                        <span class="text-bold text-danger" v-if="errors.has('name')" v-text="errors.get('name')"></span>
                    </div>
                </div>

                <!--notes-->
                <div class="row">
                    <div class="col-12">
                        <div><small><strong>* Required</strong></small></div>
                    </div>
                </div>
            </template>  
        </Modal>
    </div>
</template>

<script>
    import Errors from '../../mixins/Errors';
    import Modal from '../../components/Modal.vue';
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
            initialTag: {
                type: Object,
                required: true,
                default: [],
            },
        },
        components: { 
            Modal,
            Select2,
        },
        data() {
            return {
                title: "Create Tag",
                tag: {
                    id: "",
                    name: "",
                    parent_id: 0,
                },
                ajaxParent: {
                    url: `/feed/${this.settings.module_tag}/all`,
                    data: params => {
                        return {
                            term: params.term,
                        };
                    },
                    processResults: function (data) {
                    // Tranforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data.map(x => {return {id:x.id, text: x.value}})
                    };
                    }
                },
                errors: new Errors(),
            }
        },
        methods: {
            close: function() {
                this.tag = {
                    id: "",
                    name: "",
                    parent_id: 0,
                };
                this.errors= new Errors()
                this.$emit('close')
            },
            onSubmit() {   
                NProgress.start();
                if(_.isNumber(this.tag.id)) {
                    axios
                    .patch(`${this.settings.module_tag}/${this.tag.id}`, this.tag)
                    .then(response => {
                        NX.notification({
                            type: 'success',
                            message: response.data.message
                        });
                        this.$emit('close')
                        location.reload();
                    })
                    .catch(error => {
                        this.errors.record(error.response.data.errors);
                        NX.notification({
                            type: 'error',
                            message: error.response.data.message
                        });
                    })
                    .then(function () {
                        NProgress.done();
                    });
                } else {
                    axios
                    .post(`${this.settings.module_tag}`, this.tag)
                    .then(response => {
                        NX.notification({
                            type: 'success',
                            message: response.data.message
                        });
                        this.$emit('close')
                        location.reload();
                    })
                    .catch(error => {
                        this.errors.record(error.response.data.errors);
                        NX.notification({
                            type: 'error',
                            message: error.response.data.message
                        });
                    })
                    .then(function () {
                        NProgress.done();
                    });
                }
            },
        },
        watch: {
            initialTag: function(newVal) {
                if(!_.isEmpty(newVal)) 
                {
                    console.log(newVal)
                    this.title ='Edit Tag';
                    this.tag = {...newVal};
                }
            },
            tag: function(newVal) {
                this.$emit('tagUpdated', newVal);
            },
        },
    }
</script>
