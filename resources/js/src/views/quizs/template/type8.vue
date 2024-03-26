<template>
  <div>
    <div v-html="item.noi_dung"></div>
    <!-- view quiz type 8 -->
    <div class="ans-ques-type-8 mt-4" v-if="item.type_view == 8">
      <div class="text-center">
        <span v-for="(item_lc, index_lc) in item.lua_chon" :key="index_lc">
          <span class="rich_text inline-block item-img" v-if="item_lc.obj_type == 'richText'">
                  <span :id="item_lc.id">
                      <span v-html="item_lc.noi_dung"></span>
                  </span>
              </span>
              <span class="InputText-input-text" v-if="item_lc.obj_type == 'inputText'">
                <a class="Input_text InputText"></a>
                <input type="text" class="inline-block txt " :id="item_lc.id" size="3" value="">
              </span>
              <br v-if="item_lc.obj_type == 'breakDown'">
        </span>
      </div>
    </div>
    <div class="ans-ques-type-8 mt-4" v-if="item.type_view == 8">
      <p style="margin-bottom:10px; font-weight: 600;">Đáp án</p>
      <div class="text-center">
        <span v-for="(item_lc, index_lc) in item.lua_chon" :key="index_lc">
          <span class="rich_text inline-block item-img" v-if="item_lc.obj_type == 'richText'">
                  <span :id="item_lc.id">
                      <span v-html="item_lc.noi_dung"></span>
                  </span>
              </span>
              <span class="InputText-input-text correct" v-if="item_lc.obj_type == 'inputText'">
                <a class="Input_text InputText"></a>
                <input type="text" class="inline-block txt " :id="item_lc.id" size="3" :value="item.dap_an[item_lc.id]">
              </span>
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