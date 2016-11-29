<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Administration</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?= URL::to( '/' ); ?>/assets/administration/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= URL::to( '/' ); ?>/assets/administration/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= URL::to( '/' ); ?>/assets/administration/dist/css/skins/skin-blue.min.css">
    <link rel="stylesheet" href="<?= URL::to( '/' ); ?>/assets/administration/custom.css">
    @yield('custom_css')
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
        <a href="index2.html" class="logo">
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
                                    <a class="btn btn-default btn-flat" href="{{ url('/logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
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
                        <li><a href="<?= url::to( '/admin/navigation' ); ?>">Usporiadanie navigácie</a></li>
                        <li><a href="<?= url::to( '/admin/page_create' ); ?>">Pridať novú</a></li>
                    </ul>
                </li>
                <li id="nav-news"><a class="disabled" href="<?= url::to( '/admin#' ); ?>"><i class="fa fa-thumb-tack" aria-hidden="true"></i> <span>Aktuality</span></a></li>
                <li id="nav-users"><a class="disabled" href="<?= url::to( '/admin#' ); ?>"><i class="fa fa-users" aria-hidden="true"></i> <span>Používatelia</span></a></li>
                <li id="nav-tools"><a class="disabled" href="<?= url::to( '/admin#' ); ?>"><i class="fa fa-cogs" aria-hidden="true"></i> <span>Nástroje</span></a></li>
                <li id="nav-languages" class="treeview">
                    <a href="#"><i class="fa fa-language" aria-hidden="true"></i> <span>Jazyky</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?= url::to( '/admin/languages' ); ?>">Jazyky</a></li>
                        <li><a href="<?= url::to( '/admin/create_lang' ); ?>">Vytvoriť jazyk</a></li>
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
                <li><a href="<?= base_path('/admin') ?>"><i class="fa fa-chevron-right" aria-hidden="true"></i> Administrácia</a></li>
                <li class="active">@yield('title')</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

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
    @yield('custom_scripts')
</body>
</html>
