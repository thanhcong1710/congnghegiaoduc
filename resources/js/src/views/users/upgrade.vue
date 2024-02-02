<template>
  <section id="pricing-plan">
    <div class="text-center">
      <h1 class="mt-5"> Chính sách giá </h1>
      
    </div>
    <div class="vx-row pricing-card mt-10" style="justify-content: center; display: flex; width: 100%;">
      <div class="md:w-10/12 w-full">
        <div class="vx-row">
          <div :class="!user.is_vip ? 'vx-col md:w-1/3 w-full mb-4 active' : 'vx-col md:w-1/3 w-full mb-4'">
            <div class="vx-card text-center">
              <!---->
              <!---->
              <div class="card-body p-5">
                <h3 style="color: #07d5c0;" class="mt-5">Miễn Phí</h3>
                <div class="annual-plan">
                  <div class="plan-price mt-4 mb-4">
                    <span class="pricing-basic-value font-weight-bolder text-primary">0</span>
                    <sub class="font-medium-1 font-weight-bold text-primary">đ</sub>
                    <sub class="pricing-duration text-body font-medium-1 font-weight-bold">/tháng</sub>
                  </div>
                </div>
                <div class="vs-list">
                  <div class="vs-list--item">
                    <div class="vs-list--icon">
                      <i class="vs-icon notranslate icon-scale feather icon-check null" style="font-size: 20px !important; color: #0fc305;"></i>
                    </div>
                    <div class="list-titles">
                      <div class="vs-list--subtitle">Cuộc họp video <span style="color:#d5072a; font-size:14px">không giới hạn thời gian họp</span></div>
                    </div>
                  </div>
                  <div class="vs-list--item">
                    <div class="vs-list--icon">
                      <i class="vs-icon notranslate icon-scale feather icon-check null" style="font-size: 20px !important; color: #0fc305;"></i>
                    </div>
                    <div class="list-titles">
                      <div class="vs-list--subtitle">Người tham gia (100 người)</div>
                    </div>
                  </div>
                  <div class="vs-list--item">
                    <div class="vs-list--icon">
                      <i class="vs-icon notranslate icon-scale feather icon-check null" style="font-size: 20px !important; color: #0fc305;"></i>
                    </div>
                    <div class="list-titles">
                      <div class="vs-list--subtitle">Ghi lại cuộc họp (lưu trữ 3 ngày)</div>
                    </div>
                  </div>
                  <div class="vs-list--item">
                    <div class="vs-list--icon">
                      <i class="vs-icon notranslate icon-scale feather icon-check null" style="font-size: 20px !important; color: #0fc305;"></i>
                    </div>
                    <div class="list-titles">
                      <div class="vs-list--subtitle">Bảng trắng</div>
                    </div>
                  </div>
                  <div class="vs-list--item">
                    <div class="vs-list--icon">
                      <i class="vs-icon notranslate icon-scale feather icon-check null" style="font-size: 20px !important; color: #0fc305;"></i>
                    </div>
                    <div class="list-titles">
                      <div class="vs-list--subtitle">Chia sẻ màn hình</div>
                    </div>
                  </div>
                  <div class="vs-list--item">
                    <div class="vs-list--icon">
                      <i class="vs-icon notranslate icon-scale feather icon-check null" style="font-size: 20px !important; color: #0fc305;"></i>
                    </div>
                    <div class="list-titles">
                      <div class="vs-list--subtitle">Trình bày slide</div>
                    </div>
                  </div>
                  <div class="vs-list--item">
                    <div class="vs-list--icon">
                      <i class="vs-icon notranslate icon-scale feather icon-check null" style="font-size: 20px !important; color: #0fc305;"></i>
                    </div>
                    <div class="list-titles">
                      <div class="vs-list--subtitle">Trò chuyện nhóm</div>
                    </div>
                  </div>
                   <div class="vs-list--item">
                    <div class="vs-list--icon">
                      <i class="vs-icon notranslate icon-scale feather icon-check null" style="font-size: 20px !important; color: #0fc305;"></i>
                    </div>
                    <div class="list-titles">
                      <div class="vs-list--subtitle">Bảng tổng kết sau cuộc họp</div>
                    </div>
                  </div>
                </div>
              </div>
              <!---->
              <!---->
            </div>
          </div>
          <div :class="user.is_vip ? 'vx-col md:w-1/3 w-full mb-4 active' : 'vx-col md:w-1/3 w-full mb-4'">
            <div class="vx-card text-center">
              <!---->
              <!---->
              <div class="card-body p-5">
                <h3 style="color: #65c600;" class="mt-5">VIP</h3>
                <div class="annual-plan">
                  <div class="plan-price mt-4 mb-4">
                    <span class="pricing-basic-value font-weight-bolder text-primary">{{amount_vip | formatCurrency}}</span>
                    <sub class="font-medium-1 font-weight-bold text-primary">đ</sub>
                    <sub class="pricing-duration text-body font-medium-1 font-weight-bold">/tháng</sub>
                  </div>
                </div>
                <div class="vs-list">
                  <div class="vs-list--item">
                    <div class="vs-list--icon">
                      <i class="vs-icon notranslate icon-scale feather icon-check null" style="font-size: 20px !important; color: #0fc305;"></i>
                    </div>
                    <div class="list-titles">
                      <div class="vs-list--subtitle"> Đầy đủ tính năng của gói miễn phí</div>
                    </div>
                  </div>
                  <div class="vs-list--item">
                    <div class="vs-list--icon">
                      <i class="vs-icon notranslate icon-scale feather icon-check null" style="font-size: 20px !important; color: #0fc305;"></i>
                    </div>
                    <div class="list-titles">
                      <div class="vs-list--subtitle">Người tham gia <span style="color:#d5072a; font-size:14px">không giới hạn</span></div>
                    </div>
                  </div>
                  <div class="vs-list--item">
                    <div class="vs-list--icon">
                      <i class="vs-icon notranslate icon-scale feather icon-check null" style="font-size: 20px !important; color: #0fc305;"></i>
                    </div>
                    <div class="list-titles">
                      <div class="vs-list--subtitle">Ghi lại cuộc họp <span style="color:#d5072a; font-size:14px">lưu trữ không giới hạn</span></div>
                    </div>
                  </div>
                </div>
                <div class="text-success text-center mb-3" v-if="user.end_vip && user.num_vip >3" >(Hạn dùng: {{user.end_vip}})</div>
                <div class="text-warning text-center mb-3" v-if="user.end_vip && user.num_vip <= 3 && user.num_vip > 0">(Hạn dùng: {{user.end_vip}})</div>
                <div class="text-danger text-center mb-3" v-if="user.end_vip  && user.num_vip == 0">(Tài khoản hết hạn)</div>
                <vs-button color="primary" type="filled" class="w-full" @click="addPayment">{{user.end_vip ? 'Gia hạn ngay' : 'Nâng cấp ngay'}}</vs-button>
              </div>
              <!---->
              <!---->
            </div>
          </div>
          <div class="vx-col md:w-1/3 w-full  mb-4">
            <div class="vx-card text-center">
              <!---->
              <!---->
              <div class="card-body p-5">
                <h3 tyle="color: #ff901c;" class="mt-5">Doanh Nghiệp</h3>
                <p class="card-text mt-3" style="text-align: justify;"> Liên hệ với chúng tôi để biết thêm thông tin về mức giá và hơn thế nữa </p>
                
                <div class="vs-list">
                  <div class="vs-list--item">
                    <div class="vs-list--icon">
                      <i class="vs-icon notranslate icon-scale feather icon-check null" style="font-size: 20px !important; color: #0fc305;"></i>
                    </div>
                    <div class="list-titles">
                      <div class="vs-list--subtitle">Đầy đủ tính năng của gói VIP</div>
                    </div>
                  </div>
                  <div class="vs-list--item">
                    <div class="vs-list--icon">
                      <i class="vs-icon notranslate icon-scale feather icon-check null" style="font-size: 20px !important; color: #0fc305;"></i>
                    </div>
                    <div class="list-titles">
                      <div class="vs-list--subtitle">Máy chủ dùng riêng</div>
                    </div>
                  </div>
                  <div class="vs-list--item">
                    <div class="vs-list--icon">
                      <i class="vs-icon notranslate icon-scale feather icon-check null" style="font-size: 20px !important; color: #0fc305;"></i>
                    </div>
                    <div class="list-titles">
                      <div class="vs-list--subtitle">API kết nối</div>
                    </div>
                  </div>
                  
                </div>
                <vs-button color="primary" type="border" class="w-full" @click="showModalContact()">Liên hệ ngay</vs-button>
              </div>
              <!---->
              <!---->
            </div>
          </div>
        </div>
      </div>
    </div>
    <vs-popup title="Liên hệ tư vấn" :active.sync="popup.active">
      <div class="vx-col w-full mt-2">
        <vs-input class="w-full" label="Tên công ty" v-model="popup.company" />
      </div>
      <div class="vx-col w-full mt-2">
        <vs-input class="w-full" label="Người liên hệ" v-model="popup.contact_name" />
      </div>
      <div class="vx-col w-full mt-2">
        <vs-input class="w-full" label="Số điện thoại liên hệ" v-model="popup.phone" />
      </div>
      <div class="vx-col w-full mt-4">
        <vs-textarea label="Ghi chú" class="w-full" v-model="popup.content" />
      </div>
      <span class="text-danger text-sm">{{ popup.error }}</span>
      <div class="vx-col w-full mt-5 text-right">
        <vs-button color="dark" type="border" @click="popup.active = false">Hủy</vs-button>
        <vs-button color="primary" type="filled" @click="addContact()">Gửi</vs-button>
      </div>
    </vs-popup>
  </section>
</template>

<script>
  import axios from '../../http/axios.js'

  export default {
    components: {},
    data() {
      return {
        amount_vip: 100000,
        user:{
          is_vip: this.$store.state.AppActiveUser.is_vip,
          end_vip: this.$store.state.AppActiveUser.is_vip,
          num_vip :0
        }, 
        popup:{
          active: false,
          company: '',
          contact_name :'',
          phone: '',
          content: '',
          error:''
        },
        records: [],
        pagination: {
          url: "/api/records/list",
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
          init: 0
        },
      }
    },
    created() {
      this.getData();
    },
    methods: {
      getData() {
        this.$vs.loading()
        axios.p(`/api/records/list`, {
            pagination: this.pagination
          })
          .then((response) => {
            this.$vs.loading.close()
            this.records = response.data.list
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
      openConfirmDelete(id, file_name) {
        this.delete_id = id
        this.$vs.dialog({
          type: 'confirm',
          color: 'danger',
          title: `Thông báo`,
          text: 'Bạn muốn xóa bản ghi lưu trữ phòng họp ' + file_name,
          accept: this.acceptDelete,
          acceptText: 'Xóa',
          cancelText: 'Hủy'
        })
      },
      acceptDelete() {
        this.$vs.loading()
        axios.g(`/api/records/delete/${this.delete_id}`)
          .then((response) => {
            this.$vs.loading.close()
            this.getData();
          })
          .catch((error) => {
            console.log(error);
            this.$vs.loading.close();
          })
      },
      showModalContact(){
        this.popup.active =true
        this.resetModalContact();
      },
      resetModalContact(){
        this.popup.company= ''
        this.popup.contact_name=''
        this.popup.phone= ''
        this.popup.content= ''
        this.popup.error=''
      },
      addContact(){
        if(!this.popup.phone){
          this.popup.error= 'Số điện thoại liên hệ không để trống';
          return false;
        }else{
          this.$vs.loading()
          axios.p(`/api/user/contact`,{
            company : this.popup.company,
            contact_name : this.popup.contact_name,
            phone : this.popup.phone,
            note : this.popup.content,
          })
          .then((response) => {
            this.$vs.loading.close()
            this.popup.active =false
            this.resetModalContact();
            this.$vs.notify({
              title: 'Thành Công',
              text: response.data.message,
              iconPack: 'feather',
              icon: 'icon-alert-circle',
              color: 'success'
            })
          })
          .catch((error) => {
            console.log(error);
            this.$vs.loading.close();
          })
        }
      },
      addPayment(){
        this.$vs.loading()
        axios.p(`/api/user/payment-add`,{
          amount:this.amount_vip
        })
          .then((response) => {
            this.$vs.loading.close()
            
          })
          .catch((error) => {
            console.log(error);
            this.$vs.loading.close();
          })
      }
    }
  }
</script>
<style scoped>
.vs-list--item{
  border-bottom: none;
}
.pricing-card .annual-plan .plan-price span {
    font-size: 32px;
    line-height: .8;
}
.pricing-card .annual-plan .plan-price sub{
  font-size: 16px;
}
.pricing-card .annual-plan .plan-price .font-weight-bolder {
    font-weight: 600!important;
}
.pricing-card .vs-list--subtitle{
  font-size: 14px;
}
.vx-row.pricing-card {
  margin: 10px 0px;
}
.vs-list--item .list-titles{
 text-align: left;
}
#pricing-plan .vx-col.active .vx-card{
  border: 2px solid rgba(var(--vs-primary), 1) ;
}
</style>