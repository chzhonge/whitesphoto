<template>
    <div class="container">
        <div class="row">
            <!--<div v-if="modal" class="overlay" v-on:click="closeModal"></div>-->
            <!--<div v-if="modal" class="modal-box">-->
                <!--<Tab v-bind:selectedCollectionID="selectedCollectionID"-->
                     <!--v-on:cancelCover="closeModal" v-on:changeCover="updateCover">-->
                <!--</Tab>-->
            <!--</div>-->
            <item v-for="subProjectData in projectData"
                  v-bind:itemData="subProjectData"
                  v-bind:selectedProjectID="selectedProjectID"
                  v-on:editItemInfo="lockThisProject"
                  v-on:changeCover="showChangeCoverMenu"
                  v-on:itemStatusChange="reloadData"
            >
            </item>
        </div>
    </div>
</template>

<script>
    import Item from '../item/Item.vue';
    import { PROJECT_URL } from '../api';

    export default {
        name: '',
        props:['userID'],
        data () {
            return {
                modal:false,
                selectedProjectID:null,
                projectData:[]
            }
        },
        computed: {

        },
        mounted () {
            this.getAllProject();
        },
        destroyed() {

        },
        methods: {
            getAllProject:function () {
                let self = this;
                axios.get(PROJECT_URL)
                    .then(function (response) {
                        self.projectData = response.data.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            showChangeCoverMenu:function(projectID) {
                this.modal = true;
                console.log('showChangeCoverMenu');
                this.selectedProjectID = projectID;
            },
            closeModal:function() {
                this.modal = false;
                console.log('closeModal');
            },
            lockThisProject:function(projectID) {
                this.selectedProjectID = projectID;
                console.log('lockThisProject');
            },
            updateCover:function() {
                this.closeModal();
//                this.$emit('updateCover');
            },
            reloadData:function () {
                this.getAllProject();
            }
        },
        components: {
            Item
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
        left: 25%;
        margin-top: -100px;
        margin-left: -150px;
        background-color: #ffffff;
        border-radius: 10px;
        border: 5px solid #CCE2FF;
        text-align: center;
        z-index: 11; /* 1px higher than the overlay layer */
    }
</style>