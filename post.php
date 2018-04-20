<?php require_once('includes/header.php'); ?>

    <?php require_once('includes/nav.php'); ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php
                    
                    if(isset($_GET['post_id'])) {
                        $post_id = $_GET['post_id'];
                    }

                    $posts_info = array();
                    
                    $query = "SELECT * FROM tblposts WHERE post_id = {$post_id}";
                    
                    $result = mysqli_query($connection, $query);
                    
                    if($result) {
                    
                        while($row = mysqli_fetch_assoc($result)) {

                            $posts_info['post_title'] = $row['post_title'];
                            $posts_info['post_author'] = $row['post_author'];
                            $posts_info['post_date'] = $row['post_date'];
                            $posts_info['post_image'] = $row['post_image'];
                            $posts_info['post_content'] = $row['post_content'];
                            
                ?>

                <!--  Blog Post -->
                <h1 class="page-header">
                <?php echo $posts_info['post_title']; ?>
                </h1>
                <p class="lead">
                    by <a href="index.php"><?php echo $posts_info['post_author']; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $posts_info['post_date']; ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $posts_info['post_image']; ?>" alt="">
                <hr>
                <p><?php echo $posts_info['post_content']; ?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

                <?php   }
                    
                    }

                ?>

                <!-- Blog Comments -->

                <?php

                    if(isset($_POST['create_comment'])) {

                        $post_id = $_GET['post_id'];

                        $comment_author = $_POST['comment_author'];
                        $comment_content = $_POST['comment_content'];
                        $comment_email = $_POST['comment_email'];

                        $query = "INSERT INTO tblcomments(comment_author, comment_email, comment_content, comment_status, comment_date, post_id) VALUES('{$comment_author}', '{$comment_email}', '{$comment_content}', 'Unapproved', now(), {$post_id})";
                        $result = mysqli_query($connection, $query);

                        if(!$result) {
                            die("SQL Error " . mysqli_error($connection));
                        } else {
                            echo "Your comment is now submitted for review.";
                        }
                    }

                ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form method="post" role="form">
                        <div class="form-group">
                            <input type="text" class="form-control" name="comment_author" placeholder="Your Name">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="comment_email" placeholder="Your Email">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="3" placeholder="Enter your comment" name="comment_content"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <?php

                    $comments_query = "SELECT * FROM tblcomments WHERE post_id = {$post_id} AND comment_status = 'Approved' ORDER BY comment_id DESC";
                    $comments_result = mysqli_query($connection, $comments_query);

                    if($comments_result) {

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

                        <?php
                        }

                    } else {
                        die('Query failed ' . mysqli_error($connection));
                    }

                ?>
                
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

            <!-- Blog Sidebar Widgets Column -->
            <?php require_once('includes/sidebar.php') ?>

        <hr>

<!-- Footer -->
<?php require_once('includes/footer.php') ?>