<?php require_once('includes/header.php'); ?>

<!-- Navigation -->

<?php require_once('includes/nav.php'); ?>

<?php

    loggedInRedirect("/php-cms/admin");

    if(isMethod("post")) {

        if(isset($_POST['username']) && isset($_POST['password'])) {

            login($_POST['username'], $_POST['password']);

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

							<h3><i class="fa fa-user fa-4x"></i></h3>
							<h2 class="text-center">Login</h2>
							<div class="panel-body">

								<form id="login-form" role="form" autocomplete="off" class="form" method="post">

									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>

											<input name="username" type="text" class="form-control" placeholder="Username" required>
										</div>
									</div>

									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
											<input name="password" type="password" class="form-control" placeholder="Password" required>
										</div>
									</div>

                                    <div class="form-group">
                                        <a href="/php-cms/forgot.php?token=<?php echo uniqid(true); ?>">Forgot Password</a>
                                    </div>

									<div class="form-group">

										<input name="login" class="btn btn-lg btn-primary btn-block" value="Login" type="submit">
									</div>

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

