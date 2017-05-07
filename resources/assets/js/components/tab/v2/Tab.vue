<template>
    <div class="col-md-3">
        <img class="img-responsive img-thumbnail tab-clear"
             v-bind:class="{ 'tab-seleted':clicked }" :src="imageData.thumPath" v-on:click="focusThis" >
    </div>
</template>

<script>

    import { router } from '../../../app';

    export default {
        name: 'Tab',
        props:['imageData','selectedProjectID','selectedCover'],
        data () {
            return {

            }
        },
        computed: {
            clicked:function() {
                if (this.selectedCover !== this.imageData.id) {
                    return false;
                }
                else {
                    return true;
                }
            }
        },
        mounted () {

        },
        destroyed() {

        },
        methods: {
            focusThis:function() {
                this.$emit('focusThis', this.imageData.id);
            }
        },
        components: {},
    }
</script>

<style>
    .tab-seleted {
        box-shadow: 0 0 0 5px #2185d0;
        -webkit-box-shadow: 0 0 0 5px #2185d0;
    }
</style>