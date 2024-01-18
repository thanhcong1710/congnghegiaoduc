<template>
  <div class="the-navbar__user-meta flex items-center" v-if="activeUserInfo.displayName">

    <div class="text-right leading-tight hidden sm:block">
      <p class="font-semibold">{{ activeUserInfo.displayName }}</p>
      <small>Available</small>
    </div>

    <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">

      <div class="con-img ml-3">
        <img v-if="activeUserInfo.photoURL" key="onlineImg" :src="activeUserInfo.photoURL" alt="user-img" width="40" height="40" class="rounded-full shadow-md cursor-pointer block" />
      </div>

      <vs-dropdown-menu class="vx-navbar-dropdown">
        <ul style="min-width: 10rem">

          <li
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="$router.push('/user/profile').catch(() => {})">
            <feather-icon icon="UserIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Tài khoản</span>
          </li>
          <li v-if="activeUserInfo.menuroles == 'admin' || activeUserInfo.menuroles == 'user'"
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="$router.push('/user/products').catch(() => {})">
            <feather-icon icon="PackageIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Sản phẩm</span>
          </li>
          <li v-if="activeUserInfo.menuroles == 'admin' || activeUserInfo.menuroles == 'user'"
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="$router.push('/user/payments').catch(() => {})">
            <feather-icon icon="CheckSquareIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Thanh toán</span>
          </li>
           <li v-if="activeUserInfo.menuroles == 'admin' || activeUserInfo.menuroles == 'law'"
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="$router.push('/user/calendar').catch(() => {})">
            <feather-icon icon="CalendarIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Đặt lịch</span>
          </li>
          <li
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="$router.push('/user/wish-list').catch(() => {})">
            <feather-icon icon="HeartIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Ưu thích</span>
          </li>

          <vs-divider class="m-1" />

          <li
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="logout">
            <feather-icon icon="LogOutIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Đăng xuất</span>
          </li>
        </ul>
      </vs-dropdown-menu>
    </vs-dropdown>
  </div>
  <router-link to="/pages/login" v-else>
    <vs-button>Login</vs-button>
  </router-link>
</template>

<script>
import axios from './../../../../http/axios.js'
export default {
  data () {
    return {

    }
  },
  computed: {
    activeUserInfo () {
      return this.$store.state.AppActiveUser
    }
  },
  methods: {
    logout () {
      axios.p('/api/auth/logout',{
        token: localStorage.getItem('accessToken')
      }).then((response) => {})
      // if user is logged in via auth0
      if (this.$auth.profile) this.$auth.logOut()

      // If JWT login
      if (localStorage.getItem('accessToken')) {
        localStorage.removeItem('accessToken')
        this.$router.push('/pages/login').catch(() => {})
      }

      // Change role on logout. Same value as initialRole of acj.js
      this.$acl.change('admin')
      localStorage.removeItem('userInfo')

      // This is just for demo Purpose. If user clicks on logout -> redirect
      this.$router.push('/pages/login').catch(() => {})
    }
  }
}
</script>
