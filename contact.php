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
                        
                            if(isset($_POST['send'])) {

                                $to = "ianpamintuan06@gmail.com";
                                $email = clean($_POST['email']);
                                $subject = clean($_POST['subject']);
                                $message = clean($_POST['message']);
                                $message = wordwrap($message,70);

                                $headers = "From: {$email}";

                                if(!empty($email) && !empty($subject) && !empty($message)) {

                                    if(mail($to, $subject, $message, $headers)) {

                                        echo "<div class='alert alert-success alert-dismissible' role='alert'>
                                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                        Message sent! Thank you for contacting us.</div>";

                                    }

                                } else {

                                    echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                    Please complete all the required fields.</div>";

                                }
                                
                            }

                        ?>

                        <div class="form-wrap">
                        <h1>Contact</h1>
                            <form role="form" action="contact.php" method="post" id="login-form" autocomplete="off">
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="name@domain.com" required>
                                </div>
                                <div class="form-group">
                                    <label for="subject" class="sr-only">Subject</label>
                                    <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject" required>
                                </div>
                                <div class="form-group">
                                    <textarea name="message" id="message" cols="30" rows="10" class="form-control" placeholder="Message" required></textarea>
                                </div>
                        
                                <input type="submit" name="send" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Send">
                            </form>
                        
                        </div>
                    </div> <!-- /.col-xs-12 -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </section>

        <hr>

<?php include "includes/footer.php";?>
