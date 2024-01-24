<template>
  <vx-card no-shadow>
    <div style="overflow: hidden;">
      <div class="con-input-upload" style="height: 130px; width: 100%;margin: 0px; margin-bottom: 20px;">
        <input type="file" ref="file" multiple="multiple" @change="submitFiles">
        <span class="text-input">Upload Slide</span>
        <span>Click để chọn file cần upload (png, jpg, pdf, doc..)</span>
        <span class="input-progress" style="width: 0%;"></span>
        <i translate="no" class="material-icons notranslate">cloud_upload</i>
      </div>

      <div class="vs-component vs-con-table stripe vs-table-primary mt-5">
        <header class="header-table vs-table--header">
          <!---->
        </header>
        <div class="con-tablex vs-table--content">
          <div class="vs-con-tbody vs-table--tbody ">
            <table class="vs-table vs-table--tbody-table">
              <thead class="vs-table--thead">
                <tr>
                  <!---->
                  <th colspan="1" rowspan="1">
                    <div class="vs-table-text">Tên file
                      <!---->
                    </div>
                  </th>
                  <th colspan="1" rowspan="1">
                    <div class="vs-table-text">Thao tác
                      <!---->
                    </div>
                  </th>
                </tr>
              </thead>
              <tr class="tr-values vs-table--tr tr-table-state-null" v-for="item in list_file" :key="item.id">
                <!---->
                <td class="td vs-table--td">
                  <span>{{item.title}}</span>
                </td>
                <td class="td vs-table--td">
                  <a target="blank" :href="item.file_url">
                    <feather-icon icon="DownloadIcon" svgClasses="h-5 w-5"></feather-icon>
                  </a>
                  <feather-icon icon="Trash2Icon" svgClasses="h-5 w-5" style="cursor: pointer;" @click="openConfirmDelete(item.id, item.title)"></feather-icon>
                </td>
              </tr>
            </table>
          </div>
          <!---->
          <!---->
        </div>
      </div>
    </div>
  </vx-card>
</template>

<script>
  import axios from '../../../http/axios.js'

  export default {
    components: {},
    props: {
      room: {
        type: Object,
        default: () => {}
      },
    },
    data() {
      return {
        list_file:[],
        delete_id:'',
      }
    },
    created() {
      this.getListFileByRoom();
    },
    methods: {
      submitFiles() {
        if(this.$refs.file.files.length){
          this.$vs.loading()
          const formData = new FormData();
          for (var i = 0; i < this.$refs.file.files.length; i++) {
            let file = this.$refs.file.files[i];
            formData.append('files[' + i + ']', file);
          }
          formData.append('room_id', this.room.id);
          axios.p('/api/rooms/upload-file', formData, {
              headers: {
                'Content-Type': 'multipart/form-data'
              },
            }).then((response) => {  
              // this.$vs.loading.close()
              this.getListFileByRoom();
            })
          .catch((error)   => { console.log(error); this.$vs.loading.close(); })
        }
      },
      getListFileByRoom() {
        this.$vs.loading()
        axios.g(`/api/rooms/slides/${this.$route.params.id}`)
          .then((response) => {
            this.$vs.loading.close()
            if (response.data.status) {
              this.list_file = response.data.data
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
      },
      openConfirmDelete(id,file_name) {
        this.delete_id = id
        this.$vs.dialog({
          type: 'confirm',
          color: 'danger',
          title: `Thông báo`,
          text: 'Bạn muốn xóa file trình chiếu '+file_name,
          accept: this.acceptDelete,
          acceptText: 'Xóa',
          cancelText:'Hủy'
        })
      },
      acceptDelete() {
        this.$vs.loading()
        axios.g(`/api/rooms/slides-delete/${this.delete_id}`)
          .then((response) => {
            this.$vs.loading.close()
            this.getListFileByRoom();
          })
          .catch((error) => {
            console.log(error);
            this.$vs.loading.close();
          })
      },
    }
  }
</script>