<template>
  <vx-card no-shadow>
    <vs-alert active="true" icon-pack="feather" icon="icon-info">
      <span style="text-decoration: underline; currsor:pointer">Hướng dẫn thêm câu hỏi</span>
    </vs-alert>
    <div class="vs-component mt-4">
      <div class="ques-item" v-for="(item, index) in quizs" :key="index">
          <div class="ques-parent" v-if="item.quiz_info.parent && item.quiz_info.parent.noi_dung" v-html="item.quiz_info.parent.noi_dung"></div>
          <div class="vs-component">
            <span class="con-slot-label"><strong style="font-size:16px;font-weight:600;">Câu
                {{index + 1 + (pagination.cpage - 1) * pagination.limit}}</strong>
            </span>
            <vs-button color="danger" type="border" size="small" style="float:right">Xóa</vs-button>
          </div>
            
          <div class="mb-base">
            <template-type-1 :item="item.quiz_info" v-if="item.quiz_info.type_view == 1"/>
            <template-type-2 :item="item.quiz_info" v-if="item.quiz_info.type_view == 2"/>
            <template-type-3 :item="item.quiz_info" v-if="item.quiz_info.type_view == 3"/>
            <template-type-4 :item="item.quiz_info" v-if="item.quiz_info.type_view == 4"/>
            <template-type-5 :item="item.quiz_info" v-if="item.quiz_info.type_view == 5"/>
            <template-type-6 :item="item.quiz_info" v-if="item.quiz_info.type_view == 6"/>
            <template-type-7 :item="item.quiz_info" v-if="item.quiz_info.type_view == 7"/>
            <template-type-8 :item="item.quiz_info" v-if="item.quiz_info.type_view == 8"/>
            <div class="mt-2 label-show-answer">
              <i @click="toggleAnswer(index)">Xem lời giải chi tiết</i> 
             </div>
            <div class="content-show-answer" v-html="item.quiz_info.loi_giai" v-show="item.quiz_info.show_loi_giai" ></div>
          </div>
        </div>
      <vs-pagination
        v-if="Math.ceil(pagination.total / pagination.limit) >1"
        :total="Math.ceil(pagination.total / pagination.limit)"
        :max="7"
        v-model="pagination.cpage" @change="changePage()"/>
        
    </div>
  </vx-card>
</template>

<script>
  import TemplateType1 from '../../quizs/template/type1.vue'
  import TemplateType2 from '../../quizs/template/type2.vue'
  import TemplateType3 from '../../quizs/template/type3.vue'
  import TemplateType4 from '../../quizs/template/type4.vue'
  import TemplateType5 from '../../quizs/template/type5.vue'
  import TemplateType6 from '../../quizs/template/type6.vue'
  import TemplateType7 from '../../quizs/template/type7.vue'
  import TemplateType8 from '../../quizs/template/type8.vue'
  import axios from '../../../http/axios.js'

  export default {
    components: {
      TemplateType1,
      TemplateType2,
      TemplateType3,
      TemplateType4,
      TemplateType5,
      TemplateType6,
      TemplateType7,
      TemplateType8
    },
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
              setTimeout(function () {
                MathJax.typeset()
              }, 300)
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
      toggleAnswer(index){
        this.quizs[index].quiz_info.show_loi_giai = ! this.quizs[index].quiz_info.show_loi_giai
      },
      changePageLimit(limit) {
        this.pagination.cpage = 1
        this.pagination.limit = limit
        this.getData();
      },
    }
  }
</script>