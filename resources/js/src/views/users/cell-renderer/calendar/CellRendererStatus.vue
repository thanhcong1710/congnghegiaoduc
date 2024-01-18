<template>
    <vs-chip class="ag-grid-cell-chip" :color="chipColor(params.value)">
      <span v-text="titleStatus(params.value)"></span>
    </vs-chip>
</template>

<script>
export default {
  name: 'CellRendererStatus',
  computed: {
    chipColor () {
      return (value) => {
        if (value == '2') return 'success'
        // else if (value == 'blocked') return 'danger'
        else if (value == '1') return 'warning'
        else return 'primary'
      }
    },
    titleStatus () {
      return (value) => {
        if (value == '2') return 'Hoàn thành'
        // else if (value == 'blocked') return 'danger'
        else if (value == '1') return 'Đã xếp lịch'
        else return 'Lịch chống'
      }
    }
  }
}
</script>

<style lang="scss" scpoped>
.ag-grid-cell-chip {
  &.vs-chip-success {
    background: rgba(var(--vs-success),.15);
    color: rgba(var(--vs-success),1) !important;
    font-weight: 500;
  }
  &.vs-chip-warning {
    background: rgba(var(--vs-warning),.15);
    color: rgba(var(--vs-warning),1) !important;
    font-weight: 500;
  }
  &.vs-chip-danger {
    background: rgba(var(--vs-danger),.15);
    color: rgba(var(--vs-danger),1) !important;
    font-weight: 500;
  }
}
</style>
