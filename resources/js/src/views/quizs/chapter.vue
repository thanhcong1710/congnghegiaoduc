<template>
  <div>
    <div class="router-header flex flex-wrap items-center mb-6">
      <div class="vx-breadcrumb ml-4">
        <ul class="flex flex-wrap items-center">
          <li class="inline-flex items-end">
              <router-link to="/">
                  <feather-icon icon="HomeIcon" svgClasses="h-5 w-5 mb-1 stroke-current text-primary" />
              </router-link>
              <span class="breadcrumb-separator mx-2"><feather-icon :icon="$vs.trl ? 'ChevronsLeftIcon' : 'ChevronsRightIcon'" svgClasses="w-4 h-4" /></span>
          </li>
          <li class="inline-flex  items-center">
            <router-link :to="`/admin/grade/${chapter_info.grade_id}`" >{{ chapter_info.grade_name }}</router-link>
            <span class="breadcrumb-separator mx-2 flex items-start"><feather-icon :icon="$vs.trl ? 'ChevronsLeftIcon' : 'ChevronsRightIcon'" svgClasses="w-4 h-4" /></span>
          </li>
          <li class="inline-flex  items-center">
            <router-link :to="`/admin/subject/${chapter_info.lms_subject_id}`" >{{ chapter_info.subject_name }}</router-link>
            <span class="breadcrumb-separator mx-2 flex items-start"><feather-icon :icon="$vs.trl ? 'ChevronsLeftIcon' : 'ChevronsRightIcon'" svgClasses="w-4 h-4" /></span>
          </li>
          <li class="inline-flex"><span class="cursor-default">{{chapter_info.title}}</span></li>
        </ul>
      </div>
    </div>
    <div id="page-subjects">
      <vs-dropdown vs-trigger-click class="cursor-pointer mb-4 mr-4 items-per-page-handler">
        <div class="p-4 border border-solid d-theme-border-grey-light rounded-full d-theme-dark-bg cursor-pointer flex items-center justify-between font-medium">
          <span class="mr-2">{{ pagination.cpage * pagination.limit - (pagination.limit - 1) }} - {{ pagination.total - pagination.cpage * pagination.limit > 0 ? pagination.cpage * pagination.limit : pagination.total }} of {{ pagination.total }}</span>
          <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
        </div>
        <vs-dropdown-menu>
          <vs-dropdown-item v-for="(item, index) in limitSource" :key="index" @click="pagination.limit=item" >
            <span>{{item}}</span>
          </vs-dropdown-item>
        </vs-dropdown-menu>
      </vs-dropdown>
      <vx-card no-shadow>

      <vs-alert active="true" class="mb-3">
        <div>
          Đã chọn <strong>{{check_list.length}}</strong> câu hỏi
          <button class="vs-component vs-button vs-button-success vs-button-filled" @click="showModalAddQuiz()">
            Thêm vào bài kiểm tra</button>
        </div>
      </vs-alert>
        
        <div class="ques-item" v-for="(item, index) in questions" :key="index">
          <div class="ques-parent" v-if="item.parent && item.parent.noi_dung" v-html="item.parent.noi_dung"></div>
          <div class="vs-component con-vs-checkbox vs-checkbox-primary vs-checkbox-default">
            <input type="checkbox" v-model="check_list" :value="item.id" class="vs-checkbox--input" >
            <span class="checkbox_x vs-checkbox" style="border: 2px solid rgb(180, 180, 180);">
              <span class="vs-checkbox--check">
                <i class="vs-icon notranslate icon-scale vs-checkbox--icon  material-icons null">check</i>
              </span>
            </span>
            <span class="con-slot-label"><strong style="font-size:16px;font-weight:600;">Câu
                {{index + 1 + (pagination.cpage - 1) * pagination.limit}}</strong>
            </span>
          </div>
            
          <div class="mb-base pl-8">
            <template-type-1 :item="item" v-if="item.type_view == 1"/>
            <template-type-2 :item="item" v-if="item.type_view == 2"/>
            <template-type-3 :item="item" v-if="item.type_view == 3"/>
            <template-type-4 :item="item" v-if="item.type_view == 4"/>
            <template-type-5 :item="item" v-if="item.type_view == 5"/>
            <template-type-6 :item="item" v-if="item.type_view == 6"/>
            <template-type-7 :item="item" v-if="item.type_view == 7"/>
            <template-type-8 :item="item" v-if="item.type_view == 8"/>
            <div class="mt-2 label-show-answer">
              <i @click="toggleAnswer(index)">Xem lời giải chi tiết</i> 
             </div>
            <div class="content-show-answer" v-html="item.loi_giai" v-show="item.show_loi_giai" ></div>
          </div>
        </div>
      </vx-card>
    </div>
      
    <vs-pagination
        class="mt-3"
        v-if="Math.ceil(pagination.total / pagination.limit) >1"
        :total="Math.ceil(pagination.total / pagination.limit)"
        :max="7"
        v-model="pagination.cpage" @change="changePage()"/>
    
    <vs-popup title="Thêm vào bài kiểm tra" :active.sync="popup.active">
      <div class="vx-col w-full mt-2">
        <v-select
              id="topic-options"
              v-model="popup.test_id"
              :dir="$vs.rtl? 'rtl' : 'ltr'"
              :options="testOptions"
              :reduce="val => val.id"
              :clearable="true"
              label="title"
              input-id="topic-options"
              placeholder="Chọn bài kiểm tra"
            />
      </div>
      <span class="text-danger text-sm">{{ popup.error }}</span>
      <div class="vx-col w-full mt-5 text-right">
        <vs-button color="dark" type="border" @click="popup.active = false">Hủy</vs-button>
        <vs-button color="primary" type="filled" @click="addQuizToTest()">Thêm</vs-button>
      </div>
    </vs-popup>
  </div>

</template>
<script>
  import TemplateType1 from './template/type1.vue'
  import TemplateType2 from './template/type2.vue'
  import TemplateType3 from './template/type3.vue'
  import TemplateType4 from './template/type4.vue'
  import TemplateType5 from './template/type5.vue'
  import TemplateType6 from './template/type6.vue'
  import TemplateType7 from './template/type7.vue'
  import TemplateType8 from './template/type8.vue'
  import axios from '../../http/axios.js'
  import vSelect from 'vue-select'
  export default {
    components: {
      vSelect,
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
        check_list: [
        ],
        questions: [],
        chapter_info:'',
        limitSource: [10, 20, 50, 100],
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
          limit: 20,
          pages: [],
          init: 0
        },
        testOptions:[],
        popup:{
          active: false,
          test_id :'',
          error:''
        },
      }
    },
    methods: {
      getData() {
        this.$vs.loading()
        axios.p('/api/quizs/chapter-detail', {
            chapter_id: this.$route.params.id,
            pagination: this.pagination
          })
          .then((response) => {
            this.questions = response.data.list
            this.chapter_info = response.data.chapter_info
            this.$vs.loading.close()
            this.pagination = response.data.paging;
            this.pagination.init = 1;
            setTimeout(function () {
              MathJax.typeset()
            }, 300)
          })
          .catch((error) => {
            console.log(error);
            this.$vs.loading.close();
          })
      },
      redirectSubjectDetail(id){
        $router.push(item.url).catch(() => {})
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
      toggleAnswer(index){
        this.questions[index].show_loi_giai = ! this.questions[index].show_loi_giai
      },
      getTestByUser(){
        this.$vs.loading()
        axios.g ('/api/tests/all')
          .then((response) => {
            this.testOptions = response.data
            this.$vs.loading.close();
          })
          .catch((error) => {
            console.log(error);
            this.$vs.loading.close();
          })
      },
      showModalAddQuiz(){
        this.popup.active = true
        this.popup.error =""
        this.popup.test_id =""
      },
      addQuizToTest(){
        if(!this.check_list.length){
          this.popup.error = "Chọn câu hỏi để thêm vào bài kiểm tra."
          return false
        }
        if(!this.popup.test_id){
          this.popup.error = "Chọn bài kiểm tra."
          return false
        }
        this.$vs.loading()
        axios.p('/api/tests/add-quiz', {
            test_id: this.popup.test_id,
            list_quiz: this.check_list,
            type: 1
          })
          .then((response) => {
            this.popup.active=false
            this.check_list = []
            this.$vs.loading.close()
            this.$vs.notify({
                title: 'Thành Công',
                text: response.data.message,
                color: 'success',
                iconPack: 'feather',
                icon: 'icon-check'
              })
          })
          .catch((error) => {
            console.log(error);
            this.$vs.loading.close();
          })

        }
    },
    created() {
      this.getTestByUser()
      this.getData()
    }
  }
</script>
<style>
.ans-ques-type-6 .select-text-question p {
    display: inline-block;
    margin-right: 0;
    padding: 3px 2px;
    margin-bottom: 3px;
    cursor: pointer;
    border: 0.5px solid #fff;
    box-shadow: 0 0.5px #fff;
}
.ans-ques-type-6 .select-text-question .selected p {
    background: #d2e9c3;
    border-radius: 4px;
    border: 0.5px solid #5eb34f;
    box-shadow: 0 0.5px #47a518;
}

.ans-ques-type-7 .option-answers.yes-no-question a {
    display: inline-block;
    border-radius: 4px;
    border: 1px solid #e0e0e0;
    margin: 0 5px 20px;
    cursor: pointer;
}
.ans-ques-type-7 .choice-button a {
    width: 100% !important;
    padding: 6px !important;
}
.ans-ques-type-7 .font-size-20 {
    font-size: 20px;
    line-height: 26px;
    color: #252525;
}
.ans-ques-type-7 .bg-latte {
    background: #f1ead8;
}
.ans-ques-type-7 .option-answers .bg-latte.active {
    background: rgba(138, 197, 62, .7294117647058823);
}

.ans-ques-type-8 .InputText-input-text {
    display: inline-block;
    z-index: 1;
    position: relative;
}
.ans-ques-type-8 input.txt {
    color: #555 !important;
    min-width: 50px !important;
    max-width: 99.99% !important;
    transition: width .25s;
    text-align: center;
    margin-left: 4px;
    margin-right: 4px;
    border: 1px solid #a1a1a1 !important;
}
.ans-ques-type-8 .InputText-input-text input {
    height: 28px;
    margin-bottom: 4px;
    margin-top: 4px;
}
.ans-ques-type-8 .InputText-input-text.correct input.txt{
  border: 1px solid #5eb34f !important;
}
</style>