<?php require_once('db.php'); ?>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">MyCMS</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php getCategories(); ?>
                    <?php

                        $pages = array(
                            'Registration' => 'registration.php',
                            'Contact' => 'contact.php'
                        );

                        $class = "";

                        $page_name = basename($_SERVER['PHP_SELF']);

                        foreach($pages as $page => $url) {

                            echo $url . " " . $page;

                            if($url == $page_name) {
                                echo "<li class='active'><a href='/php-cms/{$url}'>{$page}</a></li>";
                            } else {
                                echo "<li><a href='/php-cms/{$url}'>{$page}</a></li>";
                            }

                        }

                    ?>
                    
                    <li><a href="/php-cms/admin">Admin</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>