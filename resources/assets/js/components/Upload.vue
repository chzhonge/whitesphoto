<template lang="html">
    <div class="col-md-12">
        <form role="form">
            <div class="form-group text-center" v-show="show" >
                <div class="img-thumbnail" v-show="!show"style="width: 100%;"></div>
                <div class="img-thumbnail" v-show="show" style="">
                <img id='img' style="width: 100%;"/>
                </div>
            </div>
            <div class="form-group">
                <label for="file">上傳作品</label>
                <input type="file" @change="bindFile" class="form-control">

            </div>
            <div class="form-group">
                <label>作品名稱</label>
                <input v-model="photo.photoName" type="text" class="form-control">
                <p class="text-warning" v-if="photoNameRe">作品名稱為必填</p>
            </div>
            <div class="form-group">
                <label>作者姓名</label>
                <input v-model="photo.author" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label>作品描述</label>
                <textarea v-model="photo.desc" class="form-control" rows="8" cols="40"></textarea>
            </div>
            <div class="form-group">
                <label>儲存在哪一本收藏冊？</label>
                <select class="form-control" v-model="photo.selected" >
                    <option selected="selected" v-bind:value="0">選擇收藏冊</option>
                    <option v-for="(project, name) in projects" v-bind:value="project.id">{{ project.name }}</option>
                </select>
                <p class="text-warning" v-if="selectIDRe">請選擇收藏冊</p>
            </div>
            <div class="form-group text-center">
                <input type="button" class='btn btn-success btn-lg'
                style="width:45%;" v-on:click='onSubmit' v-bind:disabled="canUpload"
                value="上傳" />
                <button type="button" class='btn btn-danger btn-lg' style="width:45%;"
                v-on:click="cancelUpload"
                >取消</button>
            </div>
        </form>
    </div>
 </template>

<script>
    import { PROJECT_URL, IMAGE_URL } from './api';
    import { router } from './../app';
    import Vuex from 'vuex';

    export default {
        data () {
            return  {
                show : false,
                photo : {
                    photoName : '',
                    author : '',
                    desc :'',
                    selected : 0,
                    ownerID : ''
                },
                f_photo : new FormData(),
                projects : null,
                responseResult : false,
                responseID : null,
                uploadFileRe:true,
            }
        },
        computed: {
            photoNameRe:function () {
                return this.photo.photoName == '' ? true : false;
            },
            selectIDRe:function () {
                return this.photo.selected == 0 ? true : false;
            },
            canUpload:function () {
                if (this.photoNameRe == false && this.selectIDRe == false && this.uploadFileRe == false ) {
                    return false;
                }
                return true;
            }
        },
        mounted () {
            this.getProjectsList();
            this.pushPath();
//            this.$emit('pushOrPopBreadcrumb', 'push', '上傳', '/upload');
        },
        destroyed() {
            this.popPath();
//            this.$emit('pushOrPopBreadcrumb', 'pop', '上傳', '/upload');

        },
        methods: {
            ...Vuex.mapMutations(['breadcrumb']),
            pushPath:function () {
                let viewName ='上傳';
                let action ='push';
                let viewUrl ='/upload';
                this.$store.commit('breadcrumb' , {viewName,action,viewUrl});
            },
            popPath:function () {
                let viewName ='上傳';
                let action ='pop';
                let viewUrl ='/upload';
                this.$store.commit('breadcrumb' , {viewName,action,viewUrl});
            },
            getProjectsList:function() {
                let self = this;
                axios.get(PROJECT_URL)
                    .then(function (response) {
                        self.projects = response.data.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            bindFile: function(e) {
                // 附加image
                this.f_photo.append('image', e.target.files[0]);

                if (!e.target.files.length) {
                    this.uploadFileRe = true;
                    this.show = false;
                    return;
                }

                // 上傳時顯示縮圖
                var input = e.target;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById("img").src = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                    this.uploadFileRe = false;
                }
                this.show = true;

            },
            cancelUpload:function () {
                router.push('/');
            },
            onSubmit: function(e) {


                if(this.f_photo.image==undefined) {
                    this.f_photo.append('image', '');
                }
                this.f_photo.append('photoName',this.photo.photoName);
                this.f_photo.append('author',this.photo.author);
                this.f_photo.append('desc',this.photo.desc);
                this.f_photo.append('selected',this.photo.selected);
                this.f_photo.append('ownerID',this.photo.ownerID);
                let self = this;
                axios.post(IMAGE_URL, this.f_photo)
                    .then(function (response) {
                        if (response.data.result === true) {
                            self.responseResult = response.data.result;
                            console.log('hee'+response.data.result);
                            self.responseID = response.data.data;
                            swal("上傳圖片成功!", '跳轉至該圖片', "success");
                            if (self.responseResult === true) {
                                router.push('/projects/'+self.photo.selected+'/'+self.responseID);
                            }
                            console.log('no');
                        } else {
                            swal("上傳圖片失敗!", '', "error");
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

                }
        },
    }
</script>

<style lang="css">
</style>
