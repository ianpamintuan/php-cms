<?php require_once('includes/header.php'); ?>

    <?php require_once('includes/nav.php'); ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php

                    if(isset($_GET['category'])) {
                        $category_id = clean($_GET['category']);
                    } else {
                        header("Location: index.php");
                        exit();
                    }

                    $category_stmt = mysqli_prepare($connection, "SELECT category_title FROM tblcategories WHERE category_id = ?");

                    checkPreparedStatement($category_stmt);

                    mysqli_stmt_bind_param($category_stmt, "i", $category_id);
                    mysqli_stmt_execute($category_stmt);
                    mysqli_stmt_bind_result($category_stmt, $category_title);

                    while(mysqli_stmt_fetch($category_stmt)) {
                        $category = $category_title;
                    }

                    ?>

                    <h1 class="page-header">
                        <?php

                            if(mysqli_stmt_num_rows($category_stmt) > 0) {
                                echo $category;
                            } else {
                                echo "Category not found.";
                            }
                        ?>
                    </h1>
                    
                    <?php

                    $posts_info = array();

                    $post_status = "Published";

                    $posts_stmt = mysqli_prepare($connection, "SELECT * FROM tblposts JOIN tblusers ON tblusers.user_id = tblposts.post_author WHERE category_id = ? AND post_status = ? ORDER BY post_id DESC");

                    checkPreparedStatement($posts_stmt);

                    mysqli_stmt_bind_param($posts_stmt, "is", $category_id, $post_status);
                    mysqli_stmt_execute($posts_stmt);
                    $result = mysqli_stmt_get_result($posts_stmt);

                    while($row = mysqli_fetch_array($result)) {

                        $posts_info['post_id'] = $row['post_id'];
                        $posts_info['post_title'] = $row['post_title'];
                        $posts_info['post_author'] = $row['username'];
                        $posts_info['post_date'] = $row['post_date'];
                        $posts_info['post_image'] = $row['post_image'];
                        $posts_info['post_content'] = substr($row['post_content'], 0, 250);
                            
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
                <p><?php echo $posts_info['post_content'] . '...'; ?></p>
                <a class="btn btn-primary" href="post.php?post_id=<?php echo $posts_info['post_id']; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

                <?php
                    
                    }

                    if($result->num_rows < 1) {
                        echo "<h1 class='page-header'>No result found for this category.</h1>";
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