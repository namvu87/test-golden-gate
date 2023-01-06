<template>
  <div class="dashboard-container">
    <div class="app-container">
      <div class="filter-container search">
        <el-row :gutter="20">
          <el-col :span="6">
            <el-input
              v-model="listQuery.fullname"
              style="width: 250px; margin-right: 10px"
              class="filter-item"
              placeholder="Tìm tên người dùng"
            />
          </el-col>
          <el-col :span="6">
            <el-select
              v-model="listQuery.gender"
              multiple
              filterable
              class="filter-item"
              placeholder="Chọn giới tính"
              style="width: 100%"
            >
              <el-option
                v-for="item in gender"
                :key="item.key"
                :label="item.label"
                :value="item.key"
              />

            </el-select>
          </el-col>
          <el-col :span="6">
            <el-date-picker
              v-model="listQuery.birthday"
              type="date"
              placeholder="Tìm kiếm ngày sinh"
              :picker-options="pickerOptions"
              format="dd-MM-yyyy"
              value-format="yyyy-MM-dd"
            />
          </el-col>
          <el-col :span="6">
            <el-select
              v-model="listQuery.level"
              multiple
              filterable
              class="filter-item"
              placeholder="Chọn Trình độ"
              style="width: 100%"
            >
              <el-option
                v-for="item
                  in listLevel"
                :key="item.key"
                :label="item.label"
                :value="item.key"
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
            <span>Nhân sự</span>
            <el-row style="float: right;">
              <el-col>
                <el-button type="primary" size="mini" @click="handleAddEmployee()">
                  Thêm nhân sự mới
                </el-button>
              </el-col>
            </el-row>
          </div>
          <div style="margin-bottom:50px;">
            <el-table
              ref="multipleTable"
              :key="tableKey"
              v-loading="listLoading"
              :data="listEmployeeData"
              border
              fit
              :default-sort="{prop: 'id', order: 'descending'}"
              highlight-current-row
              style="width: 100%;"
            >
              <el-table-column label="Mã nhân viên" prop="id" sortable="custom" align="center" width="80" :class-name="getSortClass('id')">
                <template slot-scope="{row}">
                  <span>{{ row.id }}</span>
                </template>
              </el-table-column>
              <el-table-column label="Họ và tên">
                <template slot-scope="{row}">
                  <span>{{ row.fullname }}</span>
                </template>
              </el-table-column>
              <el-table-column label="Giới tính">
                <template slot-scope="{row}">
                  <span>{{ row.gender }}</span>
                </template>
              </el-table-column>
              <el-table-column label="Trình độ">
                <template slot-scope="{row}">
                  <span>{{ row.level }}</span>
                </template>
              </el-table-column>
              <el-table-column label="Điện thoai">
                <template slot-scope="{row}">
                  <span>{{ row.phone }}</span>
                </template>
              </el-table-column>
              <el-table-column label="Ngày sinh">
                <template slot-scope="{row}">
                  <span>{{ formatDate(row.birthday) }}</span>
                </template>
              </el-table-column>
              <el-table-column label="Facebook">
                <template slot-scope="{row}">
                  <span>{{ row.facebook }}</span>
                </template>
              </el-table-column>

              <el-table-column label="Zalo">
                <template slot-scope="{row}">
                  <span>{{ row.zalo }}</span>
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
              @pagination="getListEmployee"
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
                  <el-form-item label="Họ và tên" prop="fullname">
                    <el-input v-model="formData.fullname" />
                  </el-form-item>
                </el-col>
                <el-col :span="12">
                  <el-form-item label="Giới tính" prop="gender">
                    <el-select v-model="formData.gender" filterable class="filter-item" placeholder="Giới tính" style="width: 100%;">
                      <el-option v-for="item in gender" :key="item.key" :label="item.label" :value="item.key" />
                    </el-select>
                  </el-form-item>
                </el-col>
              </el-row>

              <el-row :gutter="20">
                <el-col :span="12">
                  <el-form-item label="Ngày sinh" prop="birthday">
                    <el-date-picker
                      v-model="formData.birthday"
                      type="date"
                      placeholder="Ngày sinh"
                      :picker-options="pickerOptions"
                      format="dd-MM-yyyy"
                      value-format="yyyy-MM-dd"
                    />
                  </el-form-item>
                </el-col>
                <el-col :span="12">
                  <el-form-item label="Tình trạng hôn nhân" prop="gender">
                    <el-select v-model="formData.marital_status" filterable class="filter-item" placeholder="Tình trạng hôn nhân" style="width: 100%;">
                      <el-option
                        v-for="item in listMaritalStatus"
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
                  <el-form-item label="Nơi ở hiện tại" prop="local_address">
                    <el-input
                      v-model="formData.local_address"
                      placeholder="Nơi ở hiện tại"
                    />
                  </el-form-item>
                </el-col>
                <el-col :span="12">
                  <el-form-item label="Tỉnh" prop="province_id">
                    <el-select
                      v-model="formData.province_id"
                      filterable
                      class="filter-item"
                      placeholder="Tỉnh thành"
                      style="width: 100%;"
                    >
                      <el-option
                        v-for="item in listProvinceData"
                        :key="item.id"
                        :label="item._name"
                        :value="item.id"
                      />
                    </el-select>
                  </el-form-item>
                </el-col>
              </el-row>

              <el-row :gutter="20">
                <el-col :span="12">
                  <el-form-item label="CMND" prop="local_address">
                    <el-input
                      v-model="formData.card_number"
                      placeholder="Cmnd"
                    />
                  </el-form-item>
                </el-col>
                <el-col :span="12">
                  <el-form-item label="Ngày cấp" prop="date_card">
                    <el-date-picker
                      v-model="formData.date_card"
                      type="date"
                      placeholder="Ngày cấp"
                      :picker-options="pickerOptions"
                      format="dd-MM-yyyy"
                      value-format="yyyy-MM-dd"
                    />
                  </el-form-item>
                </el-col>
              </el-row>

              <el-row :gutter="20">
                <el-col :span="12">
                  <el-form-item label="Nơi cấp" prop="local_address">
                    <el-input
                      v-model="formData.address_card"
                      placeholder="Nơi cấp"
                    />
                  </el-form-item>
                </el-col>
                <el-col :span="12">
                  <el-form-item label="Địa chỉ thường trú" prop="address_permanent">
                    <el-input
                      v-model="formData.address_permanent"
                      placeholder="Địa chỉ thường trú"
                    />
                  </el-form-item>
                </el-col>
              </el-row>

              <el-row :gutter="20">
                <el-col :span="12">
                  <el-form-item label="Điện thoại" prop="phone">
                    <el-input
                      v-model="formData.phone"
                      placeholder="Điện thoại"
                    />
                  </el-form-item>
                </el-col>
                <el-col :span="12">
                  <el-form-item label="Email cá nhân" prop="email">
                    <el-input
                      v-model="formData.email"
                      placeholder="Email"
                    />
                  </el-form-item>
                </el-col>
              </el-row>

              <el-row :gutter="20">
                <el-col :span="12">
                  <el-form-item label="Zalo" prop="zalo">
                    <el-input
                      v-model="formData.zalo"
                      placeholder="Zalo"
                    />
                  </el-form-item>
                </el-col>
                <el-col :span="12">
                  <el-form-item label="Facebook" prop="facebook">
                    <el-input
                      v-model="formData.facebook"
                      placeholder="Facebook"
                    />
                  </el-form-item>
                </el-col>
              </el-row>

              <el-row :gutter="20">
                <el-col :span="12">
                  <el-form-item label="Trình độ học vấn" prop="level">
                    <el-select v-model="formData.level" filterable class="filter-item" placeholder="Tình trạng hôn nhân" style="width: 100%;">
                      <el-option
                        v-for="item in listLevel"
                        :key="item.key"
                        :label="item.label"
                        :value="item.key"
                      />
                    </el-select>
                  </el-form-item>
                </el-col>
                <el-col :span="12">
                  <el-form-item label="Trường đào tạo" prop="school">
                    <el-input
                      v-model="formData.school"
                      placeholder="Trường đào tạo"
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

import { createEmployee, deleteEmployee, listEmployee, updateEmployee, listProvince } from '@/api/employee';
import { GENDER, LEVEL, MARITAL_STATUS } from '@/utils/constants';
import Pagination from '@/components/Pagination'; // secondary package based on el-pagination
import moment from 'moment';

export default {
  name: 'ListHrm',
  components: {
    Pagination,
  },
  data() {
    return {
      listEmployeeData: [],
      listLoading: false,
      listQuery: {
        fullname: '',
        gender: '',
        created_at: '',
        birthday: '',
        level: '',
      },
      gender: GENDER,
      pickerOptions: {
        disabledDate(time) {
          return time.getTime() > Date.now();
        },
      },
      listMaritalStatus: MARITAL_STATUS,
      listLevel: LEVEL,
      tableKey: 0,
      listQueryData: {
        page: 1,
        limit: 20,
        sort: '+id',
      },
      textMap: {
        update: 'Sửa nhân viên',
        create: 'Tạo nhân viên',
      },
      dialogStatus: 'create',
      dialogFormVisible: false,
      formData: {
        fullname: '', gender: '', birthday: '', marital_status: '',
        local_address: '', province_id: '', card_number: '', date_card: '',
        address_card: '', phone: '', zalo: '', facebook: '',
        level: '', address_permanent: '', school: '', email: '', id: '',
      },
      rules: {
        fullname: [{ required: true, message: 'Họ và tên bắt buộc', trigger: 'blur' }],
        birthday: [{ required: true, message: 'Ngày sinh bắt buộc', trigger: 'blur' }],
        gender: [{ required: true, message: 'Giới tính bắt buộc', trigger: 'blur' }],
        level: [{ required: true, message: 'Trình độ là bắt buộc', trigger: 'blur' }],
        marital_status: [{ required: true, message: 'Tình trạng hôn nhân là bắt buộc', trigger: 'blur' }],
      },
      listProvinceData: [],
      total: 0,
    };
  },
  created() {
    this.getListEmployee();
    this.getListProvince();
  },
  methods: {
    getListEmployee() {
      this.listLoading = true;
      listEmployee().then((res) => {
        this.listEmployeeData = res.data;
        this.listLoading = false;
      });
    },
    sortChange(data) {
      const { prop, order } = data;
      if (prop === 'id') {
        this.sortByID(order);
      }
    },
    clearFilters() {
      this.getListEmployee();
    },
    handleSearch() {
      this.listLoading = true;
      listEmployee(Object.assign(this.listQuery, this.listQueryData)).then(response => {
        this.listEmployeeData = response.data;
        this.listLoading = false;
      });
    },
    handleAddEmployee() {
      this.resetForm();
      this.dialogStatus = 'create';
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs['dataForm'].clearValidate();
      });
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
      this.$confirm('Bạn có muốn xóa nhân sự trên', 'Chờ', {
        confirmButtonText: 'Xác nhận',
        cancelButtonText: 'Hủy bỏ',
        type: 'warning',
      })
        .then(async() => {
          await deleteEmployee(id);
          this.$message({
            type: 'success',
            message: 'Delete succeed!',
          });
          this.getListEmployee();
        })
        .catch(err => {
          console.error(err);
        });
    },
    resetForm() {
      this.formData = {
        id: '',
        fullname: '', gender: '', birthday: '', marital_status: '',
        local_address: '', province_id: '', card_number: '', date_card: '',
        address_card: '', phone: '', zalo: '', facebook: '',
        level: '', address_permanent: '', school: '', email: '',
      };
    },
    createData() {
      this.$refs.dataForm.validate(valid => {
        if (valid) {
          createEmployee(this.formData)
            .then(res => {
              this.getListEmployee();
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
          updateEmployee(this.formData, id)
            .then(res => {
              this.getListEmployee();
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
    getSortClass(key) {
      const sort = this.listQueryData.sort;
      return sort === `+${key}` ? 'ascending' : 'descending';
    },
    sortByID(order) {
      if (order === 'ascending') {
        this.listQuery.sort = '+id';
      } else {
        this.listQuery.sort = '-id';
      }
    },
    getListProvince() {
      listProvince().then((res) => {
        this.listProvinceData = res.data;
      });
    },
    getObjKey(obj, value) {
      return Object.keys(obj).find(key => obj[key] === value);
    },
    formatDate(value) {
      return moment(String(value)).format('DD-MM-YYYY');
    },
  },
};
</script>

<style scoped>

</style>
