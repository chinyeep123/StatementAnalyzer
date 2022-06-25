class Errors {
    constructor() {
        this.errors = {};
    }

    has(field) {
        return this.errors.hasOwnProperty(field);
    }

    any() {
        return Object.keys(this.errors).length > 0;
    }

    get(field) {
        if (this.errors[field]) {
            return this.errors[field][0];
        }
    }

    record(errors) {
        return this.errors = errors;
    }

    clear(field) {
        console.log('message: ' + field); //<-- executed with a blank message
        delete this.errors[field]; //<-- not sure if this is working as expected
    }
}
export default Errors;