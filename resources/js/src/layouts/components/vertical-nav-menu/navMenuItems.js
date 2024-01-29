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
  // {
  //   url: '/',
  //   name: 'Dashboard',
  //   tagColor: 'warning',
  //   icon: 'HomeIcon',
  //   i18n: 'Dashboard'
  // },
  {
    header: 'Ứng dụng',
    icon: 'PackageIcon',
    i18n: 'Ứng dụng',
    items: [
      {
        url: '/admin/rooms',
        name: 'Phòng họp',
        slug: 'rooms',
        icon: 'VideoIcon',
        i18n: 'Phòng họp'
      },
      {
        url: '/admin/records',
        name: 'Lưu trữ',
        slug: 'records',
        icon: 'ArchiveIcon',
        i18n: 'Lưu trữ'
      },
    ]
  },
  {
    header: 'Tài khoản',
    icon: 'PackageIcon',
    i18n: 'Tài khoản',
    items: [
      {
        url: '/admin/user/profile',
        name: 'Cài đặt tài khoản',
        slug: 'user',
        icon: 'SettingsIcon',
        i18n: 'Cài đặt tài khoản'
      },
      {
        url: '/admin/upgrade',
        name: 'Gói dịch vụ',
        slug: 'records',
        icon: 'StarIcon',
        i18n: 'Gói dịch vụ',
        submenu: [
          {
            url: '/admin/upgrade',
            name: 'Nâng cấp',
            slug: 'app-user-list',
            i18n: 'Nâng cấp dịch vụ'
          },
          {
            url: '/admin/user/payment',
            name: 'Lịch sử thanh toán',
            slug: 'app-user-view',
            i18n: 'Lịch sử thanh toán'
          }
        ]
      },
    ]
  }
]

