import Layout from '@/layout';

const productRoutes = {
  path: '/products',
  component: Layout,
  redirect: '/products/index',
  meta: {
    title: 'Products',
    icon: 'dollar',
    permissions: ['list_products'],
  },
  children: [
    {
      path: 'index',
      component: () => import('@/views/products/index'),
      name: 'Products',
      meta: {
        title: 'List Products',
        noCache: true,
      },
    },
    {
      path: 'create',
      component: () => import('@/views/products/create'),
      name: 'CreateProduct',
      meta: {
        title: 'Create Product',
      },
    },
    {
      path: 'edit/:id(\\d+)',
      component: () => import('@/views/products/edit'),
      name: 'EditProduct',
      meta: {
        title: 'Edit Product',
        noCache: true,
        activeMenu: '/products/index',
      },
      hidden: true,
    },
  ],
}
;

export default productRoutes;
