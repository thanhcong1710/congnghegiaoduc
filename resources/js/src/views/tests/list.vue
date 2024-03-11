<!-- =========================================================================================
  File Name: UserList.vue
  Description: User List page
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>

  <div id="page-tests-list">
    <data-view-sidebar :isSidebarActive="addNewDataSidebarTest" @closeSidebar="toggleDataSidebarTest" :context="context" :data="sidebarData" :topicOptions="topicOptions"/>
    <div class="flex flex-wrap items-center">
      <div
        class="btn-add-new p-3 rounded-lg cursor-pointer flex items-center justify-center text-lg font-medium text-base text-primary border border-solid border-primary"
        @click="addNewData">
        <feather-icon icon="PlusIcon" svgClasses="h-4 w-4" />
        <span class="ml-2 text-base text-primary">Thêm mới</span>
      </div>
      <div class="con-input-search vs-table--search">
        <input type="text" class="input-search vs-table--search-input" style="padding:14px 35px; font-size:14px;" v-model="searchQuery.keyword" @input="getData()">
        <i class="vs-icon notranslate icon-scale material-icons null" style="font-size:24px;">search</i>
      </div>
    </div>

    <div class="vx-row" style="padding: 20px 0px;">
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/3 xl:w-1/3 mb-base" v-for="item in tests" :key="item.id">
        <div class="vx-card overflow-hidden">
            <!---->
            <div class="vx-card__collapsible-content vs-con-loading__container">
                <div>
                    <feather-icon icon="SettingsIcon" svgClasses="h-6 w-6" style="position: absolute !important; right: 10px; top: 10px;cursor: pointer;" @click="test_detail_view(item.id)"></feather-icon>
                    <div class="p-6 pb-0" style="cursor: pointer;" @click="test_detail_view(item.id)">
                        <span
                            class="p-3 inline-flex rounded-full feather-icon select-none relative text-primary mb-4"
                            style="background: rgba(var(--vs-primary),.15);">
                            <feather-icon icon="FileTextIcon" svgClasses="h-8 w-8"></feather-icon></span>
                        <div class="truncate">
                            <h5 class="mb-1">{{item.title}}</h5> 
                            <span>30 phút 15 câu hỏi</span>
                        </div>
                    </div>
                    <vs-divider />
                    <div class="p-6 pb-0 pt-0">
                       <div class="flex flex-wrap justify-between mb-3">
                          <feather-icon style="cursor: pointer" @click="copyTextJoinLink(item.join_link, 'Link tham gia cuộc họp')" icon="CopyIcon" svgClasses="h-9 w-9"></feather-icon>
                          <vs-button  @click="join(item)">Bắt đầu</vs-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
    <vs-pagination
          v-if="Math.ceil(pagination.total / pagination.limit) >1"
          :total="Math.ceil(pagination.total / pagination.limit)"
          :max="7"
          v-model="pagination.cpage" @change="changePage()"/>
  </div>

</template>

<script>
  import {
    AgGridVue
  } from 'ag-grid-vue'
  import '@sass/vuexy/extraComponents/agGridStyleOverride.scss'
  import vSelect from 'vue-select'
  import axios from '../../http/axios.js'

  import DataViewSidebar from './components/DataViewSidebarTest.vue'

  export default {
    components: {
      AgGridVue,
      vSelect,
      DataViewSidebar
    },
    data() {
      return {
        context : { componentParent: this },
        searchQuery: {
          keyword: '',
        },
        topicOptions:[],
        tests: [],
        limitSource: [10, 20, 30, 40, 50],
        pagination: {
          url: "/api/tests/list",
          id: "",
          style: "line",
          class: "",
          spage: 1,
          ppage: 1,
          npage: 0,
          lpage: 1,
          cpage: 1,
          total: 0,
          limit: 12,
          pages: [],
          init: 0
        },
        context: {
          componentParent: this
        },
        addNewDataSidebarTest: false,
        sidebarData: {}
      }
    },
    methods: {
      addNewData() {
        console.log(this.topicOptions)
        this.sidebarData = {}
        this.toggleDataSidebarTest(true)
      },
      toggleDataSidebarTest(val = false) {
        this.addNewDataSidebarTest = val
      },
      getTopics() {
        this.$vs.loading()
        axios.g('/api/topics/list-all-user')
          .then((response) => {
            this.topicOptions = response.data
            this.$vs.loading.close()
          })
          .catch((error) => {
            console.log(error);
            this.$vs.loading.close();
          })
      },
      getData() {
        this.$vs.loading()
        axios.p('/api/tests/list', {
            keyword: this.searchQuery.keyword,
            pagination: this.pagination
          })
          .then((response) => {
            this.tests = response.data.list
            this.$vs.loading.close()
            this.pagination = response.data.paging;
            this.pagination.init = 1;
          })
          .catch((error) => {
            console.log(error);
            this.$vs.loading.close();
          })
      },
      changePage() {
        if (this.pagination.init) {
          this.getData();
        }
      },
      changePageLimit(limit) {
        this.pagination.cpage = 1
        this.pagination.limit = limit
        this.getData();
      },
      test_detail_view(id){
        this.$router.push({name: 'test-detail-view', params: {id:id }}).catch(() => {})
      },
      copyTextJoinLink(textCopy, message) {
          const thisIns = this;
          this.$copyText(textCopy).then(function() {
              thisIns.$vs.notify({
                  title: 'Copy',
                  text: message,
                  color: 'success',
                  iconPack: 'feather',
                  icon: 'icon-check-circle'
              })
          }, function() {
              thisIns.$vs.notify({
                  title: 'Failed',
                  text: 'Error in copying text',
                  color: 'danger',
                  iconPack: 'feather',
                  icon: 'icon-alert-circle'
              })
          })
      },
    },
    created() {
      this.getData();
      this.getTopics();
    }
  }
</script>
<style>
@media only screen and (min-width: 600px) {
  #page-tests-list .vs-table--search {
    max-width: 360px;
  }
  #page-tests-list .vs-table--search-input{
    width: 360px;
  }
}
</style>