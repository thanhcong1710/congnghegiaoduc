<!-- =========================================================================================
    File Name: Login.vue
    Description: Login Page
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
  <div class="h-screen flex w-full bg-img vx-row no-gutter justify-center items-center">
    <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-2/5 m-4">
      <vx-card class="pt-8 pb-8">
        <img src="/static/logo.png" alt="" style="width: 200px; margin: auto;">
        <div class="vx-card__title mb-6 mt-8">
          <p class="mb-1">Bạn đã được mời tham gia</p>
          <h3>{{room.title}}</h3>
        </div>

        <div class="subscription">
          <div class="mb-3">
            <label for="" class="vs-input--label">Tên truy cập</label>
            <input type="text" v-model="input.name" class="vs-inputx vs-input--input normal mt-1">
            <span class="text-danger text-sm">{{ error.name }}</span>
          </div>
          <div v-if="room.pass" class=" mb-5">
            <label for="" class="vs-input--label" >Mã truy cập</label>
            <input type="text" v-model="input.pass" class="vs-inputx vs-input--input normal mt-1" >
            <span class="text-danger text-sm">{{ error.pass }}</span>
          </div>
          <vs-button class="w-full" @click="join()"> Tham gia cuộc họp</vs-button>
        </div>
      </vx-card>
    </div>
  </div>
</template>


<script>
import VueCountdown from '@chenfengyuan/vue-countdown'
import axios from './../../http/axios.js'
export default {
  data () {
    return {
      room: {
        id: '',
        title: '',
        pass: '',
        code: '',
      },
      input:{
        name:'',
        pass:''
      },
      error:{
        name:'',
        pass:''
      }
    }
  },
  components: {
    'countdown': VueCountdown
  },
  created() {
    this.getRoomInfo();
  },
  methods: {
    getRoomInfo() {
      this.$vs.loading()
      axios.g(`/api/room/info/${this.$route.params.code}`)
        .then((response) => {
          this.$vs.loading.close()
          if (response.data.status) {
            this.room = response.data.data
          } else {
            this.$router.push({
              name: 'page-error-404'
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
    join(){
      this.error.name= ''
      if(!this.input.name){
        this.error.name = "Tên truy cập là bắt buộc";
      }else{
        this.$vs.loading()
        axios.p(`/api/room/join`,{
          code: this.room.code,
          name: this.input.name,
          pass: this.input.pass
        })
        .then((response) => {
          if (response.data.status) {
            window.location.href = response.data.redirect_url;
            this.$vs.loading.close()
          } else {
            this.$vs.loading.close()
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
      }

    }
  },
}

</script>

