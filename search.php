<?php require_once('includes/header.php'); ?>

    <?php require_once('includes/nav.php'); ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <h1 class="page-header">
                    Search Results
                </h1>

                <?php

                    if(isset($_GET['search']) ) {

                        $keyword = clean($_GET['search']);
                        
                        $search = "%" . $keyword . "%";

                        $post_status = "Published";

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

                        $posts_count_stmt = mysqli_prepare($connection, "SELECT * FROM tblposts JOIN tblusers ON tblusers.user_id = tblposts.post_author WHERE post_tags LIKE ? AND post_status = ?");
                    
                        mysqli_stmt_bind_param($posts_count_stmt, "ss", $search, $post_status);
                        mysqli_stmt_execute($posts_count_stmt);
                        $posts_count_result = mysqli_stmt_get_result($posts_count_stmt);

                        checkPreparedStatement($posts_count_stmt);

                        $posts_count = mysqli_num_rows($posts_count_result);

                        $pagination = ceil($posts_count / $posts_per_page);

                        $search_stmt = mysqli_prepare($connection, "SELECT * FROM tblposts JOIN tblusers ON tblusers.user_id = tblposts.post_author WHERE post_tags LIKE ? AND post_status = ? ORDER BY post_id DESC LIMIT ?, ?");

                        checkPreparedStatement($search_stmt);

                        mysqli_stmt_bind_param($search_stmt, "ssii", $search, $post_status, $offset, $posts_per_page);
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
                            <img class="img-responsive" src="<?php echo imagePlaceholder($posts_info['post_image']); ?>" alt="">
                            <hr>
                            <p><?php echo $posts_info['post_content']; ?></p>
                            <a class="btn btn-primary" href="/php-cms/post/<?php echo $posts_info['post_id']; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
            
                            <hr>
            
                        <?php   }
            
                        }
    
                    }
                
                ?>

                <ul class="pager">

                <?php

                    for($i = 1; $i <= $pagination; $i++) {

                        if($i == 1 && $page == "") {
                            echo "<li><a class='active' href='/php-cms/search.php?search={$keyword}&page={$i}'>{$i}</a></li>";
                        } elseif($i == $page) {
                            echo "<li><a class='active' href='/php-cms/search.php?search={$keyword}&page={$i}'>{$i}</a></li>";
                        } else {
                            echo "<li><a href='/php-cms/search.php?search={$keyword}&page={$i}'>{$i}</a></li>";
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