<template>
    <div v-bind:data-id="image.id" class="col-md-3 height-limit" >
        <div v-bind:data-id="image.id"
             class="image-item">
            <a>
                <div v-on:click="showImage">
                    <img v-bind:src="image.thumPath"
                         v-bind:data-name="image.title"
                         class="img-responsive img-thumbnail"
                    >
                </div>
            </a>
            <div class="image-item-info">
                <div class='image-item-title'>
                    <router-link  v-bind:to="url">{{image.title}}</router-link>
                </div>
                <div class='image-item-author'>
                    {{image.author}}
                </div>
                <div class="image-item-updated">
                    {{image.updated_at}}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { router } from '../../app';

    export default {
        name: 'Image',
        props: ['image'],
        data () {
            return {
                url :'/projects/'+this.image.projectID+"/"+this.image.id
            }
        },
        computed: {},
        mounted () {

        },
        destroyed() {

        },
        methods: {
            showImage:function() {
                router.push('/projects/'+this.image.projectID+"/"+this.image.id);
            }
        },
        components: {},
    }
</script>

<style>
    .image-item {
        display: inline-block;
        position: relative;
        margin: 5px 5px;
        font-size: 12px;
        text-align: left;
        line-height: 1;
        color: #555;
    }

    .image-item-info {
        height: 60px;
    }
    .image-item-title {
        font-weight: bold;
        font-size: 18px;
        padding-left: 5px;
    }
    .image-item-author {
        padding-top: 5px;
        font-size: 15px;
        padding-left: 5px;
    }

    .image-item-updated {
        text-align: right;
        margin-top: 7px;
        margin-right: 5px;
    }

</style>