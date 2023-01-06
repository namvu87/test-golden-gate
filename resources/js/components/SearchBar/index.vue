<template>
  <div class="search-form">
    <Form ref="searchForm" :form="searchData" :label-position="labelPositionForm">
      <slot />
      <slot name="search-btn" />
    </Form>
  </div>
</template>

<script>
import Form from '../Form/index';

export default {
  name: 'SearchBar',
  // eslint-disable-next-line vue/no-reserved-component-names
  components: { Form },
  props: {
    labelPositionForm: {
      type: String,
      default: '',
    },
    searchData: {
      type: Object,
      required: true,
    },
  },
  methods: {
    resetSearchForm() {
      this.$refs.searchForm.resetForm();
    },
  },
};
</script>

<style>

</style>
