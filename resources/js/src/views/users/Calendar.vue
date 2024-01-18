<!-- =========================================================================================
  File Name: UserList.vue
  Description: User List page
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>

  <div id="page-user-list">
    <data-view-sidebar :isSidebarActive="addNewDataSidebar" @closeSidebar="toggleDataSidebar" :data="sidebarData" />

    <div class="vx-card p-6">

      <div class="flex flex-wrap items-center">

        <!-- ITEMS PER PAGE -->
        <div class="flex-grow">
          <vs-dropdown vs-trigger-click class="cursor-pointer">
            <div class="p-4 border border-solid d-theme-border-grey-light rounded-full d-theme-dark-bg cursor-pointer flex items-center justify-between font-medium">
              <span class="mr-2">{{ pagination.cpage * pagination.limit - (pagination.limit - 1) }} - {{ pagination.total - pagination.cpage * pagination.limit > 0 ? pagination.cpage * pagination.limit : pagination.total }} of {{ pagination.total }}</span>
              <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
            </div>
            <!-- <vs-button class="btn-drop" type="line" color="primary" icon-pack="feather" icon="icon-chevron-down"></vs-button> -->
            <vs-dropdown-menu>
              <vs-dropdown-item  v-for="item in limitSource" :key="item" @click="changePageLimit(item)">
                <span>{{item}}</span>
              </vs-dropdown-item>
            </vs-dropdown-menu>
          </vs-dropdown>
        </div>

       
           <v-select :clearable="false" :options="statusOptions" class="sm:mr-4 mr-0  md:w-1/6 sm:w-1/2 w-full sm:order-normal order-3 sm:mt-0 mt-4" v-model="searchQuery.status" @input="searchData()"  />
          <div class="btn-add-new p-2 rounded-lg cursor-pointer flex items-center justify-center text-lg font-medium text-base text-primary border border-solid border-primary" @click="addNewData">
              <feather-icon icon="PlusIcon" svgClasses="h-4 w-4" />
              <span class="ml-2 text-base text-primary">Thêm mới</span>
          </div>
      </div>


      <!-- AgGrid Table -->
      <ag-grid-vue
        ref="agGridTable"
        :components="components"
        :gridOptions="gridOptions"
        class="ag-theme-material w-100 my-4 ag-grid-table"
        :columnDefs="columnDefs"
        :defaultColDef="defaultColDef"
        :rowData="paymentsData"
        rowSelection="multiple"
        colResizeDefault="shift"
        :animateRows="true"
        :floatingFilter="false"
        :context="context"
        :enableRtl="$vs.rtl">
      </ag-grid-vue>

      <vs-pagination
        v-if="Math.ceil(pagination.total / pagination.limit) >1"
        :total="Math.ceil(pagination.total / pagination.limit)"
        :max="7"
        v-model="pagination.cpage" @change="changePage()"/>

    </div>
  </div>

</template>

<script>
import { AgGridVue } from 'ag-grid-vue'
import '@sass/vuexy/extraComponents/agGridStyleOverride.scss'
import vSelect from 'vue-select'
import axios from './../../http/axios.js'

// Cell Renderer
import CellRendererStatus from './cell-renderer/calendar/CellRendererStatus.vue'
import CellRendererActions from './cell-renderer/calendar/CellRendererActions.vue'
import DataViewSidebar from './cell-renderer/calendar/DataViewSidebar.vue'

export default {
  components: {
    AgGridVue,
    vSelect,

    // Cell Renderer
    CellRendererStatus,
    CellRendererActions,
    DataViewSidebar
  },
  data () {
    return {

      statusOptions: [
        { label: 'Chọn trạng thái', value: '-1' },
        { label: 'Lịch chống', value: '0' },
        { label: 'Đã xếp lịch', value: '1' },
        { label: 'Hoàn thành', value: '2' }
      ],

      searchQuery: {
        keyword: '',
        status: {  label: 'Chọn trạng thái', value: '-1' },
      },

      // AgGrid
      gridApi: null,
      gridOptions: {onGridReady: (event) => event.api.sizeColumnsToFit()},
      defaultColDef: {
        sortable: false,
        resizable: true,
        suppressMenu: true
      },
      columnDefs: [
        {
          headerName: 'ID',
          field: 'id',
          width: 125,
          filter: true,
        //   checkboxSelection: true,
        //   headerCheckboxSelectionFilteredOnly: true,
        //   headerCheckboxSelection: true,
        },
        {
          headerName: 'Ngày',
          field: 'date',
          filter: true,
          minWidth: 230,
        // cellClass: "text-center",
        },
        {
          headerName: 'Thời gian bắt đầu',
          field: 'open_time',
          filter: true,
          minWidth: 230,
        //   cellClass: "text-center"
        },
        {
          headerName: 'Thời gian kết thúc',
          field: 'close_time',
          filter: true,
          minWidth: 230,
        //   cellClass: "text-center"
        },
        {
          headerName: 'Trạng thái',
          field: 'status',
          filter: true,
          minWidth: 230,
          cellRendererFramework: 'CellRendererStatus',
        //    cellClass: "text-center"
        },
        {
          headerName: 'Actions',
          field: 'id',
          minWidth: 230,
          cellRendererFramework: 'CellRendererActions',
        //    cellClass: "text-center"
        }
      ],

      // Cell Renderer Components
      components: {
        CellRendererStatus,
        CellRendererActions,
      },
      paymentsData:[],
      limitSource: [10, 20, 30, 40, 50],  
      pagination: {
        url: "/api/payment/list",
        id: "",
        style: "line",
        class: "",
        spage: 1,
        ppage: 1,
        npage: 0,
        lpage: 1,
        cpage: 1,
        total: 0,
        limit: 10,
        pages: [],
        init:0
      },
      context : { componentParent: this },
      addNewDataSidebar: false,
      sidebarData: {}
    }
  },
  methods: {
    addNewData () {
      this.sidebarData = {}
      this.toggleDataSidebar(true)
    },
    toggleDataSidebar (val = false) {
      this.addNewDataSidebar = val
      this.getData();
    },
    editData (data) {
      // this.sidebarData = JSON.parse(JSON.stringify(this.blankData))
      this.sidebarData = data
      this.toggleDataSidebar(true)
    },
    searchData(type=''){
      if(type=='keyword' && this.searchQuery.keyword.length>=3){
        this.getData();
      }else{
        this.getData();
      }
    },
    getData(){
      this.$vs.loading()
      axios.p('/api/user/law-schedules', {
        status : this.searchQuery.status.value,
        pagination : this.pagination
      })
      .then((response) => {  
        this.paymentsData = response.data.list
        this.$vs.loading.close()
        this.pagination = response.data.paging;
        this.pagination.init = 1;
      })
      .catch((error)   => { console.log(error); this.$vs.loading.close(); })
    },
    changePage(){
      if(this.pagination.init){
        this.getData();
      }
    },
    changePageLimit(limit){
        this.pagination.cpage = 1
        this.pagination.limit = limit
        this.getData();
    }
  },
  created () {
    this.getData();
  }
}

</script>
<style>
/* .ag-header-cell-label {
    text-align: center;
    display: block;
} */

</style>

