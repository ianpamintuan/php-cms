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
                            Posts
                        </h1>

                        <?php
                        
                            if(isset($_GET['src'])) {
                                $src = $_GET['src'];
                            } else {
                                $src = "";
                            }

                            switch($src) {

                                case 'add_post':
                                require_once('includes/add_post.php');
                                break;

                                case 'edit_post':
                                require_once('includes/edit_post.php');
                                break;

                                default:
                                require_once('includes/view_all_posts.php');

                            }

                        ?>                        

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
