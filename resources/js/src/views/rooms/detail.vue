<template>
  <div>
    <vs-row vs-w="12" class="mb-4">
      <vs-col class="mb-3" vs-type="flex" vs-justify="left" vs-align="center" vs-lg="4" vs-sm="12" vs-xs="12">
        <div class="flex flex-wrap items-center">
          <span class="p-3 inline-flex rounded-full feather-icon select-none relative text-primary"
            style="background: rgba(var(--vs-primary),.15);">
            <feather-icon icon="VideoIcon" svgClasses="h-8 w-8"></feather-icon>
          </span>
          <div class="ml-5">
            <h5>{{room.title}}</h5>
            <p class="mt-2">Phiên gần nhất: {{room.last_session_time}}</p>
          </div>
        </div>
      </vs-col>
      <vs-col class="mb-3 action-room-detail" vs-type="flex" vs-justify="right" vs-align="center" vs-lg="8" vs-sm="12" vs-xs="12">
        <vs-button type="border">
          <feather-icon icon="CopyIcon" svgClasses="h-5 w-5"></feather-icon> Sao chép liên kết
        </vs-button>
        <vs-button class="ml-3">
          <feather-icon icon="PlayCircleIcon" svgClasses="h-5 w-5"></feather-icon> Bắt đầu cuộc họp
        </vs-button>
      </vs-col>
    </vs-row>

    <vs-tabs :position="isSmallerScreen ? 'top' : 'left'" class="tabs-shadow-none" id="profile-tabs"
      :key="isSmallerScreen">

      <!-- GENERAL -->
      <vs-tab icon-pack="feather" icon="icon-settings" :label="!isSmallerScreen ? 'Cài đặt' : ''">
        <div class="tab-general md:ml-4 md:mt-0 mt-4 ml-0">
          <room-settings-general :data="room" />
        </div>
      </vs-tab>
      <vs-tab icon-pack="feather" icon="icon-file-text" :label="!isSmallerScreen ? 'Slide thuyết trình' : ''">
        <div class="tab-info md:ml-4 md:mt-0 mt-4 ml-0">
          <room-settings-slide />
        </div>
      </vs-tab>
      <vs-tab icon-pack="feather" icon="icon-save" :label="!isSmallerScreen ? 'Bản ghi hình' : ''">
        <div class="tab-info md:ml-4 md:mt-0 mt-4 ml-0">
          <room-settings-record />
        </div>
      </vs-tab>
    </vs-tabs>
  </div>
</template>

<script>
  import axios from './../../http/axios.js'
  import RoomSettingsGeneral from './components/RoomSettingsGeneral.vue'
  import RoomSettingsRecord from './components/RoomSettingsRecord.vue'
  import RoomSettingsSlide from './components/RoomSettingsSlide.vue'

  export default {
    components: {
      RoomSettingsGeneral,
      RoomSettingsRecord,
      RoomSettingsSlide
    },
    data() {
      return {
        room: {},
      }
    },
    computed: {
      isSmallerScreen() {
        return this.$store.state.windowWidth < 768
      }
    },
    created() {
      this.getRoomInfo();
    },
    methods: {
      getRoomInfo() {
        this.$vs.loading()
        axios.g(`/api/rooms/info/${this.$route.params.id}`)
          .then((response) => {
            this.$vs.loading.close()
            if (response.data.status) {
              this.room = response.data.data
            } else {
              this.$router.push({
                name: 'rooms'
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
  .action-room-detail .vs-button:not(.vs-radius):not(.includeIconOnly):not(.small):not(.large) {
    padding: 8px 10px;
  }
}
</style>