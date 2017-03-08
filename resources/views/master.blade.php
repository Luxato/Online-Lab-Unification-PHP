<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Online lab')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <!--google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700&amp;subset=latin-ext" rel="stylesheet">
    <!--favicon-->
    <link rel="apple-touch-icon" sizes="57x57" href="assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="./favicon/ms-icon-144x144.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        var baseUrl = "<?= URL( '/' ) ?>";
    </script>
</head>
<body>
{{--<div class="se-pre-con"></div>--}}
<div id="preLoader">
    <div style=" position: absolute;top: 50%;left: 50%;width: 100%;margin-left: -50%;margin-top:-100px;text-align: center;">

        <div style="width: 50px; height: 50px; margin: 0 auto">
            <div class="kp-loading2"></div>
        </div>
        <h3 style="margin-top: 20px; font-weight: bold">One moment...</h3>
    </div>
</div>
<aside>
    <div class="container">
        <ul class="user-panel left">
            <li><a href="#"><i class="fa fa-plus" aria-hidden="true"></i> Vytvoriť api kľúč</a></li>
        </ul>
        <div class="user-panel logout">
            <a href="#">prihlásený užívateľ: Michal <i class="fa fa-angle-down" aria-hidden="true"></i></a>
        </div>
    </div>
</aside>
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand logo" href="<?= URL::to( '/' ); ?>"><img src="./assets/img/logo.png" alt="logo"
                                                                            width="37px"></a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
				<?php foreach($navigation as $nav_link): ?>
				<?php if(! isset( $nav_link->children )): ?>
                <li><a href="<?= $nav_link->controller ?>"><?php echo $nav_link->title ?></a>
                </li>
				<?php else: ?>
                <li><a class="dropdown-toggle" data-toggle="dropdown"
                       href="#"><?php echo trans( $nav_link->title ) ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu multi-level">
						<?php foreach($nav_link->children as $child_link): ?>
						<?php if(! isset( $child_link->children )): ?>
                        <li><a href="<?= $child_link->controller ?>"><?= $child_link->title ?></a></li>
						<?php else: ?>
                        <li class="dropdown-submenu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <?= trans( $child_link->title) ?> </a>
                            <ul class="dropdown-menu">
                                <?php foreach($child_link->children as $sub_child_link): ?>
                                    <li><a href="<?= $sub_child_link->controller ?>"><?= $sub_child_link->name ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>

						<?php endif; ?>
						<?php endforeach; ?>
                    </ul>
                </li>
				<?php endif; ?>
				<?php endforeach; ?>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b><?= trans('translation.login') ?></b> <span class="caret"></span></a>
                    <ul id="login-dp" class="dropdown-menu">
                        <li>
                            <div class="row">
                                <div class="col-md-12">
                                    <form class="form" role="form" method="post" action="login" accept-charset="UTF-8"
                                          id="login-nav">
                                        <div class="form-group">
                                            <label class="sr-only" for="exampleInputEmail2"><?= trans('translation.email_address') ?></label>
                                            <input type="email" class="form-control" id="exampleInputEmail2"
                                                   placeholder="<?= trans('translation.email_address') ?>" required="">
                                        </div>
                                        <div class="form-group">
                                            <label class="sr-only" for="exampleInputPassword2"><?= trans('translation.password') ?></label>
                                            <input type="password" class="form-control" id="exampleInputPassword2"
                                                   placeholder="<?= trans('translation.password') ?>" required="">
                                            <div class="help-block text-right"><a href="">Forget the password ?</a>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block"><?= trans('translation.sign_in')  ?></button>
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
            <?php foreach($languages as $language): ?>
               <li><a href="<?= URL::to( 'setlang/' . $language['language_shortcut'] ); ?>"><?= strtoupper($language['language_shortcut']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<header>
    <a class="header-logo" href="index.html"><img src="./assets/img/logo_svk_full.png" alt="logo"></a>
    <div id="particles-js" style="height: 200px;"></div>
</header>

<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li><a href="<?= URL( '/' ) ?>">Home</a></li>
        <li class="active">@yield('title')</li>
    </ol>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            @yield('content')
        </div>
    </div>
</div>
<footer>
    <div class="container" style="height: 100%;">
        <div class="row" style="height: 100%;">
            <div class="col-md-3" style="border-right: 2px solid #f0f0f0; height: 100%;">
                <div class="footer-header">Web služby</div>
                <ul>
                    <li><a href="#">3D Model segway vozidla</a></li>
                    <li><a href="#">3D Model hydraulickej sústavy</a></li>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="footer-right">
                    <ul>
                        <li>
                            <a href="#"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
                        </li>
                        <li>
                            <a target="_blank" href="https://github.com/Luxato/Online-Lab-Unification-PHP"><i
                                        class="fa fa-github-square" aria-hidden="true"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{--<p>Copyright © 2016</p>
    <ul>
        <li>
            <a target="_blank" href="https://github.com/Luxato/Online-Lab-Unification-PHP"><i
                        class="fa fa-github-square" aria-hidden="true"></i></a>
        </li>
    </ul>--}}
    <div id="gotoTop" style="display: block;"><i class="fa fa-angle-up" aria-hidden="true"></i></div>
</footer>
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/parallax.min.js"></script>
<script src="assets/js/particles.min.js"></script>
<script src="assets/js/particles-animation.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
@yield('custom_bottom_scripts')
<script>
    $(window).load(function () {
        $("#preLoader").fadeOut("slow");
    });
    if  (window.innerWidth <= 768) {
        $(".navbar-fixed-top").addClass('navbar-mini');
    }
    $(window).scroll(function () {
        var navbar = $(".navbar-fixed-top");
        if  (window.innerWidth <= 768) {
            navbar.addClass('navbar-mini');
            return;
        }
        if ($(".navbar-fixed-top").offset().top > 50) {
            navbar.addClass('navbar-mini');
        } else {
            navbar.removeClass('navbar-mini');
        }
    });
    $(document).ready(function() {
        $('.navbar a.dropdown-toggle').on('click', function(e) {
            var $el = $(this);
            var $parent = $(this).offsetParent(".dropdown-menu");
            $(this).parent("li").toggleClass('open');

            if(!$parent.parent().hasClass('nav')) {
                $el.next().css({"top": $el[0].offsetTop, "left": $parent.outerWidth() - 4});
            }

            $('.nav li.open').not($(this).parents("li")).removeClass("open");

            return false;
        });
    });
    // Go top
    /*if($window.scrollTop() > 450) {
        $goToTopEl.fadeIn();
    } else {
        $goToTopEl.fadeOut();
    }*/
    $(document).ready(function() {
        var scrollHeight = $(document).height();
        var scrollPosition = $(window).height() + $(window).scrollTop();
        if((scrollHeight == scrollPosition) && ($(window).scrollTop() != 0)) {
           $('#gotoTop').fadeIn();
            console.log('test');
        } else {
            $('#gotoTop').fadeOut();
        }
        $(window).scroll(function() {
            if($(this).scrollTop() > 100){
                $('#gotoTop').fadeIn();
            }
            else{
                $('#gotoTop').fadeOut();
            }
        });
        $('#gotoTop').click(function() {
            $('html, body').stop().animate({
                scrollTop: 0
            }, 500, function() {
                $('#goTop').stop().animate({
                    top: '-100px'
                }, 500);
            });
        });
    });
</script>
</body>
</html>