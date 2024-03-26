<template>
  <div>
    <div v-html="item.noi_dung"></div>
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