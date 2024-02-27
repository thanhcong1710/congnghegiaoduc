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
          <div>
            <div><strong>Câu {{index + 1 + (pagination.cpage - 1) * pagination.limit}}</strong></div>
            <div v-html="item.noi_dung"></div>
          </div>
        </div>
      </vx-card>
      
    </div>
      
    <vs-pagination
        v-if="Math.ceil(pagination.total / pagination.limit) >1"
        :total="Math.ceil(pagination.total / pagination.limit)"
        :max="7"
        v-model="pagination.cpage" @change="changePage()"/>
  </div>

</template>
<script>
  import VueMathjax from 'vue-mathjax'
  import axios from '../../http/axios.js'
  export default {
    components: {},
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
    },
    created() {
      this.getData()
    }
  }
</script>
<style scoped>
.label-chapter p{
  color: #2f6a4f;
  font-size: 15px;
  margin-bottom: 4px;
}
.label-chapter p:hover{
  color: #4624ee;
  text-decoration: underline;
}
.label-chapter p .num-q{
  color:#2c2c2c
}
</style>