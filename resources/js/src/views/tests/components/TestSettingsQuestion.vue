<template>
  <vx-card no-shadow>
    <vs-alert active="true" icon-pack="feather" icon="icon-info">
      <span style="text-decoration: underline; currsor:pointer">Hướng dẫn thêm câu hỏi</span>
    </vs-alert>
    <div class="vs-component mt-4">
      <vs-pagination
        v-if="Math.ceil(pagination.total / pagination.limit) >1"
        :total="Math.ceil(pagination.total / pagination.limit)"
        :max="7"
        v-model="pagination.cpage" @change="changePage()"/>
        
    </div>
  </vx-card>
</template>

<script>
  import axios from '../../../http/axios.js'

  export default {
    components: {},
    data() {
      return {
        quizs:[],
        pagination: {
          url: `/api/tests/quizs/${this.$route.params.id}`,
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
        axios.p(`/api/tests/quizs/${this.$route.params.id}`, {
            pagination: this.pagination
          })
          .then((response) => {
            this.$vs.loading.close()
            if (response.data.status) {
              this.quizs = response.data.data.list
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