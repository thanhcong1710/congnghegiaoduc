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
                  <div class="vs-table-text">Mã
                    <!---->
                  </div>
                </th>
                <th colspan="1" rowspan="1">
                  <div class="vs-table-text">Bắt đầu
                    <!---->
                  </div>
                </th>
                <th colspan="1" rowspan="1">
                  <div class="vs-table-text">Kết thúc
                    <!---->
                  </div>
                </th>
                <th colspan="1" rowspan="1">
                  <div class="vs-table-text">Ghi hình
                    <!---->
                  </div>
                </th>
              </tr>
            </thead>
            <tr class="tr-values vs-table--tr tr-table-state-null" v-for="item in sessions" :key="item.id">
              <!---->
              <td class="td vs-table--td">{{item.code}}</td>
              <td class="td vs-table--td">{{item.start_time}}</td>
              <td class="td vs-table--td">{{item.end_time}}</td>
              <td class="td vs-table--td"></td>
            </tr>
          </table>
          <vs-pagination
            v-if="Math.ceil(pagination.total / pagination.limit) >1"
            :total="Math.ceil(pagination.total / pagination.limit)"
            :max="7"
            v-model="pagination.cpage" @change="changePage()"/>
        </div>
        <!---->
        <!---->
      </div>
    </div>
  </vx-card>
</template>

<script>
  import axios from '../../../http/axios.js'

  export default {
    components: {},
    data() {
      return {
        sessions:[],
        pagination: {
          url: "/api/rooms/list",
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
        axios.p(`/api/rooms/sessions/${this.$route.params.id}`, {
            pagination: this.pagination
          })
          .then((response) => {
            this.$vs.loading.close()
            if (response.data.status) {
              this.sessions = response.data.data.list
              this.pagination = response.data.data.paging;
              this.pagination.init = 1;
            } else {
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
    }
  }
</script>