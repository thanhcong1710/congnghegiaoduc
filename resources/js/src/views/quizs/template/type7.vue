<template>
  <div>
    <div v-html="item.noi_dung"></div>
    <!-- view quiz type 7 -->
    <div class="ans-ques-type-7 mt-4" v-if="item.type_view == 7">
      <div class="option-answers yes-no-question choice-button" clickable="true" v-for="(item_lc, index_lc) in item.lua_chon" :key="index_lc">
        <a :class=" item.dap_an[item_lc.id] ? 'active bg-latte font-size-20' : 'bg-latte font-size-20'"><span v-html="item_lc.noi_dung"></span></a>
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