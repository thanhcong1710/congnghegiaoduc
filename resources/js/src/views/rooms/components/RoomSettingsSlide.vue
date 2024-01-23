<template>
  <vx-card no-shadow>
    <div style="overflow: hidden;">
      <div class="con-input-upload" style="height: 130px; width: 98%">
        <input type="file" ref="file" multiple="multiple" @change="submitFiles">
        <span class="text-input">Upload Slide</span>
        <span>Click để chọn file cần upload (png, jpg, pdf, doc..)</span>
        <span class="input-progress" style="width: 0%;"></span>
        <button type="button" title="Upload" class="btn-upload-all vs-upload--button-upload">
          <i translate="no" class="material-icons notranslate">cloud_upload</i>
        </button>
      </div>
    </div>
  </vx-card>
</template>

<script>
  import axios from '../../../http/axios.js'

  export default {
    components: {},
    data() {
      return {
      }
    },
    methods: {
      submitFiles() {
        this.$vs.loading()
        const formData = new FormData();
        for (var i = 0; i < this.$refs.file.files.length; i++) {
          let file = this.$refs.file.files[i];
          formData.append('files[' + i + ']', file);
        }
        axios.p('/api/rooms/upload-file', formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            },
          }).then((response) => {  
            this.$vs.loading.close()
          })
          .catch((error)   => { console.log(error); this.$vs.loading.close(); })
      },
    }
  }
</script>