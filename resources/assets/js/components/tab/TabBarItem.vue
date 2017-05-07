<template lang="html">
  <li role="presentation">
    <a
      href="#/Collection"
      v-bind:class="{ 'bar-seleted':clicked }"
      v-on:click="focusThis">
      {{tabData.collectionName}}</a>
  </li>
</template>

<script>
export default {
  name:'TabBarItem',
  props:['tabData','collection'],
  data() {
    return {

    }
  },
  computed:{
    clicked:function() {
      if (this.collection.id != this.tabData.id) {
        return false;
      }
      else {
        return true;
      }
    }
  },
  methods:{
    focusThis:function() {
      console.log('TabBarItem:'+this.tabData.id);
      this.$emit('focusThis',this.tabData.id);
      //return c.id
    }
  }
}
</script>

<style lang="css">
.bar-seleted {
  color: #fff;
  background-color: #337ab7;
}
</style>
