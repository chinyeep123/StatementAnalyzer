<template>
    <div>
        <input @input="onInput" placeholder="Last Name" :class="cssClass" v-model="lastname" />
        <input @input="onInput" placeholder="First Name" :class="cssClass" v-model="firstname" />
        <input @input="onInput" placeholder="Organization Name" :class="cssClass" v-model="organization_name" />
        <address-input @input="onInput" v-model="address" label=""></address-input>
    </div>
</template>

<script>
import AddressInput from './Address.vue'

export default {
    components: {
        AddressInput,
    },
    props: {
        label: {

        },
        value: {
            default: {}
        },
        cssClass: {
            default: 'field field--input'
        }
    },
    watch: {
        value(value) {
            if (value) {
                this.lastname = value.lastname
                this.firstname = value.firstname
                this.organization_name = value.organization_name
                this.address = value.address
            } else {
                this.lastname = null
                this.firstname = null
                this.organization_name = null
                this.address = null

            }
        },
    },
    data() {
        return {
            lastname: null,
            firstname: null,
            organization_name: null,
            address: {},
        }
    },
    methods: {
        onInput() {
            this.$emit('input', {
                lastname: this.lastname,
                firstname: this.firstname,
                organization_name: this.organization_name,
                address: this.address,
            })
        }
    },
    mounted() {
        if (this.value) {
            this.lastname = this.value.lastname
            this.firstname = this.value.firstname
            this.organization_name = this.value.organization_name
            this.address = this.value.address
        }
    }
}
</script>

<style>

</style>