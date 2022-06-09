<template>
    <div>
        <div v-if="editing">
            <contact-input v-model="editingContact" label=""></contact-input>
            
            <p-button @click="save" class="button button--primary">Save</p-button>
            <p-button @click="editing = false">Cancel</p-button>
        </div>

        <div v-else-if="contact" >
            <div>
                <h3>{{ contact.organization_name }}</h3>
            </div>
            <div>
                <h3>{{ contact.lastname}} {{ contact.firstname }}</h3>
            </div>
            <address>
                {{ optional(contact.address).fullAddress }}
            </address>

            <p-button @click="editing = true">Edit</p-button>
        </div>

        <div v-else >
            <p-button @click="editing = true">Edit</p-button>
        </div>
    </div>
</template>

<script>
import ContactInput from './Contact'
import helpers from 'fusioncms-helper-js/mixins/helpers'

export default {
    mixins: [helpers],
    components: {
        ContactInput,
    },
    props: {
        label: {

        },
        value: {
            default: {}
        },
    },
    watch: {
        value(value) {
            this.editingContact = value
            this.contact = value
        },
        contact(value) {
            this.$emit('input', value)
        }
    },
    data() {
        return {
            editing: false,
            saving: false,
            contact: this.value,
            editingContact: this.value,
        }
    },
    mounted() {
        if (this.value) {
            this.editingContact = this.value
            this.contact = this.value
        }
    },
    methods: {
        showEdit() { // Needed as will be called by parent component
            this.editing = true
        },
        save() {
            this.saving = true
            this.editing = false
            this.$emit('save', this.editingContact)
        }
    }
}
</script>

<style>

</style>