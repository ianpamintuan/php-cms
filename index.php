<?php require_once('includes/header.php'); ?>
    
    <?php require_once('includes/nav.php'); ?>

    <?php session_start(); ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    Blog Posts
                </h1>

                <?php
                    
                    $posts_info = array();
                    
                    $query = "SELECT * FROM tblposts WHERE post_status = 'Published'";
                    
                    $result = mysqli_query($connection, $query);
                    
                    if($result) {
                    
                        //add code on counting the result query
                        if(empty($result) || mysqli_num_rows($result) < 1) {
                            echo "<h1 class='page-header'>No published blog posts found.</h1>";
                        }

                        while($row = mysqli_fetch_assoc($result)) {

                            $posts_info['post_id'] = $row['post_id'];
                            $posts_info['post_title'] = $row['post_title'];
                            $posts_info['post_author'] = $row['post_author'];
                            $posts_info['post_date'] = $row['post_date'];
                            $posts_info['post_image'] = $row['post_image'];
                            $posts_info['post_content'] = substr($row['post_content'], 0, 250);
                            
                ?>

                <!--  Blog Post -->
                <h2>
                    <a href="post.php?post_id=<?php echo $posts_info['post_id']; ?>"><?php echo $posts_info['post_title']; ?></a>
                    <?php
                        if(isset($_SESSION['user_id'])) { ?>
                            <a href="admin/posts.php?src=edit_post&edit=<?php echo $posts_info['post_id']; ?>" class="pull-right" style="font-size: 16px;">Edit post</a>
                    <?php                            
                        }
                    ?>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $posts_info['post_author']; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $posts_info['post_date']; ?></p>
                <hr>
                <a href="post.php?post_id=<?php echo $posts_info['post_id']; ?>">
                    <img class="img-responsive" src="images/<?php echo $posts_info['post_image']; ?>" alt="Post image">
                </a>
                <hr>
                <p><?php echo $posts_info['post_content'] . '...'; ?></p>
                <a class="btn btn-primary" href="post.php?post_id=<?php echo $posts_info['post_id']; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

                <?php   }
                        
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