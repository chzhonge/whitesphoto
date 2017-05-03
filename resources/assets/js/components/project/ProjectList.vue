<template>
    <div class="container">
        <div class="row">
            <item v-for="subProjectData in projectData" v-bind:itemData="subProjectData" ></item>
        </div>
    </div>
</template>

<script>
    import Item from '../item/Item.vue';

    export default {
        name: '',
        props:['projectData'],
        data () {
            return {

            }
        },
        computed: {

        },
        mounted () {

        },
        destroyed() {

        },
        methods: {

        },
        components: {
            Item
        },
    }
</script>

<style>

</style>