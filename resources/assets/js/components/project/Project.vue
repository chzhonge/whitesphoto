<template lang="html">
    <div v-bind:data-id="projectInfo.id" class="item">
        <a>
            <div v-on:click="testItemClick" v-bind:class="changeStyle(projectInfo.width,projectInfo.height)"  >
                <img v-bind:src="projectInfo.thumPath" v-bind:data-name="projectInfo.name" class="img-responsive img-thumbnail" >
            </div>
        </a>
        <div class="caption">
            <h3 v-show="!caption" >
            {{ projectInfo.name }}
            <button class='btn btn-default btn-xs' v-on:click="editProject(projectInfo.name)" type="button">編輯</button>
            </h3>
            <div v-show="caption">
                <div v-if="checkIsDefaultValue" class="form-group" >
                <h3>{{ projectInfo.name }}</h3>
                </div>
            <div v-if="!checkIsDefaultValue" class="form-group form-inline" >
                <input  type="text" class='form-control text-center input-sm' v-model="projectInfo.name">
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
export default {
  name: "Project",
  props: ['projectInfo','nowSelectedProjectID'],
  data () {
    return {
      caption : false,
      checkIsDefaultValue:false,
      originalProjectName : '',
      disable : false
    }
  },
  computed: {

  },
  mounted () {},
  methods: {
    changeStyle:function(width, height) {

    },
    editProject:function(name) {

    },
    changeName:function() {

    },
    cancelReName:function() {

    },
    decideName:function() {

    },
    changeCover:function() {

    },
    checkIsDefault:function() {

    },
    testItemClick:function() {

    },
    deleteProject:function() {

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
