<?php require_once('includes/header.php'); ?>

<!-- Navigation -->

<?php require_once('includes/nav.php'); ?>

<?php

    if(!isset($_GET['token'])) {

        header("Location: /php-cms/login");
        exit();
    
    }

    if(isset($_SESSION['user_role'])) {

        header("Location: /php-cms/");
        exit();

    }

    if(isMethod("post")) {

        if(isset($_POST['email'])) {

            $email = $_POST['email'];
            $length = 50;
            $token = bin2hex(openssl_random_pseudo_bytes($length));

            if(userDetailDuplicate("email", $email)) {

                $token_stmt = mysqli_prepare($connection, "UPDATE tblusers SET token = '{$token}' WHERE email = ?");

                checkPreparedStatement($token_stmt);

                mysqli_stmt_bind_param($token_stmt, "s", $email);
                mysqli_stmt_execute($token_stmt);
                mysqli_stmt_close($token_stmt);

                //Configure PHPMailer

                require_once('vendor/phpmailer/phpmailer/src/Exception.php');
                require_once('vendor/phpmailer/phpmailer/src/PHPMailer.php');
                require_once('vendor/phpmailer/phpmailer/src/SMTP.php');
                require_once('/classes/Config.php');
                
                $mail = new PHPMailer\PHPMailer\PHPMailer();

                $mail->isSMTP();
                $mail->Host = Config::SMTP_HOST;
                $mail->Username = Config::SMTP_USER;
                $mail->Password = Config::SMTP_PASSWORD;
                $mail->Port = Config::SMTP_PORT;
                $mail->SMTPSecure = 'tls';
                $mail->SMTPAuth = true;

                $mail->setFrom('ianpamintuan@gmail.com', 'Mark Ian Pamintuan');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->CharSet = 'utf-8';
                $mail->Subject = 'Password Reset';
                $mail->Body    = "<p>Click the link the reset your password <a href='http://localhost/php-cms/reset.php?email={$email}&token={$token}'>here</a> </p>"; 
                
                if($mail->send()) {
                    $message = 'Sent';
                } else {
                    $message = 'Failed';
                }

            } else {

                $message = 'Unregistered';

            }

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
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>

                                <?php 
            
                                    if(isset($message)) {

                                        if($message == 'Sent') {

                                            echo "<div class='alert alert-success alert-dismissible' role='alert'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden=true'>&times;</span></button>
                                            Message has been sent! You can check your email.</div>";
                                            exit();

                                        } elseif($message == 'Failed') {

                                            echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden=true'>&times;</span></button>
                                            Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";

                                        } elseif($message == 'Unregistered') {

                                            echo "<div class='alert alert-warning alert-dismissible' role='alert'>
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden=true'>&times;</span></button>
                                            Your email is not yet registered within our system.</div>";

                                        }

                                    } 

                                ?>

                                <div class="panel-body">

                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <hr>

    <?php require_once('includes/footer.php');?>

</div> <!-- /.container -->