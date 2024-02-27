<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Công Nghệ Giáo Dục</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset(mix('css/main.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/iconfont.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/material-icons/material-icons.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/vuesax.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/prism-tomorrow.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">

    <!-- Favicon -->
    <link href="../static/flexstart/img/apple-touch-icon.png" rel="shortcut icon">
  </head>
  <body>
    <noscript>
      <strong>Công Nghệ Giáo Dục  - cung cấp các nền tảng dịch vụ hỗ trợ quản lý giảng dạy online trên nền tảng BigBlueButton. Lớp học ảo, cuộc họp video, thuyết trình trực tuyến, hội thảo trên web và đào tạo từ xa ...</strong>
    </noscript>
    <div id="app">
    </div>
    <!-- <script src="js/app.js"></script> -->
    <script src="{{ asset(mix('js/app.js')) }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.2/MathJax.js?config=TeX-AMS_HTML"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ML87RVSPD0"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-ML87RVSPD0');
    </script>
  </body>
</html>
