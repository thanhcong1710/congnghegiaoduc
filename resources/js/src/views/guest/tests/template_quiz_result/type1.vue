<template>
  <div>
    <div v-html="item.quiz_info.noi_dung"></div>
    <!-- view quiz type 1 -->
    <div class="vx-row ans-ques-type-1 mb-4">
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/2 mt-2" v-for="(item_op, index_op) in item.quiz_info.lua_chon"
        :key="index_op">
        <vs-radio v-model="item.quiz_info.user_answer" :vs-value="item_op.answer_key" :vs-name="'quiz_'+item.id">
          <div class="option-key">{{item_op.answer_key}}.</div>
          <div class="option-content" v-html="item_op.noi_dung"></div>
        </vs-radio>
      </div>
    </div>
    <div :class="item.result != 1 ? 'content-show-answer error' : 'content-show-answer'">
      <div class="box-result">
        <span class="text-answer">
          <i class="fa-solid fa-xmark" v-if="item.result != 1"></i>
          <i class="fa-solid fa-check" v-else></i>
          Bạn đã chọn: <span style="text-transform:uppercase">{{item.answer}}</span>
        </span>
        <span class="text-result"> 
          | Đáp án đúng: <span style="text-transform:uppercase">{{item.quiz_info.dap_an}}</span>
        </span>
      </div>
      <div>
        <div>Lời giải:</div>
        <div v-html="item.quiz_info.loi_giai"></div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      item: {
        type: Object,
        required: true
      }
    }
  }
</script>
<style scoped>
.box-result{
  font-size: 24px;
}
.content-show-answer .text-answer{
  color: #03a416;
}
.content-show-answer.error .text-answer{
  color: #bc0606;
}
.content-show-answer .text-result{
  color: #03a416;
}
[dir] .content-show-answer.error {
  border: 2px solid #9904047a;
}
</style>