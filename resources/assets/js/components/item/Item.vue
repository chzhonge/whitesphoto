<template lang="html">
    <div v-bind:data-id="itemData.id" class="col-md-3 height-limit" >
        <div>
            <a class="flex-center"  >
                <div v-on:click="testItemClick" >
                    <img v-bind:src="itemData.thumPath" v-bind:data-name="itemData.name" class="img-responsive img-thumbnail">
                </div>
            </a>
            <div class="caption">
                <h3 v-show="!caption" >{{ itemData.name }}
                    <button class='btn btn-default btn-xs'v-on:click="editItemInfo(itemData.name)"type="button">編輯</button>
                </h3>
                <div v-show="caption">
                    <div v-if="checkIsDefaultValue" class="form-group" >
                        <h3>{{ itemData.name }}</h3>
                    </div>
                    <div v-if="!checkIsDefaultValue" class="form-group" >
                        <input  type="text" class='form-control text-center input-sm' v-model="itemData.name">
                    </div>
                    <div class="form-group">
                        <button type="button" v-on:click="changeCover" class='btn btn-info btn-xs'>更改收藏集封面</button>
                        <button type="button" v-on:click="deleteItem" class='btn btn-danger btn-xs'>刪除這本收藏集</button>
                    </div>
                    <div class="form-group">
                        <button class='btn btn-default btn-xs btn-half-zh' v-on:click="finish" type="button">完成</button>
                        <button class='btn btn-default btn-xs btn-half-zh' v-on:click="cancel" type="button">取消</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { router } from '../../app';
import { PROJECT_URL} from '../api';

export default {
  name: "Item",
  props: ['itemData','selectedProjectID'],
  data () {
    return {
      caption : false,
      checkIsDefaultValue:false,
      backName : '',
      disable : false
    }
  },
  computed: {

  },
  mounted () {},
    methods: {
        editItemInfo:function(name) {
            if (this.selectedProjectID != this.itemData.id
                && this.selectedProjectID != null ) {
                return;
            }

//            if (this.itemData.name == '預設') {
//                this.checkIsDefaultValue = true;
//            }
//            else {
//                this.checkIsDefaultValue = false;
//            }

            this.caption = !this.caption;
            this.backName = name;
            this.$emit('editItemInfo', this.itemData.id);
        },
        changeName:function() {
            if (this.itemData.name != this.backName)
            {
                this.$http.put(active.api+'project/rename',this.itemData,active.headers).then((response) => {
                    console.log('changeNameProject');
                    this.$emit('changeCover');
                }, (response) => {
                    console.log(response);
                });
            }
        },
        cancel:function() {
            this.itemData.name = this.backName;
            this.caption = !this.caption;
            this.$emit('editItemInfo',null);
        },
        finish:function() {
            this.caption = !this.caption;
            this.changeName();
            this.$emit('editItemInfo',null);
        },
        changeCover:function() {
            this.$emit('changeCover',this.itemData.id);
        },
        checkIsDefault:function() {
            console.log(this.itemData.name);
            return this.itemData.name == "預設" ? true : false;
        },
        testItemClick:function() {
            console.log('id is here');
            console.log(this.itemData.id);
            // let cID = this.itemData.id;
            router.push('/Collection/'+this.itemData.id);
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
                function(){
                    axios.delete(PROJECT_URL+'/'+self.itemData.id)
                        .then(function (response) {
                            swal("刪除成功！", "該收藏集已刪除", "success");
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                });
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
    height: 340px ;
}

.btn-half-zh {
    width: 49%;
}

.caption {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 10px;
}

</style>
