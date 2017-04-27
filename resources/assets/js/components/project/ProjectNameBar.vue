<template lang="html">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form role="form" class="form-inline" style="margin-bottom: 20px;">
                    <button type="button" v-on:click="showAddProjectNameBar" class='btn btn-primary btn-lg'>
                    建立作品集
                    </button>
                    <transition name="fade">
                        <div style='display:inline;' v-show="projectNameBarVisible">
                            <div class="form-group" v-show="projectNameBarVisible">
                                <label >作品集名稱</label>
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
       <!--<router-view></router-view>-->
    </div>
</template>

<script>

const createProjectNameURL = 'http://localhost/whitesphoto/public/test';

import { router } from '../../app';

export default {
    name:'ProjectNameBar',
    data () {
        return {
            projectNameBarVisible:false,
            projectName:''
        }
    },
    computed: {

    },
    mounted () {},
    methods: {
        showAddProjectNameBar:function() {
            this.projectNameBarVisible = true;
        },
        createNewProject:function() {
            this.projectNameBarVisible = false;

            axios.get(createProjectNameURL)
                .then(function (response) {
                    swal("Here's a message!");
                    console.log(response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        cancelCreateNewProject:function() {
            this.projectNameBarVisible = false;
        },
        changeViewToUploadView:function() {
        // TODO to laravel router make

        }
    }
}
</script>

<style lang="css">
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s
}
.fade-enter, .fade-leave-active {
    opacity: 0
}
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
