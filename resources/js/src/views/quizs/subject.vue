<template>
  <div>
    <div class="router-header flex flex-wrap items-center mb-6">
      <div class="vx-breadcrumb ml-4 ">
        <ul class="flex flex-wrap items-center">
          <li class="inline-flex items-end">
              <router-link to="/">
                  <feather-icon icon="HomeIcon" svgClasses="h-5 w-5 mb-1 stroke-current text-primary" />
              </router-link>
              <span class="breadcrumb-separator mx-2"><feather-icon :icon="$vs.trl ? 'ChevronsLeftIcon' : 'ChevronsRightIcon'" svgClasses="w-4 h-4" /></span>
          </li>
          <li class="inline-flex  items-center">
            <router-link :to="{name:'grade',id:subject_info.grade_id}" >{{ subject_info.grade_name }}</router-link>
            <span class="breadcrumb-separator mx-2 flex items-start"><feather-icon :icon="$vs.trl ? 'ChevronsLeftIcon' : 'ChevronsRightIcon'" svgClasses="w-4 h-4" /></span>
          </li>
          <li class="inline-flex"><span class="cursor-default">{{subject_info.name}}</span></li>
        </ul>
      </div>
    </div>
    <div id="page-subjects">
      <div class="vx-row">
        <div class="vx-col w-full md:w-1/2 sm:w-1/2" >
          <vx-card class="text-center mb-5" v-for="item in chapters" :key="item.id" v-if="item.id <=  center_id">
            <h4 class="mb-2">{{ item.title }}</h4>
            <div class="text-left label-chapter cursor-pointer" v-for="(item_sub, index_sub) in item.subs" :key="index_sub"  @click="redirectChapterDetail(item_sub.id)">
              <p>{{index_sub+1}}. {{ item_sub.title }} <span class="ml-2 num-q">({{item_sub.question_count}} câu)</span></p>
            </div>
          </vx-card>
        </div>
        <div class="vx-col w-full md:w-1/2 sm:w-1/2" >
          <vx-card class="text-center mb-5" v-for="item in chapters" :key="item.id" v-if="item.id > center_id">
            <h4 class="mb-2">{{ item.title }}</h4>
            <div class="text-left label-chapter cursor-pointer" v-for="(item_sub, index_sub) in item.subs" :key="index_sub"  @click="redirectChapterDetail(item_sub.id)">
              <p>{{index_sub+1}}. {{ item_sub.title }} <span class="ml-2 num-q">({{item_sub.question_count}} câu)</span></p>
            </div>
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
        chapters: [],
        subject_info:''
      }
    },
    methods: {
      getData() {
        this.$vs.loading()
        axios.p('/api/quizs/chapters', {
            subject_id: this.$route.params.id,
          })
          .then((response) => {
            this.chapters = response.data.list
            this.subject_info = response.data.subject_info
            this.center_id = response.data.center_id
            this.$vs.loading.close()
          })
          .catch((error) => {
            console.log(error);
            this.$vs.loading.close();
          })
      },
      redirectChapterDetail(id){
        this.$router.push({name: 'chapter', params: {id:id }}).catch(() => {})
      }
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