<?php require_once('includes/header.php'); ?>

    <?php require_once('includes/nav.php'); ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    Blog Posts
                </h1>

                <?php

                    if(isset($_GET['search']) ) {
    
                        $search = "%" . clean($_GET['search']) . "%";

                        $post_status = "Published";

                        $search_stmt = mysqli_prepare($connection, "SELECT * FROM tblposts JOIN tblusers ON tblusers.user_id = tblposts.post_author WHERE post_tags LIKE ? AND post_status = ? ORDER BY post_id DESC");

                        checkPreparedStatement($search_stmt);

                        mysqli_stmt_bind_param($search_stmt, "ss", $search, $post_status);
                        mysqli_stmt_execute($search_stmt);
                        $result = mysqli_stmt_get_result($search_stmt);
                                
                        $count = mysqli_num_rows($result);

                        if($count == 0) {
                            echo "<p>No result found.</p>";
                        } else {
                            
                            $posts_info = array();
                            
                            while($row = mysqli_fetch_assoc($result)) {
        
                                $posts_info['post_id'] = $row['post_id'];
                                $posts_info['post_title'] = $row['post_title'];
                                $posts_info['post_author'] = $row['username'];
                                $posts_info['post_date'] = $row['post_date'];
                                $posts_info['post_image'] = $row['post_image'];
                                $posts_info['post_content'] = $row['post_content'];
                                    
                            ?>
            
                            <!--  Blog Post -->
                            <h2>
                            <a href="/php-cms/post/<?php echo $posts_info['post_id']; ?>"><?php echo $posts_info['post_title']; ?></a>
                            </h2>
                            <p class="lead">
                                by <a href="author/<?php echo $posts_info['post_author']; ?>"><?php echo $posts_info['post_author']; ?></a>
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $posts_info['post_date']; ?></p>
                            <hr>
                            <img class="img-responsive" src="images/<?php echo $posts_info['post_image']; ?>" alt="">
                            <hr>
                            <p><?php echo $posts_info['post_content']; ?></p>
                            <a class="btn btn-primary" href="/php-cms/post/<?php echo $posts_info['post_id']; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
            
                            <hr>
            
                        <?php   }
            
                        }
    
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