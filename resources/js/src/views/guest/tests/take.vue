<!-- =========================================================================================
    File Name: Login.vue
    Description: Login Page
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
  <div class="h-screen flex w-full">
    <vs-row vs-w="12">
      <vs-col vs-type="flex" vs-justify="center" vs-align="top" vs-lg="9" vs-sm="12" class="p-3">
        <vx-card no-shadow>
          <div class="vs-component p-5">
            <h3 class="text-center mb-5">{{test.title}}</h3>
            <div class="ques-item" v-for="(item, index) in quizs" :key="index">
                <div class="ques-parent" v-if="item.quiz_info.parent && item.quiz_info.parent.noi_dung" v-html="item.quiz_info.parent.noi_dung"></div>
                <div class="vs-component">
                  <span class="con-slot-label"><strong style="font-size:16px;font-weight:600;">Câu
                      {{index + 1 }}</strong>
                  </span>
                </div>
                  
                <div class="mb-base">
                  <template-type-1 :item="item" v-if="item.quiz_info.type_view == 1" :context="context"/>
                  <template-type-2 :item="item" v-if="item.quiz_info.type_view == 2"/>
                  <template-type-3 :item="item" v-if="item.quiz_info.type_view == 3"/>
                  <template-type-4 :item="item" v-if="item.quiz_info.type_view == 4"/>
                  <template-type-5 :item="item" v-if="item.quiz_info.type_view == 5"/>
                  <template-type-6 :item="item" v-if="item.quiz_info.type_view == 6"/>
                  <template-type-7 :item="item" v-if="item.quiz_info.type_view == 7"/>
                  <template-type-8 :item="item" v-if="item.quiz_info.type_view == 8"/>
                </div>
              </div>
          </div>
        </vx-card>
        <!-- vs-sm="4" vs-xs="12" -->
      </vs-col>
      <vs-col vs-type="flex" vs-justify="center" vs-align="top" vs-lg="3" vs-sm="12"  class="p-3">
        <vx-card no-shadow class="test-overview">
          <div class="text-center">
              <vs-col vs-justify="center" vs-align="center" vs-lg="6" class="p-2 pt-3" style="border-right: 1px solid #ccc;">
                Số câu đã làm <br>
                <span style="font-size:30px">{{count_quiz_answer}}/{{quizs.length}}</span>
              </vs-col>
              <vs-col  vs-justify="center" vs-align="center" vs-lg="6" class="p-2 pt-3">
                Thời gian còn lại <br>
                <span style="font-size:30px">
                  <countdown v-if="countdownTest" :time="test.left_time * 1000" v-slot="{ minutes, seconds }" @end="onCountdownEnd">
                    {{ minutes > 9 ? minutes : '0'+minutes }}:{{ seconds > 9 ? seconds : '0'+seconds }}
                  </countdown>
                </span>
              </vs-col>
              <hr>
              <div class="text-left box-select-quiz">
                <div :class="item.quiz_info.user_answer ? 'quiz-icon primary' : 'quiz-icon'" v-for="(item, index) in quizs" :key="index">{{index+1}}</div>
              </div>
              <div class="text-center box-action pr-3 pl-3">
                <vs-button color="warning" type="filled" class="w-full" @click="endTest()" >NỘP BÀI</vs-button>
              </div>
              <!-- <div class="text-left" style="margin: 30px 0px">
                <div class="box-note">
                  <div class="quiz-icon primary">  </div> 
                  <div class="text-quiz">Câu đã làm</div>
                </div>
                <div class="box-note">
                  <div class="quiz-icon">  </div> 
                  <div class="text-quiz">Câu chưa làm</div>
                </div>
              </div> -->
          </div>
        </vx-card>
      </vs-col>
    </vs-row>
  </div>
</template>


<script>
  import TemplateType1 from './template_quiz/type1.vue'
  import TemplateType2 from './template_quiz/type2.vue'
  import TemplateType3 from './template_quiz/type3.vue'
  import TemplateType4 from './template_quiz/type4.vue'
  import TemplateType5 from './template_quiz/type5.vue'
  import TemplateType6 from './template_quiz/type6.vue'
  import TemplateType7 from './template_quiz/type7.vue'
  import TemplateType8 from './template_quiz/type8.vue'
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
        quizs:[]
      }
    },
    created() {
      this.getTestSessionInfo();
    },
    methods: {
      getTestSessionInfo() {
        this.$vs.loading()
        axios.g(`/api/test/session-info/${this.$route.params.code}`)
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
        axios.g(`/api/test/session-quiz/${test_id}/${test_session_id}`)
          .then((response) => {
            this.$vs.loading.close()
            this.quizs = response.data
            this.getTextCountQuiz();
            setTimeout(function () {
              MathJax.typeset()
            }, 300)
          })
          .catch((error) => {
            console.log(error);
            this.$vs.loading.close();
          })
      },
      onCountdownEnd(){
        alert('123');
      },
      endTest(){
        var quiz_not_answer = 0
        this.quizs.forEach((item) => {
          if(!item.quiz_info.user_answer){
            quiz_not_answer++
          }
        })
        this.openConfirmSubmitTest(quiz_not_answer)
      },
      openConfirmSubmitTest(quiz_not_answer) {
        this.$vs.dialog({
          type: 'confirm',
          color: 'danger',
          title: `Nộp bài`,
          text: quiz_not_answer ? 'Còn '+quiz_not_answer+' câu chưa làm và chưa hết thời làm bạn vẫn muốn nộp bài?' : 'Chưa hết thời làm bạn vẫn muốn nộp bài?',
          accept: this.submitTest,
          acceptText: 'Nộp tiền',
          cancelText: 'Hủy'
        })
      },
      submitTest(){
        this.$vs.loading()
        axios.p(`/api/test/end`,{
          test_session_id: this.test.test_session_id,
          quizs: this.quizs
        })
        .then((response) => {
          window.location.href = response.data.redirect_url;
        })
        .catch((error) => {
          console.log(error);
        })
      },
      getTextCountQuiz(){
        var count_quiz_answer = 0
        this.quizs.forEach((item) => {
          if(item.quiz_info.user_answer){
            count_quiz_answer++
          }
        })
        this.count_quiz_answer = count_quiz_answer
      },
      answerQuiz(data){
        this.getTextCountQuiz();
        axios.p(`/api/test/answer-quiz`,{
          test_session_id: this.test.test_session_id,
          test_quiz_id: data.id,
          quiz_id: data.quiz_info.id,
          quiz_type: data.quiz_type,
          answer:data.quiz_info.user_answer
        })
        .then((response) => {
          
        })
        .catch((error) => {
          console.log(error);
        })
      }
    },
  }
</script>