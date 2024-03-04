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
            <div class="ans-ques-type-3" v-if="item.type_view == 3">
              <div class="text-center fill-box-question text-left">
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

            <!-- view quiz type 4 -->
            <div class="ans-ques-type-4 mt-8" v-if="item.type_view == 4">
              <div class="row-lego" id="match-side" v-for="(item_tg, index_tg) in item.targets.items" :key="index_tg">
                <div class="col-lego">
                    <div class="text lego-question-item text-center item-lego-target" >
                        <div v-html="item_tg.text_content"></div>
                    </div>
                </div>
                <div class="col-lego" style="opacity: 1;">
                    <div class="text lego-question-item text-center  item-lego-source dragEnd" draggable="true">
                        <div v-html="item.sources.items[index_tg].text_content"></div>
                    </div>
                </div>
              </div>
            </div>
            <div class="ans-ques-type-4 mt-8" v-if="item.type_view == 4">
              <p style="margin-bottom:10px; font-weight: 600;">Đáp án</p>
              <div class="mergeDiv row-lego" id="match-side" v-for="(item_tg, index_tg) in item.targets.items" :key="index_tg">
                  <div class="col-lego">
                      <div class="text lego-question-item text-center item-lego-target">
                          <div v-html="item_tg.text_content"></div>
                      </div>
                  </div>
                  <div class="col-lego" style="opacity: 1;">
                      <div class="text lego-question-item text-center  item-lego-source dragEnd" draggable="true">
                          <div v-html="item.sources.items[item.dap_an[item_tg.id]].text_content"></div>
                      </div>
                  </div>
              </div>
            </div>

            <!-- view quiz type 5 -->
            <div class="ans-ques-type-5 mt-8" v-if="item.type_view == 5">
              <div class="text-center list-item paragraph-components">
                <span class="box_container" v-for="(item_pg, index_pg) in item.paragraph.items" :key="index_pg">
                  <div class="solution-fill-item inline-block box-text">
                      <div v-html="item_pg.text_content"></div>
                  </div>
                </span>
              </div>
            </div>
            <div class="ans-ques-type-5 mt-8" v-if="item.type_view == 5">
              <p style="margin-bottom:10px; font-weight: 600;">Đáp án</p>
              <div class="text-center list-item paragraph-components">
                  <span class="box_container" v-for="(item_da, index_da) in item.dap_an" :key="index_da">
                    <div class="solution-fill-item inline-block box-text answer-correct">
                        <div v-html="item_da.text_content"></div>
                    </div>
                  </span>
                </div>
            </div>

            <!-- view quiz type 6 -->
            <div class="ans-ques-type-6" v-if="item.type_view == 6">
              <div class=" mt-4 select-text-question" >
                <div class="inline-block " clickable="true" v-for="(item_lc, index_lc) in item.lua_chon" :key="index_lc" v-html="item_lc.noi_dung">
                </div>
              </div>
              <p style="margin-top:10px; margin-bottom:5px; font-weight: 600;">Đáp án</p>
              <div class="mt-4 select-text-question">
                <div clickable="true" v-for="(item_lc, index_lc) in item.lua_chon" :key="index_lc" v-html="item_lc.noi_dung"  :class="item.dap_an[item_lc.id] ? 'inline-block bg-hightlight selected' : 'inline-block' " >
                </div>
              </div>
            </div>

            <!-- view quiz type 7 -->
            <div class="ans-ques-type-7 mt-4" v-if="item.type_view == 7">
              <div class="option-answers yes-no-question choice-button" clickable="true" v-for="(item_lc, index_lc) in item.lua_chon" :key="index_lc">
                <a :class=" item.dap_an[item_lc.id] ? 'active bg-latte font-size-20' : 'bg-latte font-size-20'"><span v-html="item_lc.noi_dung"></span></a>
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
</style>