<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{config('app.name')}}</title>
    {{-- <link rel="apple-touch-icon" href="{{asset('assets/images/Dash-logo.ico')}}"> --}}
    {{-- <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/Dash-logo.ico')}}"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/app-assets/vendors/css/vendors-rtl.min.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/app-assets/css-rtl/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/app-assets/css-rtl/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/app-assets/css-rtl/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/app-assets/css-rtl/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/app-assets/css-rtl/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/app-assets/css-rtl/themes/bordered-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/app-assets/css-rtl/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/app-assets/css-rtl/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/app-assets/css-rtl/plugins/forms/form-validation.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/app-assets/css-rtl/pages/page-auth.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/app-assets/css-rtl/custom-rtl.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/assets/css/style-rtl.css')}}">
    <!-- END: Custom CSS-->
    <style>
        body.preloader-site {
            overflow: hidden;
        }

        .preloader-wrapper {
            height: 100%;
            width: 100%;
            background: #161D31;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 9999999;
        }

        .preloader-wrapper .preloader {
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            width: 120px;
        }
    </style>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
<!-- BEGIN: Content-->
@yield('content')
<!-- END: Content-->

<div class="preloader-wrapper">
    <div class="preloader">
        <img src="{{asset('assets/images/preloader.svg')}}" alt="logo" height="100">
    </div>
</div>
<!-- BEGIN: Vendor JS-->
<script src="{{asset('assets/admin/app-assets/vendors/js/vendors.min.js')}}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{asset('assets/admin/app-assets/vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{asset('assets/admin/app-assets/js/core/app-menu.js')}}"></script>
<script src="{{asset('assets/admin/app-assets/js/core/app.js')}}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="{{asset('assets/admin/app-assets/js/scripts/pages/page-auth-login.js')}}"></script>
<!-- END: Page JS-->

<script>
    $(window).on('load', function () {
        $('.preloader-wrapper').fadeOut(200);
    });
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })


</script>
<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })


    let mode = localStorage.getItem('mode');

    $('#switch-mode').on('click',function (){
        if (mode === 'dark-layout')
        {
            mode = 'light-layout';
            localStorage.setItem('mode',mode);
        }else {

            mode = 'dark-layout';
            localStorage.setItem('mode',mode);
        }
        setLayout(mode)
    })
    if (!mode){
        mode = 'light-layout';
    }
    function setLayout(currentLocalStorageLayout) {
        var navLinkStyle = $('.nav-link-style'),
            currentLayout = currentLocalStorageLayout,
            mainMenu = $('.main-menu'),
            navbar = $('.header-navbar');

        var $html = $('html');
        $html.removeClass('semi-dark-layout dark-layout bordered-layout');

        if (currentLocalStorageLayout !== 'dark-layout') {
            $html.addClass('dark-layout');
            mainMenu.removeClass('menu-light').addClass('menu-dark');
            navbar.removeClass('navbar-light').addClass('navbar-dark');
            navLinkStyle.find('.ficon').replaceWith(feather.icons['sun'].toSvg({ class: 'ficon' }));
        } else {
            $html.addClass('light-layout');
            mainMenu.removeClass('menu-dark').addClass('menu-light');
            navbar.removeClass('navbar-dark').addClass('navbar-light');
            navLinkStyle.find('.ficon').replaceWith(feather.icons['moon'].toSvg({ class: 'ficon' }));
        }
        // Set radio in customizer if we have
        if ($('input:radio[data-layout=' + currentLocalStorageLayout.split('-')[0] + ']').length > 0) {
            setTimeout(function () {
                $('input:radio[data-layout=' + currentLocalStorageLayout.split('-')[0] + ']').prop('checked', true);
            });
        }
    }

    setLayout(mode)
</script>
</body>
<!-- END: Body-->

</html>
