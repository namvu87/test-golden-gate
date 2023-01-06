<template>
  <div class="app-container">
    <div class="filter-container">

      <el-button class="filter-item" style="margin-left: 10px;" type="primary" icon="el-icon-edit" @click="$router.push({ name: 'CreateProduct'})">
        Thêm sản phẩm
      </el-button>

      <SearchBar ref="searchBar" :search-data="searchData">
        <el-row :gutter="20">
          <el-col :span="6">
            <el-form-item prop="name_or_code">
              <Input
                :input="searchData.name_or_code"
                input-icon="el-icon-search"
                name="name_or_code"
                placeholder="Mã/Tên"
                @setInput="setNameProduct"
                @search="searchProduct"
              />
            </el-form-item>
          </el-col>
          <el-col :span="18">
            <el-form-item>
              <el-button type="primary" @click="searchProduct">Tìm kiếm</el-button>
              <el-button @click="clearFilters">Xóa tìm kiếm</el-button>
            </el-form-item>
          </el-col>
        </el-row>
      </SearchBar>
    </div>

    <el-table
      :key="tableKey"
      v-loading="listLoading"
      :data="list"
      border
      fit
      highlight-current-row
      style="width: 100%;"
      @sort-change="sortChange"
    >
      <el-table-column label="Mã sản phẩm" prop="id" sortable="custom" align="center" width="180" :class-name="getSortClass('id')">
        <template slot-scope="{row}">
          <span>{{ row.id }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Tên sản phẩm" min-width="200x">
        <template slot-scope="{row}">
          <span class="link-type" @click="$router.push({ name: 'EditProduct', params: {id: row.id} })">{{ row.product_name }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Code" min-width="100x">
        <template slot-scope="{row}">
          <span class="link-type" @click="$router.push({ name: 'EditProduct', params: {id: row.id} })">{{ row.product_code }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Nhà sản xuất" width="200px" align="center">
        <template slot-scope="{row}">
          <span>{{ row.manufactory }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Người tạo" width="150px" align="center">
        <template slot-scope="{row}">
          <span>{{ row.created_by.username }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Thời gian tạo" width="180px" align="center">
        <template slot-scope="{row}">
          <span>{{ row.created_at }}</span>
        </template>
      </el-table-column>
      <el-table-column label="Hành động" align="center" width="100" class-name="small-padding fixed-width">
        <template slot-scope="{row}">
          <el-button size="mini" type="danger" @click="handleDelete(row.id)">
            Delete
          </el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import { listProduct, deleteProduct } from '@/api/product';
import SearchBar from '@/components/SearchBar';
import Input from '@/components/Input';

export default {
  name: 'Products',
  // eslint-disable-next-line vue/no-reserved-component-names
  components: { SearchBar, Input },
  data() {
    return {
      searchData: {
        name_or_code: '',
      },
      tableKey: 0,
      list: [],
      total: 0,
      listLoading: true,
      listQuery: {
        page: 1,
        limit: 20,
        sort: '+id',
      },
      sortOptions: [{ label: 'ID Ascending', key: '+id' }, { label: 'ID Descending', key: '-id' }],
    };
  },
  created() {
    this.getList();
  },
  methods: {
    getList() {
      this.listLoading = true;
      listProduct(this.listQuery).then(response => {
        this.list = response.data;
        this.listLoading = false;
      });
    },
    setNameProduct(val) {
      this.searchData.name_or_code = val;
    },
    searchProduct() {
      this.listQuery = Object.assign(this.listQuery, { ...this.searchData });
      this.getList();
    },
    clearFilters() {
      this.$refs.searchBar.resetSearchForm();
      delete this.listQuery?.name_or_code;
      this.getList();
    },
    sortChange(data) {
      const { prop, order } = data;
      if (prop === 'id') {
        this.sortByID(order);
      }
    },
    sortByID(order) {
      if (order === 'ascending') {
        this.listQuery.sort = '+id';
      } else {
        this.listQuery.sort = '-id';
      }
      this.handleFilter();
    },
    getSortClass(key) {
      const sort = this.listQuery.sort;
      return sort === `+${key}` ? 'ascending' : 'descending';
    },
    handleDelete(productId) {
      this.$confirm('Confirm to remove the product?', 'Warning', {
        confirmButtonText: 'Confirm',
        cancelButtonText: 'Cancel',
        type: 'warning',
      })
        .then(async() => {
          await deleteProduct(productId);
          this.$message({
            type: 'success',
            message: 'Delete succeed!',
          });
          this.getList();
        })
        .catch(err => {
          console.error(err);
        });
    },
  },
};
</script>
