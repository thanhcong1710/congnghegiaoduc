<template>
  <vx-card no-shadow>
    <div class="vx-row tab-config-room">
      <div class="vx-col md:w-1/2 w-full mb-base item-first">
        <div class="mb-6">
          <label>Tên phòng họp</label>
          <div class=w-full>
            <input type="text" v-model="room.title" class="vs-inputx vs-input--input normal" style="border: 1px solid rgba(0, 0, 0, 0.2); width: calc(100% - 85px); float:left">
            <vs-button style="width:82px; float:left; padding:10px 5px; margin-left: 3px;" @click="updateTitleRoom()">Cập nhật</vs-button>
          </div>
          <div style="clear:both"></div>
        </div>
        <div class="mb-6">
          <label>Tạo mã truy cập cho người xem</label>
          <div class=w-full v-if="room.password_attendee">
            <input type="text" v-model="room.password_attendee" disabled="true" class="vs-inputx vs-input--input normal" style="border: 1px solid rgba(0, 0, 0, 0.2); width: calc(100% - 85px); float:left">
            <span style="width:82px; float:left; padding:10px 5px; margin-left: 3px;">
              <feather-icon icon="CopyIcon" @click="copyText(room.password_attendee)" svgClasses="h-5 w-5"></feather-icon>
              <feather-icon icon="RefreshCcwIcon" @click="genPass(1)" style="margin-left:3px" svgClasses="h-5 w-5"></feather-icon>
              <feather-icon icon="Trash2Icon" @click="removePass(1)" style="margin-left:3px"  svgClasses="h-5 w-5"></feather-icon>
            </span>
          </div>
          <div class=w-full v-else>
            <vs-button class="mt-2" type="border" @click="genPass(1)">Tạo mã truy cập</vs-button>
          </div>
          <div style="clear:both"></div>
        </div>
        <div class="mb-6">
          <label>Tạo mã truy cập cho người kiểm duyệt</label>
          <div class=w-full v-if="room.password_moderator">
            <input type="text" v-model="room.password_moderator" disabled="true" class="vs-inputx vs-input--input normal" style="border: 1px solid rgba(0, 0, 0, 0.2); width: calc(100% - 85px); float:left">
            <span style="width:82px; float:left; padding:10px 5px; margin-left: 3px;">
              <feather-icon icon="CopyIcon" @click="copyText(room.password_moderator)" svgClasses="h-5 w-5"></feather-icon>
              <feather-icon icon="RefreshCcwIcon" @click="genPass(1)" style="margin-left:3px" svgClasses="h-5 w-5"></feather-icon>
              <feather-icon icon="Trash2Icon" @click="removePass(2)" style="margin-left:3px"  svgClasses="h-5 w-5"></feather-icon>
            </span>
          </div>
          <div class=w-full v-else>
            <vs-button class="mt-2" type="border" @click="genPass(2)">Tạo mã truy cập</vs-button>
          </div>
          <div style="clear:both"></div>
        </div>
      </div>
      <div class="vx-col md:w-1/2 w-full mb-base item-last">
        <h5 class="mb-6">Thiết lập người dùng</h5>
        <div class="mb-4">
          <div class=w-full>
            <label style=" width: calc(100% - 50px); float:left">Cho phép ghi hình lại phòng họp</label> <vs-switch v-model="room.cf_record" @click="updateConfigRoom" style="float:left; margin-left: 5px;"/>
          </div>
          <div style="clear:both"></div>
        </div>
        <div class="mb-4">
          <div class=w-full>
            <label style=" width: calc(100% - 50px); float:left">Cho phép bất kỳ người dùng nào bắt đầu cuộc họp này</label> <vs-switch v-model="room.cf_user_start" @click="updateConfigRoom" style="float:left; margin-left: 5px;"/>
          </div>
          <div style="clear:both"></div>
        </div>
        <div class="mb-4">
          <div class=w-full>
            <label style=" width: calc(100% - 50px); float:left">Tất cả người dùng tham gia với tư cách là người kiểm duyệt</label> <vs-switch v-model="room.cf_moderator" @click="updateConfigRoom" style="float:left; margin-left: 5px;"/>
          </div>
          <div style="clear:both"></div>
        </div>
        <div class="mb-4">
          <div class=w-full>
            <label style=" width: calc(100% - 50px); float:left">Tắt tiếng người dùng khi họ tham gia</label> <vs-switch v-model="room.cf_join_voice" @click="updateConfigRoom" style="float:left; margin-left: 5px;"/>
          </div>
          <div style="clear:both"></div>
        </div>
        <div class="mb-4">
          <vs-button style="float:right" type="border" color="danger" @click="openConfirmDeleteRoom(room.id, room.title)">Xóa phòng họp</vs-button>
          <div style="clear:both"></div>
        </div>
      </div>
    </div>
  </vx-card>

</template>

<script>
  import axios from './../../../http/axios.js'
  export default {
    props: {
      room: {
        type: Object,
        default: () => {}
      },
    },
    data() {
      return {
        delete_room_id:'',
        alert: {
          status: '',
          show: false,
          message: ''
        },
        switch1:''
      }
    },
    created() {
      
    },
    methods: {
      copyText(textCopy) {
          const thisIns = this;
          this.$copyText(textCopy).then(function() {
              thisIns.$vs.notify({
                  title: 'Copy',
                  text: textCopy,
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
      updateTitleRoom(){
        if(this.room.title){
          this.$vs.loading()
          axios.p(`/api/rooms/update`,{
            id: this.room.id,
            title: this.room.title
          })
          .then((response) => {
            this.$vs.loading.close()
            if (response.data.status) {
              this.$vs.notify({
                title: 'Thành Công',
                text: response.data.message,
                iconPack: 'feather',
                icon: 'icon-alert-circle',
                color: 'success'
              })
            } else {
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
        }else{
          this.$vs.notify({
            title: 'Lỗi',
            text: 'Tên phòng họp không được để trống',
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: 'danger'
          })
        }
      },
      removePass(type){
        this.$vs.loading()
        axios.p(`/api/rooms/remove-pass`,{
          id: this.room.id,
          type: type
        })
        .then((response) => {
          this.$vs.loading.close()
          if (response.data.status) {
            this.room = response.data.data
            this.$vs.notify({
              title: 'Thành Công',
              text: response.data.message,
              iconPack: 'feather',
              icon: 'icon-alert-circle',
              color: 'success'
            })
          } else {
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
      genPass(type){
        this.$vs.loading()
        axios.p(`/api/rooms/gen-pass`,{
          id: this.room.id,
          type: type
        })
        .then((response) => {
          this.$vs.loading.close()
          if (response.data.status) {
            this.room = response.data.data
            this.$vs.notify({
              title: 'Thành Công',
              text: response.data.message,
              iconPack: 'feather',
              icon: 'icon-alert-circle',
              color: 'success'
            })
          } else {
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
      openConfirmDeleteRoom(id,room_name) {
        this.delete_room_id = id
        this.$vs.dialog({
          type: 'confirm',
          color: 'danger',
          title: `Thông báo`,
          text: 'Bạn muốn xóa phòng họp '+room_name,
          accept: this.acceptDeleteRoom,
          acceptText: 'Xóa',
          cancelText:'Hủy'
        })
      },
      acceptDeleteRoom() {
        this.$vs.loading()
        axios.g(`/api/rooms/room-delete/${this.delete_room_id}`)
          .then((response) => {
            this.$vs.loading.close()
            if (response.data.status) {
              this.$router.push({name: 'rooms'}).catch(() => {})
              this.$vs.notify({
                title: 'Thành Công',
                text: response.data.message,
                iconPack: 'feather',
                icon: 'icon-alert-circle',
                color: 'success'
              })
            } else {
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
      updateConfigRoom(){
        this.$vs.loading()
        axios.p(`/api/rooms/update`,{
          id: this.room.id,
          cf_record: this.room.cf_record,
          cf_user_start: this.room.cf_user_start,
          cf_moderator: this.room.cf_moderator,
          cf_join_voice: this.room.cf_join_voice,
        })
        .then((response) => {
          this.$vs.loading.close()
          if (response.data.status) {
            this.$vs.notify({
              title: 'Thành Công',
              text: response.data.message,
              iconPack: 'feather',
              icon: 'icon-alert-circle',
              color: 'success'
            })
          } else {
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
.feather-icon {
  cursor: pointer;
}
@media (max-width: 768px) {
  .tab-config-room .vx-col.mb-base.item-last, .tab-config-room .vx-col.mb-base.item-first{
    border:none
  }
}
</style>