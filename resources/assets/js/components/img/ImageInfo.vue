<template>
    <div class="container">
        <div class="row" v-if="!edit">
            <div class="col-md-3">
                <div class="form-group">
                    <div class="form-group">
                        <button type="button" class='btn btn-success'
                                v-on:click="backProject"
                        >返回</button>
                        <button type="button" class='btn btn-primary'
                                v-bind:disabled="!prevAble"
                                v-on:click="prevPhoto"
                        >前一張</button>
                        <button type="button" class='btn btn-primary'
                                v-bind:disabled="!nextAble"
                                v-on:click="nextPhoto"
                        >下一張</button>
                        <button type="button" class='btn btn-warning'
                                v-on:click="editPhoto"
                        >編輯</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" >
            <div class="col-md-12 col-lg-12">
                <img class="img-responsive img-thumbnaii" v-for="image in imageData" v-bind:src="image.rawPath" alt="" />
            </div>
        </div>

        <div class="panel" v-if="edit">
            <div class="panel-body">
                <div class="row"  >
                    <div class="col-md-12 col-lg-12">
                        <form role="form">
                            <div class="form-group">
                                <label>作品名稱</label>
                                <input v-model="image.title" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>作者姓名</label>
                                <input v-model="image.author" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>作品描述</label>
                                <textarea v-model="image.desc" class="form-control" rows="8" cols="40"></textarea>
                            </div>
                            <div class="form-group">
                                <label>儲存在哪一本作品集？</label>
                                <select class="form-control" v-model="image.selected" >
                                    <option v-bind:value="0">選擇作品集</option>
                                    <option v-for="(project, name) in projects" v-bind:value="project.id">{{ project.name }}</option>
                                </select>
                            </div>
                            <div class="form-group text-center">
                                <button type="button" class='btn btn-primary btn-lg'
                                        style="width:45%;"
                                        v-on:click="updatePhoto"
                                >確定</button>
                                <button type="button" class='btn btn-default btn-lg'
                                        style="width:45%;"
                                        v-on:click='cancelPhoto'
                                >取消</button>
                            </div>
                            <div class="form-group text-center">
                                <button type="button" class='btn btn-danger btn-lg btn-block'
                                        v-on:click="deletePhotoWarning"
                                >刪除</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="media" v-show="!edit" >
                    {{ image.updated_at }}
                    <div class="media-body">
                        <h4 class="media-heading">{{ image.title }} by {{ image.author }}</h4>
                        {{ image.desc }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { router } from '../../app';
    import { IMAGE_URL , PROJECT_URL } from '../api';
    import Vuex from 'vuex';

    export default {
        name: 'ImageInfo',
        props: [''],
        data () {
            return {
                imageData : null,
                projectID : null,
                imageIDList : null,
                selected : null,
                prevAble : true,
                nextAble : true,
                edit : false,
                backImage : null,
                image : {

                },
                projects : null,
                deleted:null
            }
        },
        computed: {
            ...Vuex.mapGetters(['selectedProjectID','selectedProjectName'])
        },
        mounted () {
            this.updateProjectName();
            this.getThisPhoto();
        },
        destroyed() {
            this.popPath();
        },
        methods: {
            updateProjectName:function () {
                let viewName = this.selectedProjectName;
                let action ='push';
                let viewUrl ='/projects/'+this.selectedProjectID;
                this.$store.commit('breadcrumb' , {viewName,action,viewUrl});
            },
            updateBreadcrumb:function () {
                let viewName = this.image.title;
                let action ='push';
                let viewUrl ='/projects/'+this.selectedProjectID+'/'+this.$route.params.imageID;
                this.$store.commit('breadcrumb' , {viewName,action,viewUrl});
            },
            popPath:function () {
                let viewName = this.selectedProjectName;
                let action = 'pop';
                let viewUrl = '/projects/'+this.selectedProjectID;
                this.$store.commit('breadcrumb' , {viewName,action,viewUrl});
            },
            getThisPhoto:function() {
                let imageID =this.$route.params.imageID;
                let self = this;
                axios.get(IMAGE_URL+'/info/'+imageID).then((response) => {
                    self.imageData = response.data.result;
                    self.image = response.data.result[0];
                    self.getProjectID();
                    self.getProjectData();
                    self.updateBreadcrumb();
                }, (err) => {
                    console.log(err)
                });
            },
            getProjectID:function() {
                let self = this;
                this.projectID = this.imageData[0].projectID;
                axios.get(IMAGE_URL+'/'+this.projectID+'/ids').then((response) => {
                    self.imageIDList = response.data.result;
                    console.log('he');
                    console.log(self.imageIDList);
                    self.selected = self.imageIDList.indexOf(self.imageData[0].id);
                    if (self.selected === -1 || self.selected === 0) {
                        self.prevAble = false;
                    }
                    if (self.selected === self.imageIDList.length-1 ) {
                        self.nextAble = false;
                    }
                }, (err) => {
                    console.log(err)
                });
            },
            getProjectData:function() {
                let self = this;
                axios.get(PROJECT_URL).then((response) => {
                   self.projects = response.data.data;
                }, (err) => {
                    console.log(err)
                })
            },
            backProject:function() {
                let _projectID = this.$route.params.id;
                this.popPath();
                router.push('/projects/'+_projectID);
            },
            nextPhoto:function() {
                this.popPath();
                router.push('/projects/'+this.imageData[0].projectID
                    +"/"+this.imageIDList[this.selected+1]);
                this.prevAble = true;
                this.nextAble = true;
                this.getThisPhoto();
            },
            prevPhoto:function() {
                this.popPath();
                router.push('/projects/'+this.imageData[0].projectID
                    +"/"+this.imageIDList[this.selected-1]);
                this.prevAble = true;
                this.nextAble = true;
                this.getThisPhoto();
            },
            editPhoto:function() {
                this.edit = true;
                this.backImage = this.Image;
            },
            cancelPhoto:function() {
                this.photo = this.backImage;
                this.backImage = null;
                this.edit = false;
            },
            updatePhoto:function() {
                let self = this;
                axios.put(IMAGE_URL+'/'+this.image.id,this.image).then((response) => {
                    self.projects = response.data.data;
                    self.getThisPhoto();
                    self.edit = false;
                    swal("更改圖片成功！", "該圖片已更改", "success");
                }, (err) => {
                    console.log(err)
                });
            },
            deletePhotoWarning:function() {
                let self = this;
                swal({
                        title: "您確定要刪除這張圖片嗎",
                        text: "",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "沒錯，我要刪除!",
                        closeOnConfirm: false
                    },
                    function() {
                        axios.delete(IMAGE_URL+'/'+self.image.id)
                            .then(function (response) {
                                swal("刪除成功！", "該圖片已刪除", "success");
                                self.popPath();
                                self.deleted = true;
                                self.getProjectData();
                                router.push('/');
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    });

            }
        },
        components: {},
    }
</script>

<style>

</style>