<template>
  <vx-card no-shadow>
    <div class="vx-row tab-config-room">
      <div class="vx-col md:w-1/2 w-full mb-base item-first">
        <div class="mb-6">
          <label>Tên phòng họp</label>
          <div class=w-full>
            <input type="text" class="vs-inputx vs-input--input normal" style="border: 1px solid rgba(0, 0, 0, 0.2); width: calc(100% - 85px); float:left">
            <vs-button style="width:82px; float:left; padding:10px 5px; margin-left: 3px;">Cập nhật</vs-button>
          </div>
          <div style="clear:both"></div>
        </div>
        <div class="mb-6">
          <label>Tạo mã truy cập cho người xem</label>
          <div class=w-full>
            <input type="text" disabled="true" class="vs-inputx vs-input--input normal" style="border: 1px solid rgba(0, 0, 0, 0.2); width: calc(100% - 85px); float:left">
            <span style="width:82px; float:left; padding:10px 5px; margin-left: 3px;">
              <feather-icon icon="CopyIcon" svgClasses="h-5 w-5"></feather-icon>
              <feather-icon icon="RefreshCcwIcon" style="margin-left:3px" svgClasses="h-5 w-5"></feather-icon>
              <feather-icon icon="Trash2Icon" style="margin-left:3px"  svgClasses="h-5 w-5"></feather-icon>
            </span>
            <vs-button  type="border">Tạo mã truy cập</vs-button>
          </div>
          <div style="clear:both"></div>
        </div>
        <div class="mb-6">
          <label>Tạo mã truy cập cho người kiểm duyệt</label>
          <div class=w-full>
            <input type="text" disabled="true" class="vs-inputx vs-input--input normal" style="border: 1px solid rgba(0, 0, 0, 0.2); width: calc(100% - 85px); float:left">
            <span style="width:82px; float:left; padding:10px 5px; margin-left: 3px;">
              <feather-icon icon="CopyIcon" svgClasses="h-5 w-5"></feather-icon>
              <feather-icon icon="RefreshCcwIcon" style="margin-left:3px" svgClasses="h-5 w-5"></feather-icon>
              <feather-icon icon="Trash2Icon" style="margin-left:3px"  svgClasses="h-5 w-5"></feather-icon>
            </span>
            <vs-button  type="border">Tạo mã truy cập</vs-button>
          </div>
          <div style="clear:both"></div>
        </div>
      </div>
      <div class="vx-col md:w-1/2 w-full mb-base item-last">
        <h5 class="mb-6">Thiết lập người dùng</h5>
        <div class="mb-4">
          <div class=w-full>
            <label style=" width: calc(100% - 50px); float:left">Cho phép ghi hình lại phòng họp</label> <vs-switch v-model="switch1" style="float:left; margin-left: 5px;"/>
          </div>
          <div style="clear:both"></div>
        </div>
        <div class="mb-4">
          <div class=w-full>
            <label style=" width: calc(100% - 50px); float:left">Cho phép bất kỳ người dùng nào bắt đầu cuộc họp này</label> <vs-switch v-model="switch1" style="float:left; margin-left: 5px;"/>
          </div>
          <div style="clear:both"></div>
        </div>
        <div class="mb-4">
          <div class=w-full>
            <label style=" width: calc(100% - 50px); float:left">Tất cả người dùng tham gia với tư cách là người kiểm duyệt</label> <vs-switch v-model="switch1" style="float:left; margin-left: 5px;"/>
          </div>
          <div style="clear:both"></div>
        </div>
        <div class="mb-4">
          <div class=w-full>
            <label style=" width: calc(100% - 50px); float:left">Tắt tiếng người dùng khi họ tham gia</label> <vs-switch v-model="switch1" style="float:left; margin-left: 5px;"/>
          </div>
          <div style="clear:both"></div>
        </div>
        <div class="mb-4">
          <vs-button style="float:right" type="border" color="danger">Xóa phòng họp</vs-button>
          <div style="clear:both"></div>
        </div>
      </div>
    </div>
  </vx-card>

</template>

<script>
  import axios from './../../../http/axios.js'
  export default {
    data() {
      return {
        room: {},
        alert: {
          status: '',
          show: false,
          message: ''
        },
        switch1:''
      }
    },
    created() {
      // this.getRoomInfo();
    },
    methods: {
      getRoomInfo() {
        this.$vs.loading()
        axios.g(`/api/rooms/info/${this.$route.params.id}`)
          .then((response) => {
            this.$vs.loading.close()
            if (response.data.status) {
              this.room = response.data.data
            } else {
              this.$router.push({
                name: 'rooms'
              }).catch(() => {})
              this.$vs.notify({
                title: 'Lỗi',
                text: response.data.message,
                iconPack: 'feather',
                icon: 'icon-alert-circle',
                color: 'danger'
              })
            }
          })
          .catch((error) => {
            console.log(error);
            this.$vs.loading.close();
          })
      },
      reset() {
        this.phone = this.$store.state.AppActiveUser.phone
        this.name = this.$store.state.AppActiveUser.name
        this.email = this.$store.state.AppActiveUser.email
      }
    },
  }
</script>
<style scoped>
.tab-config-room .vx-col.mb-base.item-first{
  border-right: 1px solid #ccc
}
.tab-config-room .vx-col.mb-base.item-last{
  border-left: 1px solid #ccc
}
@media (max-width: 768px) {
  .tab-config-room .vx-col.mb-base.item-last, .tab-config-room .vx-col.mb-base.item-first{
    border:none
  }
}
</style>