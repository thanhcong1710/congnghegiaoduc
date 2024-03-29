<template>
  <div>
    <div v-html="item.noi_dung"></div>
    <!-- view quiz type 3 -->
    <div class="ans-ques-type-3" v-if="item.type_view == 3">
      <div class="text-center fill-box-question text-left">
        <div class="solution">
          <div class="list-item paragraph-components">
              <div class="solution-fill-item inline-block box-text" draggable="true" v-for="(item_fp, index_fp) in item.firstParagraph.items" :key="index_fp">
                  <div>{{item_fp.content}}</div>
              </div>
          </div>
        </div>
      </div>
      <div class="fill-answer">
        <div class="text-center list-item paragraph-components" >
          <span v-for="(item_sp, index_sp) in item.secondParagraph.items" :key="index_sp">
            <span class="rich_text inline-block item-img" v-if="item_sp.obj_type == 'richText'">
                <span :id="item_sp.id">
                    <span>{{item_sp.content}}</span>
                </span>
            </span>
            <span class="empty-box inline-block box-text answer-correct" v-if="item_sp.obj_type == 'boxText'">
                <span :id="item_sp.id">
                  {{item.dap_an[item_sp.id]}}
                </span>
            </span>
            <br v-if="item_sp.obj_type == 'breakDown'">
          </span>
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