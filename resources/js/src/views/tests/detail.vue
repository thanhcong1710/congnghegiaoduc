<template>
  <div>
    <vs-row vs-w="12" class="mb-4">
      <vs-col class="mb-3" vs-type="flex" vs-justify="left" vs-align="center" vs-lg="4" vs-sm="12" vs-xs="12">
        <div class="flex flex-wrap items-center">
          <span class="p-3 inline-flex rounded-full feather-icon select-none relative text-primary"
            style="background: rgba(var(--vs-primary),.15);">
            <feather-icon icon="FileTextIcon" svgClasses="h-8 w-8"></feather-icon>
          </span>
          <div class="ml-5">
            <h5>{{test.title}}</h5>
            <p class="mt-2">30 phút 15 câu hỏi</p>
          </div>
        </div>
      </vs-col>
      <vs-col class="mb-3 action-test-detail" vs-type="flex" vs-justify="right" vs-align="center" vs-lg="8" vs-sm="12" vs-xs="12">
        <vs-button type="border"  @click="copyTextJoinLink(test.join_link, 'Link tham gia cuộc họp')">
          <feather-icon icon="CopyIcon" svgClasses="h-5 w-5"></feather-icon> Sao chép liên kết
        </vs-button>
        <vs-button class="ml-3" @click="join">
          <feather-icon icon="PlayCircleIcon" svgClasses="h-5 w-5"></feather-icon> Bắt đầu kiểm tra
        </vs-button>
      </vs-col>
    </vs-row>

    <vs-tabs :position="isSmallerScreen ? 'top' : 'left'" class="tabs-shadow-none" id="profile-tabs"
      :key="isSmallerScreen">

      <!-- GENERAL -->
      <vs-tab icon-pack="feather" icon="icon-settings" :label="!isSmallerScreen ? 'Cài đặt' : ''">
        <div class="tab-general md:ml-4 md:mt-0 mt-4 ml-0">
          <test-settings-general :test="test" />
        </div>
      </vs-tab>
      <vs-tab icon-pack="feather" icon="icon-help-circle" :label="!isSmallerScreen ? 'Câu hỏi' : ''">
        <div class="tab-info md:ml-4 md:mt-0 mt-4 ml-0">
          <test-settings-question :test="test"/>
        </div>
      </vs-tab>
      <vs-tab icon-pack="feather" icon="icon-user" :label="!isSmallerScreen ? 'Kết quả' : ''">
        <div class="tab-info md:ml-4 md:mt-0 mt-4 ml-0">
          <test-settings-record :test="test"/>
        </div>
      </vs-tab>
    </vs-tabs>
  </div>
</template>

<script>
  import axios from '../../http/axios.js'
  import TestSettingsGeneral from '../tests/components/TestSettingsGeneral.vue'
  import TestSettingsQuestion from '../tests/components/TestSettingsQuestion.vue'
  import TestSettingsSlide from '../tests/components/TestSettingsSlide.vue'

  export default {
    components: {
      TestSettingsGeneral,
      TestSettingsQuestion,
      TestSettingsSlide
    },
    data() {
      return {
        test: {},
      }
    },
    computed: {
      isSmallerScreen() {
        return this.$store.state.windowWidth < 768
      }
    },
    created() {
      this.getTestInfo();
    },
    methods: {
      getTestInfo() {
        this.$vs.loading()
        axios.g(`/api/tests/info/${this.$route.params.id}`)
          .then((response) => {
            this.$vs.loading.close()
            if (response.data.status) {
              this.test = response.data.data
            } else {
              this.$router.push({
                name: 'tests'
              }).catch(() => {})
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
      copyTextJoinLink(textCopy, message) {
          const thisIns = this;
          this.$copyText(textCopy).then(function() {
              thisIns.$vs.notify({
                  title: 'Copy',
                  text: message,
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
      join(){
        this.$vs.loading()
        axios.p(`/api/test/join`,{
          code: this.test.code,
          name: this.$store.state.AppActiveUser.name,
          pass: this.test.password_moderator,
          init: 1,
        })
        .then((response) => {
          if (response.data.status) {
            window.location.href = response.data.redirect_url;
            this.$vs.loading.close()
          } else {
            this.$vs.loading.close()
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
      }
    },
  }
</script>

<style lang="scss">
  #profile-tabs {
    .vs-tabs--content {
      padding: 0;
    }
  }
@media (max-width: 768px) {
  .action-test-detail .vs-button:not(.vs-radius):not(.includeIconOnly):not(.small):not(.large) {
    padding: 8px 10px;
  }
}
</style>