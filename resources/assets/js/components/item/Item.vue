<template lang="html">
    <div v-bind:data-id="itemData.id" class="col-md-3 height-limit" >
            <a class="flex-center"  >
                <div v-on:click="entryPhoto" >
                    <img v-bind:src="itemData.thumPath" v-bind:data-name="itemData.name" class="img-responsive img-thumbnail">
                </div>
            </a>
            <div class="caption">
                <h3 v-show="!caption" >{{ itemData.name }}
                    <button class='btn btn-default btn-xs'v-on:click="editItemInfo(itemData.name)"type="button">編輯</button>
                </h3>
                <div v-show="caption">
                    <div class="form-group" >
                        <h3 class="text-center">{{ itemData.name }}</h3>
                    </div>
                    <div class="form-group" >
                        <input  type="text" class='form-control text-center input-sm' v-model="itemData.name">
                    </div>
                    <div class="form-group">
                        <button type="button" v-on:click="showChangeCover" class='btn btn-info btn-xs'>更改收藏集封面</button>
                        <button type="button" v-on:click="deleteItem" class='btn btn-danger btn-xs'>刪除這本收藏集</button>
                    </div>
                    <div class="form-group">
                        <button class='btn btn-default btn-xs btn-half-zh' v-on:click="finish" type="button">完成</button>
                        <button class='btn btn-default btn-xs btn-half-zh' v-on:click="cancel" type="button">取消</button>
                    </div>
                </div>
            </div>
    </div>
</template>

<script>
    import { router } from '../../app';
    import { PROJECT_URL} from '../api';
    import Vuex from 'vuex';

    export default {
        name: "Item",
        props: ['itemData'],
        data () {
            return {
                caption : false,
                checkIsDefaultValue:false,
                backName : '',
                disable : false
            }
        },
        computed: {
            ...Vuex.mapGetters(['selectedProjectID'])
        },
        created () {

        },
        mounted () {

        },
        methods: {
            ...Vuex.mapMutations(['selectedProjectID','model','selectedProjectName']),
            ...Vuex.mapActions(['getProjectData','getImagesData']),
            editItemInfo:function(name) {
                if (this.selectedProjectID != this.itemData.id && this.selectedProjectID != null ) {
                    return;
                }

                this.caption = !this.caption;
                this.backName = name;
                this.$store.commit('selectedProjectID' , this.itemData.id);
                this.$store.dispatch('getImagesData' , this.itemData.id);
            },
            showChangeCover:function() {
                this.$store.commit('selectedProjectID' , this.itemData.id);
                this.$store.commit('modal' , true);
            },
            deleteItem:function() {
                let self = this;
                swal({
                        title: "你確定要刪除這本收藏集嗎?",
                        text: "刪除後，所有在此收藏集中的圖片將會一起刪除!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "沒錯，我要刪除!",
                        closeOnConfirm: false
                    },
                    function() {
                        axios.delete(PROJECT_URL+'/'+self.itemData.id)
                            .then(function (response) {
                                swal("刪除成功！", "該收藏集已刪除", "success");
                                self.$store.commit('selectedProjectID' , null);
                                self.getProjectData();

                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    });
            },
            finish:function() {
                this.caption = !this.caption;
                this.changeItemName();
                this.$store.commit('selectedProjectID' , null)
            },
            cancel:function() {
                this.itemData.name = this.backName;
                this.caption = !this.caption;
                this.$store.commit('selectedProjectID' , null)
            },
            changeItemName:function() {
                let self = this;
                console.log(this.itemData.name +'  '+this.backName);
                if (this.itemData.name !== this.backName) {
                    console.log('gello');
                    axios.put(PROJECT_URL+'/'+this.itemData.id, {
                        ownerID: this.userID,
                        name: this.itemData.name
                    })
                    .then(function (response) {
                        console.log('成功');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            entryPhoto:function() {
                this.$store.commit('selectedProjectName' , this.itemData.name);
                this.$store.commit('selectedProjectID' , this.itemData.id);
                console.log(this.itemData.id);
                router.push('/projects/'+this.itemData.id);
            }
         },
        components: {}
}
</script>

<style lang="css">

.flex-center {
    display: flex;
    justify-content: center;
    align-items: center;
}

.height-limit{
    height: 395px ;
}

.btn-half-zh {
    width: 49%;
}


.caption {
    display: flex;
    justify-content: center;
    align-items: center;
    /*margin-top: 10px;*/
}

</style>
