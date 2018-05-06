<?php require_once('includes/header.php'); ?>

    <!-- Navigation -->
    
    <?php require_once('includes/nav.php'); ?>
 
    <!-- Page Content -->
    <div class="container">
    
        <section id="login">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        
                        <?php

                            if(isset($_SESSION['user_role'])) {
                                header("Location: index.php");
                                exit();
                            }
                        
                            if(isset($_POST['submit'])) {

                                $user_info = array();

                                $user_info['first_name'] = $_POST['first-name'];
                                $user_info['last_name'] = $_POST['last-name'];
                                $user_info['email'] = $_POST['email'];
                                $user_info['username'] = $_POST['username'];
                                $user_info['password'] = $_POST['password'];

                                foreach($user_info as $info) {
                                    if(empty($info)) {
                                        echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                        Please complete all the required fields.</div>";
                                        break;
                                    }
                                }

                                if(userDetailDuplicate("username", $user_info['username'])) {

                                    echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                    Username already exists.</div>";

                                } else if(userDetailDuplicate("email", $user_info['email'])) {

                                    echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                    Email already exists.</div>";

                                } else {

                                    foreach($user_info as $key => $value) {
                                        $user_info[$key] = clean($value);
                                    }

                                    $hashed_password = password_hash($user_info['password'], PASSWORD_DEFAULT);

                                    register($user_info['first_name'], $user_info['last_name'], $user_info['email'], $user_info['username'], $hashed_password);

                                    echo "<div class='alert alert-success alert-dismissible' role='alert'>
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                    Your registration has been submitted. <a href='index.php#login_form'>Login</a></div>";

                                    unset($user_info);

                                }

                            }

                        ?>

                        <div class="form-wrap">
                        <h1>Register</h1>
                            <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                                <div class="form-group">
                                    <label for="first-name" class="sr-only">First Name</label>
                                    <input type="text" name="first-name" id="first-name" class="form-control" placeholder="First Name" value="<?php echo isset($user_info['first_name']) ? $user_info['first_name'] : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="last-name" class="sr-only">Last Name</label>
                                    <input type="text" name="last-name" id="last-name" class="form-control" placeholder="Last Name" value="<?php echo isset($user_info['last_name']) ? $user_info['last_name'] : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="name@domain.com" value="<?php echo isset($user_info['email']) ? $user_info['email'] : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="username" class="sr-only">username</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="<?php echo isset($user_info['username']) ? $user_info['username'] : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="sr-only">Password</label>
                                    <input type="password" name="password" id="key" class="form-control" placeholder="Password" value="<?php echo isset($user_info['password']) ? $user_info['password'] : ''; ?>" required>
                                </div>
                        
                                <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                            </form>
                        
                        </div>
                    </div> <!-- /.col-xs-12 -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </section>

        <hr>

<?php include "includes/footer.php";?>
