<template>
  <div>
    <div v-html="item.noi_dung"></div>
    <!-- view quiz type 6 -->
    <div class="ans-ques-type-6" v-if="item.type_view == 6">
        <div class=" mt-4 text-center select-text-question" >
          <span v-for="(item_lc, index_lc) in item.lua_chon" :key="index_lc">
          <div class="inline-block " clickable="true" v-html="item_lc.noi_dung"></div>
          <br v-if="item_lc.obj_type == 'breakDown'">
          </span>
        </div>
        <p style="margin-top:10px; margin-bottom:5px; font-weight: 600;">Đáp án</p>
        <div class="mt-4 text-center select-text-question">
          <span v-for="(item_lc, index_lc) in item.lua_chon" :key="index_lc">
            <div clickable="true" v-html="item_lc.noi_dung"  :class="item.dap_an[item_lc.id] ? 'inline-block bg-hightlight selected' : 'inline-block' " ></div>
            <br v-if="item_lc.obj_type == 'breakDown'">
          </span>
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