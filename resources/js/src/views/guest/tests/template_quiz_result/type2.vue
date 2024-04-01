<template>
  <div>
    <div v-html="item.noi_dung"></div>
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