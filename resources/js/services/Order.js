export default {
    endpoint: {
        show: '/api/orders/{order}',
        delete: '/api/matrices/{order}',
        updateStatus: '/api/order/{order}/update-status',
        updateTracking: '/api/order/{order}/update-tracking-number',
        updateItems: '/api/order/{order}/update-items',
        updateContact: '/api/order/{order}/update-contact/{type}',
    },
    get(id) {
        var url = this.endpoint.show
            .replace('{order}', id)

        return axios.get(url)
    },
    delete(id) {
        var url = this.endpoint.delete
            .replace('{order}', id)

        return axios.delete(url)
    },
    updateStatus(id, status, note, should_notify) {
        var url = this.endpoint.updateStatus
            .replace('{order}', id)
        return axios.patch(url, {status: status, note: note, should_notify: should_notify})
    },
    updateTracking(id, tracking_number, courier) {
        var url = this.endpoint.updateTracking
            .replace('{order}', id)
        return axios.patch(url, {tracking_number: tracking_number, courier: courier})
    },
    updateItems(id, items) {
        var url = this.endpoint.updateItems
            .replace('{order}', id)
        return axios.patch(url, {items: items})
    },
    updateContact(id, contactType, contact) {
        var url = this.endpoint.updateContact
            .replace('{order}', id)
            .replace('{type}', contactType)
        return axios.patch(url, {contact: contact})
    }
}