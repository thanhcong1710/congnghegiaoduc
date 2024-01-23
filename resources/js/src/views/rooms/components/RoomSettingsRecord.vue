<template>
  <vx-card no-shadow>
    <div class="vs-component vs-con-table stripe vs-table-primary">
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
                  <div class="vs-table-text">Email
                    <!---->
                  </div>
                </th>
                <th colspan="1" rowspan="1">
                  <div class="vs-table-text">Name
                    <!---->
                  </div>
                </th>
                <th colspan="1" rowspan="1">
                  <div class="vs-table-text">Website
                    <!---->
                  </div>
                </th>
                <th colspan="1" rowspan="1">
                  <div class="vs-table-text">Nro
                    <!---->
                  </div>
                </th>
              </tr>
            </thead>
            <tr class="tr-values vs-table--tr tr-table-state-null">
              <!---->
              <td class="td vs-table--td"><span>
                  <!---->
                  Sincere@april.biz
                  <!----></span></td>
              <td class="td vs-table--td"><span>
                  <!---->
                  Leanne Graham
                  <!----></span></td>
              <td class="td vs-table--td"><span>
                  <!---->
                  hildegard.org
                  <!----></span></td>
              <td class="td vs-table--td"><span>
                  <!---->
                  1
                  <!----></span></td>
            </tr>
          </table>
        </div>
        <!---->
        <!---->
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
        note: this.$store.state.AppActiveUser.note,
        birthday: this.$store.state.AppActiveUser.birthday,
        address: this.$store.state.AppActiveUser.address,
        gender: this.$store.state.AppActiveUser.gender,
        alert: {
          status: '',
          show: false,
          message: ''
        }
      }
    },
    computed: {
      activeUserInfo() {
        return this.$store.state.AppActiveUser
      }
    },
    methods: {
      updateUser() {
        this.$vs.loading()
        axios.p('/api/user/update-info', {
            data: {
              'note': this.note,
              'birthday': this.birthday,
              'address': this.address,
              'gender': this.gender
            }
          })
          .then((response) => {
            this.$store.dispatch('updateUserInfo', response.data.userData)
            this.$vs.loading.close()
            this.alert.show = true
            this.alert.status = response.data.status
            this.alert.message = response.data.message
            this.alert.color = response.data.status ? 'success' : 'danger'
          })
          .catch((error) => {
            console.log(error);
            this.$vs.loading.close();
          })
      },
      reset() {
        this.note = this.$store.state.AppActiveUser.note
        this.birthday = this.$store.state.AppActiveUser.birthday
        this.address = this.$store.state.AppActiveUser.address
        this.gender = this.$store.state.AppActiveUser.gender
      }
    }
  }
</script>