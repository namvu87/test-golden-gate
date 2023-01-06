import request from '@/utils/request';

export function listEmployee(query) {
  return request({
    url: `/employee`,
    method: 'get',
    params: query,
  });
}

export function createEmployee(data) {
  return request({
    url: `/employee`,
    method: 'post',
    data,
  });
}

export function updateEmployee(data, id) {
  return request({
    url: `/employee/${id}`,
    method: 'put',
    data,
  });
}

export function deleteEmployee(id) {
  return request({
    url: `/employee/${id}`,
    method: 'delete',
  });
}

export function listProvince() {
  return request({
    url: `/list-province/`,
    method: 'get',
  });
}
