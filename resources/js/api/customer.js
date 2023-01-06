import request from '@/utils/request';

export function getListCustomer(query) {
  return request({
    url: `/customer`,
    method: 'get',
    params: query,
  });
}

export function createCustomer(params) {
  return request({
    url: `/customer`,
    method: 'post',
    params,
  });
}

export function updateCustomer(id, data) {
  return request({
    url: `/customer/${id}`,
    method: 'put',
    data,
  });
}

export function deleteCustomer(id) {
  return request({
    url: `/customer/${id}`,
    method: 'delete',
  });
}

export function listField() {
  return request({
    url: `/list-field/`,
    method: 'get',
  });
}
