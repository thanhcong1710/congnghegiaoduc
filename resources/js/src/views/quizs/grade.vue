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
            <span class="cursor-default">Kho bài tập</span>
            <span class="breadcrumb-separator mx-2 flex items-start"><feather-icon :icon="$vs.trl ? 'ChevronsLeftIcon' : 'ChevronsRightIcon'" svgClasses="w-4 h-4" /></span>
          </li>
          <li class="inline-flex"><span class="cursor-default">{{grade_info.name}}</span></li>
        </ul>
      </div>
    </div>
    <div id="page-subjects">
      <div class="vx-row">
        <div class="vx-col w-full md:w-1/3 sm:w-1/2 mb-base" v-for="item in subjects" :key="item.id" @click="redirectSubjectDetail(item.id)">
          <vx-card class="text-center cursor-pointer">
            <h4 class="mb-2">{{ item.name }}</h4>
            <small> <strong>{{item.chapter_count}}</strong> chủ đề <strong>{{item.question_count}}</strong> câu
              hỏi</small>
          </vx-card>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
  import axios from '../../http/axios.js'
  export default {
    components: {},
    data() {
      return {
        subjects: [],
        grade_info:''
      }
    },
    methods: {
      getData() {
        this.$vs.loading()
        axios.p('/api/quizs/subjects', {
            grade_id: this.$route.params.id,
          })
          .then((response) => {
            this.subjects = response.data.list
            this.grade_info = response.data.grade_info
            this.$vs.loading.close()
          })
          .catch((error) => {
            console.log(error);
            this.$vs.loading.close();
          })
      },
      redirectSubjectDetail(id){
        this.$router.push({name: 'subject', params: {id:id }}).catch(() => {})
      }
    },
    created() {
      this.getData()
    }
  }
</script>