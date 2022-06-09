<template>
    <div>
        <div v-if="loading">
            <spinner container-class="inline-flex justify-center w-full border p-4" variant="black" text=""/>
        </div>
        <div v-else >
            <span v-if="courierOptions">
                Courier:
                <p-select :options="dropdown(courierOptions, 'name', 'slug')" v-model="selectedCourier" :error-message="_.first(errors.courier)" name="courier"></p-select>
            </span>
            <p-input placeholder="Tracking Number" v-model="newTrackingNumber" :error-message="_.first(errors.tracking_number)" name="tracking_number"></p-input>
            <p-button @click="submit" class="button button--primary" theme="primary" color="dark">Save</p-button>
            <p-button @click="cancel" color="dark">Cancel</p-button>
        </div>
    </div>
</template>

<script>
import Order from '../services/Order'
import helpers from '../mixins/helpers'
import Spinner from './Spinner'

export default {
    mixins: [helpers],
    props: {
        trackingNumber: {
            
        },
        order: {

        },
        couriers: {

        }
    },
    components: {
        Spinner,
    },
    data() {
        return {
            newTrackingNumber: this.trackingNumber,
            selectedCourier: null,
            courierOptions: this.couriers,
            loading: false,
            errors: {},
        }
    },
    watch: {
    },
    computed: {
    },
    mounted() {
        if (!this.couriers || this.couriers.length == 0) {
            this.loading = true
                
            axios.get('/api/couriers').then((response) => {
                this.loading = false
                
                this.courierOptions = response.data
            }).catch((error) => {
                this.loading = false
                toast('failed', error.message)
            })
        }
    },
    methods: {
        cancel() {
            this.$emit('cancel');
        },
        submit() {
            Order.updateTracking(this.order, this.newTrackingNumber, this.selectedCourier).then((response) => {
                var order = response.data.data
                this.$emit('input', order.tracking_number);
                this.$emit('saved', order)
                // setTimeout(() => {
                //     this.selected = false;
                // }, 100);
                
                toast('Successfully update order tracking number', 'success')
                // setTimeout(() => {
                //     this.selected = response.data.status;
                // }, 200)
                
            }).catch((error) => {
                this.errors = error.response.data.errors
                toast('Failed to update order tracking number', 'error')
            })
        }
    }
}
</script>

<style>
</style>