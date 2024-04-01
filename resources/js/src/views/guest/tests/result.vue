<!-- =========================================================================================
    File Name: Login.vue
    Description: Login Page
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
  <div class="h-screen flex w-full" id="test-result">
    <vs-row vs-w="12" vs-align="top" vs-type="flex" vs-justify="center">
      <vs-col vs-lg="9" vs-sm="12" class="p-3">
        <div class="w-full">
          <vx-card slot="no-body" class="text-center bg-success-gradient greet-user">
                      <img src="@assets/images/elements/decore-left.png" class="decore-left" alt="Decore Left" width="200" >
                      <img src="@assets/images/elements/decore-right.png" class="decore-right" alt="Decore Right" width="175">
            <feather-icon icon="AwardIcon" class="p-6 mb-8 bg-success inline-flex rounded-full text-white shadow" svgClasses="h-8 w-8"></feather-icon>
            <h1 class="mb-6 text-white">{{test.title}}</h1>
            <div class="result-point">
              <span class="num-correct">{{test.total_quiz_correct}}</span>
            </div>
            <div class="result-detail">
              <p class="mx-auto text-white"><i class="fa-solid fa-user"></i> Họ tên: <strong>{{test.client_name}}</strong></p>
              <p class="mx-auto text-white"><i class="fa-solid fa-clock"></i> Thời gian làm bài: <strong>{{ Math.round( test.total_time/60 )}}</strong> phút 
              <p class="mx-auto text-white"><i class="fa-regular fa-circle-question ml-5"></i> kết quả: đúng <strong>{{test.total_quiz_correct}} / {{test.total_quiz}}</strong> câu</p>
            </div>

            <vx-card no-shadow class="test-overview mt-5 p-3" v-if="test.cf_xem_loi_giai">
              <div class="text-center">
                  <h3>Kết quả</h3>
                  <p>(Bấm vào câu hỏi để xem chi tiết)</p>
                  <div class="text-left box-select-quiz">
                    <div :class="item.result == 1 ? 'quiz-icon success': (item.result == 2 ? 'quiz-icon error' : 'quiz-icon')" @click="showDetail(item, index)" v-for="(item, index) in quizs" :key="index">{{index+1}}</div>
                  </div>
              </div>
            </vx-card>
          </vx-card>
          <div class="mt-5 ques-item" v-if="quiz_info">
            <div class="ques-parent" v-if="quiz_info.parent && quiz_info.parent.noi_dung" v-html="quiz_info.parent.noi_dung"></div>
            <div class="vs-component">
              <span class="con-slot-label"><strong style="font-size:16px;font-weight:600;">Câu
                  {{quiz_info_num + 1 }}</strong>
              </span>
            </div>
              
            <div class="mb-base">
              <template-type-1 :item="quiz_info" v-if="quiz_info.quiz_info.type_view == 1"/>
              <template-type-2 :item="quiz_info" v-if="quiz_info.quiz_info.type_view == 2"/>
              <template-type-3 :item="quiz_info" v-if="quiz_info.quiz_info.type_view == 3"/>
              <template-type-4 :item="quiz_info" v-if="quiz_info.quiz_info.type_view == 4"/>
              <template-type-5 :item="quiz_info" v-if="quiz_info.quiz_info.type_view == 5"/>
              <template-type-6 :item="quiz_info" v-if="quiz_info.quiz_info.type_view == 6"/>
              <template-type-7 :item="quiz_info" v-if="quiz_info.quiz_info.type_view == 7"/>
              <template-type-8 :item="quiz_info" v-if="quiz_info.quiz_info.type_view == 8"/>
            </div>
          </div>
        </div>
      </vs-col>
    </vs-row>
  </div>
</template>


<script>
  import TemplateType1 from './template_quiz_result/type1.vue'
  import TemplateType2 from './template_quiz_result/type2.vue'
  import TemplateType3 from './template_quiz_result/type3.vue'
  import TemplateType4 from './template_quiz_result/type4.vue'
  import TemplateType5 from './template_quiz_result/type5.vue'
  import TemplateType6 from './template_quiz_result/type6.vue'
  import TemplateType7 from './template_quiz_result/type7.vue'
  import TemplateType8 from './template_quiz_result/type8.vue'
  import VueCountdown from '@chenfengyuan/vue-countdown'
  import axios from '../../../http/axios.js'
  export default {
    components: {
      'countdown': VueCountdown,
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
        context : { componentParent: this },
        count_quiz_answer:0,
        countdownTest: false,
        test: {},
        quizs:[],
        quiz_info: null,
        quiz_info_num: ''
      }
    },
    created() {
      this.getTestSessionInfo();
    },
    methods: {
      getTestSessionInfo() {
        this.$vs.loading()
        axios.g(`/api/test/session-result/${this.$route.params.code}`)
          .then((response) => {
            this.$vs.loading.close()
            if (response.data.status) {
              this.test = response.data.data
              this.countdownTest = true
              this.getDataQuiz(this.test.test_id, this.test.test_session_id)
            } else {
              this.$router.push({
                name: 'page-error-404'
              }).catch(() => {})
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
      getDataQuiz(test_id, test_session_id) {
        this.$vs.loading()
        axios.g(`/api/test/session-result-quiz/${test_id}/${test_session_id}`)
          .then((response) => {
            this.$vs.loading.close()
            this.quizs = response.data
          })
          .catch((error) => {
            console.log(error);
            this.$vs.loading.close();
          })
      },
      showDetail(data, num){
        this.quiz_info = data
        this.quiz_info_num = num
        setTimeout(function () {
          MathJax.typeset()
        }, 300)
      }
    },
  }
</script>
<style>
#test-result .greet-user .decore-left {
    position: absolute;
    left: 0;
    top: 0;
}
#test-result .greet-user .decore-right {
    position: absolute;
    right: 0;
    top: 0;
}
.result-point {
  font-size: 28px;
}
.result-point .num-correct{
  font-size: 86px;
  color: #ffd800;
}
#test-result .result-detail .text-white{
  font-size: 16px;
}
</style>