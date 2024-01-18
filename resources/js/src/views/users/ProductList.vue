<template>
  <div id="ecommerce-wishlist-demo">
      <div  v-if="ProductListitems.length" >
        <div class="items-grid-view vx-row match-height">
            <div class="vx-col lg:w-1/4 md:w-1/3 sm:w-1/2 w-full" v-for="item in ProductListitems" :key="item.objectID">

                <item-grid-view :item="item">

                    <!-- SLOT: ACTION BUTTONS -->
                    <template slot="action-buttons">
                        <div class="item-details px-4">
                          <h6 class="truncate font-semibold mb-1" v-if="(item.status==1 ||item.status==2) && item.law_schedule_id">Đã đặt lịch vào: {{item.schedule_date_time}}</h6>
                          <h6 class="truncate font-semibold mb-1" v-else-if="item.status==1 && !item.law_schedule_id">Chưa đặt lịch </h6>
                        </div>
                        <div class="flex flex-wrap mt-3">
                            <!-- SECONDARY BUTTON: MOVE TO CART -->
                            <div v-if="item.status==1 && item.law_schedule_id" @click="joinMeeting(item.law_schedule_id)" class="item-view-secondary-action-btn bg-success p-3 flex flex-grow items-center justify-center text-white cursor-pointer" >
                                <feather-icon icon="ShoppingBagIcon" svgClasses="h-4 w-4" />

                                <span class="text-sm font-semibold ml-2" >TRAO ĐỔI ONLINE</span>
                            </div>
                            <div v-else-if="item.status==2" class="item-view-secondary-action-btn bg-warning p-3 flex flex-grow items-center justify-center text-white cursor-pointer" >
                                <feather-icon icon="ShoppingBagIcon" svgClasses="h-4 w-4" />

                                <span class="text-sm font-semibold ml-2" >ĐÁNH GIÁ</span>
                            </div>
                            <div v-else-if="item.status==1 && !item.law_schedule_id" class="item-view-secondary-action-btn bg-primary p-3 flex flex-grow items-center justify-center text-white cursor-pointer" >
                                <feather-icon icon="ShoppingBagIcon" svgClasses="h-4 w-4" />

                                <span class="text-sm font-semibold ml-2" >ĐẶT LỊCH</span>
                            </div>
                        </div>
                    </template>
                </item-grid-view>

            </div>
        </div>
        <vs-pagination
          v-if="Math.ceil(pagination.total / pagination.limit) >1"
          :total="Math.ceil(pagination.total / pagination.limit)"
          :max="7"
          v-model="pagination.cpage" @change="changePage()"/>
      </div>
      <!-- IF NO ITEMS IN CART -->
      <vx-card title="You don't have any items ." v-else>
          <vs-button @click="$router.push('/law/list').catch(() => {})">Browse Shop</vs-button>
      </vx-card>
  </div>
</template>

<script>
import axios from './../../http/axios.js'
const ItemGridView = () => import('./../law/components/ItemGridView.vue')
export default {
  components: {
    ItemGridView
  },
  data () {
    return {
      ProductListitems:[],
      limitSource: [10, 20, 30, 40, 50],  
      pagination: {
        url: "/api/payments/list",
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
        init:0
      },
    }
  },
  created () {
    this.getData();
  },
  methods: {
    getData(){
      this.$vs.loading()
      axios.p('/api/payment/items', {
        pagination : this.pagination
      })
      .then((response) => {  
        this.ProductListitems = response.data.list
        console.log(this.ProductListitems.length);
        this.$vs.loading.close()
        this.pagination = response.data.paging;
        this.pagination.init = 1;
      })
      .catch((error)   => { console.log(error); this.$vs.loading.close(); })
    },
    joinMeeting(law_schedule_id){
      axios.p('/api/video-call/join',{
        law_schedule_id: law_schedule_id
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
    changePage(){
      if(this.pagination.init){
        this.getData();
      }
    },
  }
}
</script>

<style lang="scss" scoped>
#ecommerce-wishlist-demo {
    .item-view-primary-action-btn {
        color: #2c2c2c !important;
        background-color: #f6f6f6;
        min-width: 50%;
    }

    .item-view-secondary-action-btn {
        min-width: 50%;
    }
}
</style>
