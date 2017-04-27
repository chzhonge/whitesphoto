<template lang="html">
  <!-- <div class='item col-md-3'> -->
  <div v-bind:data-id="itemData.id"
    class="item">
    <a>
      <!--  v-bind:class="changeStyle(itemData.width,itemData.height)"-->
      <div
        v-on:click="testItemClick"
        v-bind:class="changeStyle(itemData.width,itemData.height)"  >
        <img
        v-bind:src="itemData.thumPath"
        v-bind:data-name="itemData.name"
        class="img-responsive img-thumbnail"
        >
      </div>
    </a>
    <div class="caption">
      <h3 v-show="!caption" >
        {{ itemData.name }}
        <button class='btn btn-default btn-xs'
        v-on:click="editProject(itemData.name)"
        type="button">編輯</button>
      </h3>
      <div v-show="caption">
        <div v-if="checkIsDefaultValue" class="form-group" >
          <h3>{{ itemData.name }}</h3>
        </div>
        <div v-if="!checkIsDefaultValue" class="form-group form-inline" >
          <input  type="text" class='form-control text-center input-sm' v-model="itemData.name">
          <!-- <button class='btn btn-default btn-xs' v-on:click="decideName" type="button">確定</button>
          <button class='btn btn-default btn-xs' v-on:click="cancelReName" type="button">取消</button> -->
        </div>
        <div class="form-group">
          <button type="button" v-on:click="changeCover" class='btn btn-info btn-xs'>更改收藏集封面</button>
          <button type="button" v-on:click="deleteProject" class='btn btn-danger btn-xs'>刪除這本收藏集</button>
        </div>
        <div class="form-group">
          <button class='btn btn-default btn-xs' v-on:click="decideName" type="button">完成</button>
          <button class='btn btn-default btn-xs' v-on:click="cancelReName" type="button">取消</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { router } from '../app';
import * as active from '../active/active.js';
export default {
  name: "Item",
  props: ['itemData','selectedCollectionID'],
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
    changeStyle:function(width, height) {
      // console.log('width:'+width);
      // console.log('height:'+height);
      return width > height ? "_layout-thumbnail_w" : "_layout-thumbnail_h";
    },
    editProject:function(name) {
      // console.log('this.selectedCollectionID '+this.selectedCollectionID);
      // console.log('this.selectedCollectionID '+this.itemData.id);

      if (this.selectedCollectionID != this.itemData.id
        && this.selectedCollectionID != null ) {
        return;
      }

      if (this.itemData.name == '預設') {
        this.checkIsDefaultValue = true;
      }
      else {
        this.checkIsDefaultValue = false;
      }

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
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s
}
.fade-enter, .fade-leave-active {
  opacity: 0
}

.test{

}

.item {
  display: inline-block;
    position: relative;
    overflow-y: hidden;
    /*width: 230px;*/
    width:23.6%;
    height: 340px;
    margin: 5px 5px;
    padding: 10px 10px 0;
    font-size: 12px;
    text-align: center;
    line-height: 1;
    vertical-align: top;
    color: #555;
    -webkit-box-shadow: inset 0 0 0 1px rgba(0,0,0,0.2);
    box-shadow: inset 0 0 0 1px rgba(0,0,0,0.2);
}

._layout-thumbnail_w {
    margin-top: 30%;
    display: inline-block;
    position: relative;
    /*height: 280px;*/
    z-index: 1;
    cursor: pointer;
    /*
    ____
   │    │
   ──────
     */
}

._layout-thumbnail_h {
    display: inline-block;
    position: relative;
    height: 202px;
    z-index: 1;
    cursor: pointer;
    /**
     * ___
     * │  │
     * │__│
     */
}

.caption {
  margin-top: 10px;
}

</style>
