<template>
  <div>
    <div v-html="item.noi_dung"></div>
    <!-- view quiz type 1 -->
    <div class="vx-row ans-ques-type-1">
      <div class="vx-col w-full sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/2 mt-2" v-for="(item_op, index_op) in item.lua_chon"
        :key="index_op">
        <vs-radio v-model="item.dap_an" :vs-value="item_op.answer_key" :vs-name="'quiz_'+item.id">
          <div class="option-key">{{item_op.answer_key}}.</div>
          <div class="option-content" v-html="item_op.noi_dung"></div>
        </vs-radio>
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