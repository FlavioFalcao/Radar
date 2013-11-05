<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Radar</title>
        <meta name="description" content="An RSS Reader">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="/assets/css/main.css">

        <!--[if lt IE 9]>
            <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
            <script>window.html5 || document.write('<script src="/assets/js/vendor/html5shiv.js"><\/script>')</script>
        <![endif]-->
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <div class="wrapper">

            <header class="clearfix">
                <nav class="navbar navbar-inverse navbar-static-top"
                    role="navigation">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle"
                            data-toggle="collapse" data-target="#navLinks">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand site-logo" href="/">Radar</a>
                    </div>

                    <div class="collapse navbar-collapse" id="navLinks">
                        <ul class="nav navbar-nav">
                            <li><a href="/feeds" title="Feeds">Feeds</a></li>
                            <li><a href="/about" title="About">About</a></li>
                        </ul>
                        <p class="navbar-text pull-right">
                            <?php if (User::current()) : ?>
                                <?php $user = User::find($_SESSION['user_id']); ?>
                                <a class="navbar-link" href="/signout"
                                    title="Sign out">
                                    <span class="glyphicon glyphicon-user"></span> 
                                    <?php echo html($user->username); ?>
                                </a>
                            <?php else : ?>
                                <a class="navbar-link" href="/signin"
                                    title="Sign in">
                                    <span class="glyphicon glyphicon-user"></span> 
                                    Sign in
                                </a>
                            <?php endif; ?>
                        </p>
                    </div>
                </nav>
            </header>


            <div class="container">

                <section class="content">

