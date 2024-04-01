<template>
  <div>
    <div v-html="item.noi_dung"></div>
    <!-- view quiz type 5 -->
    <div class="ans-ques-type-5 mt-8" v-if="item.type_view == 5">
      <div class="text-center list-item paragraph-components">
        <span class="box_container" v-for="(item_pg, index_pg) in item.paragraph.items" :key="index_pg">
          <div class="solution-fill-item inline-block box-text">
              <div v-html="item_pg.text_content"></div>
          </div>
        </span>
      </div>
    </div>
    <div class="ans-ques-type-5 mt-8" v-if="item.type_view == 5">
      <p style="margin-bottom:10px; font-weight: 600;">Đáp án</p>
      <div class="text-center list-item paragraph-components">
          <span class="box_container" v-for="(item_da, index_da) in item.dap_an" :key="index_da">
            <div class="solution-fill-item inline-block box-text answer-correct">
                <div v-html="item_da.text_content"></div>
            </div>
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