<template lang="html">
  <div class="tab-item"
    v-bind:class="{ 'tab-seleted':clicked }"
    v-on:click="focusThis">
    <img
    v-bind:src="TabItemData.thumPath"
    v-bind:data-name="TabItemData.name"
    class="img-responsive img-thumbnail tab-clear"
    >
  </div>
</template>

<script>
export default {
  name:'TabItem',
  props:['TabItemData','selectedCover'],
  data() {
    return {

    }
  },
  computed:{
    clicked:function() {
      if (this.selectedCover != this.TabItemData.id) {
        return false;
      }
      else {
        return true;
      }
    }
  },
  mounted() {

  },
  methods:{
    focusThis:function() {
      console.log(this.TabItemData);
      this.$emit('focusThis',this.TabItemData.id);
    },
    sendCollectionName:function() {
      if (this.TabItemData.name =='預設') {
        this.$emit('focusThis',this.TabItemData.id);
      }
    }
  }
}
</script>

<style lang="css">

.tab-seleted {
  box-shadow: 0 0 0 5px #2185d0;
  -webkit-box-shadow: 0 0 0 5px #2185d0;
}

.tab-clear {
  padding: 0px;
}

.tab-item {
  float: left;
  display: inline-block;
  position: relative;
  overflow-y: hidden;
  /*width: 230px;*/
  /*width:23.6%;*/
  height: 220px;
  margin: 5px 10px;
  /*padding: 10px 10px 0;*/
  font-size: 12px;
  text-align: center;
  line-height: 1;
  vertical-align: top;
  color: #555;
  /*-webkit-box-shadow: inset 0 0 0 1px rgba(0,0,0,0.2);
  box-shadow: inset 0 0 0 1px rgba(0,0,0,0.2);*/
}
</style>
