
const employeeRoutes = {
  path: '/employee',
  component: () => import('@/views/hrm/index'),
  redirect: '/administrator/employee',
  name: 'Quản lý nhân sự',
  alwaysShow: true,
  meta: {
    title: 'Employee',
    icon: 'user',
    permissions: ['view menu administrator'],
  },
};

export default employeeRoutes;
