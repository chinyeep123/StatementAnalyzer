<template>
  <div>
      <p-select ref="selector" v-if="selected" @input="statusSelected" :value="value" :options="optionDropdown(options)" name="order-status" />
      <p-textarea v-model="note"></p-textarea>
      <p-checkbox
        v-model="should_notify"
        name="notify_customer"
        id="notify-customer">
            Notify Customer
      </p-checkbox>
      <p-button @click="submit" class="button button--primary" theme="primary" color="dark">Save</p-button>
      <p-button @click="cancel" color="dark">Cancel</p-button>
  </div>
</template>

<script>
import Order from '../services/Order'

export default {
    props: {
        value: {

        },
        order: {

        },
        options: {

        }
    },
    data() {
        return {
            should_notify: false,
            selected: this.value,
            note: '',
        }
    },
    watch: {
        value() {
            this.selected = this.value
        }
    },
    methods: {
        statusSelected(value) {
            this.$emit('input', value)  
        },
        optionDropdown(options) {
            return Object.keys(options).map((key) => {
                return {
                    value: key,
                    label: options[key],
                }
            })
        },
        cancel() {
            this.$emit('cancel');
        },
        submit() {
            Order.updateStatus(this.order, this.value, this.note, this.should_notify).then((response) => {
                var order = response.data.data
                this.$emit('input', order.status);
                this.$emit('saved', order)

                // @TODO: try to use $nextTick()
                // Reference: https://stackoverflow.com/questions/44607108/vuejs-components-using-scrollintoview
                setTimeout(() => {
                    this.selected = false;
                }, 100);
                
                toast('Successfully update order status', 'success')
                setTimeout(() => {
                    this.selected = response.data.status;
                }, 200)
                // this.$forceUpdate()
            }).catch((error) => {
                toast('Failed to update order status', 'error')
            })
        }
    }
}
</script>

<style>

</style>