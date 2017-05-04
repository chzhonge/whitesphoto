<template lang="html">
  <ul class="nav nav-tabs">
    <TabBarItem
      v-for='tabData in tabDatas'
      v-bind:tabData="tabData"
      v-bind:collection="collection"
      v-on:focusThis="selectThisTab"
      ></TabBarItem>
  </ul>
</template>

<script>
import TabBarItem from './TabBarItem.vue';

export default {
  name:'TabBar',
  props:['tabDatas','collection'],
  components:{
    TabBarItem
  },
  methods: {
    selectThisTab:function(cID) {
      console.log('selectThisTab:'+cID);
      this.$emit('selectThisTab',cID);
    }
  }
}
</script>

<style lang="css">
</style>
