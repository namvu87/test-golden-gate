<template>
  <el-input
    v-model="tempInput"
    :name="inputName"
    :placeholder="placeholder"
    :suffix-icon="inputIcon"
    @keyup.enter.native="search"
  />
</template>

<script>
export default {
  // eslint-disable-next-line vue/no-reserved-component-names
  name: 'Input',
  props: {
    input: {
      type: String,
      default: '',
    },
    inputIcon: {
      type: String,
      default: '',
    },
    isSearch: {
      type: Boolean,
      default: true,
    },
    inputName: {
      type: String,
      default: '',
    },
    placeholder: {
      type: String,
      default: '',
    },
  },
  computed: {
    tempInput: {
      get() {
        return this.input;
      },
      set(val) {
        this.setInput(val);
      },
    },
  },
  methods: {
    setInput(val) {
      this.$emit('setInput', val);
    },
    search() {
      if (this.isSearch) {
        this.$emit('search');
      }
    },
  },
};
</script>

<style>

</style>
