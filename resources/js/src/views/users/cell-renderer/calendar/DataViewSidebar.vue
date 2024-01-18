<!-- =========================================================================================
  File Name: AddNewDataSidebar.vue
  Description: Add New Data - Sidebar component
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
  <vs-sidebar click-not-close position-right parent="body" default-index="1" color="primary" class="add-new-data-sidebar items-no-padding" spacer v-model="isSidebarActiveLocal">
    <div class="mt-6 flex items-center justify-between px-6">
        <h4>{{ Object.entries(this.data).length === 0 ? "THÊM MỚI" : "CẬP NHẬT" }} LỊCH CHỐNG</h4>
        <feather-icon icon="XIcon" @click.stop="isSidebarActiveLocal = false" class="cursor-pointer"></feather-icon>
    </div>
    <vs-divider class="mb-0"></vs-divider>

    <component :is="scrollbarTag" class="scroll-area--data-list-add-new" :settings="settings" :key="$vs.rtl">

      <div class="p-6">
        <div class="vs-component vs-con-input-label vs-input mt-5 w-full vs-input-primary">
          <label for="" class="vs-input--label">Ngày</label>
            <datepicker :format="format" name="item-date" v-model="dataDate"></datepicker>
        </div>
        
        <!-- Thời gian bắt đầu -->
        <vs-input label="Thời gian bắt đầu" type="number" min="0" max="23" v-model="dataOpentime" class="mt-5 w-full" name="item-open-time" v-validate="'required'" />
        <span class="text-danger text-sm" v-show="errors.has('item-open-time')">{{ errors.first('item-open-time') }}</span>

        
      </div>
    </component>

    <div class="flex flex-wrap items-center p-6" slot="footer">
      <vs-button class="mr-6" @click="submitData" >{{ Object.entries(this.data).length === 0 ? "Thêm mới" : "Cập nhật" }}</vs-button>
      <vs-button type="border" color="danger" @click="isSidebarActiveLocal = false">Hủy</vs-button>
    </div>
  </vs-sidebar>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
import VuePerfectScrollbar from 'vue-perfect-scrollbar'
import axios from './../../../../http/axios.js'

export default {
  props: {
    isSidebarActive: {
      type: Boolean,
      required: true
    },
    data: {
      type: Object,
      default: () => {}
    }
  },
  components: {
    VuePerfectScrollbar,
    Datepicker
  },
  data () {
    return {
      format: "dd/MM/yyyy",
      dataId: null,
      dataDate: null,
      dataOpentime: null,
      settings: { // perfectscrollbar settings
        maxScrollbarLength: 60,
        wheelSpeed: .60
      }
    }
  },
  watch: {
    isSidebarActive (val) {
      if (!val) return
      if (Object.entries(this.data).length === 0) {
        this.initValues()
        this.$validator.reset()
      } else {
        const { id, date, open_time } = JSON.parse(JSON.stringify(this.data))
        this.dataId = id
        this.dataDate = new Date(date)
        this.dataOpentime = open_time.split(":")[0]
      }
    }
  },
  computed: {
    isSidebarActiveLocal: {
      get () {
        return this.isSidebarActive
      },
      set (val) {
        if (!val) {
          this.$emit('closeSidebar')
          // this.$validator.reset()
          // this.initValues()
        }
      }
    },
    scrollbarTag () { return this.$store.getters.scrollbarTag }
  },
  methods: {
    initValues () {
      if (this.data.id) return
      this.dataId = null
      this.dataDate = null
      this.dataOpentime = null
    },
    submitData () {
      this.$validator.validateAll().then(result => {
        if (result) {
          const obj = {
            id: this.dataId,
            date: this.formatDate(this.dataDate),
            open_time: this.dataOpentime
          }
          this.$vs.loading()
          axios.p('/api/user/law-schedules/add',obj).then((response) => {
            /* Below two lines are just for demo purpose */
            this.$vs.loading.close()
            if(response.data.status==1){
              this.$vs.notify({
                title: 'Thành Công',
                text: response.data.message,
                color: 'success',
                iconPack: 'feather',
                icon: 'icon-check'
              })
              this.$emit('closeSidebar')
              this.initValues()
            }else{
              this.$vs.notify({
                title: 'Lỗi',
                text: response.data.message,
                iconPack: 'feather',
                icon: 'icon-alert-circle',
                color: 'danger'
              })
            }
          }).catch((error)   => { console.log(error); this.$vs.loading.close(); })
          
        }
      })
    },
    padTo2Digits(num) {
      return num.toString().padStart(2, '0');
    },

    formatDate(date) {
      return [
        date.getFullYear(),
        this.padTo2Digits(date.getMonth() + 1),
        this.padTo2Digits(date.getDate()),
      ].join('-');
    }
  }
}
</script>

<style lang="scss" scoped>
.add-new-data-sidebar {
  ::v-deep .vs-sidebar--background {
    z-index: 52010;
  }

  ::v-deep .vs-sidebar {
    z-index: 52010;
    width: 400px;
    max-width: 90vw;

    .img-upload {
      margin-top: 2rem;

      .con-img-upload {
        padding: 0;
      }

      .con-input-upload {
        width: 100%;
        margin: 0;
      }
    }
  }
}

.scroll-area--data-list-add-new {
    // height: calc(var(--vh, 1vh) * 100 - 4.3rem);
    height: calc(var(--vh, 1vh) * 100 - 16px - 45px - 82px);

    &:not(.ps) {
      overflow-y: auto;
    }
}
</style>
