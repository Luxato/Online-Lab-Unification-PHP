<?php
    if (empty($navigation)) {
        $navigation = [];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'Online lab')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?= url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
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
    <link rel="stylesheet" href="<?= url('assets/css/switchery.min.css') ?>">
    <link href="<?= url('assets/css/style.css') ?>" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
        var baseUrl = "<?= URL( '/' ) ?>";
    </script>
    <script src="<?= url('assets/js/jquery.js') ?>"></script>
</head>
<body <?= Session::get( 'logged_user_id' ) ? 'class="logged"' : '' ?>>
<div id="preLoader">
    <div style=" position: absolute;top: 50%;left: 50%;width: 100%;margin-left: -50%;margin-top:-100px;text-align: center;">

        <div style="width: 50px; height: 50px; margin: 0 auto">
            <div class="kp-loading2"></div>
        </div>
        <h3 style="margin-top: 20px; font-weight: bold">One moment...</h3>
    </div>
</div>
<?php if(Session::get( 'logged_user_id' )): ?>
<aside id="nav">
    <div class="container">
        <nav class="primary_nav_wrap">
            {{--<ul>
                <li><a href="#">API kľúče <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                    <ul>
                        <li><a href="#"><i class="fa fa-plus" aria-hidden="true"></i> Vytvoriť API kľúč</a></li>
                    </ul>
                </li>
            </ul>--}}
            <ul>
                <li><a data-toggle="modal" data-target="#apiModal"><i class="fa fa-plus" aria-hidden="true"></i> <?= trans('translation.create_api_key') ?></a></li>
            </ul>
        </nav>
        <div class="user-panel logout pull-right">
            <nav class="primary_nav_wrap">
                <ul>
                    <li><a href="#"><?= trans('translation.logged_user') ?>: <?= $user->name ?> <i class="fa fa-angle-down"
                                                                                                  aria-hidden="true"></i></a>
                        <ul>
                            <li><a href="<?= url('login/logout') ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> <?= trans('translation.logout') ?></a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</aside>
<?php endif; ?>
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand logo" href="<?= URL::to( '/' ); ?>"><img src="<?= url('assets/img/logo.png') ?>" alt="logo"
                                                                            width="37px"></a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
				<?php foreach($navigation as $nav_link): ?>
				<?php if(! isset( $nav_link->children )): ?>

                    {{--Aktuality--}}
                    <?php if($nav_link->controller == 'aktuality'): ?>
                    <li><a href="aktuality"><?= trans( 'translation.actualities' ) ?></a></li>
					<?php elseif($nav_link->controller == 'cuslogin'): ?>
					<?php if(! Session::get( 'logged_user_id' )): ?>
                    {{--Logged users can not see theese--}}
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle"
                           data-toggle="dropdown"><b><?= trans( 'translation.login' ) ?></b> <span class="caret"></span></a>
                        <ul id="login-dp" class="dropdown-menu">
                            <li>
                                <div class="row">
                                    <div class="col-md-12">
                                        <form id="login-nav" class="form" role="form" method="post" action="<?= URL( '/login/custom' ) ?>">
                                            <input name="_token" type="hidden" id="_token" value="{{ csrf_token() }}"/>
                                            <div class="form-group">
                                                <label for=""><?= trans('translation.ais_login') ?>: </label>
                                                <input type="checkbox" class="js-switch">
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only"
                                                       for="exampleInputEmail2"><?= trans( 'translation.email_address' ) ?></label>
                                                <input name="email" type="email" class="form-control"
                                                       id="exampleInputEmail2"
                                                       placeholder="<?= trans( 'translation.email_address' ) ?>"
                                                       required="">
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only"
                                                       for="exampleInputPassword2"><?= trans( 'translation.password' ) ?></label>
                                                <input name="password" type="password" class="form-control"
                                                       id="exampleInputPassword2"
                                                       placeholder="<?= trans( 'translation.password' ) ?>" required="">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit"
                                                        class="btn btn-primary btn-block"><?= trans( 'translation.sign_in' )  ?></button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="bottom text-center">
                                        <div><?= trans('translation.or') ?></div>
                                        <button type="button" class="btn btn-default" id="showModal" href="#"><?= trans('translation.create_account') ?></button>
                                        <div><?= trans('translation.or') ?></div>
                                        <a class="googleLogin" href="#"><span style="position: absolute;top: 0;color: white;right: 30px;"><?= trans('translation.login_google') ?></span><img height="44" src="<?= url('assets/img/google.png') ?>" alt="google_login"></a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
					<?php else: ?>

                <?php endif; ?>
                    <?php else: ?>
                    <li><a href="<?= isset($nav_link->content_file) ? $nav_link->controller : '#' ?>"><?php echo $nav_link->title ?></a>
                    </li>
                    <?php endif; ?>
				<?php else: ?>
                <li><a class="dropdown-toggle" data-toggle="dropdown"
                       href="#"><?php echo trans( $nav_link->title ) ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu multi-level">
						<?php foreach($nav_link->children as $child_link): ?>
						<?php if(! isset( $child_link->children )): ?>
                        <li><a href="<?= isset($child_link->content_file) ? $child_link->controller : '#' ?>"><?= $child_link->title ?></a></li>
						<?php else: ?>
                        <li class="dropdown-submenu">
                            <a href="#" class="dropdown-toggle"
                               data-toggle="dropdown"> <?= trans( $child_link->title ) ?> </a>
                            <ul class="dropdown-menu">
								<?php foreach($child_link->children as $sub_child_link): ?>
                                <li><a href="<?= isset($sub_child_link->content_file) ? $sub_child_link->controller : '#' ?>"><?= $sub_child_link->title ?></a></li>
								<?php endforeach; ?>
                            </ul>
                        </li>

						<?php endif; ?>
						<?php endforeach; ?>
                    </ul>
                </li>
				<?php endif; ?>
				<?php endforeach; ?>

            </ul>
        </div><!--/.nav-collapse -->
        <ul class="translation-flags">
            <?php
	        if (Session::get( 'applocale' )) {
	            $applocale = Session::get( 'applocale' );
	        } else {
		        $applocale = \Config::get( 'app.locale' );
            }
            ?>
			<?php foreach($languages as $language): ?>
            <?php if($applocale !== $language['language_shortcut']): ?>
                <li>
                    <a href="<?= URL::to( 'setlang/' . $language['language_shortcut'] ); ?>"><?= strtoupper( $language['language_shortcut'] ) ?></a>
                </li>
            <?php endif; ?>
			<?php endforeach; ?>
        </ul>
    </div>
</div>
    <?php if (Route::getCurrentRoute()->uri() == '/'): ?>
    <header>
        <a class="header-logo" href="index.html"><img src="<?= url('assets/img/logo_svk_full.png') ?>" alt="logo"></a>
        <div id="particles-js" style="height: 200px;"></div>
    </header>
    <?php endif; ?>

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
            <div class="col-md-3">
                <ul>
                    <li><a href="#">3D Model segway vozidla</a></li>
                    <li><a href="#">3D Model hydraulickej sústavy</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div id="registrationModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><?= trans('translation.registration') ?></h4>
                </div>
                <form action="<?= url('users') ?>" method="POST">
                    <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4 col-md-offset-1">
                                        <div class="form-group">
                                            <label for="username">Username <i class="fa fa-asterisk required" aria-hidden="true"></i></label>
                                            <input name="username" type="text" class="form-control" id="username">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email <i class="fa fa-asterisk required" aria-hidden="true"></i></label>
                                            <input name="email" type="email" class="form-control" id="email">
                                        </div>
                                        <div class="form-group">
                                            <label for="passoword">Password <i class="fa fa-asterisk required" aria-hidden="true"></i></label>
                                            <input name="password" type="password" class="form-control" id="passoword">
                                        </div>
                                        <div class="form-group">
                                            <label for="password_repeat">Repeat password <i class="fa fa-asterisk required" aria-hidden="true"></i></label>
                                            <input name="password_repeat" type="password" class="form-control" id="password_repeat">
                                        </div>
                                        <i class="fa fa-asterisk required" aria-hidden="true"></i> - Povinná položka
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success"><?= trans('translation.create') ?></button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div id="gotoTop" style="display: block;"><i class="fa fa-angle-up" aria-hidden="true"></i></div>
</footer>
<script src="<?= url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?= url('assets/js/parallax.min.js') ?>"></script>
<script src="<?= url('assets/js/particles.min.js') ?>"></script>
<script src="<?= url('assets/js/particles-animation.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
<script src="<?= url('assets/js/switchery.min.js') ?>"></script>
<script src="<?= URL::to( '/' ); ?>/assets/administration/plugins/noty/jquery.noty.packaged.min.js"></script>
@yield('custom_bottom_scripts')
<script>
    $('#nav').ready(function () {
        $("#preLoader").hide();
    });
    if (window.innerWidth <= 768) {
        $(".navbar-fixed-top").addClass('navbar-mini');
    }
    $(window).scroll(function () {
        var navbar = $(".navbar-fixed-top");
        if (window.innerWidth <= 768) {
            navbar.addClass('navbar-mini');
            return;
        }
        if ($(".navbar-fixed-top").offset().top > 50) {
            navbar.addClass('navbar-mini');
        } else {
            navbar.removeClass('navbar-mini');
        }
    });
    $(document).ready(function () {
        var elem = document.querySelector('.js-switch');
        var t = 0;
        var input = $('input[name=email]');
        if(elem != null) {
            elem.onchange = function() {
                if (t % 2 == 0) {
                    input.attr('type', 'text');
                    input.attr('name', 'aislogin');
                    input.attr('placeholder', 'AIS login');
                    $('#login-nav').attr('action', baseUrl + '/login/ldap');
                } else {
                    input.attr('type', 'email');
                    input.attr('name', 'email');
                    input.attr('placeholder', 'Email');
                    $('#login-nav').attr('action', baseUrl + '/login/custom');
                }
                t++;
            };
            var switchery = new Switchery(elem, {size: 'small'});
        }

        $('.navbar a.dropdown-toggle').on('click', function (e) {
            var $el = $(this);
            var $parent = $(this).offsetParent(".dropdown-menu");
            $(this).parent("li").toggleClass('open');

            if (!$parent.parent().hasClass('nav')) {
                $el.next().css({"top": $el[0].offsetTop, "left": $parent.outerWidth() - 4});
            }

            $('.nav li.open').not($(this).parents("li")).removeClass("open");

            return false;
        });
        $('#showModal').on('click', function() {
           $('#registrationModal').modal('show');
        });
    });
    $(document).ready(function () {
        $('#generateApiKey').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                method: "post",
                url: "api/generateApiKey",
                dataType: "json",
                data: $('#FormApiKey').serialize(),
                success: function (response) {
                  $('#apikey').text(response.key);
                }
            });
        });

        var scrollHeight = $(document).height();
        var scrollPosition = $(window).height() + $(window).scrollTop();
        if ((scrollHeight == scrollPosition) && ($(window).scrollTop() != 0)) {
            $('#gotoTop').fadeIn();
            console.log('test');
        } else {
            $('#gotoTop').fadeOut();
        }
        $(window).scroll(function () {
            if ($(this).scrollTop() > 100) {
                $('#gotoTop').fadeIn();
            }
            else {
                $('#gotoTop').fadeOut();
            }
        });
        $('#gotoTop').click(function () {
            $('html, body').stop().animate({
                scrollTop: 0
            }, 500, function () {
                $('#goTop').stop().animate({
                    top: '-100px'
                }, 500);
            });
        });
    });
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
@if (Session::has('success'))
    <script>
        generate('success', '<div class="activity-item"> <i class="fa fa-check" aria-hidden="true"></i> <div class="activity"><?= trans('translation.' . Session::get('success')) ?></div> </div>');
    </script>
@elseif (Session::has('warning'))
    <script>
        generate('warning', '<div class="activity-item"> <i class="fa fa-check" aria-hidden="true"></i> <div class="activity"><?= trans('translation.' . Session::get('warning')) ?></div> </div>');
    </script>
@endif

{{--Only logged users can see this--}}
<?php if(Session::get( 'logged_user_id' )): ?>
<div id="apiModal" class="modal fade" tabindex="-2" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?= trans('translation.create_api_key') ?></h4>
            </div>
            <div class="modal-body">
                <strong>Váš api kľúč:</strong>
                <div id="apikey" class="well">
                    <?= isset($user->apikey->key) ? $user->apikey->key : 'Api kľúč je potrebné vygenerovať' ?>
                </div>
                <form id="FormApiKey" action="" method="POST">
                    <input name="_token" type="hidden" id="_token" value="{{ csrf_token() }}"/>
                    <input name="secret" type="hidden" value="<?= encrypt(Session::get('logged_user_id')) ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Zavrieť</button>
                <button id="generateApiKey" type="button" class="btn btn-primary">Generovať</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>
</body>
</html>