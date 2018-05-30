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

                    $posts_per_page = 5;

                    $query = "SELECT posts_per_page FROM tblsettings";
                    $stmt = mysqli_prepare($connection, $query);
                    checkPreparedStatement($stmt);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $posts_per_page);
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_close($stmt);

                    if(isset($_GET['page'])) {

                        $page = clean($_GET['page']);

                    } else {

                        $page = "";

                    }

                    if($page === "" || $page === 1) {

                        $offset = 0;

                    } else {

                        $offset = ($page * $posts_per_page) - $posts_per_page;

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

                    $posts_count_stmt = mysqli_prepare($connection, "SELECT * FROM tblposts JOIN tblusers ON tblusers.user_id = tblposts.post_author WHERE category_id = ? AND post_status = ?");
                    
                    mysqli_stmt_bind_param($posts_count_stmt, "is", $category_id, $post_status);
                    mysqli_stmt_execute($posts_count_stmt);
                    $posts_count_result = mysqli_stmt_get_result($posts_count_stmt);

                    checkPreparedStatement($posts_count_stmt);

                    $posts_count = mysqli_num_rows($posts_count_result);

                    $pagination = ceil($posts_count / $posts_per_page);

                    $posts_stmt = mysqli_prepare($connection, "SELECT * FROM tblposts JOIN tblusers ON tblusers.user_id = tblposts.post_author WHERE category_id = ? AND post_status = ? ORDER BY post_id DESC LIMIT ?, ?");

                    checkPreparedStatement($posts_stmt);

                    mysqli_stmt_bind_param($posts_stmt, "isii", $category_id, $post_status, $offset, $posts_per_page);
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
                    <a href="/php-cms/post/<?php echo $posts_info['post_id']; ?>"><?php echo $posts_info['post_title']; ?></a>
                </h2>
                <p class="lead">
                    by <a href="/php-cms/author/<?php echo $posts_info['post_author']; ?>"><?php echo $posts_info['post_author']; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $posts_info['post_date']; ?></p>
                <hr>
                <img class="img-responsive" src="<?php echo imagePlaceholder($posts_info['post_image']); ?>" alt="">
                <hr>
                <p><?php echo $posts_info['post_content'] . '...'; ?></p>
                <a class="btn btn-primary" href="/php-cms/post/<?php echo $posts_info['post_id']; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

                <?php
                    
                    }

                    if($result->num_rows < 1) {
                        echo "<h1 class='page-header'>No result found for this category.</h1>";
                    }

                ?>

                <ul class="pager">

                <?php

                    for($i = 1; $i <= $pagination; $i++) {

                        if($i == 1 && $page == "") {
                            echo "<li><a class='active' href='/php-cms/category/{$category_id}/{$i}'>{$i}</a></li>";
                        } elseif($i == $page) {
                            echo "<li><a class='active' href='/php-cms/category/{$category_id}/{$i}'>{$i}</a></li>";
                        } else {
                            echo "<li><a href='/php-cms/category/{$category_id}/{$i}'>{$i}</a></li>";
                        }
                        
                    }

                ?>

                </ul>

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