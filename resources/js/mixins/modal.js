
// import ConfirmModal from '../pages/Components/ConfirmModal'

export default {
    components: {
        // ConfirmModal,
    },
    methods: {
        closeModal(name) {
            //var name = 'price-setting-' + key
            this.$bus.$emit('toggle-modal-' + name)
        },
        openModal(name) {
            //var name = 'price-setting-' + key
            this.$bus.$emit('toggle-modal-' + name)
        },
        confirm(message, title) {
            let Dialog = Vue.extend(ConfirmModal)
            let dialog = new Dialog
            // let node = document.createElement('div')
            // document.querySelector('body').appendChild(node)

            // dialog.registeredViews = this.registeredComponents()

            // this.$root.$el.append(dialog.$el)

            alert('test dialog')
            dialog.$mount(this.$root)
            // this.$root.$mount()

            dialog.confirm(message)
        }
    },
}