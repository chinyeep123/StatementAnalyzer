<template>
    <div>
        <portal to="title">
            <page-title icon="layer-group">Order - {{ order.number }}</page-title>
        </portal>

        <portal to="actions">
            <router-link :to="{name: 'order'}" class="button button--secondary">Go Back</router-link>
            <a v-if="order.downloadInvoiceUrl" :href="order.downloadInvoiceUrl" class="button">Download PDF</a>
        </portal>
		
        <form-container>
            
            <div class="card">
                <div class="card__body">
                    <div class="flex -mx-2">
                        <p-card classes="w-1/2 mx-2">
                            <p-card-header>Bill To</p-card-header>
                            
                            <p-card-body>
                                <spinner variant="black" v-if="editingBilling" />
                                <editable-contact v-else ref="editBilling" @save="saveContact('billing', $event)" v-model="order.billpayer" label=""></editable-contact>

                            </p-card-body>
                        </p-card>
                        <p-card classes="w-1/2 mx-2">
                            <p-card-header>Ship To</p-card-header>
                            
                            <p-card-body>
                                <spinner variant="black" v-if="editingShipping" />
                                <editable-contact v-else ref="editShipping" @save="saveContact('shipping', $event)" v-model="order.shippingContact" label=""></editable-contact>

                            </p-card-body>
                        </p-card>
                    </div>

                    <div>
                        <p-card>
                            <p-card-header>Ordered Items<a v-show="!editingItems" href="#" @click.prevent="editOrderItems" style="float:right">Edit</a></p-card-header>
                                <div class="mx-3" v-show="editingItems">
                                    <label>Add Product</label>
                                    <select2 class="mb-3" :endpoint="'/api/order-products'" @select="addProduct($event)" :settings="select2Settings"></select2>
                                </div>

                                <div class="table__wrapper mx-3 my-3">
                                    <table class="table table-auto">
                                        <tr>
                                            <th class="px-4 py-2 text-left">#</th>
                                            <th class="text-left px-4 py-2">Item</th>
                                            <th class="px-4 py-2">Price</th>
                                            <th class="px-4 py-2">Quantity</th>
                                            <th class="px-4 py-2">Subtotal</th>
                                        </tr>
                                        <tr v-for="(item, index) in order.items" :key="index">
                                            <td class="border px-4 py-2">{{ index + 1 }}</td>
                                            <td class="border px-4 py-2">
                                                <a v-show="editingItems" href="#" @click.prevent="removeProduct(index)"> X </a>
                                                {{ item.name }}
                                                
                                                <p-button v-if="item.properties && item.properties.length > 0" @click="openModal('product-properties-' + index)">Details</p-button>

                                                <p-modal :name="'product-properties-' + index" :title="'Properties - ' + (index + 1)" :key="index">
                                                    <div v-for="property in item.properties" class="flex">
                                                        <div class="w-1/2">{{ property.property.name }}</div>
                                                        <div class="w-1/2">{{ property.title }}</div>
                                                    </div>
                                                </p-modal>
                                            </td>
                                            <td class="border px-4 py-2 text-right">{{ price(item.convertedPrice) }}</td>
                                            <td class="border px-4 py-2 text-center">
                                                <div v-if="editingItems"><input min="1" style="max-width: 100px" v-model="item.quantity" type="number" /></div>
                                                <div v-else >{{ item.quantity }}</div>
                                            </td>
                                            <td class="border px-4 py-2 text-right">{{ editingItems ? price(item.quantity * item.convertedPrice) : price(item.convertedTotal) }}</td>
                                        </tr>

                                        <tr>
                                            <td colspan="4" class="text-right px-4 py-2 ">Subtotal</td><td class="text-right border px-4 py-2 ">{{ editingItems ? price(editingOrderTotal.subtotalInUserCurrency) : price(order.subtotalInUserCurrency) }}</td>
                                        </tr>
                                        <tr v-for="(charge, index) in order.charges" :key="index">
                                            <td colspan="4" class="text-right px-4 py-2 ">{{ charge.text }}</td><td class="text-right border px-4 py-2 ">{{ price(charge.convertedPrice) }}</td>
                                        </tr>
                                        <!-- <tr>
                                            <td colspan="4" class="text-right px-4 py-2 ">Shipping Charges</td><td class="text-right border px-4 py-2 ">{{ price(order.shipping_charges) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-right px-4 py-2 ">Discount</td><td class="text-right border px-4 py-2 ">{{ price(order.discount, 0) }}</td>
                                        </tr> -->

                                        <tr>
                                            <td colspan="4" class="text-right px-4 py-2 "><strong>Total</strong></td><td class="text-right border px-4 py-2 ">{{ editingItems ? price(editingOrderTotal.totalInUserCurrency) : price(order.totalInUserCurrency) }}</td>
                                        </tr>
                                    </table>

                                    <p-button class="button button--primary" v-show="editingItems" @click="saveOrderItems">Save</p-button>
                                    <p-button v-show="editingItems" @click="editingItems = false">Cancel</p-button>
                                </div>
                            <p-card-body>
                            </p-card-body>
                        </p-card>
                    </div>

                    <div>
                        <p-card>
                            <p-card-header>Notes</p-card-header>
                            <p-card-body>{{ defaultValue(order.notes, ' - ') }}</p-card-body>
                        </p-card>
                    </div>
                    
                    <div>
                        <p-card v-if="order.user">
                            <p-card-header>Customer</p-card-header>
                            <table class="table table-auto">
                                <tr><th class="text-left px-4 py-2">#</th><td>{{ order.user.id }}</td></tr>
                                <tr><th class="text-left px-4 py-2">Name</th><td>{{ order.user.name }}</td></tr>
                                <tr><th class="text-left px-4 py-2">Email</th><td>{{ order.user.email }}</td></tr>
                                <tr><th class="text-left px-4 py-2">Last login</th><td>{{ order.user.last_login_at }}</td></tr>
                                <tr><th class="text-left px-4 py-2">Status</th><td>{{ order.user.deleted_at == null && order.user.is_active ? 'Active' : 'Inactive' }}</td></tr>
                            </table>
                        </p-card>
                        <p-card v-else-if="order.billpayer && order.billpayer.email">
                            <p-card-header>Customer (Guest)</p-card-header>
                            <table class="table table-auto">
                                <tr><th class="text-left px-4 py-2">Email</th><td>{{ order.billpayer.email }}</td></tr>
                            </table>
                        </p-card>
                        <p-card>
                            <p-card-header>Payments</p-card-header>
                                <div class="table__wrapper mx-3 my-3">
                                    <table class="table table-auto">
                                        <tr>
                                            <th class="px-4 py-2 text-left">#</th>
                                            <th class="text-left px-4 py-2">Date</th>
                                            <th class="text-left px-4 py-2">Method</th>
                                            <th class="px-4 py-2">Currency</th>
                                            <th class="px-4 py-2">Price</th>
                                            <th class="px-4 py-2">Status</th>
                                        </tr>
                                        <tr v-for="(item, index) in order.payments">
                                            <td class="border px-4 py-2">{{ index + 1 }}</td>
                                            <td class="border px-4 py-2">{{ item.created_at }}</td>
                                            <td class="border px-4 py-2">{{ item.paymentMethod.name }}</td>
                                            <td class="border px-4 py-2 text-right">{{ item.currency }}</td>
                                            <td class="border px-4 py-2 text-right">{{ price(item.amount) }} ({{ item.displayAmount }})</td>
                                            <td class="border px-4 py-2 text-center">{{ item.status }}</td>
                                        </tr>
                                    </table>
                                </div>
                            <p-card-body>
                            </p-card-body>
                        </p-card>
                    </div>
                </div>
            </div>
            
            <template v-slot:sidebar>
                <div class="card">
                    <div class="card__body">
                        Delivery Tracking: 
                        <div v-if="order.tracking_number && !editingDeliveryTracking">
                            <h1>{{ order.tracking_number }}</h1>
                            <a v-show="!editingItems" href="#" @click="editingDeliveryTracking = true">Edit</a>
                        </div>
                        <after-ship @saved="afterSavedTracking" @cancel="editingDeliveryTracking = false" v-else :tracking-number="order.tracking_number" :order="id" v-model="order.deliveryTracking"></after-ship>
                    </div>
                </div>
                <div class="card">
                    <div class="card__body">
                        Status: 
                        <div v-if="!editingStatus">
                            <h1>{{ order.statusText }}</h1>
                            <a v-show="!editingItems" href="#" @click="editingStatus = true">Edit</a>
                        </div>
                        <update-status @cancel="editingStatus = false" @saved="afterSavedStatus" v-else :options="order.validStatuses" :order="id" v-model="order.status"></update-status>
                    </div>
                </div>
                <div class="card">
                    <div class="card__body">
                        Total Price: 
                        <h1>{{ order.displayTotal }}</h1>
                    </div>
                </div>
                <div class="card">
                    <div class="card__body">
                        <p>Shipping Method:<br/>
                        {{ optional(order.shippingMethod).name }}</p>
                        
                        <p>Shipping Charges:<br/>
                        {{ order.displayShippingCharges }}</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card__body">
                        Log:<br/>
                        <timeline v-if="order.statusHistory.length" color="#22c0e8" :timeline="toTimeline(order.statusHistory, {title: 'name', date: 'created_at', content: 'reason'})" />
                        <span v-else>No records</span>
                    </div>
                </div>
            </template>
        </form-container>
		
        <!--
		<div>
			<p-card>
				<pre>{{ order }}</pre>
				<p-button @click="this.load()">Load</p-button>
			</p-card>
		</div>

        -->
		
        <portal to="modals">
            <p-modal name="delete-matrix" title="Delete Matrix" key="delete_matrix">
                <p>Are you sure you want to permenantly delete this matrix?</p>

                <template slot="footer" slot-scope="matrix">
                    <p-button v-modal:delete-matrix @click="destroy(matrix.data.id)" theme="danger" class="ml-3">Delete</p-button>
                    <p-button v-modal:delete-matrix>Cancel</p-button>
                </template>
            </p-modal>
        </portal>
    </div>
</template>

<script>
    import helpers from '@/mixins/helpers'
    import modal from '@/mixins/modal'
    //import store from '../../store'
    import VueHead from 'vue-head'
    import Vue from 'vue'
    import Order from '@/services/Order'
    import UpdateStatus from '../../components/UpdateStatus'
    import AfterShip from '../../components/AfterShip'
    import Timeline from '../../components/Timeline'
    import Select2 from '../../components/Select2'
    import EditableContact from '../../components/EditableContact'
    import Spinner from 'fusioncms-helper-js/components/Spinner.vue'
    import ContactInput from '../../components/Contact'
    import AddressInput from '../../components/Address'

    Vue.use(VueHead)

    export default {
        mixins: [helpers, modal],
        components: {
            EditableContact,
            Select2,
            UpdateStatus,
            AfterShip,
            Timeline,
            Spinner,
        },
        head: {
            title() {
                return {
                    inner: 'Order'
                }
            }
        },

        data() {
            return {
                selectedValue: null,
				id: null,
				savedOrder: { items: [{convertedTotal: 0}] },
                editingOrder: null,
                endpoint: '/datatable/orders',
                editingStatus: false,
                editingItems: false,
                editingDeliveryTracking: false,
                editingBilling: false,
                editingShipping: false,
            }
        },
        mounted() {
			this.id = this.$route.params.order;
			
			this.load();
		},

        computed: {
            order() {
                return this.editingItems ? this.editingOrder : this.savedOrder
            },
            editingOrderTotal() {
                var subtotal = 0
                this.order.items.forEach((item) => {
                    subtotal += item.convertedPrice * item.quantity
                })
                return {
                    subtotal: subtotal,
                    total: subtotal - this.order.discount + this.order.shipping_charges,
                }
            },
        },

        methods: {
			load(id) {
				Order.get(this.$route.params.order).then((response) => {
					this.savedOrder = response.data.data
				}).catch((error) => {
                    toast(error.response.data.message, 'danger')
                })
			},
            destroy(id) {
                Order.delete(this.$route.params.order).then((response) => {
                    toast('Order successfully deleted', 'success')
                }).catch((error) => {
                    toast(error.response.data.message, 'danger')
                })
            },
            afterSavedStatus(order) {
                this.editingStatus = false
                this.order.statusText = order.statusText
                this.order.statusHistory = order.statusHistory
            },
            afterSavedTracking(order) {
                this.editingDeliveryTracking = false
                this.order.tracking_number = order.tracking_number
            },
            toTimeline(data, aliases) {
                return data.map((item, key) => {
                    var timelineItem = {};

                    Object.keys(aliases).forEach((from) => {
                        var to = aliases[from]
                        timelineItem[from] = item[to]
                    }) 
                    return timelineItem
                })
            },
            editOrderItems() {
                this.editingOrder = this.clone(this.order)
                this.editingItems = true
            },
            saveContact(contactType, contact) {
                if (contactType == 'billing') {
                    this.editingBilling = true
                } else {
                    this.editingShipping = true
                }
                Order.updateContact(this.$route.params.order, contactType, contact).then((response) => {
                    this.savedOrder = response.data.data

                    if (contactType == 'billing') {
                        this.editingBilling = false
                    } else {
                        this.editingShipping = false
                    }
                    toast('Address is successfully saved.', 'success')
				}).catch((error) => {
                    if (contactType == 'billing') {
                        this.editingBilling = false
                        this.$nextTick(() => this.$refs.editBilling.showEdit())
                    } else {
                        this.editingShipping = false
                        this.$nextTick(() => this.$refs.editShipping.showEdit())
                    }
                    toast(error.response.data.message, 'danger')
                })
            },
            saveOrderItems() {
                Order.updateItems(this.$route.params.order, this.editingOrder.items).then((response) => {
                    this.savedOrder = response.data.data
                    this.editingItems = false
                    toast('Order items is successfully saved.', 'success')
				}).catch((error) => {
                    toast(error.response.data.message, 'danger')
                })
            },
            addProduct(value) {
                this.selectedValue = value
                var product = value.product

                this.editingOrder.items.push({
                    product_id: product.id,
                    price: product.price,
                    currency: product.currency,
                    name: product.name,
                    convertedPrice: product.convertedPrice,
                    convertedTotal: product.convertedPrice * 1,
                    quantity: 1,
                    properties: [],
                })
            },
            removeProduct(index) {
                this.editingOrder.items.splice(index, 1)
            }
        }
    }
</script>