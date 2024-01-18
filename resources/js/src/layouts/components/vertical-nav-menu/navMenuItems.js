/*=========================================================================================
  File Name: sidebarItems.js
  Description: Sidebar Items list. Add / Remove menu items from here.
  Strucutre:
          url     => router path
          name    => name to display in sidebar
          slug    => router path name
          icon    => Feather Icon component/icon name
          tag     => text to display on badge
          tagColor  => class to apply on badge element
          i18n    => Internationalization
          submenu   => submenu of current item (current item will become dropdown )
                NOTE: Submenu don't have any icon(you can add icon if u want to display)
          isDisabled  => disable sidebar item/group
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


export default [
  {
    url: '/law/list',
    name: 'Tìm luật sư',
    tag: '3',
    tagColor: 'warning',
    icon: 'SearchIcon',
    submenu: [
      {
        url: '/#',
        name: 'Bảo hiểm',
        slug: 'dashboard-analytics',
      },
      {
        url: '/#',
        name: 'Dân sự',
        slug: 'dashboard-ecommerce',
      },
      {
        url: '/#',
        name: 'Đất đai',
        slug: 'dashboard-ecommerce',
      }
    ]
  },
  {
    url: '/#',
    name: 'Bảng phí',
    icon: 'DollarSignIcon',
  },
  {
    url: '/#',
    name: 'Dịch vụ pháp lý',
    icon: 'KeyIcon',
  },
  {
    url: '/#',
    name: 'Chính sách bảo mật',
    icon: 'BookOpenIcon',
  },
  {
    url: '/#',
    name: 'Liên hệ',
    icon: 'InfoIcon',
  }
]

