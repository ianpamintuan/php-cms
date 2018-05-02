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
                            Comments
                        </h1>

                        <?php
                        
                            if(isset($_GET['src'])) {
                                $src = clean($_GET['src']);
                            } else {
                                $src = "";
                            }

                            switch($src) {

                                case 'add_comment':
                                require_once('includes/add_comment.php');
                                break;

                                case 'edit_comment':
                                require_once('includes/edit_comment.php');
                                break;

                                default:
                                require_once('includes/view_all_comments.php');

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
