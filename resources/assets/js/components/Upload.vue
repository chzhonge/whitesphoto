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
                <label>儲存在哪一本作品集？</label>
                <select class="form-control" v-model="photo.selected" >
                    <option v-bind:value="0">選擇作品集</option>
                    <option v-for="(project, name) in projects" v-bind:value="project.id">{{ project.name }}</option>
                </select>
            </div>
            <div class="form-group text-center">
                <input type="submit" class='btn btn-success btn-lg'
                style="width:45%;"
                v-on:click='onSubmit'
                value="上傳" />
                <button type="button" class='btn btn-danger btn-lg' style="width:45%;" >取消</button>
            </div>
        </form>
    </div>
 </template>

<script>

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
        }
    },
    computed: {

    },
    mounted () {
    //    this.getProjectsList();
        this.$emit('pushOrPopBreadcrumb', 'push', '上傳', '/upload');
    },
    destroyed() {
        this.$emit('pushOrPopBreadcrumb', 'pop', '上傳', '/upload');
    },
    methods: {
    getProjectsList:function() {
        this.$http.get(active.api+'project/all/'+active.id).then((response) => {
        this.projects=response.body.result;
        }, (response) => {

        });
    },
    bindFile: function(e) {
        // 附加image
        this.f_photo.append('image', e.target.files[0]);

        // 上傳時顯示縮圖
        var input = e.target;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("img").src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
        this.show = true;

    },
    onSubmit: function(e) {
        console.log('submit');
        // var header = {headers: {'X-CSRF-TOKEN': document.getElementById('token').getAttribute("content")}};

        if(this.f_photo.image==undefined) {
            this.f_photo.append('image', '');
        }
        this.f_photo.append('photoName',this.photo.photoName);
        this.f_photo.append('author',this.photo.author);
        this.f_photo.append('desc',this.photo.desc);
        this.f_photo.append('selected',this.photo.selected);
        this.f_photo.append('ownerID',this.photo.ownerID);

        this.$http.post(active.api+'photo/create', this.f_photo, active.headers)
        .then((response) => {
            console.log(response.body);
        }, (response) => {

        });
        }
    },
}
</script>

<style lang="css">
</style>
