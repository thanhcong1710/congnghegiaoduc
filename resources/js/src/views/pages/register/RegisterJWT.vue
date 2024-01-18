<!-- =========================================================================================
File Name: RegisterJWT.vue
Description: Register Page for JWT
----------------------------------------------------------------------------------------
Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
  <div class="clearfix">
    <vs-input
      v-validate="'required|min:3'"
      data-vv-validate-on="blur"
      label-placeholder="Họ tên"
      name="displayName"
      placeholder="Họ tên"
      v-model="displayName"
      class="w-full" />
    <span class="text-danger text-sm">{{ errors.first('displayName') }}</span>

    <vs-input
      v-validate="{ required: true, regex: /([\+84|84|0]+(3|5|7|8|9))+([0-9]{8})\b/ }"
      data-vv-validate-on="blur"
      name="phone"
      label-placeholder="Số điện thoại"
      placeholder="Số điện thoại"
      v-model="phone"
      class="w-full mt-6" />
    <span class="text-danger text-sm">{{ errors.first('phone') }}</span>

    <vs-input
      ref="password"
      type="password"
      data-vv-validate-on="blur"
      v-validate="'required|min:6|max:10'"
      name="password"
      label-placeholder="Mật khẩu"
      placeholder="Mật khẩu"
      v-model="password"
      class="w-full mt-6" />
    <span class="text-danger text-sm">{{ errors.first('password') }}</span>

    <vs-input
      type="password"
      v-validate="'min:6|max:10|confirmed:password'"
      data-vv-validate-on="blur"
      data-vv-as="password"
      name="confirm_password"
      label-placeholder="Mật khẩu"
      placeholder="Mật khẩu"
      v-model="confirm_password"
      class="w-full mt-6" />
    <span class="text-danger text-sm">{{ errors.first('confirm_password') }}</span>

    <vs-checkbox v-model="isTermsConditionAccepted" class="mt-6">I accept the terms & conditions.</vs-checkbox>
    <vs-button  type="border" to="/pages/login" class="mt-6">Login</vs-button>
    <vs-button class="float-right mt-6" @click="registerUserJWt" :disabled="!validateForm">Register</vs-button>
  </div>
</template>

<script>
export default {
  data () {
    return {
      displayName: '',
      phone: '',
      password: '',
      confirm_password: '',
      isTermsConditionAccepted: true
    }
  },
  computed: {
    validateForm () {
      return !this.errors.any() && this.displayName !== '' && this.phone !== '' && this.password !== '' && this.confirm_password !== '' && this.isTermsConditionAccepted === true
    }
  },
  methods: {
    checkLogin () {
      // If user is already logged in notify
      if (this.$store.state.auth.isUserLoggedIn()) {

        // Close animation if passed as payload
        // this.$vs.loading.close()

        this.$vs.notify({
          title: 'Login Attempt',
          text: 'You are already logged in!',
          iconPack: 'feather',
          icon: 'icon-alert-circle',
          color: 'warning'
        })

        return false
      }
      return true
    },
    registerUserJWt () {
      // If form is not validated or user is already login return
      if (!this.validateForm || !this.checkLogin()) return

      const payload = {
        userDetails: {
          displayName: this.displayName,
          phone: this.phone,
          password: this.password,
          confirmPassword: this.confirm_password
        },
        notify: this.$vs.notify,
        redirect_url : this.$store.state.eCommerce.cartItems.length > 0  ? '/law/checkout':''
      }
      this.$store.dispatch('auth/registerUserJWT', payload)
    }
  }
}
</script>
