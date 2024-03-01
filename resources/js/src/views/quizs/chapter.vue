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
        <div class="ques-item" v-for="(item, index) in questions" :key="index">
          <div class="mb-base">
            <div class="ques-parent" v-if="item.parent && item.parent.noi_dung" v-html="item.parent.noi_dung"></div>
            <div><strong style="font-size:16px;font-weight:600;">Câu {{index + 1 + (pagination.cpage - 1) * pagination.limit}}</strong></div>
            <div v-html="item.noi_dung"></div>
            <!-- view quiz type 1 -->
            <div class="vx-row ans-ques-type-1" v-if="item.type_view == 1">
              <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/2 mt-2"  v-for="(item_op, index_op) in item.lua_chon" :key="index_op">
                <vs-radio v-model="item.dap_an" :vs-value="item_op.answer_key" :vs-name="'quiz_'+item.id" :disabled="true">
                  <div class="option-key">{{item_op.answer_key}}.</div>
                  <div class="option-content" v-html="item_op.noi_dung"></div>
                </vs-radio> 
              </div>
            </div>

            <!-- view quiz type 2 -->
            <div class="main-content-quiz ans-ques-type-2" v-if="item.type_view == 2">
              <div>
                  <p class="option-choicce font-roboto-b text-right"><span>ĐÚNG</span><span>SAI</span></p>
                  <div class="choice_answer radio-list-horizontal">
                      <div class="item"  v-for="(item_op, index_op) in item.lua_chon" :key="index_op">
                          <div class="content-quiz">
                              <div v-html="item_op.noi_dung"></div>
                          </div>
                          <vs-checkbox class="checkbox-question-2" :checked="item.dap_an[item_op.id]" disabled="true"></vs-checkbox>
                          <vs-checkbox class="checkbox-question-2" :checked="!item.dap_an[item_op.id]" disabled="true"></vs-checkbox>
                      </div>
                  </div>
              </div>
            </div>

            <!-- view quiz type 3 -->
            <div class="ans-ques-type-3">
              <div class="text-center fill-box-question text-left" v-if="item.type_view == 3">
                <div class="solution">
                  <div class="list-item paragraph-components">
                      <div class="solution-fill-item inline-block box-text" draggable="true" v-for="(item_fp, index_fp) in item.firstParagraph.items" :key="index_fp">
                          <div>{{item_fp.content}}</div>
                      </div>
                  </div>
                </div>
              </div>
              <div class="fill-answer">
                <div class="text-center list-item paragraph-components" >
                  <span v-for="(item_sp, index_sp) in item.secondParagraph.items" :key="index_sp">
                    <span class="rich_text inline-block item-img" v-if="item_sp.obj_type == 'richText'">
                        <span :id="item_sp.id">
                            <span>{{item_sp.content}}</span>
                        </span>
                    </span>
                    <span class="empty-box inline-block box-text answer-correct" v-if="item_sp.obj_type == 'boxText'">
                        <span :id="item_sp.id">
                          {{item.dap_an[item_sp.id]}}
                        </span>
                    </span>
                    <br v-if="item_sp.obj_type == 'breakDown'">
                  </span>
                </div>
              </div>
            </div>
            
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
  </div>

</template>
<script>
  import axios from '../../http/axios.js'
  export default {
    components: {
    },
    data() {
      return {
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
      }
    },
    created() {
      this.getData()
    }
  }
</script>
<style>
.option-key{
  float: left;
  width: 25px;
  text-transform: uppercase;
  font-size: 15px;
  line-height: 20px;  
}
.option-content{
  float: left;
  width: calc(100% - 25px);
  line-height: 20px;
}
.ques-item .vs-radio{
  position: absolute;
  top:0;
}
.ques-item .vs-radio--label {
    margin-left: 25px;
}
.ques-parent {
  border: 2px solid #ccc;
  padding: 5px 10px;
  margin-bottom: 10px;
}
.label-show-answer i{
  cursor: pointer;
  color: #1d56e0;
  font-size: 15px;
  text-decoration: underline;
}
.content-show-answer {
  padding: 10px 15px;
  border: 2px solid #057d2180;
  border-radius: 8px;
  margin-top: 4px;
}
.content-show-answer p{
  margin-bottom: 2px;
}

.ans-ques-type-2.main-content-quiz {
  font-size: 16px;
  width: 100%;
  display: block;
  max-width: 686px;
  overflow: hidden;
  margin: auto;
}
.ans-ques-type-2 .option-choicce>span {
    margin-right: 20px;
}
.ans-ques-type-2 .option-choicce>span {
    display: inline-block; 
}
.ans-ques-type-2 .font-roboto-b {
    font-family: Roboto-regular;
    font-weight: 700;
}
.ans-ques-type-2 .text-right {
    text-align: right;
}
.ans-ques-type-2 .content-quiz{
  float: left;
  width: calc(100% - 120px);
  margin-right: 20px;
  margin-top: 3px;
}
.ans-ques-type-2 .checkbox-question-2{
  float: left;
  width: 50px;
  text-align: center;
  margin: 0px;
  margin-top: 4px;
}

.ans-ques-type-2 .vs-checkbox--input:disabled+.vs-checkbox{
  opacity:1
}
.ans-ques-type-1 .vs-radio--input:disabled+.vs-radio{
  opacity:1
}

.ans-ques-type-3 .list-item .solution-fill-item {
    margin: 10px 5px;
}
.ans-ques-type-3 .solution-fill-item {
    display: inline-block;
    padding: 0 10px;
    border: 1px solid #c1c1c1;
    border-radius: 3px;
    text-align: center;
    background: #f1ead9;
    line-height: 27px;
    cursor: pointer;
    vertical-align: bottom;
    margin: 0 5px 5px;
    vertical-align: baseline;
    margin-right: 5px !important;
}
.ans-ques-type-3 .fill-box-question{
  margin: 10px 0px;
}
.ans-ques-type-3 .fill-answer .empty-box {
    cursor: pointer;
    border-radius: 3px;
    display: inline-block;
    min-width: 66px;
    height: 29px;
    border: 1px solid #c1c1c1 !important;
    opacity: 1 !important;
    margin: 10px 5px;
    padding: 0 10px;
    vertical-align: middle;
}
.ans-ques-type-3 .fill-answer .empty-box.answer-correct{
  border: 1px solid #0ab60a !important;
}
</style>