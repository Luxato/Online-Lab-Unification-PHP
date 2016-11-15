<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Online lab')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?= URL::to( '/' ); ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <!--google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700&amp;subset=latin-ext" rel="stylesheet">
    <!--favicon-->
    <link rel="apple-touch-icon" sizes="57x57" href="<?= URL::to( '/' ); ?>/assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= URL::to( '/' ); ?>/assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= URL::to( '/' ); ?>/assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= URL::to( '/' ); ?>/assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= URL::to( '/' ); ?>/assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= URL::to( '/' ); ?>/assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= URL::to( '/' ); ?>/assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= URL::to( '/' ); ?>/assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= URL::to( '/' ); ?>/assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= URL::to( '/' ); ?>/assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= URL::to( '/' ); ?>/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= URL::to( '/' ); ?>/assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= URL::to( '/' ); ?>/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="./favicon/ms-icon-144x144.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link href="<?= URL::to( '/' ); ?>/assets/css/style.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .mockup {
            margin: 25px 0;
        }
    </style>
</head>
<body>
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand logo" href="<?= URL::to( '/' ); ?>"><img src="<?= URL::to( '/' ); ?>/assets/img/logo.png" alt="logo" width="37px"></a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <?php foreach($navigation as $nav_link): ?>
                <?php if(!isset($nav_link->children)): ?>
                <li><a href="<?= $nav_link->name ?>"><?php echo trans( 'navigation.' . $nav_link->name ) ?></a></li>
                <?php else: ?>
                <li><a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo trans( 'navigation.' . $nav_link->name ) ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu multi-level">
                        <?php foreach($nav_link->children as $child_link): ?>
                        <li><a href="<?= $child_link->controller ?>"><?= $child_link->name ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <?php endif; ?>
                <?php endforeach; ?>
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu 1 <b class="caret"></b></a>
                    <ul class="dropdown-menu multi-level">
                        <li><a href="#">Some link</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                        <li class="dropdown-submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Action</a></li>
                                <li class="dropdown-submenu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown-submenu">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown</a>
                                            <ul class="dropdown-menu">
                                                <li><a href="#">The end</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#">Separated link</a></li>
                                                <li class="divider"></li>
                                                <li><a href="#">One more separated link</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Login</b> <span class="caret"></span></a>
                    <ul id="login-dp" class="dropdown-menu">
                        <li>
                            <div class="row">
                                <div class="col-md-12">
                                    {{--Login via
                                    <div class="social-buttons">
                                        <a href="#" class="btn btn-fb"><i class="fa fa-facebook"></i> Facebook</a>
                                        <a href="#" class="btn btn-tw"><i class="fa fa-twitter"></i> Twitter</a>
                                    </div>
                                    or--}}
                                    <form class="form" role="form" method="post" action="login" accept-charset="UTF-8" id="login-nav">
                                        <div class="form-group">
                                            <label class="sr-only" for="exampleInputEmail2">Email address</label>
                                            <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Email address" required="">
                                        </div>
                                        <div class="form-group">
                                            <label class="sr-only" for="exampleInputPassword2">Password</label>
                                            <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password" required="">
                                            <div class="help-block text-right"><a href="">Forget the password ?</a></div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"> keep me logged-in
                                            </label>
                                        </div>
                                    </form>
                                </div>
                                <div class="bottom text-center">
                                    New here ? <a href="#"><b>Join Us</b></a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
        <ul class="translation-flags">
            <li><a href="<?= URL::to( '/sk' ); ?>">SK</a></li>
            <li><a href="<?= URL::to( '/en' ); ?>">EN</a></li>
        </ul>
    </div>
</div>
<header>
    <a class="header-logo" href="index.html"><img src="<?= URL::to( '/' ); ?>/assets/img/logo_svk_full.png" alt="logo"></a>
    <div id="particles-js" style="height: 200px;"></div>
</header>

<div class="container" style="width: 100%;">
    <div class="row">
{{--        <div class="col-sm-3" style="padding: 25px;">
--}}{{--            <nav class="navbar navbar-default" role="navigation">
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav navbar-vertical">
                        <li><a href="#">Link</a></li>
                        <li><a href="#">Link</a></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>--}}{{--
        </div>--}}
        <div class="col-sm-12 mockup">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="usr">Trvanie animácie:</label>
                        <input type="text" class="form-control" id="usr">
                    </div>
                    <div class="form-group">
                        <label for="usr">Počiatočný uhol v stupňoch:</label>
                        <input type="text" class="form-control" id="usr">
                    </div>
                    <div class="form-group">
                        <label for="usr">Počiatočná rýchlosť vozidla v m/s:</label>
                        <input type="text" class="form-control" id="usr">
                    </div>
                    <label for="usr">Použiť PID regulátor:</label>
                    <div class="radio">
                        <label><input type="radio" name="optradio" checked>Áno</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" name="optradio">Nie</label>
                    </div>
                    <div class="form-group">
                        <label for="usr">P:</label>
                        <input type="text" class="form-control" id="usr">
                    </div>
                    <div class="form-group">
                        <label for="usr">I:</label>
                        <input type="text" class="form-control" id="usr">
                    </div>
                    <div class="form-group">
                        <label for="usr">D:</label>
                        <input type="text" class="form-control" id="usr">
                    </div>
                    <button style="display: inline-block;margin: 10px 0;width: 105px;" type="button" class="btn btn-success btn-md">Generovať</button>
                    <button type="button" class="btn btn-success btn-md">Zobraziť graf</button>
                </div>
                <div class="col-md-9">
                    <img style="width:94%;" class="img-responsive" src="<?= URL::to( '/' ); ?>/mockups/1.jpg" alt="">
                </div>
                </div>
        </div>
    </div>
</div>
<footer>
    <p>Copyright © 2016</p>
    <ul>
        <li>
            <a target="_blank" href="https://github.com/Luxato/Online-Lab-Unification-PHP"><i
                        class="fa fa-github-square" aria-hidden="true"></i></a>
        </li>
    </ul>
</footer>
<script src="<?= URL::to( '/' ); ?>/assets/js/jquery.js"></script>
<script src="<?= URL::to( '/' ); ?>/assets/js/bootstrap.min.js"></script>
<script src="<?= URL::to( '/' ); ?>/assets/js/parallax.min.js"></script>
<script src="<?= URL::to( '/' ); ?>/assets/js/particles.min.js"></script>
<script src="<?= URL::to( '/' ); ?>/assets/js/particles-animation.js"></script>
<script>
    $(window).load(function () {
        $(".se-pre-con").fadeOut("slow");
    });
    $(window).scroll(function() {
        var navbar = $(".navbar-fixed-top");
        if ($(".navbar-fixed-top").offset().top > 50) {
            navbar.addClass('navbar-mini');
        } else {
            navbar.removeClass('navbar-mini');
        }
    });
</script>
<div class="se-pre-con"></div>
</body>
</html>