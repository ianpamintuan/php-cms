<?php require_once('db.php'); ?>

            <div class="col-md-4">

                <!-- Login Well -->
                <div class="well" id="login_form">

                     <?php
                    
                    if(isset($_SESSION['username'])) {

                    ?>
                        <h3>Logged in as <span class="label label-primary"><?php echo $_SESSION['username']; ?></span></h3>
                        <a href="includes/logout.php" class="btn btn-danger">Logout</a>
                    <?php

                        } else {

                            if(isset($_GET['login'])) {

                                $message = $_GET['login'];

                                if($message == 'error') {

                                    echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                    Incorrect username or password.</div>";

                                }
              
                            }

                    ?>

                        <h4>Login Form</h4>
                        <form action="includes/login.php" method="POST">
                            <div class="form-group">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            </div>
                            
                            <button class="btn btn-primary" type="submit" name="login">
                                Login
                            </button>

                            <a href="registration.php" class="btn btn-default">Register</a>
                            
                        </form>
                        <!-- /.input-group -->
                    
                    <?php

                        }
                        
                    ?>
                </div>

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <form action="search.php">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <span class="glyphicon glyphicon-search"></span>
                            </button>
                            </span>
                        </div>
                    </form>
                    <!-- /.input-group -->
                </div>

                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">
                                <?php getCategories(); ?>
                            </ul>
                        </div>
                        <!-- /.col-lg-6 -->
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <div class="well">
                    <h4>Side Widget Well</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
                </div>

            </div>

        </div>
        <!-- /.row -->