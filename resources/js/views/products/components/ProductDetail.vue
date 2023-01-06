<template>
  <div class="createProduct-container">
    <el-form
      ref="productForm"
      :model="productForm"
      :rules="rules"
      class="form-container"
    >
      <sticky :z-index="10" class="sub-navbar draf">
        <el-button v-loading="loading" type="success" style="margin-right: 25px;" @click="isEdit ? updateProduct() : createProduct()">
          {{ isEdit ? "Update" : "Create" }}
        </el-button>
      </sticky>

      <div class="createProduct-main-container">
        <el-row>
          <el-col :span="24">
            <div class="productInfo-container">
              <el-row>
                <el-col :span="8">
                  <el-form-item
                    label-width="120px"
                    label="Tên sản phẩm"
                    class="productInfo-container-item"
                    prop="product_name"
                  >
                    <el-input v-model="productForm.product_name" width="100%" />
                  </el-form-item>
                </el-col>

                <el-col :span="8">
                  <el-form-item
                    label-width="120px"
                    label="Mã sản phẩm"
                    class="productInfo-container-item"
                    prop="product_code"
                  >
                    <el-input v-model="productForm.product_code" width="100%" />
                  </el-form-item>
                </el-col>

                <el-col :span="8">
                  <el-form-item
                    label-width="120px"
                    label="Sản xuất"
                    class="productInfo-container-item"
                    prop="manufactory"
                  >
                    <el-input v-model="productForm.manufactory" width="100%" />
                  </el-form-item>
                </el-col>
              </el-row>
            </div>
          </el-col>
        </el-row>

        <el-form-item
          prop="description"
          label-width="120px"
          label="Mô tả"
          style="margin-bottom: 30px"
        >
          <Tinymce
            ref="editor"
            v-model="productForm.description"
            :height="400"
          />
        </el-form-item>

        <el-tabs type="card">
          <el-tab-pane label="Thuộc tính">
            <properties
              ref="properties"
            />
          </el-tab-pane>
        </el-tabs>
      </div>
    </el-form>
  </div>
</template>

<script>
import _ from 'underscore';
import Tinymce from '@/components/Tinymce';
import Sticky from '@/components/Sticky';
import Properties from './Properties';
import { detailProduct, addProduct, updateProduct } from '@/api/product';

const defaultForm = {
  product_name: '',
  product_code: '',
  manufactory: '',
  description: '',
  id: undefined,
  attributes: [],
  properties: [],
};

export default {
  name: 'ProductDetail',
  components: { Tinymce, Sticky, Properties },
  props:
    {
      isEdit: {
        type: Boolean,
        default: false,
      },
    },
  data() {
    const validateRequire = (rule, value, callback) => {
      if (value === '') {
        this.$message({
          message: rule.field + ' is required',
          type: 'error',
        });
        callback(new Error(rule.field + ' is required'));
      } else {
        callback();
      }
    };

    return {
      productForm: Object.assign({}, defaultForm),
      loading: false,
      rules: {
        product_name: [{ validator: validateRequire }],
        product_code: [{ validator: validateRequire }],
        manufactory: [{ validator: validateRequire }],
      },
    };
  },
  computed: {
    cptProductForm() {
      const form = JSON.parse(JSON.stringify(this.productForm));
      const attributes = this.$refs.properties.attributes;
      const properties = this.$refs.properties.productProperties;
      const propName = this.$refs.properties.attribute_name;
      const propMapping = _.map(properties, (prop, index) => {
        prop.property_name = propName[index];
        return prop;
      });
      form.attributes = attributes;
      form.properties = Object.assign([], propMapping);
      return form;
    },
  },
  created() {
    if (this.isEdit) {
      this.productForm.id = this.$route.params?.id;
      this.fetchData(this.productForm.id);
    } else {
      this.$store.dispatch('product/setProduct', []);
    }
  },
  beforeDestroy() {
    this.$store.dispatch('product/setProduct', []);
  },
  methods: {
    fetchData(id) {
      detailProduct(id)
        .then((res) => {
          this.productForm = res.data;
          this.$store.dispatch('product/setProduct', res.data);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    createProduct() {
      this.$refs.productForm.validate(valid => {
        if (valid) {
          addProduct(this.cptProductForm)
            .then(res => {
              this.$notify({
                title: 'Success',
                message: res.message,
                type: 'success',
                duration: 2000,
              });
              this.$router.push({ name: 'Products' });
            });
        } else {
          return false;
        }
      });
    },
    updateProduct() {
      updateProduct(this.productForm.id, this.cptProductForm)
        .then(res => {
          this.$notify({
            title: 'Success',
            message: res.message,
            type: 'success',
            duration: 2000,
          });
          this.$router.push({ name: 'Products' });
        });
    },
  },
};
</script>

<style lang="scss" scoped>
@import "~@/styles/mixin.scss";

.createProduct-container {
  position: relative;

  .createProduct-main-container {
    padding: 40px 45px 20px 50px;

    .productInfo-container {
      position: relative;
      @include clearfix;
      margin-bottom: 10px;

      .productInfo-container-item {
        float: left;
        width: 100%;
      }
    }
  }

  .word-counter {
    width: 40px;
    position: absolute;
    right: 10px;
    top: 0px;
  }
}

.product-textarea ::v-deep {
  textarea {
    padding-right: 40px;
    resize: none;
    border: none;
    border-radius: 0px;
    border-bottom: 1px solid #bfcbd9;
  }
}
</style>
