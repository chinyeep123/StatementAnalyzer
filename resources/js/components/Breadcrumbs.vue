<template>
    <div class="col-md-12 col-lg-5 align-self-center list-pages-crumbs" id="breadcrumbs">
        <h3 class="text-themecolor">{{ activeTab }}</h3>
        <!--crumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">App</li>
            <li class="breadcrumb-item" v-for="(tab, index) in this.tabs">
                {{ tab.name }}
            </li>
            
            <li class="breadcrumb-item  active active-bread-crumb ">{{ activeTab }}</li>
        </ol>
        <!--crumbs-->
    </div>
</template>

<script>
export default {
    name: 'Breadcrumbs',
    props: {
        tabs: {
            type: Array,
            required: false,
        },
        activeTab: {
            type: String,
            required: true,
        }
    },
    data() {
        return {
        }
    },
}
</script>