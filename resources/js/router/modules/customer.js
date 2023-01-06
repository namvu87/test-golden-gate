
const customerRoutes = {
  path: '/customer',
  component: () => import('@/views/customer/index'),
  redirect: '/administrator/customer',
  name: 'Quản lý khách hàng',
  alwaysShow: true,
  meta: {
    title: 'Employee',
    icon: 'user',
    permissions: ['view menu administrator'],
  },
};

export default customerRoutes;
