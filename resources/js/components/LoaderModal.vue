<template>
    <div v-if="loading"><!-- use v-show will cause the whole page not scrollable -->
        <p-modal name="loader-modal" title="" key="loader_modal">
            <template slot="header">&nbsp;</template>

            <div class="flex justify-center items-center">
                <spinner variant="black" />
            </div>
    
            <template slot="footer">&nbsp;</template>
        </p-modal>
    </div>
</template>

<script>

import Spinner from 'fusioncms-helper-js/components/Spinner.vue'
import modal from 'fusioncms-helper-js/mixins/modal'

export default {
    props: {
        loading: {

        }
    },
    mixins: [modal],
    components: { Spinner },
    mounted() {
        this.openModal('loader-modal')
    }
}
</script>

<style>

</style>