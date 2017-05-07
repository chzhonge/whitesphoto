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
            this.$emit('pushOrPopBreadcrumb', 'push', this.selectedProjectName, '/projects/'+this.selectedProjectID);
        },
        destroyed() {
            this.$emit('pushOrPopBreadcrumb', 'pop', this.selectedProjectName, '/projects/'+this.selectedProjectID);
        },
        methods: {
            getImagesData:function () {
                let self = this;
                axios.get(PROJECT_URL+'/'+this.selectedProjectID).then((response) => {
                    self.images = response.data.data;
                }, (err) => {
                    console.log(err)
                })
            },
            sendPath:function (actionType, viewName, viewUrl) {
//                this.$emit('pushOrPopBreadcrumb', actionType, viewName, viewUrl);
            }
        },
        components: {
            ImageItem
        },
    }
</script>

<style>

</style>