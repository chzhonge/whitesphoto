<template lang="html">
  <div>
    <TabBar
      v-bind:tabDatas="tabDatas"
      v-bind:collection="collection"
      v-on:selectThisTab="setTabList"
      >
    </TabBar>
    <div class='tab-cover-list' >
      <div v-for="tabData in tabDatas" >
        <TabItem
          v-on:focusThis="show"
          v-for="tab in tabData.data"
          v-bind:TabItemData="tab"
          v-bind:selectedCover="selectedCover"
          v-if="loadTabList(tab)"
          ></TabItem>
          <!--  v-if="checkShow(tab)"-->
      </div>
    </div>
    <div class="form-group text-center clear-line-height">
        <button type="button" class='btn btn-success btn-lg'
         v-on:click="changeCover"
         style="width:45%;"
         >確定</button>
        <button type="button" class='btn btn-danger btn-lg'
         style="width:45%;"
         v-on:click="cancelCover"
         >取消</button>
    </div>
  </div>

</template>

<script>
import TabItem from './tab/TabItem.vue';
import TabBar from './tab/TabBar.vue';

export default {
  name : 'Tab',
  props : ['selectedCollectionID'],
  components:{
    TabItem,
    TabBar
  },
  data() {
    return {
      tabDatas:null,
      selectedCover:null,
      collection:
      {
        id:null,
        name:null
      }
    }
  },
  computed:{
  },
  mounted() {
    this.getCoverPreviewList();
    this.loadDefaultPreverList();
  },
  methods: {
    getCoverPreviewList:function() {
      console.log('getCoverPreviewList');
      this.$http.get(active.api+'photo'+'/cover/'+active.id+'/'+this.selectedCollectionID).then((response) => {
        // console.log(response.body.result);
        this.tabDatas = response.body.result;
      }, (response) => {
        console.log(response);
      });
    },
    loadDefaultPreverList:function() {
      this.collection.id = this.selectedCollectionID;
      // this.$emit('loadDefaultPreverList',this.selectedCollectionID);
    },
    reloadDefaultPreverList:function(ILselectedCollectionID) {
      // this.collection.id = this.selectedCollectionID;
      this.collection.id = ILselectedCollectionID;
      console.log('reload');
    },
    show:function(TabItemDataid) {
      console.log(TabItemDataid);
      this.selectedCover = TabItemDataid;
    },
    setTabList:function(cID) {
      // tab
      // this.collection.name = tab.collectionName;
      this.collection.id = cID;
      // console.log("collectionName:"+this.collection.name);
      console.log("collectionID:"+cID);
    },
    loadTabList:function(tab) {
      // console.log(tab);
      if (this.collection.id == tab.collectionsID ) {
          return true;
      }
      return false;
    },
    changeCover:function() {
      let postData = {
        'collectionsID' : this.selectedCollectionID,
        'photoID' : this.selectedCover};

      this.$http.put(active.api+'project/update',postData,active.headers).then((response) => {
        this.$emit('changeCover');
        // console.log(response);
      }, (response) => {
        console.log(response);
      });
    },
    cancelCover:function() {
      this.$emit('cancelCover');
    }
  }
}
</script>

<style lang="css">
.tab-cover-list {
  overflow-y: scroll;
  height: 375px;
}
.clear-line-height {
  margin-top: 5px;
  line-height: 0px;
}
</style>
