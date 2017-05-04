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
                    <button class='btn btn-default btn-xs'v-on:click="editProject(itemData.name)"type="button">編輯</button>
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
                        <button type="button" v-on:click="deleteProject" class='btn btn-danger btn-xs'>刪除這本收藏集</button>
                    </div>
                    <div class="form-group">
                        <button class='btn btn-default btn-xs btn-half-zh' v-on:click="decideName" type="button">完成</button>
                        <button class='btn btn-default btn-xs btn-half-zh' v-on:click="cancelReName" type="button">取消</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { router } from '../../app';

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
        editProject:function(name) {
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

            this.$emit('editProject',this.itemData.id);
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
        cancelReName:function() {
            this.itemData.name = this.backName;
            this.caption = !this.caption;
            this.$emit('editProject',null);
        },
        decideName:function() {
            this.caption = !this.caption;
            this.changeName();
            this.$emit('editProject',null);
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
        deleteProject:function() {
            let result = confirm("您確定要刪除這本作品集嗎?");
            if (result) {
                this.$http.delete(active.api+'project/delete/'+this.itemData.id,active.headers).then((response) => {
                    console.log('updateProject');
                    this.$emit('changeCover');
                }, (response) => {
                    console.log(response);
                });
            }
            else {

            }

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
