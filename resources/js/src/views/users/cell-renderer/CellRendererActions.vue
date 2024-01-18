<template>
    <div :style="{'direction': $vs.rtl ? 'rtl' : 'ltr'}">
      <feather-icon icon="DollarSignIcon" svgClasses="h-5 w-5 mr-4 hover:text-primary cursor-pointer" @click="payRecord" />
      <feather-icon icon="Trash2Icon" svgClasses="h-5 w-5 hover:text-danger cursor-pointer" @click="confirmDeleteRecord(params.value)" />
    </div>
</template>

<script>
import axios from './../../../http/axios.js'
export default {
  name: 'CellRendererActions',
  methods: {
    payRecord () {
      this.$router.push(`/apps/user/pay/${  268}`).catch(() => {})

      /*
              Below line will be for actual product
              Currently it's commented due to demo purpose - Above url is for demo purpose

              this.$router.push("/apps/user/user-edit/" + this.params.data.id).catch(() => {})
            */
    },
    confirmDeleteRecord (id) {
      this.$vs.dialog({
        type: 'confirm',
        color: 'danger',
        title: 'Thông báo',
        text: `Bạn chắc chắn muốn xóa bản ghi thanh toán ID-${id}`,
        accept: this.deleteRecord,
        acceptText: 'Xóa',
        cancelText: 'Hủy'
      })
    },
    deleteRecord () {
      axios.p('/api/payment/delete',{
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
        text: 'Bản ghi thanh toán đã đước xóa thành công.'
      })
    }
  }
}
</script>
