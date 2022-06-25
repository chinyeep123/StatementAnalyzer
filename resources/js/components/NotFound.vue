<template>
    <div class="table-responsive list-table-wrapper">
        <!--nothing found-->
        <div class="page-notification">
            <img src="public/images/no-results-found.png" alt="404"> 
                <!--sepcified-->
            <div class="title">Oops - No records were found</div>
            
                <!--generic-->
            <div class="sub-title">Try a difference search</div>
        </div>            
        <!--nothing found-->
    </div>
</template>

<script>
export default {
    name: 'NotFound',
    props: {
        variant: {
        },
        text: {
        },
        containerClass: {

        }
    },
    computed: {
    }
}
</script>