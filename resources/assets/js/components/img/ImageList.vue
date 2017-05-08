<template>
    <div class="container">
        <div class="row">
            <image-item v-for="image in images"

                        v-bind:image="image"></image-item>
        </div>
    </div>
</template>

<script>
    import { router } from '../../app';
    import { PROJECT_URL } from '../api';
    import Vuex from 'vuex';
    import ImageItem from './ImageItem.vue';

    export default {
        name: 'ImageList',
        props: [''],
        data () {
            return {
                images : [],
            }
        },
        computed: {
            ...Vuex.mapGetters(['selectedProjectID','selectedProjectName'])
        },
        mounted () {
            this.getImagesData();
            this.pushPath();
        },
        destroyed() {
            this.popPath();
        },
        methods: {
            ...Vuex.mapMutations(['breadcrumb']),
            pushPath:function () {
                let viewName = this.selectedProjectName;
                let action ='push';
                let viewUrl ='/projects/'+this.selectedProjectID;
                this.$store.commit('breadcrumb' , {viewName,action,viewUrl});
            },
            popPath:function () {
                let viewName = this.selectedProjectName;
                let action = 'pop';
                let viewUrl = '/projects/'+this.selectedProjectID;
                this.$store.commit('breadcrumb' , {viewName,action,viewUrl});
            },
            getImagesData:function () {
                let self = this;
                axios.get(PROJECT_URL+'/'+this.selectedProjectID).then((response) => {
                    self.images = response.data.data;
                }, (err) => {
                    console.log(err)
                })
            }
        },
        components: {
            ImageItem
        },
    }
</script>

<style>

</style>