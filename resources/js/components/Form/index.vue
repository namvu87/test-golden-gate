<template>
  <el-form ref="form" :label-position="labelPosition" :model="form">
    <slot />
  </el-form>
</template>

<script>
export default {
  // eslint-disable-next-line vue/no-reserved-component-names
  name: 'Form',
  props: {
    form: {
      type: Object,
      required: true,
    },
    labelPosition: {
      type: String,
      default: 'left',
    },
  },
  methods: {
    resetForm() {
      this.$refs.form.resetFields();
    },
  },
};
</script>

<style>

</style>
