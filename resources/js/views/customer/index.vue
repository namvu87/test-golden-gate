<template>
  <div class="dashboard-container">
    <div class="app-container">
      <div class="filter-container search">
        <el-row :gutter="20">
          <el-col :span="6">
            <el-select
              v-model="listQuery.status"
              multiple
              filterable
              class="filter-item"
              placeholder="Toàn bộ"
              style="width: 100%"
            >
              <el-option
                v-for="item in listStatus"
                :key="item.key"
                :label="item.label"
                :value="item.key"
              />

            </el-select>
          </el-col>
          <el-col :span="6">
            <el-select
              v-model="listQuery.type"
              filterable
              class="filter-item"
              placeholder="Doanh nghiệp cá nhân"
              style="width: 100%"
            >
              <el-option
                v-for="item in listType"
                :key="item.key"
                :label="item.label"
                :value="item.key"
              />

            </el-select>
          </el-col>
          <el-col :span="6">
            <el-input
              v-model="listQuery.key"
              placeholder="Từ khóa"
            />
          </el-col>
          <el-col :span="6">
            <el-select
              v-model="listQuery.employee_id"
              multiple
              filterable
              class="filter-item"
              placeholder="Người phụ trách"
              style="width: 100%"
            >
              <el-option
                v-for="item
                  in listEmployeeData"
                :key="item.id"
                :label="item.fullname"
                :value="item.id"
              />

            </el-select>
          </el-col>
        </el-row>
        <el-row :gutter="20">
          <el-col :span="4">
            <el-button size="medium" type="primary" @click="handleSearch">
              Tìm kiếm
            </el-button>
          </el-col>
          <el-col :span="4">
            <el-button size="medium" plain @click="clearFilters">
              Xóa tìm kiếm
            </el-button>
          </el-col>
        </el-row>
      </div>
      <el-row style="margin-top:50px;">
        <el-card class="box-card">
          <div slot="header" class="clearfix">
            <span>Khách hàng</span>
            <el-row style="float: right;">
              <el-col>
                <el-button type="primary" size="mini" @click="handleAddNewCustomer()">
                  Thêm khách hàng mới
                </el-button>
              </el-col>
            </el-row>
          </div>
          <div style="margin-bottom:50px;">
            <el-table
              ref="multipleTable"
              :key="tableKey"
              v-loading="listLoading"
              :data="listCustomerData"
              border
              fit
              :default-sort="{prop: 'id', order: 'descending'}"
              highlight-current-row
              style="width: 100%;"
            >
              <el-table-column label="Tên khách hàng">
                <template slot-scope="{row}">
                  <span>{{ row.contact_name }}</span>
                </template>
              </el-table-column>
              <el-table-column label="Địa chỉ văn phòng">
                <template slot-scope="{row}">
                  <span>{{ row.address_office }}</span>
                </template>
              </el-table-column>
              <el-table-column label="Điện thoại">
                <template slot-scope="{row}">
                  <span>{{ row.contact_phone }}</span>
                </template>
              </el-table-column>
              <el-table-column label="Website">
                <template slot-scope="{row}">
                  <span>{{ row.website }}</span>
                </template>
              </el-table-column>
              <el-table-column label="Người liên hệ">
                <template slot-scope="{row}">
                  <span>{{ row.representative }}</span>
                </template>
              </el-table-column>
              <el-table-column label="Điện thoại">
                <template slot-scope="{row}">
                  <span>{{ row.representative }}</span>
                </template>
              </el-table-column>
              <el-table-column label="Email">
                <template slot-scope="{row}">
                  <span>{{ row.email }}</span>
                </template>
              </el-table-column>
              <el-table-column label="Actions" align="center" style="width: 200px">
                <template slot-scope="{row}">
                  <el-button type="primary" size="mini" @click="handleUpdate(row)">
                    Edit
                  </el-button>
                  <el-button size="mini" type="danger" @click="handleDelete(row.id)">
                    Delete
                  </el-button>
                </template>
              </el-table-column>

            </el-table>
            <pagination
              v-show="total>0"
              :total="total"
              :page.sync="listQueryData.page"
              :limit.sync="listQueryData.limit"
              :current-query="listQueryData"
              @pagination="getListCustomer"
            />
          </div>
          <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible" width="80%">
            <el-form
              ref="dataForm"
              :rules="rules"
              :model="formData"
              label-position="left"
              label-width="180px"
            >
              <el-row :gutter="20">
                <el-col :span="12">
                  <el-form-item label="Tên viết tắt" prop="customer_abbreviations">
                    <el-input v-model="formData.customer_abbreviations" />
                  </el-form-item>
                </el-col>
                <el-col :span="12">
                  <el-form-item label="Tên đầy đủ" prop="gender">
                    <el-input
                      v-model="formData.contact_name"
                      placeholder="Tên đầy đủ"
                    />
                  </el-form-item>
                </el-col>
              </el-row>

              <el-row :gutter="20">
                <el-col :span="12">
                  <el-form-item label="Địa chỉ văn phòng" prop="address_office">
                    <el-input
                      v-model="formData.address_office"
                      placeholder="Địa chỉ văn phòng"
                    />
                  </el-form-item>
                </el-col>
                <el-col :span="12">
                  <el-form-item label="website" prop="website">
                    <el-input
                      v-model="formData.website"
                      placeholder="Website"
                    />
                  </el-form-item>
                </el-col>
              </el-row>

              <el-row :gutter="20">
                <el-col :span="12">
                  <el-form-item label="Số điện thoại" prop="contact_phone">
                    <el-input
                      v-model="formData.contact_phone"
                      placeholder="Nơi ở hiện tại"
                    />
                  </el-form-item>
                </el-col>
                <el-col :span="12">
                  <el-form-item label="Email" prop="email">
                    <el-input
                      v-model="formData.email"
                      placeholder="Email"
                    />
                  </el-form-item>
                </el-col>
              </el-row>

              <el-row :gutter="20">
                <el-col :span="12">
                  <el-form-item label="Người đại diện" prop="representative">
                    <el-input
                      v-model="formData.representative"
                      placeholder="Người đại diện"
                    />
                  </el-form-item>
                </el-col>
                <el-col :span="12">
                  <el-form-item label="Chức vụ" prop="position">
                    <el-input
                      v-model="formData.position"
                      placeholder="Chức vụ"
                    />
                  </el-form-item>
                </el-col>
              </el-row>

              <el-row :gutter="20">
                <el-col :span="12">
                  <el-form-item label="Địa chỉ DKKD" prop="address_business">
                    <el-input
                      v-model="formData.address_business"
                      placeholder="Địa chỉ DKKD"
                    />
                  </el-form-item>
                </el-col>
                <el-col :span="12">
                  <el-form-item label="Mã số thuế" prop="tax_code">
                    <el-input
                      v-model="formData.tax_code"
                      placeholder="Mã số thuế"
                    />
                  </el-form-item>
                </el-col>
              </el-row>

              <el-row :gutter="20">
                <el-col :span="12">
                  <el-form-item label="Lĩnh vực hoạt động" prop="field_id">
                    <el-select
                      v-model="formData.field_id"
                      filterable
                      class="filter-item"
                      placeholder="Lĩnh vực hoạt động"
                      style="width: 100%"
                    >
                      <el-option
                        v-for="item in listFieldData"
                        :key="item.id"
                        :label="item.name"
                        :value="item.id"
                      />

                    </el-select>
                  </el-form-item>
                </el-col>
                <el-col :span="12">
                  <el-form-item label="Phân loại" prop="type">
                    <el-select v-model="formData.type" filterable class="filter-item" placeholder="Phân loại" style="width: 100%;">
                      <el-option
                        v-for="item in listType"
                        :key="item.key"
                        :label="item.label"
                        :value="item.key"
                      />
                    </el-select>
                  </el-form-item>
                </el-col>
              </el-row>

              <el-row :gutter="20">
                <el-col :span="12">
                  <el-form-item label="Người phụ trách" prop="employee_id">
                    <el-select
                      v-model="formData.employee_id"
                      filterable
                      class="filter-item"
                      placeholder="Người phụ trách"
                      style="width: 100%"
                    >
                      <el-option
                        v-for="item in listEmployeeData"
                        :key="item.id"
                        :label="item.fullname"
                        :value="item.id"
                      />

                    </el-select>
                  </el-form-item>
                </el-col>
                <el-col :span="12">
                  <el-form-item label="Tình trạng khách hàng" prop="status">
                    <el-select v-model="formData.status" filterable class="filter-item" placeholder="Tình trạng khách hàng" style="width: 100%;">
                      <el-option
                        v-for="item in listStatus"
                        :key="item.key"
                        :label="item.label"
                        :value="item.key"
                      />
                    </el-select>
                  </el-form-item>
                </el-col>
              </el-row>

              <el-row :gutter="20">
                <el-col :span="24">
                  <el-form-item label="Ghi chú" prop="note">
                    <el-input
                      v-model="formData.note"
                      type="texarea"
                      :rows="2"
                    />
                  </el-form-item>
                </el-col>
              </el-row>

            </el-form>
            <div slot="footer" class="dialog-footer">
              <el-button @click="dialogFormVisible = false">
                Cancel
              </el-button>
              <el-button type="primary" @click="dialogStatus==='create'?createData():updateData(formData.id)">
                {{ dialogStatus==='create' ? 'Create' : 'Update' }}
              </el-button>
            </div>
          </el-dialog>

        </el-card>
      </el-row>

    </div>
  </div>
</template>

<script>

import { listEmployee } from '@/api/employee';
import { LIST_STATUS_CUSTOMER, LIST_TYPE } from '@/utils/constants';
import Pagination from '@/components/Pagination'; // secondary package based on el-pagination
import { createCustomer, deleteCustomer, getListCustomer, listField, updateCustomer } from '@/api/customer';

export default {
  name: 'CustomerDemo',
  components: {
    // eslint-disable-next-line vue/no-unused-components
    Pagination,
  },
  data() {
    return {
      listEmployeeData: [],
      listCustomerData: [],
      listLoading: false,
      listQuery: {
        status: '',
        type: '',
        key: '',
        employee_id: '',
      },
      listStatus: LIST_STATUS_CUSTOMER,
      listType: LIST_TYPE,
      pickerOptions: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        },
      },
      tableKey: 0,
      listQueryData: {
        page: 1,
        limit: 20,
        sort: '+id',
      },
      textMap: {
        update: 'Sửa thông tin nhân viên',
        create: 'Tạo thông tin nhân viên',
      },
      dialogStatus: 'create',
      dialogFormVisible: false,
      formData: {
        customer_abbreviations: '',
        contact_name: '',
        address_office: '',
        contact_phone: '',
        website: '',
        email: '',
        representative: '',
        position: '',
        address_business: '',
        tax_code: '',
        field_id: '',
        type: '',
        employee_id: '',
        status: '',
        note: '',
      },
      rules: {
        customer_abbreviations: [{ required: true, message: 'Tên viết tắt', trigger: 'blur' }],
        contact_phone: [{ required: true, message: 'Số điện thoại là bắt buộc', trigger: 'blur' }],
        type: [{ required: true, message: 'Loại khách hàng là bắt buộc', trigger: 'blur' }],
      },
      listProvinceData: [],
      total: 0,
      listFieldData: [],
    };
  },
  created() {
    this.getListEmployee();
    this.getListCustomer();
    this.getListField();
  },
  methods: {
    getListCustomer() {
      this.listLoading = true;
      getListCustomer().then((res) => {
        this.listCustomerData = res.data;
        this.listLoading = false;
      });
    },
    getListEmployee() {
      this.listLoading = true;
      listEmployee().then((res) => {
        this.listEmployeeData = res.data;
        this.listLoading = false;
      });
    },
    handleSearch() {
      this.listLoading = true;
      getListCustomer(Object.assign(this.listQueryData, this.listQuery)).then(response => {
        this.listCustomerData = response.data;
        this.listLoading = false;
      });
    },
    clearFilters() {
      this.listQuery = {
        status: '',
        type: '',
        key: '',
        employee_id: '',
      };
      this.getListCustomer();
    },
    handleUpdate(row) {
      this.formData = Object.assign({}, row); // copy obj
      this.dialogStatus = 'update';
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate();
      });
    },
    handleDelete(id) {
      this.$confirm('Bạn có muốn xóa khách hàng trên', 'Chờ', {
        confirmButtonText: 'Xác nhận',
        cancelButtonText: 'Hủy bỏ',
        type: 'warning',
      })
        .then(async() => {
          await deleteCustomer(id);
          this.$message({
            type: 'success',
            message: 'Delete succeed!',
          });
          this.getListCustomer();
        })
        .catch(err => {
          console.error(err);
        });
    },
    handleAddNewCustomer() {
      this.resetForm();
      this.dialogStatus = 'create';
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate();
      });
    },
    resetForm() {
      this.formData = {
        customer_abbreviations: '',
        contact_name: '',
        address_office: '',
        contact_phone: '',
        website: '',
        email: '',
        representative: '',
        position: '',
        address_business: '',
        tax_code: '',
        field_id: '',
        type: '',
        employee_id: '',
        status: '',
        note: '',
      };
    },
    createData() {
      this.$refs.dataForm.validate(valid => {
        if (valid) {
          createCustomer(this.formData)
            .then(res => {
              this.getListCustomer();
              this.$notify({
                title: 'Success',
                message: res.message,
                type: 'success',
                duration: 2000,
              });
              this.dialogFormVisible = false;
            });
        } else {
          return false;
        }
      });
    },
    updateData(id) {
      this.$refs.dataForm.validate(valid => {
        if (valid) {
          updateCustomer(id, this.formData)
            .then(res => {
              this.getListCustomer();
              this.$notify({
                title: 'Success',
                message: res.message,
                type: 'success',
                duration: 2000,
              });
              this.dialogFormVisible = false;
            });
        } else {
          return false;
        }
      });
    },
    getListField() {
      listField().then((res) => {
        this.listFieldData = res.data;
      });
    },
    getSortClass(key) {
      const sort = this.listQueryData.sort;
      return sort === `+${key}` ? 'ascending' : 'descending';
    },
  },
};
</script>

<style scoped>

</style>
