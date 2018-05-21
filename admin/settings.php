<?php require_once('includes/header.php'); ?>
<?php require_once('includes/functions.php'); ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php require_once('includes/nav.php'); ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Settings
                        </h1>

                        <?php

                            $query = "SELECT posts_per_page FROM tblsettings";
                            $stmt = mysqli_prepare($connection, $query);
                            checkPreparedStatement($stmt);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt, $posts_per_page);
                            mysqli_stmt_fetch($stmt);
                            mysqli_stmt_close($stmt);

                            if(isset($_POST['save'])) {

                                $posts_per_page = $_POST['posts_per_page'];

                                if($posts_per_page < 5 || $posts_per_page > 50) {
                                    echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                        Number of posts per page must be between 5 and 50.</div>";
                                } else {

                                    $query = '';
                                    $stmt = mysqli_prepare($connection, "UPDATE tblsettings SET posts_per_page = ?");
                                    checkPreparedStatement($stmt);
                                    mysqli_stmt_bind_param($stmt, "i", $posts_per_page);
                                    mysqli_stmt_execute($stmt);
                                    mysqli_stmt_close($stmt);

                                    echo "<div class='alert alert-success alert-dismissible' role='alert'>
                                        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                        Number of posts per page updated</div>";

                                }

                            }

                        ?>

                        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-horizontal">
                        
                            <div class="form-group">
                                <label for="posts_per_page" class="control-label col-sm-3">Number of posts per page </label>
                                <div class="col-sm-2">
                                    <input type="number" name="posts_per_page" id="posts_per_page" class="form-control" min="5" max="50" value="<?php echo isset($posts_per_page) ? $posts_per_page : 5; ?>">
                                </div>
                            </div>
                            
                            <input type="submit" class="btn btn-primary pull-right" name="save" value="Save">
                            
                        </form>

                        

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php require_once('includes/footer.php'); ?>
