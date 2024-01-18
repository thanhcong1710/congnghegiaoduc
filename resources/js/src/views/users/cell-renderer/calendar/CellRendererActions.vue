<template>
    <div :style="{'direction': $vs.rtl ? 'rtl' : 'ltr'}">
      <feather-icon icon="SendIcon" svgClasses="h-5 w-5 mr-4 hover:text-primary cursor-pointer" @click="meeting" />
      <feather-icon icon="EditIcon" svgClasses="h-5 w-5 mr-4 hover:text-primary cursor-pointer" @click="editRow(params.data)" />
      <feather-icon icon="Trash2Icon" svgClasses="h-5 w-5 hover:text-danger cursor-pointer" @click="confirmDelete(params.value)" />
    </div>
</template>

<script>
import axios from './../../../../http/axios.js'
export default {
  name: 'CellRendererActions',
  methods: {
    editRow(data){
      this.params.context.componentParent.editData(data)
    },
    meeting() {
      axios.p('/api/video-call/create',{
        law_schedule_id: this.params.data.id
      }).then((response) => {
        if(response.data.status==1){
          window.open(response.data.redirect_url, "_blank")
        }else{
          this.$vs.notify({
            title: 'Lỗi',
            text: response.data.message,
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: 'danger'
          })
        }
      }) .catch((error)   => { console.log(error); this.$vs.loading.close(); })
    },
    confirmDelete (id) {
      this.$vs.dialog({
        type: 'confirm',
        color: 'danger',
        title: 'Thông báo',
        text: `Bạn chắc chắn muốn xóa bản ghi ID-${id}`,
        accept: this.deleteRecord,
        acceptText: 'Xóa',
        cancelText: 'Hủy'
      })
    },
    deleteRecord () {
      axios.p('/api/user/law-schedules/delete',{
        payment_id: this.params.value
      }).then((response) => {
        /* Below two lines are just for demo purpose */
        this.showDeleteSuccess()
        this.params.context.componentParent.getData()
      })
      
    },
    showDeleteSuccess () {
      this.$vs.notify({
        color: 'success',
        title: 'Thông báo',
        text: 'Bản ghi đã được xóa thành công.'
      })
    }
  }
}
</script>
