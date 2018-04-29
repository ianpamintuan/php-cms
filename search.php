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
    
                        $search = $_GET['search'];
    
                        $query = "SELECT * FROM tblposts WHERE post_tags LIKE '%$search%';";
    
                        $result = mysqli_query($connection, $query);
    
                        if($result) {
                                
                            $count = mysqli_num_rows($result);
    
                            if($count == 0) {
                                echo "<p>No result found.</p>";
                            } else {
                                
                                $posts_info = array();
                                
                                while($row = mysqli_fetch_assoc($result)) {
            
                                    $posts_info['post_id'] = $row['post_id'];
                                    $posts_info['post_title'] = $row['post_title'];
                                    $posts_info['post_author'] = $row['post_author'];
                                    $posts_info['post_date'] = $row['post_date'];
                                    $posts_info['post_image'] = $row['post_image'];
                                    $posts_info['post_content'] = $row['post_content'];
                                        
                                ?>
                
                                <!--  Blog Post -->
                                <h2>
                                <a href="post.php?post_id=<?php echo $posts_info['post_id']; ?>"><?php echo $posts_info['post_title']; ?></a>
                                </h2>
                                <p class="lead">
                                    by <a href="author_posts.php?post_author=<?php echo $posts_info['post_author']; ?>"><?php echo $posts_info['post_author']; ?></a>
                                </p>
                                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $posts_info['post_date']; ?></p>
                                <hr>
                                <img class="img-responsive" src="images/<?php echo $posts_info['post_image']; ?>" alt="">
                                <hr>
                                <p><?php echo $posts_info['post_content']; ?></p>
                                <a class="btn btn-primary" href="post.php?post_id=<?php echo $posts_info['post_id']; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                
                                <hr>
                
                            <?php   }
                
                            }
    
                        } else {
                            die("Query failed!" . mysqli_error($connection));
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