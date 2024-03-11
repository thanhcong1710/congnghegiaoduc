<template>
  <vx-card no-shadow>
    <div class="vx-row tab-config-test">
      <div class="vx-col md:w-1/2 w-full mb-base item-first">
        <div class="mb-6">
          <label>Chuyên đề</label>
          <v-select
                id="topic-options"
                v-model="test.topic_id"
                :dir="$vs.rtl? 'rtl' : 'ltr'"
                :options="topicOptions"
                :reduce="val => val.id"
                :clearable="true"
                label="title"
                input-id="topic-options"
              />
        </div>
        <div class="mb-6">
          <label>Tên bài kiểm tra</label>
          <div class=w-full>
            <input type="text" v-model="test.title" class="vs-inputx vs-input--input normal">
          </div>
        </div>
        <div class="mb-6">
          <label>Thời gian</label>
          <div class=w-full>
            <input v-model="test.duration"  type="number" min="0" class="vs-inputx vs-input--input normal" style="width: 100px"> <span>(phút)</span>
          </div>
        </div>
         <div class="mb-6">
          <vs-button @click="updateInfoTest()">Cập nhật</vs-button>
        </div>
      </div>
      <div class="vx-col md:w-1/2 w-full mb-base item-last">
        <h5 class="mb-6">Thiết lập người dùng</h5>
        <div class="mb-4">
          <div class=w-full>
            <label style=" width: calc(100% - 50px); float:left">Cho phép trộn thứ tự đáp án</label> <vs-switch v-model="test.cf_tron_dap_an" @input="updateConfigTest" style="float:left; margin-left: 5px;"/>
          </div>
          <div style="clear:both"></div>
        </div>
        <div class="mb-4">
          <div class=w-full>
            <label style=" width: calc(100% - 50px); float:left">Cho phép học sinh làm lại bài kiểm tra</label> <vs-switch v-model="test.cf_lam_lai" @input="updateConfigTest" style="float:left; margin-left: 5px;"/>
          </div>
          <div style="clear:both"></div>
        </div>
        <div class="mb-4">
          <div class=w-full>
            <label style=" width: calc(100% - 50px); float:left">Hiển thị kết quả sau khi nộp bài kiểm tra</label> <vs-switch v-model="test.cf_xem_ket_qua" @input="updateConfigTest" style="float:left; margin-left: 5px;"/>
          </div>
          <div style="clear:both"></div>
        </div>
        <div class="mb-4">
          <div class=w-full>
            <label style=" width: calc(100% - 50px); float:left">Hiển thị lời giải chi tiết sau khi nộp bài kiểm tra</label> <vs-switch v-model="test.cf_xem_loi_giai" @input="updateConfigTest" style="float:left; margin-left: 5px;"/>
          </div>
          <div style="clear:both"></div>
        </div>
        <div class="mb-4">
          <vs-button style="float:right" type="border" color="danger" @click="openConfirmDeleteTest(test.id, test.title)">Xóa bài kiểm tra</vs-button>
          <div style="clear:both"></div>
        </div>
      </div>
    </div>
  </vx-card>

</template>

<script>
  import axios from '../../../http/axios.js'
  import vSelect from 'vue-select'
  export default {
    components: {
      vSelect
    },
    props: {
      test: {
        type: Object,
        default: () => {}
      },
    },
    data() {
      return {
        topicOptions:[],
        delete_test_id:'',
        alert: {
          status: '',
          show: false,
          message: ''
        },
        switch1:''
      }
    },
    created() {
      this.getTopics();
    },
    methods: {
      getTopics() {
        this.$vs.loading()
        axios.g('/api/topics/list-all-user')
          .then((response) => {
            this.topicOptions = response.data
            this.$vs.loading.close()
          })
          .catch((error) => {
            console.log(error);
            this.$vs.loading.close();
          })
      },
      copyText(textCopy) {
          const thisIns = this;
          this.$copyText(textCopy).then(function() {
              thisIns.$vs.notify({
                  title: 'Copy',
                  text: textCopy,
                  color: 'success',
                  iconPack: 'feather',
                  icon: 'icon-check-circle'
              })
          }, function() {
              thisIns.$vs.notify({
                  title: 'Failed',
                  text: 'Error in copying text',
                  color: 'danger',
                  iconPack: 'feather',
                  icon: 'icon-alert-circle'
              })
          })
      },
      updateInfoTest(){
        if(!this.test.title){
          this.$vs.notify({
            title: 'Lỗi',
            text: 'Tên phòng họp không được để trống',
            iconPack: 'feather',
            icon: 'icon-alert-circle',
            color: 'danger'
          })
          return false;
        }
        this.$vs.loading()
        axios.p(`/api/tests/update`,{
          id: this.test.id,
          title: this.test.title,
          topic_id: this.test.topic_id,
          duration: this.test.duration
        })
        .then((response) => {
          this.$vs.loading.close()
          if (response.data.status) {
            this.$vs.notify({
              title: 'Thành Công',
              text: response.data.message,
              iconPack: 'feather',
              icon: 'icon-alert-circle',
              color: 'success'
            })
          } else {
            this.$vs.notify({
              title: 'Lỗi',
              text: response.data.message,
              iconPack: 'feather',
              icon: 'icon-alert-circle',
              color: 'danger'
            })
          }
        })
        .catch((error) => {
          console.log(error);
          this.$vs.loading.close();
        })
      },
      openConfirmDeleteTest(id,test_name) {
        this.delete_test_id = id
        this.$vs.dialog({
          type: 'confirm',
          color: 'danger',
          title: `Thông báo`,
          text: 'Bạn muốn xóa bài kiểm tra: "'+test_name+'" . Lưu ý sau khi xóa các dữ liệu kết quả làm bài kiểm tra của học sinh sẽ bị mất.',
          accept: this.acceptDeleteTest,
          acceptText: 'Xóa',
          cancelText:'Hủy'
        })
      },
      acceptDeleteTest() {
        this.$vs.loading()
        axios.g(`/api/tests/delete/${this.delete_test_id}`)
          .then((response) => {
            this.$vs.loading.close()
            if (response.data.status) {
              this.$router.push({name: 'tests'}).catch(() => {})
              this.$vs.notify({
                title: 'Thành Công',
                text: response.data.message,
                iconPack: 'feather',
                icon: 'icon-alert-circle',
                color: 'success'
              })
            } else {
              this.$vs.notify({
                title: 'Lỗi',
                text: response.data.message,
                iconPack: 'feather',
                icon: 'icon-alert-circle',
                color: 'danger'
              })
            }
          })
          .catch((error) => {
            console.log(error);
            this.$vs.loading.close();
          })
      },
      updateConfigTest(){
        this.$vs.loading()
        axios.p(`/api/tests/update`,{
          id: this.test.id,
          cf_tron_dap_an: this.test.cf_tron_dap_an ? 1 : 0,
          cf_lam_lai: this.test.cf_lam_lai ? 1 : 0,
          cf_xem_ket_qua: this.test.cf_xem_ket_qua ? 1 : 0,
          cf_xem_loi_giai: this.test.cf_xem_loi_giai ? 1 : 0,
        })
        .then((response) => {
          this.$vs.loading.close()
          if (response.data.status) {
            this.$vs.notify({
              title: 'Thành Công',
              text: response.data.message,
              iconPack: 'feather',
              icon: 'icon-alert-circle',
              color: 'success'
            })
          } else {
            this.$vs.notify({
              title: 'Lỗi',
              text: response.data.message,
              iconPack: 'feather',
              icon: 'icon-alert-circle',
              color: 'danger'
            })
          }
        })
        .catch((error) => {
          console.log(error);
          this.$vs.loading.close();
        })
      },
    },
  }
</script>
<style scoped>
.tab-config-test .vx-col.mb-base.item-first{
  border-right: 1px solid #ccc
}
.tab-config-test .vx-col.mb-base.item-last{
  border-left: 1px solid #ccc
}
.feather-icon {
  cursor: pointer;
}
@media (max-width: 768px) {
  .tab-config-test .vx-col.mb-base.item-last, .tab-config-test .vx-col.mb-base.item-first{
    border:none
  }
}
</style>