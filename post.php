<?php require_once('includes/header.php'); ?>

    <?php require_once('includes/nav.php'); ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php
                    
                    if(isset($_GET['post_id'])) {
                        $post_id = clean($_GET['post_id']);
                    }

                    $posts_info = array();

                    $post_stmt = mysqli_prepare($connection, "SELECT * FROM tblposts JOIN tblusers ON tblusers.user_id = tblposts.post_author WHERE post_id = ?");
                    
                    checkPreparedStatement($post_stmt);

                    mysqli_stmt_bind_param($post_stmt, "i", $post_id);
                    mysqli_stmt_execute($post_stmt);
                    $result = mysqli_stmt_get_result($post_stmt);

                    if($post_id == NULL || !is_numeric($post_id) || mysqli_num_rows($result) == NULL) {

                        header("Location: /php-cms/");
                        exit();

                    }
                    
                    while($row = mysqli_fetch_assoc($result)) {

                        $posts_info['post_id'] = $row['post_id'];
                        $posts_info['post_title'] = $row['post_title'];
                        $posts_info['post_author'] = $row['username'];
                        $posts_info['post_date'] = $row['post_date'];
                        $posts_info['post_image'] = $row['post_image'];
                        $posts_info['post_content'] = $row['post_content'];
                            
                ?>

                <!--  Blog Post -->
                <h1 class="page-header">
                    <a href="/php-cms/post/<?php echo $posts_info['post_id']; ?>"><?php echo $posts_info['post_title']; ?></a>
                    <?php
                        if(isset($_SESSION['user_id'])) { ?>
                            <a href="/php-cms/admin/posts.php?src=edit_post&edit=<?php echo $posts_info['post_id']; ?>" class="pull-right" style="font-size: 16px;">Edit post</a>
                    <?php                            
                        }
                    ?>
                </h1>
                <p class="lead">
                    by <a href="/php-cms/author/<?php echo $posts_info['post_author']; ?>"><?php echo $posts_info['post_author']; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $posts_info['post_date']; ?></p>
                <hr>
                <img class="img-responsive" src="/php-cms/images/<?php echo $posts_info['post_image']; ?>" alt="">
                <hr>
                <p><?php echo $posts_info['post_content']; ?></p>

                <hr>

                <?php   }   ?>

                <!-- Blog Comments -->

                <?php

                    if(isset($_POST['create_comment'])) {

                        $post_id = $_GET['post_id'];

                        $comment_author = clean($_POST['comment_author']);
                        $comment_content = clean($_POST['comment_content']);
                        $comment_email = clean($_POST['comment_email']);

                        if(!empty($comment_author) && !empty($comment_content) && !empty($comment_email)) {

                            date_default_timezone_set("Asia/Taipei");
                            $comment_date = date("Y-m-d");

                            $comment_stmt = mysqli_prepare($connection, "INSERT INTO tblcomments(comment_author, comment_email, comment_content, comment_date, post_id) VALUES(?, ?, ?, ?, ?)");
                            
                            checkPreparedStatement($comment_stmt);
                            
                            mysqli_stmt_bind_param($comment_stmt, "ssssi", $comment_author, $comment_email, $comment_content, $comment_date, $post_id);
                            mysqli_stmt_execute($comment_stmt);

                            echo "<div class='alert alert-success alert-dismissible' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                            Thanks for commenting. Your comment is now submitted for review. </div>";

                        } else {

                            echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                            Please complete all the fields required. </div>";

                        }

                    }

                ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form method="post" role="form">
                        <div class="form-group">
                            <input type="text" class="form-control" name="comment_author" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="comment_email" placeholder="Your Email" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="3" placeholder="Enter your comment" name="comment_content" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <?php

                    $comment_status = "Approved";

                    $comments_stmt = mysqli_prepare($connection, "SELECT * FROM tblcomments WHERE post_id = ? AND comment_status = ? ORDER BY comment_id DESC");
                    
                    checkPreparedStatement($comments_stmt);

                    mysqli_stmt_bind_param($comments_stmt, "is", $post_id, $comment_status);
                    mysqli_stmt_execute($comments_stmt);
                    $comments_result = mysqli_stmt_get_result($comments_stmt);

                    while($row = mysqli_fetch_assoc($comments_result)) {

                        $comment_author = $row['comment_author'];
                        $comment_content = $row['comment_content'];
                        $comment_date = $row['comment_date'];
                    
                ?>

                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $comment_author; ?>
                                    <small><?php echo $comment_date; ?></small>
                                </h4>
                                <?php echo $comment_content; ?>
                            </div>
                        </div>

                <?php   }   ?>
                
                <!-- Pager -->
                <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul>

            </div>

            <?php

                $views_stmt = mysqli_prepare($connection, "UPDATE tblposts SET post_views_count = post_views_count + 1 WHERE post_id = ?");
                
                checkPreparedStatement($views_stmt);
                
                mysqli_stmt_bind_param($views_stmt, "i", $post_id);
                mysqli_stmt_execute($views_stmt);

            ?>

            <!-- Blog Sidebar Widgets Column -->
            <?php require_once('includes/sidebar.php') ?>

        <hr>

<!-- Footer -->
<?php require_once('includes/footer.php') ?>