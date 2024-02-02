<template>
  <div>
    <vx-card
        card-background="linear-gradient(120deg, #7f7fd5, #86a8e7, #91eae4)"
        style="max-width: 480px; margin:auto;"
        class="text-center">
        <h5 style="font-size: 24px; color: #fff;">THÔNG TIN CHUYỂN KHOẢN</h5>
        <h2 style="font-size: 48px; color: #fff;" class="mt-5 mb-8">{{payment.amount | formatCurrency}}</h2>
        <div style="padding: 20px;font-size: 16px; background: #fff; color:#110111; border-radius: 6px;">
          <img width="100%" :src="'https://img.vietqr.io/image/VPB-64308987-compact.png?amount='+payment.amount+'&addInfo='+payment.code+'&accountName=LUONG THANH CONG'" />     
          <div class="flex justify-between flex-wrap mt-3">
            <span style="margin-top: 6px">Ngân hàng</span> 
            <span><img src="/static/img/logo_vpb.svg" height="25px"/></span>
          </div>
          <div class="flex justify-between flex-wrap mt-3" @click="copyText('64308987','64308987')" >
            <span>Số tài khoản:</span> 
            <span><strong style="font-weight: 500;">64308987</strong> <feather-icon style="cursor: pointer;margin-left: 8px" icon="CopyIcon" svgClasses="h-5 w-5"></feather-icon></span>
          </div>
          <div class="flex justify-between flex-wrap mt-3" @click="copyText('LUONG THANH CONG','LUONG THANH CONG')" >
            <span>Chủ tài khoản:</span> 
            <span><strong style="font-weight: 500;">LUONG THANH CONG</strong> <feather-icon style="cursor: pointer; margin-left: 8px" icon="CopyIcon" svgClasses="h-5 w-5"></feather-icon></span>
          </div>
          <div class="flex justify-between flex-wrap mt-3" @click="copyText(payment.amount.toString(), payment.amount.toString())">
            <span>Số tiền chuyển:</span> 
            <span><strong style="font-weight: 500;">{{payment.amount | formatCurrency}}</strong> <feather-icon style="cursor: pointer; margin-left: 8px" icon="CopyIcon" svgClasses="h-5 w-5"></feather-icon></span>
          </div>
          <div class="flex justify-between flex-wrap mt-3" @click="copyText(payment.code, payment.code)">
            <span>Nội dung chuyển:</span> 
            <span><strong style="font-weight: 500;">{{payment.code}}</strong> <feather-icon style="cursor: pointer; margin-left: 8px"  icon="CopyIcon" svgClasses="h-5 w-5"></feather-icon></span>
          </div>
          <div class="flex justify-between flex-wrap mt-5">
            <span>Trạng thái:</span> 
            <span><strong style="font-weight: 500;" :class="payment.status==2?'text-success' : (payment.status==1 ? 'text-warning' : 'text-primary')">{{payment.status==2?'hoàn thành' : (payment.status==1 ? 'chờ xác nhận' : 'chưa chuyển tiền')}}</strong></span>
          </div>
          <div>
            <vs-button color="success" class="w-full mt-4" @click="paySuccess" v-if="payment.status!=2">Đã chuyển khoản</vs-button>
          </div>
        </div>
    </vx-card>
    <div  style="margin:auto; margin-top:25px;max-width: 680px; text-align: justify">
        <ul style="list-style-type: disc;">
            <li><i>Vui lòng chuyển khoản 24/7 và đảm bảo đúng nội dung chuyển khoản để giao dịch được xử lý nhanh nhất.</i></li>
            <li><i>Khi chuyển khoản, vui lòng chọn hình thức Người chuyển trả phí để chúng tôi nhận được chính xác số tiền đã chuyển.</i></li>
            <li><i>Sau khi chuyển khoản, vui lòng chọn xác nhận đã chuyển khoản.</i></li>
        </ul>
    </div>
  </div>
</template>

<script>
  import axios from '../../http/axios.js'

  export default {
    components: {},
    data() {
      return {
        payment:{
          amount: '100000',
          code:'',
          status:'',
        }, 
      }
    },
    created() {
      this.getData();
    },
    methods: {
      getData() {
        this.$vs.loading()
        axios.g(`/api/user/payments/${this.$route.params.id}`)
          .then((response) => {
            this.$vs.loading.close()
            this.payment = response.data
          })
          .catch((error) => {
            console.log(error);
            this.$vs.loading.close();
          })
      },
      paySuccess(){
        this.$vs.loading()
        axios.p(`/api/user/payment-transfer`,{
          id:this.$route.params.id
        })
          .then((response) => {
            this.$vs.loading.close()
            this.payment.status = 1
            this.$vs.notify({
              title: 'Thành công',
              text: response.data.message,
              iconPack: 'feather',
              icon: 'icon-check-circle',
              color: 'success'
            })
          })
          .catch((error) => {
            console.log(error);
            this.$vs.loading.close();
          })
      },
      copyText(textCopy, message) {
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
    }
  }
</script>