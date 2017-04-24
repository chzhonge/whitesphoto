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
                                <button type="button" v-on:click="createProject" v-bind:disabled="!projectName" class='btn btn-success'>
                                確定
                                </button>
                                <button type="button" v-on:click="cancelProject" class='btn btn-default'>
                                取消
                                </button>
                            </div>
                        </div>
                    </transition>
                    <div class="form-group" v-show="!projectNameBarVisible">
                        <button type="button" v-on:click="changeViewToUploadView" class='btn btn-primary btn-lg'>
                            上傳作品
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>


export default {
    name:'ProjectNameBar',
    data () {
        return {
        projectNameBarVisible:false,
        projectName:''
        }
    },
    computed: {},
    mounted () {},
    methods: {
        showAddProjectNameBar: function() {
            this.projectNameBarVisible = true;
        },
        createProject: function() {
            this.projectNameBarVisible = false;
            swal("Here's a message!");
        },
        cancelProject: function() {
            this.projectNameBarVisible = false;
        },
        changeViewToUploadView: function() {

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

</style>
