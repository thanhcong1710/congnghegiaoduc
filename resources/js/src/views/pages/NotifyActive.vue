<!-- =========================================================================================
    File Name: Register.vue
    Description: Register Page
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
    <div class="h-screen flex w-full bg-img vx-row no-gutter items-center justify-center">
        <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-3/4 xl:w-3/5 sm:m-0 m-4">
            <vx-card>
                <div slot="no-body" class="full-page-bg-color">
                    <div class="vx-row no-gutter">
                        <div class="vx-col hidden sm:hidden md:hidden lg:block lg:w-1/2 mx-auto self-center">
                            <img src="@assets/images/pages/register.jpg" alt="register" class="mx-auto">
                        </div>
                        <div class="vx-col sm:w-full md:w-full lg:w-1/2 mx-auto self-center  d-theme-dark-bg">
                            <div class="px-8 pt-8 pb-8 register-tabs-container">
                                <div class="text-center mb-12">
                                    <a href="/" >
                                        <img src="/static/logo.png" style="height: 64px; margin: auto"/>
                                    </a>
                                </div>
                                <div class="vx-card__title mb-6">
                                    <h4 class="mb-4">Tuyệt vời! Bây giờ hãy xác minh địa chỉ email của bạn.</h4>
                                    <img src="/static/verify_email.webp" style="height: 80px;"/>
                                    <p class="mt-3">Nhấp vào liên kết trong email chúng tôi đã gửi tới <strong>{{email}} </strong> </p>
                                    <p class="mt-2">Bạn chưa nhận được email? <a style="cursor: pointer;" @click="resendMailActive()">Gửi lại</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </vx-card>
        </div>
    </div>
</template>

<script>
import axios from './../../http/axios.js'
export default {
    data () {
        return {
            email: '',
        }
    },
    created() {
        this.email = this.$route.params.email
    },
    methods: {
        resendMailActive () {
            this.$vs.loading()
            axios.p(`/api/auth/resend-active`, {email:this.email})
            .then((response) => {
                this.$vs.loading.close()
                this.$vs.notify({
                    title: 'Thành công',
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
}
</script>

<style lang="scss">
.register-tabs-container {
  min-height: 517px;

  .con-tab {
    padding-bottom: 23px;
  }
}
</style>
