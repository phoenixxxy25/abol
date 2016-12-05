<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="/css/font-awesome.css">
    <!-- Styles -->
    <?php /* <link href="<?php echo e(elixir('css/app.css')); ?>" rel="stylesheet"> */ ?>

    <style>
        body { font-family: 'century gothic';}
        .fa-btn{ margin-right: 6px;}
        .mycomment{ background: #e6e6ff; padding: 5px; margin-bottom: 4px; border-radius: 4px;}
        .spanImgToDel{ color: red; font-family: century gothic; margin-left: 60px; display: none;}
        .h1Err{ background: #e2aeae; padding: 5px;}
    </style>
</head>
<body id="app-layout" >
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                    Laravel
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo e(url('/home')); ?>">Home</a></li>
                </ul>
                    
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li>
                     <form method="POST" action="<?php echo e(url('/search')); ?>"> </li>
                     <li><input type="text" name="searchobj" class="form-control" style="margin-top: 10px;" placeholder="Поиск" required /></li>
                     <li><input type="submit" class="btn btn-default" style="margin-top: 10px;" /></li>
                    <li> </form>
                    </li>
                    <?php if(Auth::guest()): ?>
                        <li><a href="<?php echo e(url('/login')); ?>">Login</a></li>
                        <li><a href="<?php echo e(url('/register')); ?>">Register</a></li>
                    <?php else: ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="font-size: 22px; font-family: century gothic;">
                                <?php echo e(Auth::user()->login); ?> <span class="caret"></span>
                            </a>    


                            <ul class="dropdown-menu" role="menu" >
                                <?php if(Auth::user()->group == 3): ?>
                                <li><a href="<?php echo e(url('/admin')); ?>"><i class="fa fa-btn fa-user"></i>AdminPanel</a></li>
                                <?php endif; ?>
                                <li><a href="<?php echo e(url('/profile')); ?>"><i class="fa fa-btn fa-user"></i>Profile</a></li>
                                <li><a href="<?php echo e(url('/dologout')); ?>"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
   


    <?php echo $__env->yieldContent('content'); ?>
   


    <!-- JavaScripts -->
    <script src="/js/ajx.jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <?php /* <script src="<?php echo e(elixir('js/app.js')); ?>"></script> */ ?>
</body>
</html>
