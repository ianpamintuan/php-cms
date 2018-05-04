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
                        
                            if(isset($_POST['submit'])) {
                                
                                $first_name = clean($_POST['first-name']);
                                $last_name = clean($_POST['last-name']);
                                $username = clean($_POST['username']);
                                $email = clean($_POST['email']);
                                $password = clean($_POST['password']);

                                if(!empty($first_name) && !empty($last_name) && !empty($username) && !empty($email) && !empty($password)) {

                                    if(userDetailDuplicate("username", $username)) {

                                        echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                        Username already exists.</div>";

                                    } else if(userDetailDuplicate("email", $email)) {

                                        echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                        Email already exists.</div>";

                                    } else {

                                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                                        register($first_name, $last_name, $email, $username, $hashed_password);

                                        $first_name = "";
                                        $last_name = "";
                                        $username = "";
                                        $email = "";
                                        $password = "";

                                        echo "<div class='alert alert-success alert-dismissible' role='alert'>
                                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                        Your registration has been submitted.</div>";

                                    }

                                } else {

                                    echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                    Please complete all the required fields.</div>";

                                }
                                
                            }

                        ?>

                        <div class="form-wrap">
                        <h1>Register</h1>
                            <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                                <div class="form-group">
                                    <label for="first-name" class="sr-only">First Name</label>
                                    <input type="text" name="first-name" id="first-name" class="form-control" placeholder="First Name" value="<?php echo isset($first_name) ? $first_name : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="last-name" class="sr-only">Last Name</label>
                                    <input type="text" name="last-name" id="last-name" class="form-control" placeholder="Last Name" value="<?php echo isset($last_name) ? $last_name : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="username" class="sr-only">username</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="<?php echo isset($username) ? $username : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="name@domain.com" value="<?php echo isset($email) ? $email : ''; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="sr-only">Password</label>
                                    <input type="password" name="password" id="key" class="form-control" placeholder="Password" value="<?php echo isset($password) ? $password : ''; ?>" required>
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
