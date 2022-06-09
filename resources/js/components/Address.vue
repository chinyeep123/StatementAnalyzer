<template>
    <div>
        <input placeholder="Address Line 1" :class="cssClass" v-model="address.address" />
        <input placeholder="Address Line 2" :class="cssClass" v-model="address.address2" />
        <input placeholder="City" :class="cssClass" v-model="address.city" />
        <input placeholder="State / Province" :class="cssClass" v-model="address.province_custom" />
        <input placeholder="Postcode" :class="cssClass" v-model="address.postalcode" />
        
        <p-select :name="'country_'+id" :id="'country_'+id" :options="countries" v-model="address.country_id" />
    </div>
</template>

<script>
export default {
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
    data() {
        return {
            address: this.value,
            countries: [],
        }
    },
    watch: {
        value(value) {
            this.address = value
        },
        address(value) {
            this.$emit('input', value)
        }
    },
    methods: {
        init() {
            this.loadCountries()
        },
        loadCountries() {
            axios.get('/api/country/list').then((response) => {
                this.countries = response.data.map((country) => {
                    return {
                        label: country.name,
                        value: country.id,
                    }
                })
            })
        }
    },
    mounted() {
        this.init()
    },
    computed: {
        id() {
            return this._uid
        },
        // field() {
        //     return { 
        //         // handle: 'billing', 
        //         name: this.label 
        //     }
        // }
    }
}
</script>

<style>

</style>