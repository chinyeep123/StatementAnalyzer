<template>
    <div>
        <portal to="title">
            <page-title icon="layer-group">Order</page-title>
        </portal>

		<!--
        <portal to="actions">
            <router-link :to="{ name: 'matrices.create' }" class="button">Create Matrix</router-link>
        </portal>
		-->
		
        <div class="row">
            <div class="content-container">
                <p-table :endpoint="endpoint" id="orders" sort-by="created_at" sort-in="desc" primary-key="id" key="orders_table">
                    <template slot="number" slot-scope="table">
                        <div class="flex items-center">
							<!--
                            <p-status :value="table.record.status" class="mr-2"></p-status>
							--> 
                            <router-link :to="{ name: 'order.show', params: {order: table.record.number} }">{{ table.record.number }}</router-link>
                        </div>
                    </template>

                    <template slot="totalInUserCurrency" slot-scope="table">
                        {{ table.record.displayTotal }}
                    </template>

                    <template slot="type" slot-scope="table">
                        <span class="badge">{{ table.record.type }}</span>
                    </template>

                    <template slot="description" slot-scope="table">
                        <span class="text-gray-800 text-sm">{{ table.record.description }}</span>
                    </template>

					
                    <template v-if="hasActions" slot="actions" slot-scope="table">
                        <p-actions :id="'order_actions'" :key="'order_actions'">
                            <p-dropdown-link v-if="parse(button.visible, table, true)" @click="processApi(button.api, table)" v-for="(button, key) in meta.buttons.line" :to="button.route" :key="key">{{ parseLabel(button.label, table) }}</p-dropdown-link>

                            <!-- <p-dropdown-link
                                @click.prevent
                                v-modal:delete-matrix="table.record"
                                classes="link--danger"
                            >
                                Delete
                            </p-dropdown-link> -->
                        </p-actions>
                    </template>
					
                </p-table>
            </div>
        </div>

        <portal to="modals">
            <loader-modal :loading="loading" />
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
    import admin from 'fusioncms-helper-js/mixins/admin-layout'
    //import store from '../../store'
    import LoaderModal from '../../components/LoaderModal.vue'

    export default {
        mixins: [admin],
        components: { LoaderModal },
        head: {
            title() {
                return {
                    inner: 'Order'
                }
            }
        },

        data() {
            return {
                meta: {},
                loading: false,
                endpoint: '/datatable/orders',
            }
        },
        computed: {
            hasActions() {
                console.log('meta', this.meta)
                return true
                return this.meta.buttons
            }
        },

        methods: {
            destroy(id) {
                axios.delete('/api/matrices/' + id).then((response) => {
                    //store.dispatch('navigation/fetchAdminNavigation')

                    //toast('Matrix successfully deleted.', 'success')

                    //bus().$emit('refresh-datatable-matrices')
                })
            }
        },

        beforeRouteEnter(to, from, next) {
            axios.get('/api/order/meta').then((response) => {
                next(function(vm) {
                    vm.meta = response.data.data

                    vm.$emit('updateHead')
                })
            }).catch(function(error) {
                next('/')
                toast('The requested meta data could not be found', 'warning')
            })
        },

        beforeRouteUpdate(to, from, next) {
            axios.get('/api/order/meta').then((response) => {
                this.meta = response.data.data

                this.$emit('updateHead')
            })

            next()
        }
    }
</script>
