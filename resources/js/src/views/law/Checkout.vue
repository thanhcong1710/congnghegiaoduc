<!-- =========================================================================================
  File Name: ECommerceCheckout.vue
  Description: eCommerce Checkout page
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
    <div id="ecommerce-checkout-demo">
        <form-wizard
            ref="checkoutWizard"
            color="rgba(var(--vs-primary), 1)"
            :title="null"
            :subtitle="null"
            :hide-buttons="true">

            <!-- tab 1 content -->
            <tab-content title="Giỏ hàng" icon="feather icon-shopping-cart" class="mb-5">

                <!-- IF CART HAVE ITEMS -->
                <div class="vx-row" v-if="cartItems.length">

                    <!-- LEFT COL -->
                    <div class="vx-col lg:w-2/3 w-full relative">
                        <div class="items-list-view" v-for="(item, index) in cartItems" :key="item.objectID">
                            <item-list-view :item="item" class="mb-base">

                                <!-- SLOT: ITEM META -->
                                <template slot="item-meta">
                                    <h6
                                      class="item-name font-semibold mb-1 cursor-pointer hover:text-primary"
                                      @click="$router.push({name: 'law-item-detail-view', params: {item_id: item.objectID }}).catch(() => {})">{{ item.name }}</h6>

                                    <p class="item-description text-sm text-justify">{{ item.intro_text }}</p>

                                    <p class="mt-4 font-bold text-sm">Quantity</p>
                                    <vs-input-number min="1" max="10" :value="item.quantity" @input="updateItemQuantity($event, index)" class="inline-flex" />

                                </template>

                                <!-- SLOT: ACTION BUTTONS -->
                                <template slot="action-buttons">

                                    <!-- PRIMARY BUTTON: REMOVE -->
                                    <div class="item-view-primary-action-btn p-3 rounded-lg flex flex-grow items-center justify-center cursor-pointer mb-3" @click="removeItemFromCart(item)">
                                        <feather-icon icon="XIcon" svgClasses="h-4 w-4" />
                                        <span class="text-sm font-semibold ml-2">REMOVE</span>
                                    </div>

                                    <!-- SECONDARY BUTTON: MOVE-TO/VIEW-IN WISHLIST -->
                                    <div class="item-view-secondary-action-btn bg-primary p-3 rounded-lg flex flex-grow items-center justify-center text-white cursor-pointer" @click="wishListButtonClicked(item)">
                                        <feather-icon icon="HeartIcon" :svgClasses="[{'text-white fill-current': isInWishList(item.objectID)}, 'h-4 w-4']" />
                                        <span class="text-sm font-semibold ml-2" v-if="isInWishList(item.objectID)">WISHLIST</span>
                                        <span class="text-sm font-semibold ml-2" v-else>WISHLIST</span>
                                    </div>
                                </template>
                            </item-list-view>
                        </div>
                    </div>

                    <!-- RIGHT COL -->
                    <div class="vx-col lg:w-1/3 w-full">
                        <vx-card>
                            <p class="text-grey mb-3">Options</p>
                            <div class="flex justify-between">
                                <span class="font-semibold">Coupons</span>
                                <span class="font-medium text-primary cursor-pointer">Apply</span>
                            </div>

                            <vs-divider />

                            <p class="font-semibold mb-3">Price Details</p>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">Total MRP</span>
                                <span>{{cartItems | getTotal}}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="text-grey">Discount</span>
                                <span class="text-success">0đ</span>
                            </div>

                            <vs-divider />

                            <div class="flex justify-between font-semibold mb-3">
                                <span>Total</span>
                                <span>{{cartItems | getTotal}}</span>
                            </div>

                            <vs-button class="w-full" @click="addOrder()">PLACE ORDER</vs-button>
                        </vx-card>
                    </div>
                </div>

                <!-- IF NO ITEMS IN CART -->
                <vx-card title="You don't have any items in your cart." v-else>
                    <vs-button @click="$router.push('/law/list').catch(() => {})">Browse Shop</vs-button>
                </vx-card>

            </tab-content>

            <!-- tab 2 content -->
            <tab-content title="Tài khoản" icon="feather icon-home" class="mb-5" v-if="!activeUserInfo.displayName">
              <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-3/4 xl:w-3/5 sm:m-0 m-4" style="margin:auto !important">
                <vx-card>
                    <div slot="no-body" class="full-page-bg-color" style="padding-bottom: 30px;">
                        <div class="vx-row no-gutter">
                            <div class="vx-col hidden sm:hidden md:hidden lg:block lg:w-1/2 mx-auto self-center">
                                <img src="@assets/images/pages/register.jpg" alt="register" class="mx-auto">
                            </div>
                            <div class="vx-col sm:w-full md:w-full lg:w-1/2 mx-auto self-center  d-theme-dark-bg">
                                <div class="px-8 pt-8 register-tabs-container">
                                    <div class="vx-card__title mb-4">
                                        <h4 class="mb-4">Create Account</h4>
                                        <p>Fill the below form to create a new account.</p>
                                    </div>
                                    <br>
                                    <register-jwt></register-jwt>
                                </div>
                            </div>
                        </div>
                    </div>
                </vx-card>
              </div>
            </tab-content>

            <!-- tab 3 content -->
            <tab-content title="Thanh toán" icon="feather icon-credit-card" class="mb-5">

                <div class="vx-row">

                    <!-- LEFT COL: PAYMENT OPTIONS -->
                    <div class="vx-col lg:w-2/3 w-full">
                        <vx-card title="Payment Options" subtitle="Be sure to click on correct payment option" class="mb-base">

                            <div class="mt-3">
                                <ul>
                                  <!-- OPTION 1 -->
                                  <li>
                                    <!-- CARD DETAILS -->
                                    <div class="flex flex-wrap justify-between items-center">
                                        <vs-radio v-model="paymentMethod" vs-value="debit-card">
                                            <div class="flex items-center">
                                                <img src="@assets/images/pages/eCommerce/bank.png" alt="bank-logo" height="40" width="50" class="inline-flex">
                                                <span>US Unlocked Debit Card 12XX XXXX XXXX 0000</span>
                                            </div>
                                        </vs-radio>
                                        <span>John Doe</span>
                                        <span>11/2020</span>
                                    </div>

                                    <!-- CVV BLOCK -->
                                    <form data-vv-scope="cvv-form">
                                        <div class="flex items-center flex-wrap">
                                            <span class="mt-4">Enter CVV: </span>
                                            <vs-input
                                                v-validate="'required|digits:3'"
                                                name="cvv"
                                                v-model="cvv"
                                                class="mr-3 ml-2 mt-4" />
                                            <vs-button class="mt-4" @click.prevent="makePayment" :disabled="false">CONTINUE</vs-button>
                                        </div>
                                        <span v-show="errors.has('cvv-form.cvv')" class="text-danger ml-24">{{ errors.first('cvv-form.cvv') }}</span>
                                    </form>
                                  </li>

                                  <vs-divider class="my-6" />

                                  <!-- OPTION 2 -->
                                  <li>
                                    <vs-radio v-model="paymentMethod" vs-value="credit-debit-atmCard">Credit / Debit / ATM Card</vs-radio>
                                  </li>

                                  <!-- OPTION 3 -->
                                  <li class="mt-2">
                                    <vs-radio v-model="paymentMethod" vs-value="netBanking">Net Banking</vs-radio>
                                  </li>

                                  <!-- OPTION 4 -->
                                  <li class="mt-2">
                                    <vs-radio v-model="paymentMethod" vs-value="emi">EMI (Easy Installment)</vs-radio>
                                  </li>

                                  <!-- OPTION 5 -->
                                  <li class="mt-2">
                                    <vs-radio v-model="paymentMethod" vs-value="cashOnDelivery">Cash On Delivery</vs-radio>
                                  </li>
                                </ul>

                                <vs-divider />

                                <!-- GIFT CARD -->
                                <div class="inline-flex items-center cursor-pointer">
                                    <feather-icon icon="PlusSquareIcon" class="mr-2" svgClasses="h-6 w-6" />
                                    <span>Add Gift Card</span>
                                </div>
                            </div>
                        </vx-card>
                    </div>

                    <!-- RIGHT COL: PRICE -->
                    <div class="vx-col lg:w-1/3 w-full">
                        <vx-card title="Price Details">

                            <div class="flex justify-between mb-2">
                                <span>Price 3 Items</span>
                                <span class="font-semibold">$699.30</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span>Delivery Charges</span>
                                <span class="text-success">Free</span>
                            </div>

                            <vs-divider />

                            <div class="flex justify-between">
                                <span>Amount Payable</span>
                                <span class="font-semibold">$699.30</span>
                            </div>
                        </vx-card>
                    </div>
                </div>
            </tab-content>

        </form-wizard>
    </div>
</template>

<script>
import { FormWizard, TabContent } from 'vue-form-wizard'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import RegisterJwt from './../pages/register/RegisterJWT.vue'
const ItemListView = () => import('./components/ItemListView.vue')
import axios from './../../http/axios.js'
import router from '@/router'

export default {
  data () {
    return {
      displayName: '',
      phone: '',
      password: '',
      confirm_password: '',
      isTermsConditionAccepted: true,
      // TAB 2
      fullName: '',
      mobileNum: '',
      pincode: '',
      houseNum: '',
      area: '',
      landmark: '',
      city: '',
      state: '',
      addressType: 1,
      addressTypeOptions: [
        { text: 'Home', value: 1 },
        { text: 'Office', value: 2 }
      ],

      // TAB 3
      paymentMethod: 'debit-card',
      cvv: ''
    }
  },
  computed: {
    cartItems () {
      return this.$store.state.eCommerce.cartItems.slice().reverse()
    },
    isInWishList () {
      return (itemId) => this.$store.getters['eCommerce/isInWishList'](itemId)
    },
    activeUserInfo () {
      return this.$store.state.AppActiveUser
    },
    validateForm () {
      return !this.errors.any() && this.displayName !== '' && this.phone !== '' && this.password !== '' && this.confirm_password !== '' && this.isTermsConditionAccepted === true
    }
  },
  methods: {

    // TAB 1
    removeItemFromCart (item) {
      this.$store.dispatch('eCommerce/toggleItemInCart', item)
    },
    wishListButtonClicked (item) {
      // Toggle in Wish List
      if (this.isInWishList(item.objectID)) this.$router.push('/apps/eCommerce/wish-list').catch(() => {})
      else {
        this.toggleItemInWishList(item)
        this.removeItemFromCart(item)
      }
    },
    toggleItemInWishList (item) {
      this.$store.dispatch('eCommerce/toggleItemInWishList', item)
    },
    updateItemQuantity (event, index) {
      const itemIndex = Math.abs(index + 1 - this.cartItems.length)
      this.$store.dispatch('eCommerce/updateItemQuantity', { quantity: event, index: itemIndex })
    },
    addOrder(){
      if(this.activeUserInfo.displayName){
        this.$vs.loading()
        axios.p('/api/payment/add', { 'cartItems' : this.cartItems })
        .then((response) => {  
          this.$refs.checkoutWizard.nextTab(); 
          this.$store.dispatch('eCommerce/removeAllCart')
          this.$vs.loading.close()
        })
        .catch((error)   => { console.log(error); this.$vs.loading.close(); })
      }else{
         this.$refs.checkoutWizard.nextTab()
      }
    },

    // TAB 3
    makePayment () {
      return new Promise(() => {
        this.$validator.validateAll('cvv-form').then(result => {
          if (result) {
            // if form have no errors
            this.$vs.notify({
              title: 'Success',
              text: 'Payment received successfully',
              color: 'success',
              iconPack: 'feather',
              icon: 'icon-check'
            })
          } else {
            this.$vs.notify({
              title: 'Error',
              text: 'Please enter valid details',
              color: 'warning',
              iconPack: 'feather',
              icon: 'icon-alert-circle'
            })
          }
        })
      })
    }
  },
  components: {
    ItemListView,
    FormWizard,
    TabContent,
    RegisterJwt
  },
  filters:{
    getTotal: function(items){
      var total =0;
      items.forEach(element => {
        total = total + element.price * element.quantity
      });
      let resp     = ''
      let number   = 0
      let currency = 'đ'
      if (parseFloat(total) < 100) {
        number   = parseFloat(v)
        currency = '%'
        resp     = `${number}${currency}`
      } else {
        number = parseInt(total)
        resp   = number > 0 ? `${number.toFixed(1).replace(/(\d)(?=(\d{3})+\.)/g, '$1,').slice(0, -2)}${currency}` : 0
      }
      return resp;
    }
  }
}
</script>

<style lang="scss" scoped>
#ecommerce-checkout-demo {
    .item-view-primary-action-btn {
        color: #2c2c2c !important;
        background-color: #f6f6f6;
    }

    .item-name {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        -webkit-line-clamp: 2;
    }

    .vue-form-wizard {
        padding-bottom: 0;

        ::v-deep .wizard-header {
            padding: 0;
        }

        ::v-deep .wizard-tab-content {
            padding-right: 0;
            padding-left: 0;
            padding-bottom: 0;

            .wizard-tab-container{
              margin-bottom: 0 !important;
            }
        }
    }
}
</style>
