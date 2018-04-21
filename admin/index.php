<?php require_once('includes/header.php'); ?>
<?php require_once('../includes/db.php'); ?>

<?php

    $posts_query = "SELECT COUNT(post_id) AS posts_count FROM tblposts";
    $posts_result = mysqli_query($connection, $posts_query);

    if(!$posts_result) {
        die("SQL Error " . mysqli_error($connection));
    } else {
        while($row = mysqli_fetch_array($posts_result)) {
            $posts_count = $row['posts_count'];
        }
    }

    $draft_posts_query = "SELECT COUNT(post_id) AS draft_posts_count FROM tblposts WHERE post_status = 'Draft'";
    $draft_posts_result = mysqli_query($connection, $draft_posts_query);

    if(!$draft_posts_result) {
        die("SQL Error " . mysqli_error($connection));
    } else {
        while($row = mysqli_fetch_array($draft_posts_result)) {
            $draft_posts_count = $row['draft_posts_count'];
        }
    }

    $published_posts_query = "SELECT COUNT(post_id) AS published_posts_count FROM tblposts WHERE post_status = 'Published'";
    $published_posts_result = mysqli_query($connection, $published_posts_query);

    if(!$published_posts_result) {
        die("SQL Error " . mysqli_error($connection));
    } else {
        while($row = mysqli_fetch_array($published_posts_result)) {
            $published_posts_count = $row['published_posts_count'];
        }
    }

    $comments_query = "SELECT COUNT(comment_id) AS comments_count FROM tblcomments";
    $comments_result = mysqli_query($connection, $comments_query);

    if(!$comments_result) {
        die("SQL Error " . mysqli_error($connection));
    } else {
        while($row = mysqli_fetch_array($comments_result)) {
            $comments_count = $row['comments_count'];
        }
    }

    $approved_comments_query = "SELECT COUNT(comment_id) AS approved_comments_count FROM tblcomments WHERE comment_status = 'Approved'";
    $approved_comments_result = mysqli_query($connection, $approved_comments_query);

    if(!$approved_comments_result) {
        die("SQL Error " . mysqli_error($connection));
    } else {
        while($row = mysqli_fetch_array($approved_comments_result)) {
            $approved_comments_count = $row['approved_comments_count'];
        }
    }

    $unapproved_comments_query = "SELECT COUNT(comment_id) AS unapproved_comments_count FROM tblcomments WHERE comment_status = 'Unapproved'";
    $unapproved_comments_result = mysqli_query($connection, $unapproved_comments_query);

    if(!$unapproved_comments_result) {
        die("SQL Error " . mysqli_error($connection));
    } else {
        while($row = mysqli_fetch_array($unapproved_comments_result)) {
            $unapproved_comments_count = $row['unapproved_comments_count'];
        }
    }

    $users_query = "SELECT COUNT(user_id) AS users_count FROM tblusers";
    $users_result = mysqli_query($connection, $users_query);

    if(!$users_result) {
        die("SQL Error " . mysqli_error($connection));
    } else {

        while($row = mysqli_fetch_array($users_result)) {
            $users_count = $row['users_count'];
        }

    }

    $category_query = "SELECT COUNT(category_id) AS category_count FROM tblcategories";
    $category_result = mysqli_query($connection, $category_query);

    if(!$category_result) {
        die("SQL Error " . mysqli_error($connection));
    } else {

        while($row = mysqli_fetch_array($category_result)) {
            $category_count = $row['category_count'];
        }

    }

?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php require_once('includes/nav.php'); ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome
                            <small><?php echo $_SESSION['first_name']; ?></small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
                
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <div class='huge'><?php echo $posts_count; ?></div>
                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <div class='huge'><?php echo $comments_count; ?></div>
                                    <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <div class='huge'><?php echo $users_count; ?></div>
                                        <div> Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class='huge'><?php echo $category_count; ?></div>
                                        <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                
                <script type="text/javascript">
                    google.charts.load('current', {'packages':['bar']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                        ['Data', 'Count'],
                        ['Draft Posts', <?php echo $draft_posts_count; ?>],
                        ['Published Posts', <?php echo $published_posts_count; ?>],
                        ['Approved Comments', <?php echo $approved_comments_count; ?>],
                        ['Unapproved Comments', <?php echo $unapproved_comments_count; ?>],
                        ['Users', <?php echo $users_count; ?>],
                        ['Categories', <?php echo $category_count; ?>],
                        ]);

                        var options = {
                        chart: {
                            title: '',
                            subtitle: '',
                        }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                </script>

                <div id="columnchart_material" style="width: auto; height: 500px;"></div>

                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php require_once('includes/footer.php'); ?>