<!-- =========================================================================================
  File Name: UserList.vue
  Description: User List page
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>

  <div id="page-topics-list">
    <data-view-sidebar :isSidebarActive="addNewDataSidebar" @closeSidebar="toggleDataSidebar" :context="context" :data="sidebarData" />
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
    <vx-card no-shadow class="mt-5">
      <div class="vs-component vs-con-table stripe vs-table-primary">
        <div class="con-tablex vs-table--content">
          <div class="vs-con-tbody vs-table--tbody ">
            <table class="vs-table vs-table--tbody-table">
              <thead class="vs-table--thead">
                <tr>
                  <!---->
                  <th colspan="1" rowspan="1">
                    <div class="vs-table-text">STT
                      <!---->
                    </div>
                  </th>
                  <th colspan="1" rowspan="1">
                    <div class="vs-table-text">Chuyên đề
                      <!---->
                    </div>
                  </th>
                  <th colspan="1" rowspan="1">
                    <div class="vs-table-text">Bài kiểm tra
                      <!---->
                    </div>
                  </th>
                  <th colspan="1" rowspan="1">
                    <div class="vs-table-text">Thao tác
                      <!---->
                    </div>
                  </th>
                </tr>
              </thead>
              <tr class="tr-values vs-table--tr tr-table-state-null" v-for="(item, index) in topics" :key="index">
                <!---->
                <td class="td vs-table--td">{{ index + 1 + (pagination.cpage - 1) * pagination.limit }}</td>
                <td class="td vs-table--td">{{item.title}}</td>
                <td class="td vs-table--td">10</td>
                <td class="td vs-table--td">
                  <feather-icon icon="EditIcon" svgClasses="h-5 w-5 mr-4 hover:text-primary cursor-pointer" @click="editData(item)" />
                  <feather-icon icon="Trash2Icon" svgClasses="h-5 w-5" style="cursor: pointer;" @click="openConfirmDelete(item.id, item.title)"></feather-icon>
                </td>
              </tr>
            </table>
            
          </div>
        </div>
      </div>
      <vs-pagination
            v-if="Math.ceil(pagination.total / pagination.limit) >1"
            :total="Math.ceil(pagination.total / pagination.limit)"
            :max="7"
            v-model="pagination.cpage" @change="changePage()"/>
    </vx-card>
  </div>

</template>

<script>

  import vSelect from 'vue-select'
  import axios from '../../http/axios.js'

  import DataViewSidebar from './components/DataViewSidebarTopic.vue'

  export default {
    components: {
      vSelect,
      DataViewSidebar
    },
    data() {
      return {
        context : { componentParent: this },
        searchQuery: {
          keyword: '',
        },

        topics: [],
        limitSource: [10, 20, 30, 40, 50],
        pagination: {
          url: "/api/topics/list",
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
        addNewDataSidebar: false,
        sidebarData: {},
        delete_id : ''
      }
    },
    methods: {
      addNewData() {
        this.sidebarData = {}
        this.toggleDataSidebar(true)
      },
      editData(data){
        this.sidebarData = data
        this.toggleDataSidebar(true)
      },
      toggleDataSidebar(val = false) {
        this.addNewDataSidebar = val
      },
      getData() {
        this.$vs.loading()
        axios.p('/api/topics/list', {
            keyword: this.searchQuery.keyword,
            pagination: this.pagination
          })
          .then((response) => {
            this.topics = response.data.list
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
      openConfirmDelete (id, title) {
        this.delete_id = id
        this.$vs.dialog({
          type: 'confirm',
          color: 'danger',
          title: 'Thông báo',
          text: `Bạn chắc chắn muốn xóa chuyên đề - ${title}`,
          accept: this.deleteTopic,
          acceptText: 'Xóa',
          cancelText: 'Hủy'
        })
      },
      deleteTopic () {
        axios.p('/api/topics/delete',{
          id: this.delete_id
        }).then((response) => {
          /* Below two lines are just for demo purpose */
          this.showDeleteSuccess()
          this.getData();
        })
        
      },
      showDeleteSuccess () {
        this.$vs.notify({
          color: 'success',
          title: 'Thông báo',
          text: 'Bản ghi đã được xóa thành công.'
        })
      }
    },
    created() {
      this.getData();
    },
  }
</script>
<style>
@media only screen and (min-width: 600px) {
  #page-topics-list .vs-table--search {
    max-width: 360px;
  }
  #page-topics-list .vs-table--search-input{
    width: 360px;
  }
}
</style>