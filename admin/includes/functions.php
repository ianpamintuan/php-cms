<?php

    function clean($value) {

        global $connection;
        return mysqli_real_escape_string($connection, trim($value));
        
    }

    function checkQuery($result) {

        global $connection;

        if(!$result) {
            die('SQL Error ' . mysqli_error($connection));
        }

    }

    function checkPreparedStatement($stmt) {

        global $connection;

        if(!$stmt) {
            die('SQL Error ' . mysqli_error($connection));
        }

    }

    function countOnlineUsers() {

        if(isset($_GET['online_users'])) {
        
            global $connection;

            if(!$connection) {
                session_start();
                require_once('../../includes/db.php');
            }

            $session = session_id();
            $time = time();
            $seconds = 10;
            $timeout = $time - $seconds;

            $sessions_query = "SELECT * FROM tblsessions WHERE session = '{$session}'";
            $sessions_result = mysqli_query($connection, $sessions_query);
            $online_count = mysqli_num_rows($sessions_result);

            if($online_count == NULL) {
                
                $sessions_insert_query = "INSERT INTO tblsessions(session, time) VALUES('{$session}', {$time})";
                $sessions_insert_query_result = mysqli_query($connection, $sessions_insert_query);

            } else {

                $sessions_update_query = "UPDATE tblsessions SET time = {$time} WHERE session = '{$session}'";
                $sessions_update_result = mysqli_query($connection, $sessions_update_query);

            }

            $session_online_query = "SELECT * FROM tblsessions WHERE time > {$timeout}";
            $session_online_result = mysqli_query($connection, $session_online_query);
            $online_users_count = mysqli_num_rows($session_online_result);

            echo $online_users_count;

        }

    }

    countOnlineUsers();

    function getCategories() {
        
        global $connection;

        $categories_stmt = mysqli_prepare($connection, "SELECT * FROM tblcategories");
        
        checkPreparedStatement($categories_stmt);

        mysqli_stmt_execute($categories_stmt);
        $result = mysqli_stmt_get_result($categories_stmt);

        while($row = mysqli_fetch_assoc($result)) {

            $category_id = $row['category_id'];
            $category_title = $row['category_title'];

            if(isset($_GET['category']) && $_GET['category'] == $category_id) {
                echo "<li class='active'><a href='category.php?category={$category_id}'>{$category_title}</a></li>";
            } else {
                echo "<li><a href='category.php?category={$category_id}'>{$category_title}</a></li>";
            }

        }

    }

    function displayCategories($type, $cat_id = 0) {

        global $connection;

        $categories_stmt = mysqli_prepare($connection, "SELECT * FROM tblcategories");
        
        checkPreparedStatement($categories_stmt);

        mysqli_stmt_execute($categories_stmt);
        $result = mysqli_stmt_get_result($categories_stmt);

        if($type == "table") {

            while($row = mysqli_fetch_assoc($result)) {

                $category_id = $row['category_id'];
                $category_title = $row['category_title'];

                echo "<tr>";
                echo "<td>{$category_id}</td>";
                echo "<td>{$category_title}</td>";
                echo "<td><a href='#editModal' data-toggle='modal' data-id='{$category_id}' class='category_row btn btn-info'>Edit</a></td>";
                ?>

                <td><input class="delete_category btn btn-danger" type="submit" name="delete" value="Delete" data-id="<?php echo $category_id; ?>"></td>

                <?php
 
                echo "</tr>";
            }      

        } else {

            echo "<select class='form-control' name='category_id'>";

            while($row = mysqli_fetch_assoc($result)) {
                $category_id = $row['category_id'];
                $category_title = $row['category_title']; 
                if($category_id == $cat_id) {
                    echo "<option value='{$category_id}' selected>" . $category_title . "</option>";
                } else {
                    echo "<option value='{$category_id}'>" . $category_title . "</option>";
                }
                
            }

            echo "</select>";

        }

    }

    function insertCategory() {
        
        if (isset($_POST['submit']) ) {

            $cat_name = clean($_POST["category"]);

            if(trim($cat_name) == "" || empty($cat_name)) {

                echo "<div class='alert alert-warning alert-dismissible' role='alert'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                    Category name should not be empty.</div>";

            } else {

                global $connection;

                $category_stmt = mysqli_prepare($connection, "INSERT INTO tblcategories(category_title) VALUES(?)");

                checkPreparedStatement($category_stmt);

                mysqli_stmt_bind_param($category_stmt, "s", $cat_name);
                mysqli_stmt_execute($category_stmt);
                              
                echo "<div class='alert alert-success alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                Category successully added.</div>";

                header("Location: categories.php");
                exit();

            }

        }

    }

    function displayPostsTable() {
        
        global $connection;

        $posts_stmt = mysqli_prepare($connection, "SELECT * FROM tblposts JOIN tblusers ON tblusers.user_id = tblposts.post_author JOIN tblcategories ON tblcategories.category_id = tblposts.category_id ORDER BY post_id DESC");
        
        checkPreparedStatement($posts_stmt);

        mysqli_stmt_execute($posts_stmt);
        $result = mysqli_stmt_get_result($posts_stmt);

        while($row = mysqli_fetch_assoc($result)) {
            
            $post_id = $row['post_id'];
            $post_title = $row['post_title'];
            $post_content = $row['post_content'];
            $post_author = $row['username'];
            $category_id = $row['category_id'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_tags = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_views_count = $row['post_views_count'];
            $post_date = $row['post_date'];
            $category_title = $row['category_title'];

            $comments_count_stmt = mysqli_prepare($connection,"SELECT post_id AS comments_count FROM tblcomments WHERE post_id = ?");

            checkPreparedStatement($comments_count_stmt);

            mysqli_stmt_bind_param($comments_count_stmt, "i", $post_id);
            mysqli_stmt_execute($comments_count_stmt);
            $count_result = mysqli_stmt_get_result($comments_count_stmt);

            $comments_count = mysqli_num_rows($count_result);

            $comments_update_stmt = mysqli_prepare($connection, "UPDATE tblposts SET post_comment_count = ? WHERE post_id = ?");

            checkPreparedStatement($comments_update_stmt);

            mysqli_stmt_bind_param($comments_update_stmt, "ii", $comments_count, $post_id);
            mysqli_stmt_execute($comments_update_stmt);

            echo "<tr>";
            echo "<td><input type='checkbox' name='checkboxArray[]' class='checkbox' value='{$post_id}'></td>";
            echo "<td>{$post_id}</td>";
            echo "<td><a href='../post.php?post_id={$post_id}'>{$post_title}</a></td>";
            echo "<td>{$post_content}</td>";
            echo "<td>{$post_author}</td>";
            echo "<td>{$category_title}</td>";
            echo "<td>{$post_status}</td>";
            echo "<td><img width=100 src='../images/{$post_image}' alt='Post image'></td>";
            echo "<td>{$post_tags}</td>";
            echo "<td><a href='comments.php?post_id={$post_id}'>{$comments_count}</a></td>";
            echo "<td><a id='reset_views' href='#' data-id='{$post_id}'>{$post_views_count}</a></td>";
            echo "<td>{$post_date}</td>";
            echo "<td><a class='btn btn-info' href='posts.php?src=edit_post&edit={$post_id}'>Edit</td>";
            ?>
            
            <td><input class="delete_post btn btn-danger" type="submit" name="delete" value="Delete" data-id="<?php echo $post_id; ?>"></td>

            <?php

            echo "</tr>";
        }                

    }

    function resetViews() {

        global $connection;

        if(isset($_GET['reset_views'])) {

            $post_id = clean($_GET['reset_views']);

            $reset_views_stmt = mysqli_prepare($connection, "UPDATE tblposts SET post_views_count = 0 WHERE post_id = ?");

            checkPreparedStatement($reset_views_stmt);

            mysqli_stmt_bind_param($reset_views_stmt, "i", $post_id);
            mysqli_stmt_execute($reset_views_stmt);

            header("Location: posts.php?message=reset_view_success");
            exit();

        }

    }

    function displayCommentsTable() {

        global $connection;

        if(isset($_GET['post_id'])) {

            $post_id = clean($_GET['post_id']);

            if(!is_numeric($post_id)) {
                header("Location: comments.php");
                exit();
            }

            $comments_stmt = mysqli_prepare($connection, "SELECT * FROM tblcomments WHERE post_id = ?");

            mysqli_stmt_bind_param($comments_stmt, "i", $post_id);

        } else {

            $comments_stmt = mysqli_prepare($connection, "SELECT * FROM tblcomments");

        }

        checkPreparedStatement($comments_stmt);

        mysqli_stmt_execute($comments_stmt);
        $result = mysqli_stmt_get_result($comments_stmt);

        while($row = mysqli_fetch_assoc($result)) {

            $comment_id = $row['comment_id'];
            $comment_author = $row['comment_author'];
            $comment_email = $row['comment_email'];
            $comment_content = $row['comment_content'];
            $comment_status = $row['comment_status'];
            $comment_date = $row['comment_date'];
            $post_id = $row['post_id'];

            echo "<tr>";
            echo "<td>{$comment_id}</td>";
            echo "<td>{$comment_author}</td>";
            echo "<td>{$comment_email}</td>";
            echo "<td>{$comment_content}</td>";
            echo "<td>{$comment_status}</td>";
            echo "<td>{$comment_date}</td>";

            $posts_stmt = mysqli_prepare($connection, "SELECT * FROM tblposts WHERE post_id = ?");

            checkPreparedStatement($posts_stmt);

            mysqli_stmt_bind_param($posts_stmt, "i", $post_id);
            mysqli_stmt_execute($posts_stmt);
            $posts_result = mysqli_stmt_get_result($posts_stmt);

            $post = mysqli_fetch_assoc($posts_result);
            $comment_post_id = $post['post_id'];
            $post_title = $post['post_title'];

            echo "<td><a href='../post.php?post_id=" . $comment_post_id . "'>{$post_title}</a></td>";

            if(isset($_GET['post_id'])) {

                $post_id = $_GET['post_id'];
                $post_id = mysqli_real_escape_string($connection, $post_id);

                echo "<td><a href='comments.php?approve=1&comment_id={$comment_id}&post_id={$post_id}'>Approve</td>";
                echo "<td><a href='comments.php?approve=0&comment_id={$comment_id}&post_id={$post_id}'>Unapprove</td>";
                
                ?>

                <td><input class="delete_comment btn btn-danger" type="submit" name="delete" value="Delete" data-id="<?php echo $comment_id; ?>"></td>

                <?php

            } else {
                
                echo "<td><a href='comments.php?approve=1&comment_id={$comment_id}'>Approve</td>";
                echo "<td><a href='comments.php?approve=0&comment_id={$comment_id}'>Unapprove</td>";
                ?>

                <td><input class="delete_comment btn btn-danger" type="submit" name="delete" value="Delete" data-id="<?php echo $comment_id; ?>"></td>

                <?php

            }

            echo "</tr>";
        }

    }

    function approveComment() {

        global $connection;

        if(isset($_GET['approve'])) {
            
            $approve = clean($_GET['approve']);

            $comment_id = clean($_GET['comment_id']);

            if(!is_numeric($approve) || !is_numeric($comment_id)) {

                header("Location: comments.php");
                exit();

            }

            if($approve == 1) {
                $comment_status = "Approved";
            } else {
                $comment_status = "Unapproved";
            }

            $approve_stmt = mysqli_prepare($connection, "UPDATE tblcomments SET comment_status = ? WHERE comment_id = ?");

            checkPreparedStatement($approve_stmt);

            mysqli_stmt_bind_param($approve_stmt, "si", $comment_status, $comment_id);
            mysqli_stmt_execute($approve_stmt);

            if(isset($_GET['post_id'])) {

                $post_id = clean($_GET['post_id']);

                header("Location: comments.php?post_id={$post_id}");
                exit();

            } else {

                header("Location: comments.php");
                exit();

            }

        }

    }

    function displayUsers($type, $author_id = 0) {

        global $connection;

        $users_stmt = mysqli_prepare($connection, "SELECT * FROM tblusers");

        checkPreparedStatement($users_stmt);

        mysqli_stmt_execute($users_stmt);
        $result = mysqli_stmt_get_result($users_stmt);

        if($type == "table") {

            while($row = mysqli_fetch_assoc($result)) {

                $user_id = $row['user_id'];
                $username = $row['username'];
                $firstname = $row['firstname'];
                $lastname = $row['lastname'];
                $user_email = $row['email'];
                $user_image = $row['image'];
                $user_role = $row['user_role'];

                echo "<tr>";
                echo "<td>{$user_id}</td>";
                echo "<td>{$username}</td>";
                echo "<td>{$firstname}</td>";
                echo "<td>{$lastname}</td>";
                echo "<td>{$user_email}</td>";
                echo "<td>{$user_image}</td>";
                echo "<td>{$user_role}</td>";

                echo "<td><a href='users.php?change_to_admin=1&user_id={$user_id}'>Admin</td>";
                echo "<td><a href='users.php?change_to_sub=1&user_id={$user_id}'>Subscriber</td>";
                echo "<td><a class='btn btn-info' href='users.php?src=edit_user&user_id={$user_id}'>Edit</td>";
                ?>

                <td><input class="delete_user btn btn-danger" type="submit" name="delete" value="Delete" data-id="<?php echo $user_id; ?>"></td>

                <?php

                echo "</tr>";
            }

        } else {

            echo "<select class='form-control' name='post_author'>";

            while($row = mysqli_fetch_assoc($result)) {

                $user_id = $row['user_id'];
                $username = $row['username'];

                if($user_id == $author_id) {
                    echo "<option value='{$user_id}' selected>" . $username . "</option>";
                } else {
                    echo "<option value='{$user_id}'>" . $username . "</option>";
                }
                
            }

            echo "</select>";

        }

    }

    function changeRole() {

        global $connection;

        if(isset($_GET['change_to_admin']) && isset($_GET['user_id'])) {

            $user_id = clean($_GET['user_id']);
            $user_role = "Admin";

            $change_role_stmt = mysqli_prepare($connection, "UPDATE tblusers SET user_role = ? WHERE user_id = ?");

            checkPreparedStatement($change_role_stmt);

            mysqli_stmt_bind_param($change_role_stmt, "si", $user_role, $user_id);
            mysqli_stmt_execute($change_role_stmt);

            header("Location: users.php");
            exit();

        } else if(isset($_GET['change_to_sub']) && isset($_GET['user_id'])) {

            $user_id = clean($_GET['user_id']);
            $user_role = "Subscriber";

            $change_role_stmt = mysqli_prepare($connection, "UPDATE tblusers SET user_role = ? WHERE user_id = ?");

            checkPreparedStatement($change_role_stmt);

            mysqli_stmt_bind_param($change_role_stmt, "si", $user_role, $user_id);
            mysqli_stmt_execute($change_role_stmt);
            
            header("Location: users.php");
            exit();

        }

    }

    function countRecords($table, $filter = "", $value = "") {

        global $connection;

        if(!empty($filter)) {
            $count_stmt = mysqli_prepare($connection, "SELECT * FROM {$table} WHERE {$filter} = ?");
            mysqli_stmt_bind_param($count_stmt, "s", $value);
        } else {
            $count_stmt = mysqli_prepare($connection, "SELECT * FROM {$table}");
        }

        checkPreparedStatement($count_stmt);

        mysqli_stmt_execute($count_stmt);
        $result = mysqli_stmt_get_result($count_stmt);

        return mysqli_num_rows($result);

    }

    function isAdmin($username) {

        global $connection;

        $role_stmt = mysqli_prepare($connection, "SELECT user_role FROM tblusers WHERE BINARY username = ?");

        checkPreparedStatement($role_stmt);

        mysqli_stmt_bind_param($role_stmt, "s", $username);
        mysqli_stmt_execute($role_stmt);
        $result = mysqli_stmt_get_result($role_stmt);
            
        $row = mysqli_fetch_array($result);
        $user_role = $row['user_role'];

        if($user_role == 'Admin') {
            return true;
        } else {
            return false;
        }

    }

    function userDetailDuplicate($filter, $value) {
        
        global $connection;

        $duplicate_stmt = mysqli_prepare($connection, "SELECT * FROM tblusers WHERE {$filter} = ?");

        checkPreparedStatement($duplicate_stmt);

        mysqli_stmt_bind_param($duplicate_stmt, "s", $value);
        mysqli_stmt_execute($duplicate_stmt);
        $result = mysqli_stmt_get_result($duplicate_stmt);

        if(mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }

    }

    function register($first_name, $last_name, $email, $username, $hashed_password, $role="Subscriber") {

        global $connection;

        $register_stmt = mysqli_prepare($connection, "INSERT INTO tblusers(firstname, lastname, email, username, password, user_role) VALUES(?, ?, ?, ?, ?, ?)");

        checkPreparedStatement($register_stmt);

        mysqli_stmt_bind_param($register_stmt, "ssssss", $first_name, $last_name, $email, $username, $hashed_password, $role);
        mysqli_stmt_execute($register_stmt);
        
    }

?>