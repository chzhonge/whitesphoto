<template>
    <div class="container">
        <div class="row">
            <ol class="breadcrumb breadcrumb-zh">
                <li v-for="(bread, index) in breadcrumb">
                    <router-link  :to="bread.path">
                        <span v-on:click="routerPopPath(bread.name, index+1)">{{ bread.name }}</span>
                    </router-link>
                    <!--<a to=="/example" v-bind:class="{ active: fillBreadCrumbClass(index), 'gray-font': !fillBreadCrumbClass(index) }">{{ bread.name }}</a>-->
                    <!--<router-link v-bind:class="{ active: fillBreadCrumbClass(index), 'gray-font': !fillBreadCrumbClass(index) }" :to="bread.path">{{ bread.name }}</router-link>-->
                </li>
            </ol>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form role="form" class="form-inline" style="margin-bottom: 20px;">
                    <button type="button" v-on:click="showAddProjectNameBar" class='btn btn-primary btn-lg'>
                        建立收藏冊
                    </button>
                    <transition name="fade">
                        <div style='display:inline;' v-show="projectNameBarVisible">
                            <div class="form-group" v-show="projectNameBarVisible">
                                <label >收藏冊名稱：</label>
                                <input class='form-control' v-model="projectName" type="text">
                            </div>
                            <div class="form-group" v-show="projectNameBarVisible">
                                <button type="button" v-on:click="createNewProject" v-bind:disabled="!projectName" class='btn btn-success'>
                                    確定
                                </button>
                                <button type="button" v-on:click="cancelCreateNewProject" class='btn btn-default'>
                                    取消
                                </button>
                            </div>
                        </div>
                    </transition>
                    <!--TODO extract Upload.vue -->
                    <div class="form-group" v-show="!projectNameBarVisible">
                        <button type="button" v-on:click="changeViewToUploadView" class='btn btn-primary btn-lg'>
                            上傳作品
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <router-view :userID="userID"  ></router-view>
            <!--v-on:pushOrPopBreadcrumb="checkActionTypeToAddOrRemove"-->
            <!--<router-view :projectData="projectData"  v-on:pushOrPopBreadcrumb="checkActionTypeToAddOrRemove" ></router-view>-->
        </div>
    </div>
</template>

<script>
    import { router } from '../../app';
    import { PROJECT_URL } from '../api';
    import Vuex from 'vuex';

    export default {
        name: 'Breadcrumb',
        data () {
            return {
                projectNameBarVisible:false,
                projectName:'',
//                breadcrumb:[{"name":'Home','path':'/'}]
            }
        },
        props:['userID'],
        computed: {
            ...Vuex.mapGetters(['breadcrumb'])
        },
        mounted () {

        },
        methods: {
            ...Vuex.mapMutations(['breadcrumb']),
            ...Vuex.mapActions(['getProjectData']),
            routerPopPath:function (name, index) {

                if (Object.keys(this.breadcrumb).length > index ) {

                    if (name === 'Home') {
                        return;
                    }
                    console.log('pop:'+name);
                    let viewName = '';
                    let action = 'pop';
                    let viewUrl = '';
                    this.$store.commit('breadcrumb' , {viewName,action,viewUrl});
                }
            },
            showAddProjectNameBar:function() {
                this.projectNameBarVisible = true;
            },
            createNewProject:function() {
                let self = this;
                this.projectNameBarVisible = false;
                axios.post(PROJECT_URL, {
                    ownerID: this.userID,
                    name: this.projectName
                })
                .then(function (response) {
                    console.log(response);
                    self.getProjectData();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cancelCreateNewProject:function() {
                this.projectNameBarVisible = false;
            },
//            fillBreadCrumbClass:function (index) {
//                if (this.checkBreadCrumbLengthIsOne()) {
//                    return false;
//                }
//                if (Object.keys(this.breadcrumb).length-1 > index) {
//                    return true;
//                }
//                return false;
//            },
//            checkBreadCrumbLengthIsOne:function () {
//                return (Object.keys(this.breadcrumb).length === 1) ? true : false;
//            },
//            checkActionTypeToAddOrRemove:function (actionType, viewName, viewUrl) {
//                if (actionType == 'push') {
//                    this.breadcrumb.push({"name":viewName,"path":viewUrl});
//                } else {
//                    this.breadcrumb.pop();
//                }
//            },
            changeViewToUploadView:function() {
                router.push({ path: '/upload' });
            },

        },
        components: {},
    }
</script>

<style>
    .breadcrumb-zh {
        background-color: #ffffff;
    }
    .gray-font {
        color: #777;
        /*cursor:text;*/
        text-decoration:none;
    }
    .gray-font:hover {
        text-decoration:none;
    }
</style>
