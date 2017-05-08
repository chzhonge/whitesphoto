<template>
    <div class="container">
        <div class="row">
            <div v-if="modal" class="overlay" v-on:click="closeModelMenu"></div>
            <div v-if="modal" class="modal-box tab-list">
                <!--<div>-->
                    <!--<ul class="nav nav-tabs">-->
                        <!--<li><a>選項一</a></li>-->
                    <!--</ul>-->
                <!--</div>-->
                <div class="row">
                    <tab v-for="image in images"
                         v-bind:imageData="image"
                         v-bind:selectedCover="selectedCover"
                         v-bind:selectedProjectID="selectedProjectID"
                         v-on:focusThis="focusThis"
                    >
                    </tab>
                </div>
                <div class="form-group text-center clear-line-height">
                    <button type="button" class='btn btn-success btn-lg'
                            style="width:49%;" v-on:click="changeProjectCover"
                    >確定</button>
                    <button type="button" class='btn btn-danger btn-lg'
                            style="width:49%;" v-on:click="closeModelMenu"

                    >取消</button>
                </div>
            </div>
            <item v-for="subProjectData in projectData"
                  v-bind:itemData="subProjectData"
                  v-bind:selectedProjectID="selectedProjectID"
            >
            </item>
        </div>
    </div>
</template>

<script>
    import Tab from '../tab/v2/Tab.vue';
    import Item from '../item/Item.vue';
    import { PROJECT_URL } from '../api';
    import Vuex from 'vuex';

    export default {
        name: '',
        props:['userID'],
        data () {
            return {
                selectedCover:null
            }
        },
        computed:{
            ...Vuex.mapGetters(['projectData','selectedProjectID','modal','images','breadcrumb'])
        },
        mounted() {
            this.getProjectData();
        },
        destroyed() {

        },
        methods: {
            ...Vuex.mapActions(['getProjectData']),
            ...Vuex.mapMutations(['selectedProjectID'])
            ,
            closeModelMenu:function() {
                this.$store.commit('modal' , false);
            },
            changeProjectCover:function () {
                let self = this;
                axios.post(PROJECT_URL+'/updateCover',{
                    imageID : this.selectedCover,
                    projectID : this.selectedProjectID
                }).then((response) => {
                    self.closeModelMenu();
                    self.getProjectData();
                    swal("封面更改成功！", "", "success");
                }, (err) => {
                    console.log(err)
                })
            },
            updateCover:function() {
                this.closeModal();
                this.getProjectData();
            },
            focusThis:function (id) {
                this.selectedCover = id;
            }

        },
        components: {
            Item,
            Tab
        },
    }
</script>

<style>
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background-color: rgba(0,0,0,0.5);
        z-index: 10;
    }

    /* just some content with arbitrary styles for explanation purposes */
    .modal-box {
        width: 75%;
        height: 75%;
        line-height: 200px;
        position: fixed;
        top: 25%;
        left: 13%;
        margin-top: -100px;
        background-color: #ffffff;
        border-radius: 10px;
        border: 5px solid #CCE2FF;
        text-align: center;
        z-index: 11; /* 1px higher than the overlay layer */
    }
    .tab-list {
        overflow-y: scroll;
        overflow-x: hidden;
    }
</style>