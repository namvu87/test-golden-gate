import Vue from 'vue';
import Router from 'vue-router';

/**
 * Layzloading will create many files and slow on compiling, so best not to use lazyloading on devlopment.
 * The syntax is lazyloading, but we convert to proper require() with babel-plugin-syntax-dynamic-import
 * @see https://doc.laravue.dev/guide/advanced/lazy-loading.html
 */

Vue.use(Router);

/* Layout */
import Layout from '@/layout';

/* Router for modules */
import adminRoutes from './modules/admin';
import errorRoutes from './modules/error';
import employeeRoutes from './modules/employee';

/**
 * Sub-menu only appear when children.length>=1
 * @see https://doc.laravue.dev/guide/essentials/router-and-nav.html
 **/

/**
* hidden: true                   if `hidden:true` will not show in the sidebar(default is false)
* alwaysShow: true               if set true, will always show the root menu, whatever its child routes length
*                                if not set alwaysShow, only more than one route under the children
*                                it will becomes nested mode, otherwise not show the root menu
* redirect: noredirect           if `redirect:noredirect` will no redirect in the breadcrumb
* name:'router-name'             the name is used by <keep-alive> (must set!!!)
* meta : {
    roles: ['admin', 'editor']   Visible for these roles only
    permissions: ['view menu zip', 'manage user'] Visible for these permissions only
    title: 'title'               the name show in sub-menu and breadcrumb (recommend set)
    icon: 'svg-name'             the icon show in the sidebar
    noCache: true                if true, the page will no be cached(default is false)
    breadcrumb: false            if false, the item will hidden in breadcrumb (default is true)
    affix: true                  if true, the tag will affix in the tags-view
  }
**/

export const constantRoutes = [
  {
    path: '/redirect',
    component: Layout,
    hidden: true,
    children: [
      {
        path: '/redirect/:path*',
        component: () => import('@/views/redirect/index'),
      },
    ],
  },
  {
    path: '/login',
    component: () => import('@/views/login/index'),
    hidden: true,
  },
  {
    path: '/auth-redirect',
    component: () => import('@/views/login/AuthRedirect'),
    hidden: true,
  },
  {
    path: '/404',
    redirect: { name: 'Page404' },
    component: () => import('@/views/error-page/404'),
    hidden: true,
  },
  {
    path: '/401',
    component: () => import('@/views/error-page/401'),
    hidden: true,
  },
  {
    path: '/profile',
    component: Layout,
    redirect: '/profile/edit',
    children: [
      {
        path: 'edit',
        component: () => import('@/views/users/SelfProfile'),
        name: 'SelfProfile',
        meta: { title: 'userProfile', icon: 'user', noCache: true },
      },
    ],
  },
  {
    path: '/guide',
    component: Layout,
    redirect: '/guide/index',
    children: [
      {
        path: 'index',
        component: () => import('@/views/guide/index'),
        name: 'Guide',
        meta: { title: 'guide', icon: 'guide', noCache: true },
      },
    ],
  },
  {
    path: '/hrm',
    component: Layout,
    redirect: '/hrm',
    children: [
      {
        path: 'hrm',
        component: () => import('@/views/hrm/index'),
        name: 'hrm',
        meta: {
          title: 'Qu???n l?? nh??n s???',
          icon: 'user',
          affix: true,
        },
      },
    ],
  },
  {
    path: '/customer',
    component: Layout,
    redirect: '/customer',
    children: [
      {
        path: 'customer',
        component: () => import('@/views/customer/index'),
        name: 'customer',
        meta: {
          title: 'Qu???n l?? Kh??ch h??ng',
          icon: 'user',
          affix: true,
        },
      },
    ],
  },
  {
    path: '/products',
    component: Layout,
    redirect: '/products/index',
    meta: {
      title: 'Qu???n l?? s???n ph???m',
      icon: 'el-icon-takeaway-box',
      permissions: ['list_products'],
    },
    children: [
      {
        path: 'index',
        component: () => import('@/views/products/index'),
        name: 'listProduct',
        meta: {
          title: 'Danh s??ch s???n ph???m',
          noCache: true,
          permissions: ['list_products'],
        },
      },
      {
        path: 'create',
        component: () => import('@/views/products/create'),
        name: 'CreateProduct',
        meta: {
          title: 'T???o s???n ph???m',
          permissions: ['create_product'],
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
          permissions: ['update_product'],
        },
        hidden: true,
      },
    ],
  },
];

export const asyncRoutes = [
  adminRoutes,
  employeeRoutes,
  errorRoutes,
  { path: '*', redirect: '/404', hidden: true },
];

const createRouter = () => new Router({
  // mode: 'history', // require service support
  scrollBehavior: () => ({ y: 0 }),
  base: process.env.MIX_LARAVUE_PATH,
  routes: constantRoutes,
});

const router = createRouter();

// Detail see: https://github.com/vuejs/vue-router/issues/1234#issuecomment-357941465
export function resetRouter() {
  const newRouter = createRouter();
  router.matcher = newRouter.matcher; // reset router
}

export default router;
