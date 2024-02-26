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
      {
        url: '/admin/upgrade',
        name: 'Kho bài tập',
        slug: 'records',
        icon: 'StarIcon',
        i18n: 'Kho bài tập',
        submenu: [
          {
            url: '/admin/grade/1',
            name: 'Lớp 12',
            slug: 'app-user-list',
            i18n: 'Lớp 12'
          },
          {
            url: '/admin/grade/2',
            name: 'Lớp 11',
            slug: 'app-user-list',
            i18n: 'Lớp 11'
          },
          {
            url: '/admin/grade/3',
            name: 'Lớp 10',
            slug: 'app-user-list',
            i18n: 'Lớp 10'
          },
          {
            url: '/admin/grade/4',
            name: 'Lớp 9',
            slug: 'app-user-list',
            i18n: 'Lớp 9'
          },
          {
            url: '/admin/grade/5',
            name: 'Lớp 8',
            slug: 'app-user-list',
            i18n: 'Lớp 8'
          },
          {
            url: '/admin/grade/6',
            name: 'Lớp 7',
            slug: 'app-user-list',
            i18n: 'Lớp 7'
          },
          {
            url: '/admin/grade/7',
            name: 'Lớp 6',
            slug: 'app-user-list',
            i18n: 'Lớp 6'
          },
          {
            url: '/admin/grade/8',
            name: 'Lớp 5',
            slug: 'app-user-list',
            i18n: 'Lớp 5'
          },{
            url: '/admin/grade/9',
            name: 'Lớp 4',
            slug: 'app-user-list',
            i18n: 'Lớp 4'
          },
          {
            url: '/admin/grade/10',
            name: 'Lớp 3',
            slug: 'app-user-list',
            i18n: 'Lớp 3'
          },
          {
            url: '/admin/grade/11',
            name: 'Lớp 2',
            slug: 'app-user-list',
            i18n: 'Lớp 2'
          },
          {
            url: '/admin/grade/12',
            name: 'Lớp 1',
            slug: 'app-user-list',
            i18n: 'Lớp 1'
          },
        ]
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
            url: '/admin/user/payments',
            name: 'Lịch sử thanh toán',
            slug: 'app-user-view',
            i18n: 'Lịch sử thanh toán'
          }
        ]
      },
    ]
  }
]

