<template>
  <div>
    <el-row :gutter="20">
      <el-col :span="6">
        <p>Thuộc tính</p>
        <el-form-item>
          <el-input
            v-model="attribute_name[0]"
            placeholder="Tên thuộc tính"
          />
        </el-form-item>
        <el-form-item>
          <el-input
            v-model="attribute_name[1]"
            placeholder="Tên thuộc tính"
          />
        </el-form-item>
        <el-form-item>
          <el-input
            v-model="attribute_name[2]"
            placeholder="Tên thuộc tính"
          />
        </el-form-item>
        <el-form-item>
          <el-input
            v-model="attribute_name[3]"
            placeholder="Tên thuộc tính"
          />
        </el-form-item>
        <el-form-item>
          <el-input
            v-model="attribute_name[4]"
            placeholder="Tên thuộc tính"
          />
        </el-form-item>
        <el-form-item>
          <el-input
            v-model="attribute_name[5]"
            placeholder="Tên thuộc tính"
          />
        </el-form-item>
      </el-col>
      <el-col :span="18">
        <p>Details</p>
        <el-form-item>
          <vue-tags-input
            v-model="value[0]"
            :tags="attribute_value[0]"
            :disabled="!attribute_name[0]"
            placeholder="Enter attribute value"
            @tags-changed="(newTags) => tagsChange(newTags, 0)"
          />
        </el-form-item>
        <el-form-item>
          <vue-tags-input
            v-model="value[1]"
            :tags="attribute_value[1]"
            :disabled="!attribute_name[1]"
            placeholder="Enter attribute value"
            @tags-changed="(newTags) => tagsChange(newTags, 1)"
          />
        </el-form-item>
        <el-form-item>
          <vue-tags-input
            v-model="value[2]"
            :tags="attribute_value[2]"
            :disabled="!attribute_name[2]"
            placeholder="Enter attribute value"
            @tags-changed="(newTags) => tagsChange(newTags, 2)"
          />
        </el-form-item>
        <el-form-item>
          <vue-tags-input
            v-model="value[3]"
            :tags="attribute_value[3]"
            :disabled="!attribute_name[3]"
            placeholder="Enter attribute value"
            @tags-changed="(newTags) => tagsChange(newTags, 3)"
          />
        </el-form-item>
        <el-form-item>
          <vue-tags-input
            v-model="value[4]"
            :tags="attribute_value[4]"
            :disabled="!attribute_name[4]"
            placeholder="Enter attribute value"
            @tags-changed="(newTags) => tagsChange(newTags, 4)"
          />
        </el-form-item>
        <el-form-item>
          <vue-tags-input
            v-model="value[5]"
            :tags="attribute_value[5]"
            :disabled="!attribute_name[5]"
            placeholder="Enter attribute value"
            @tags-changed="(newTags) => tagsChange(newTags, 5)"
          />
        </el-form-item>
      </el-col>
      <el-col v-if="attributes.length" :span="24">
        <div style="margin: 15px 0">
          <p>Attributes</p>
        </div>
        <!-- List checked attribute -->
        <el-table :data="attributes" style="width: 100%" max-height="250">
          <el-table-column fixed prop="attribute_text" label="Attribute Name" />
          <el-table-column label="Giá tiền">
            <template slot-scope="{ row }">
              <el-input
                v-model="row.price"
                active-color="#13ce66"
                inactive-color="#ff4949"
                :active-value="1"
                :inactive-value="0"
              />
            </template>
          </el-table-column>
          <el-table-column label="Status">
            <template slot-scope="{ row }">
              <el-switch
                v-model="row.status"
                active-color="#13ce66"
                inactive-color="#ff4949"
                :active-value="1"
                :inactive-value="0"
              />
            </template>
          </el-table-column>
        </el-table>
        <!-- End list -->
      </el-col>
    </el-row>
  </div>
</template>

<script>
import _ from 'underscore';
import { mapState } from 'vuex';
import VueTagsInput from '@johmun/vue-tags-input';

export default {
  name: 'PropertiesComponent',
  components: {
    VueTagsInput,
  },
  data() {
    return {
      value: [],
      attributes: [],
      attribute_name: [],
    };
  },

  computed: {
    ...mapState({
      properties: (state) => state.product.product.properties,
      prodAttributes: (state) => state.product.product.attributes,
      attribute_value: function(state) {
        const details = _.pluck(state.product.product.properties, 'details');
        if (!this.attributes.length) {
          this.computedAttributes(details);
        }
        return details;
      },
    }),
    productProperties() {
      const properties = _.map(this.properties, (prop) => {
        return {
          id: prop.id,
          property_name: prop.property_name,
          details: prop.details,
        };
      });
      return properties;
    },
  },
  mounted() {
    setTimeout(() => {
      this.attribute_name = _.pluck(this.properties, 'property_name');
    }, 500);
  },
  methods: {
    computedProperties() {
      this.attribute_name.forEach((attribute, index) => {
        this.properties.push({
          property_name: attribute,
          details: this.attribute_value[index],
        });
      });
      return this.properties;
    },
    tagsChange(newTags, index) {
      this.attribute_value[index] = newTags;
      const detailsProperty = _.map(this.attribute_value[index], (detail) => {
        return {
          text: detail.text,
        };
      });
      this.$store.dispatch('product/setProductProperties', {
        details: detailsProperty,
        index,
      });
      this.computedAttributes(this.attribute_value);
      return this.attribute_value;
    },
    computedAttributes(values) {
      const attributes = [];

      if (this.prodAttributes !== undefined) {
        _.forEach(this.prodAttributes, (val) => {
          attributes.push(val);
        });
      }
      const max = values?.length - 1;

      const helper = (arr, i) => {
        for (let j = 0, l = values[i]?.length; j < l; j++) {
          const attr = arr.slice(0); // clone arr
          attr.push(values[i][j].text);
          if (i === max) {
            attributes.push({
              attribute_text: attr.join('/'),
              id: null,
              product_id: null,
              status: 0,
              created_at: null,
              updated_at: null,
            });
          } else {
            helper(attr, i + 1);
          }
        }
      };
      helper([], 0);

      this.attributes = _.uniq(attributes, val => val.attribute_text);
    },
  },
};
</script>

<style scoped>
.vue-tags-input {
  max-width: 100%;
}
.ti-disabled {
  background-color: #f5f7fa;
  border-color: #dfe4ed;
  color: #c0c4cc;
  cursor: not-allowed;
}
</style>
