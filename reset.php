<?php require_once('includes/header.php'); ?>

<!-- Navigation -->

<?php require_once('includes/nav.php'); ?>

<?php

    if(!isset($_GET['email']) || !isset($_GET['token']) || isset($_SESSION['user_role'])) {

        header("Location: /php-cms/");
        exit();

    }

    $email = $_GET['email'];
    $token = $_GET['token'];

    $user_info_stmt = mysqli_prepare($connection, "SELECT username, email, token FROM tblusers WHERE token = ? AND email = ?");

    checkPreparedStatement($user_info_stmt);

    mysqli_stmt_bind_param($user_info_stmt, "ss", $token, $email);
    mysqli_stmt_execute($user_info_stmt);
    mysqli_stmt_bind_result($user_info_stmt, $username, $email, $token);
    mysqli_stmt_fetch($user_info_stmt);
    mysqli_stmt_close($user_info_stmt);

    if(isset($_POST['password']) && isset($_POST['confirm_password'])) {

        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if(strcmp($password, $confirm_password) == 0) {
            
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $update_password_stmt = mysqli_prepare($connection, "UPDATE tblusers SET password = ?, token = '' WHERE email = ?");

            checkPreparedStatement($update_password_stmt);

            mysqli_stmt_bind_param($update_password_stmt, "ss", $hashed_password, $email);
            mysqli_stmt_execute($update_password_stmt);

            $message = "Success";

        } else {
            $message = "Not Match";
        }

    }

?>

<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">

            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Reset Password?</h2>
                                <p>You can reset your password here.</p>

                                <?php

                                    $show_form = true;
                                
                                    if(!isset($email)) {
                                        
                                        echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden=true'>&times;</span></button>
                                        The email or token is not valid</div>";

                                        $show_form = false;

                                    } else {

                                        if(isset($message)) {

                                            if($message == "Success") {
    
                                                echo "<div class='alert alert-success alert-dismissible' role='alert'>
                                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden=true'>&times;</span></button>
                                                Your password have been reset. You can <a href='/php-cms/login'>login</a> now.</div>";

                                                $show_form = false;
    
                                            } elseif($message == "Not Match") {
    
                                                echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden=true'>&times;</span></button>
                                                The passwords does not match!</div>";
    
                                                $show_form = true;

                                            }
    
                                        }

                                        if($show_form) {

                                ?>

                                <div class="panel-body">

                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                                <input id="password" name="password" placeholder="New Password" class="form-control"  type="password" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                                                <input id="confirm_password" name="confirm_password" placeholder="Confirm Password" class="form-control"  type="password" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                                <?php

                                        }
                                    }

                                ?>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <hr>

    <?php require_once('includes/footer.php');?>

</div> <!-- /.container -->
