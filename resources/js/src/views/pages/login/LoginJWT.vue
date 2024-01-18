<template>
  <div>
    <div class="mb-10 text-center">
      <a @click="changeDemo(1)" class="mr-3">Guest</a> |
      <a @click="changeDemo(2)" class="ml-3">Lawer</a>
    </div>
    <vs-input
        v-validate="{ required: true, regex: /(84[3|5|7|8|9]|0[3|5|7|8|9])+([0-9]{8})\b/g }"
        data-vv-validate-on="blur"
        name="phone"
        icon-no-border
        icon="icon icon-user"
        icon-pack="feather"
        label-placeholder="Số điện thoại"
        v-model="phone"
        class="w-full"/>
    <span class="text-danger text-sm">{{ errors.first('phone') }}</span>

    <vs-input
        data-vv-validate-on="blur"
        v-validate="'required|min:6|max:10'"
        type="password"
        name="password"
        icon-no-border
        icon="icon icon-lock"
        icon-pack="feather"
        label-placeholder="Mật khẩu"
        v-model="password"
        class="w-full mt-6" />
    <span class="text-danger text-sm">{{ errors.first('password') }}</span>

    <div class="flex flex-wrap justify-between my-5">
        <vs-checkbox v-model="checkbox_remember_me" class="mb-3">Remember Me</vs-checkbox>
        <router-link to="/pages/forgot-password">Forgot Password?</router-link>
    </div>
    <div class="flex flex-wrap justify-between mb-3">
      <vs-button  type="border" @click="registerUser">Register</vs-button>
      <vs-button :disabled="!validateForm" @click="loginJWT">Login</vs-button>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      phone: '0389941903',
      password: 'abcd1234',
      checkbox_remember_me: false
    }
  },
  computed: {
    validateForm () {
      return !this.errors.any() && this.phone !== '' && this.password !== ''
    }
  },
  methods: {
    changeDemo(type){
      if(type==1){
        this.phone= '0389941903'
        this.password= 'abcd1234'
      }else if(type==2){
        this.phone= '0389941904'
        this.password= 'abcd1234'
      }
    },
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
    loginJWT () {
      if (!this.checkLogin()) return

      // Loading
      this.$vs.loading()

      const payload = {
        checkbox_remember_me: this.checkbox_remember_me,
        userDetails: {
          phone: this.phone,
          password: this.password
        },
        redirect_url : this.$store.state.eCommerce.cartItems.length > 0  ? '/law/checkout':''
      }

      this.$store.dispatch('auth/loginJWT', payload)
        .then(() => { this.$vs.loading.close() })
        .catch(error => {
          this.$vs.loading.close()
          this.$vs.notify({
            title: 'Error',
            text: error.message,
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: 'danger'
          })
        })
    },
    registerUser () {
      if (!this.checkLogin()) return
      this.$router.push('/pages/register').catch(() => {})
    }
  }
}

</script>

