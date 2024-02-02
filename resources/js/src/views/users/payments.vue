<template>
  <vx-card no-shadow>
    <div class="vs-component vs-con-table stripe vs-table-primary">
      <header class="header-table vs-table--header">
        <!---->
      </header>
      <div class="con-tablex vs-table--content">
        <div class="vs-con-tbody vs-table--tbody ">
          <table class="vs-table vs-table--tbody-table">
            <thead class="vs-table--thead">
              <tr>
                <!---->
                <th colspan="1" rowspan="1">
                  <div class="vs-table-text">STT
                    <!---->
                  </div>
                </th>
                <th colspan="1" rowspan="1">
                  <div class="vs-table-text">Mã
                    <!---->
                  </div>
                </th>
                <th colspan="1" rowspan="1">
                  <div class="vs-table-text">Số tiền
                    <!---->
                  </div>
                </th>
                <th colspan="1" rowspan="1">
                  <div class="vs-table-text">Ngày bắt đầu
                    <!---->
                  </div>
                </th>
                <th colspan="1" rowspan="1">
                  <div class="vs-table-text">Ngày kết thúc
                    <!---->
                  </div>
                </th>
                <th colspan="1" rowspan="1">
                  <div class="vs-table-text">Trạng thái
                    <!---->
                  </div>
                </th>
                <th colspan="1" rowspan="1">
                  <div class="vs-table-text">Thao tác
                    <!---->
                  </div>
                </th>
              </tr>
            </thead>
            <tr class="tr-values vs-table--tr tr-table-state-null" v-for="(item, index) in payments" :key="index">
              <!---->
              <td class="td vs-table--td">{{ index + 1 + (pagination.cpage - 1) * pagination.limit }}</td>
              <td class="td vs-table--td">{{item.code}}</td>
              <td class="td vs-table--td">{{item.amount | formatCurrency}}</td>
              <td class="td vs-table--td">{{item.start_date}}</td>
               <td class="td vs-table--td">{{item.end_date}}</td>
              <td class="td vs-table--td">
                <span v-if="item.status==0">Chưa chuyển tiền</span>
                <span v-if="item.status==1" class="text-warning">Chờ xác nhận</span>
                <span v-if="item.status==2"  class="text-success">Hoàn thành</span>
              </td>
              <td class="td vs-table--td">
                  <router-link :to="`/admin/user/payment/${item.id}`">
                    <feather-icon icon="CreditCardIcon" svgClasses="h-5 w-5" style="cursor: pointer;"></feather-icon>
                  </router-link>
              </td>
            </tr>
          </table>
         
        </div>
         <vs-pagination
            class="mt-5"
            v-if="Math.ceil(pagination.total / pagination.limit) >1"
            :total="Math.ceil(pagination.total / pagination.limit)"
            :max="7"
            v-model="pagination.cpage" @change="changePage()"/>
        <!---->
        <!---->
      </div>
    </div>
  </vx-card>
</template>

<script>
  import axios from '../../http/axios.js'

  export default {
    components: {},
    data() {
      return {
        records:[],
        pagination: {
          url: "/api/user/payments",
          id: "",
          style: "line",
          class: "",
          spage: 1,
          ppage: 1,
          npage: 0,
          lpage: 1,
          cpage: 1,
          total: 0,
          limit: 20,
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
        axios.p(`/api/user/payments`, {
            pagination: this.pagination
          })
          .then((response) => {
            this.$vs.loading.close()
            this.payments = response.data.list
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
      }
    }
  }
</script>