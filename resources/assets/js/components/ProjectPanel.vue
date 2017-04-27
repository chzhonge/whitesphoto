<template>
    <div>
        <breadcrumb></breadcrumb>
        <project-name-bar></project-name-bar>
        <!--<project-list></project-list>-->
        <router-view  ></router-view>
    </div>

</template>

<script>
    import Breadcrumb from './breadcrumb/Breadcrumb.vue';
    import ProjectNameBar from './project/ProjectNameBar.vue';
    import ProjectList from './project/ProjectList.vue';
    export default {
        name: 'ProjectPanel',
        data () {
            return {

            }
        },
        computed: {

        },
        mounted () {

        },
        methods: {

        },
        components: {
            Breadcrumb,
            ProjectNameBar,
            ProjectList
        },
    }
</script>

<style>

</style>