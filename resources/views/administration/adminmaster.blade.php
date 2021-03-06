<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title> @yield('title') | IOlab Admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 3.3.6 -->
    <link rel="shortcut icon" href="<?= URL::to( '/' ); ?>/assets/administration/favicon.ico" type="image/x-icon">
    <link rel="icon" href="<?= URL::to( '/' ); ?>/assets/administration/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="<?= URL::to( '/' ); ?>/assets/administration/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= URL::to( '/' ); ?>/assets/administration/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= url('assets/administration/morris.css') ?>">
    <link rel="stylesheet" href="<?= URL::to( '/' ); ?>/assets/administration/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= URL::to( '/' ); ?>/assets/administration/dist/css/skins/skin-blue.min.css">
    <link rel="stylesheet" href="<?= URL::to( '/' ); ?>/assets/administration/custom.css">
    @yield('custom_css')
    <style>
        .animated {
            -webkit-animation-duration: 1s;
            animation-duration: 1s;
            -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
        }
        @-webkit-keyframes bounceInLeft {
            0%, 60%, 75%, 90%, 100% {
                -webkit-transition-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
                transition-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
            }

            0% {
                opacity: 0;
                -webkit-transform: translate3d(-3000px, 0, 0);
                transform: translate3d(-3000px, 0, 0);
            }

            60% {
                opacity: 1;
                -webkit-transform: translate3d(25px, 0, 0);
                transform: translate3d(25px, 0, 0);
            }

            75% {
                -webkit-transform: translate3d(-10px, 0, 0);
                transform: translate3d(-10px, 0, 0);
            }

            90% {
                -webkit-transform: translate3d(5px, 0, 0);
                transform: translate3d(5px, 0, 0);
            }

            100% {
                -webkit-transform: none;
                transform: none;
            }
        }

        @keyframes bounceInLeft {
            0%, 60%, 75%, 90%, 100% {
                -webkit-transition-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
                transition-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
            }

            0% {
                opacity: 0;
                -webkit-transform: translate3d(-3000px, 0, 0);
                transform: translate3d(-3000px, 0, 0);
            }

            60% {
                opacity: 1;
                -webkit-transform: translate3d(25px, 0, 0);
                transform: translate3d(25px, 0, 0);
            }

            75% {
                -webkit-transform: translate3d(-10px, 0, 0);
                transform: translate3d(-10px, 0, 0);
            }

            90% {
                -webkit-transform: translate3d(5px, 0, 0);
                transform: translate3d(5px, 0, 0);
            }

            100% {
                -webkit-transform: none;
                transform: none;
            }
        }

        .bounceInLeft {
            -webkit-animation-name: bounceInLeft;
            animation-name: bounceInLeft;
        }
        @-webkit-keyframes bounceOutRight {
            20% {
                opacity: 1;
                -webkit-transform: translate3d(-20px, 0, 0);
                transform: translate3d(-20px, 0, 0);
            }

            100% {
                opacity: 0;
                -webkit-transform: translate3d(2000px, 0, 0);
                transform: translate3d(2000px, 0, 0);
            }
        }

        @keyframes bounceOutRight {
            20% {
                opacity: 1;
                -webkit-transform: translate3d(-20px, 0, 0);
                transform: translate3d(-20px, 0, 0);
            }

            100% {
                opacity: 0;
                -webkit-transform: translate3d(2000px, 0, 0);
                transform: translate3d(2000px, 0, 0);
            }
        }

        .bounceOutRight {
            -webkit-animation-name: bounceOutRight;
            animation-name: bounceOutRight;
        }
    </style>
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="{{url::to( '/admin' )}}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>IO</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>IO</b>lab</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- Menu Body -->
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a class="btn btn-default btn-md" href="{{ url('/logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Odhlásiť
                                    </a>
                                </div>
                            </li>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <!-- Optionally, you can add icons to the links -->
                <li id="nav-dashboard"><a href="<?= url::to( '/admin' ); ?>"><i class="fa fa-home" aria-hidden="true"></i> <span>Hlavná stránka</span></a></li>
                <li id="nav-navigacia" class="treeview">
                    <a href="#"><i class="fa fa-bars" aria-hidden="true"></i> <span>Stránky</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?= url::to( '/admin/pages' ); ?>">Všetky stránky</a></li>
                        <li><a href="<?= url::to( '/admin/navigation-reorder' ); ?>">Usporiadanie navigácie</a></li>
                        <li><a href="<?= url::to( '/admin/pages/create' ); ?>">Pridať novú</a></li>
                    </ul>
                </li>

                <li id="nav-news" class="treeview">
                    <a href="#"><i class="fa fa-thumb-tack" aria-hidden="true"></i> <span>Aktuality</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?= url::to( '/admin/actualities' ); ?>">Všetky aktuality</a></li>
                        <li><a href="<?= url::to( '/admin/actualities/create' ); ?>">Pridať novú</a></li>
                    </ul>
                </li>

                <li id="nav-users"><a href="<?= url::to( '/admin/users' ); ?>"><i class="fa fa-users" aria-hidden="true"></i> <span>Užívatelia</span></a></li>

                <li id="nav-languages" class="treeview">
                    <a href="#"><i class="fa fa-language" aria-hidden="true"></i> <span>Jazyky</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?= url::to( '/admin/languages' ); ?>">Jazyky</a></li>
                        <li><a href="<?= url::to( '/admin/languages/create' ); ?>">Vytvoriť jazyk</a></li>
                    </ul>
                </li>
                <li id="nav-settings"><a href="<?= url::to( '/admin/settings' ); ?>"><i class="fa fa-wrench" aria-hidden="true"></i> <span>Nastavenia</span></a></li>
            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('title')
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?= URL::to('/admin') ?>"><i class="fa fa-chevron-right" aria-hidden="true"></i> Hlavná stránka</a></li>
                <li class="active">@yield('title')</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <?php
	        $_errors = [];
	        if (!is_writable(dirname(getcwd()) . '/resources')) {
		        $_errors[] = dirname(getcwd()) . '/resources';
	        }
	        if (!is_writable(dirname(getcwd()) . '/public')) {
                $_errors[] = dirname(getcwd()) . '/public';
            }
	        ?>
            <?php if(sizeof($_errors) > 0): ?>
                <style>
                    td a {
                        color: gray !important;
                        opacity: 0.5!important;
                        pointer-events: none !important;
                        cursor: not-allowed !important;
                    }
                </style>
                <div class="alert alert-danger">
                    <h2 style="margin: 0;">VAROVANIE!!!</h2>
                    <strong>Funkcionalita je vypnutá. Pre bezchybný chod aplikácie opravte prosím nasledujúce:</strong><br>
                    <?php foreach($_errors as $key => $value): ?>
                        <?= $key + 1 . '. Nastavte rekurzívny chmod 777 pre adresár ' . $value ?>
                        <br>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Your Page Content Here -->
            <div class="box box-info">
                <!-- /.box-header -->
                <div class="box-body">
                        @yield('content')
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-footer -->
            </div>

        </section>
        <!-- /.content -->
    </div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.2.3 -->
<script src="<?= URL::to( '/' ); ?>/assets/administration/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?= URL::to( '/' ); ?>/assets/administration/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= URL::to( '/' ); ?>/assets/administration/dist/js/app.min.js"></script>
<script src="<?= URL::to( '/' ); ?>/assets/administration/plugins/noty/jquery.noty.packaged.min.js"></script>
<script src="<?= URL::to( '/' ); ?>/assets/administration/plugins/parsley.min.js"></script>
<script src="<?= url('assets/administration/raphael.min.js') ?>"></script>
<script src="<?= url('assets/administration/morris.min.js') ?>"></script>
<script>
    function generate(type, text) {
        var n = noty({
            text        : text,
            type        : type,
            dismissQueue: true,
            progressBar : true,
            timeout     : 5000,
            layout      : 'topRight',
            closeWith   : ['click'],
            theme       : 'relax',
            maxVisible  : 10,
            animation   : {
                open  : 'animated bounceInLeft',
                close : 'animated bounceOutRight',
                easing: 'swing',
                speed : 500
            }
        });
        return n;
    }
</script>
<?php if(count($errors) > 0): ?>
<?php foreach($errors->all() as $error): ?>
<script>
    generate('warning', '<div class="activity-item"> <i class="fa fa-check" aria-hidden="true"></i> <div class="activity">{{$error}}</div> </div>');
</script>
<?php endforeach; ?>
<?php endif; ?>
@if (Session::has('success'))
    <script>
        generate('success', '<div class="activity-item"> <i class="fa fa-check" aria-hidden="true"></i> <div class="activity">{{ Session::get('success') }}</div> </div>');
    </script>
@endif
@yield('custom_scripts')
</body>
</html>