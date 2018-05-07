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

        $query = "SELECT * FROM tblcategories;";
        
        $result = mysqli_query($connection, $query);

        checkQuery($result);

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

        $query = "SELECT * FROM tblcategories;";
        $result = mysqli_query($connection, $query);

        checkQuery($result);

        if($type == "table") {

            while($row = mysqli_fetch_assoc($result)) {
                $category_id = $row['category_id'];
                $category_title = $row['category_title'];
                echo "<tr>";
                echo "<td>{$category_id}</td>";
                echo "<td>{$category_title}</td>";
                echo "<td><a href='#editModal' data-toggle='modal' data-id='{$category_id}' class='category_row'>Edit</a></td>";
                echo "<td><a href='categories.php?delete={$category_id}'>Delete</a></td>";
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
                                        
                $query = "INSERT INTO tblcategories(category_title) VALUES('" . $cat_name . "');";
                $result = mysqli_query($connection, $query);
                
                checkQuery($result);
                                
                echo "<div class='alert alert-success alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                Category successully added.</div>";

            }

        }

    }

    function deleteCategory() {

        if (isset($_GET['delete'])) {
            
            global $connection;

            $cat_id = clean($_GET['delete']);
            
            $query = "DELETE FROM tblcategories WHERE category_id={$cat_id}";
            $result = mysqli_query($connection, $query);
            
            checkQuery($result);
            
            echo "<div class='alert alert-success alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
            Category successully deleted.</div>";

            header("Location: categories.php");
            
        }

    }

    function displayPostsTable() {
        
        global $connection;
        
        $query = "SELECT * FROM tblposts JOIN tblusers ON tblusers.user_id = tblposts.post_author JOIN tblcategories ON tblcategories.category_id = tblposts.category_id ORDER BY post_id DESC;";
        $result = mysqli_query($connection, $query);

        checkQuery($result);
        
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

            $count_query = "SELECT post_id AS comments_count FROM tblcomments WHERE post_id = {$post_id}";
            $count_result = mysqli_query($connection, $count_query);

            if(!$count_result) {
                die("SQL Error " . mysqli_error($connection));
            } else {
                $comments_count = mysqli_num_rows($count_result);
                $count_update_query = "UPDATE tblposts SET post_comment_count = {$comments_count} WHERE post_id = {$post_id}";
                $count_update_result = mysqli_query($connection, $count_update_query);     
            }

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

            $query = "UPDATE tblposts SET post_views_count = 0 WHERE post_id={$post_id}";
            $result = mysqli_query($connection, $query);

            checkQuery($result);

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

            $query = "SELECT * FROM tblcomments WHERE post_id = {$post_id}";

        } else {

            $query = "SELECT * FROM tblcomments";

        }

        $result = mysqli_query($connection, $query);

        checkQuery($result);

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

            $posts_query = "SELECT * FROM tblposts WHERE post_id = {$post_id}";
            $posts_result = mysqli_query($connection, $posts_query);

            checkQuery($posts_result);

            $post = mysqli_fetch_assoc($posts_result);
            $comment_post_id = $post['post_id'];
            $post_title = $post['post_title'];
            echo "<td><a href='../post.php?post_id=" . $comment_post_id . "'>{$post_title}</a></td>";

            if(isset($_GET['post_id'])) {

                $post_id = $_GET['post_id'];
                $post_id = mysqli_real_escape_string($connection, $post_id);

                echo "<td><a href='comments.php?approve=1&comment_id={$comment_id}&post_id={$post_id}'>Approve</td>";
                echo "<td><a href='comments.php?approve=0&comment_id={$comment_id}&post_id={$post_id}'>Unapprove</td>";
                echo "<td><a href='comments.php?delete={$comment_id}&post_id={$post_id}'>Delete</td>";

            } else {
                
                echo "<td><a href='comments.php?approve=1&comment_id={$comment_id}'>Approve</td>";
                echo "<td><a href='comments.php?approve=0&comment_id={$comment_id}'>Unapprove</td>";
                echo "<td><a href='comments.php?delete={$comment_id}'>Delete</td>";

            }

            echo "</tr>";
        }

    }

    function deleteComment() {

        global $connection;

        if(isset($_GET['delete'])) {
            
            $comment_id = clean($_GET['delete']);

            if(!is_numeric($comment_id)) {
                header("Location: comments.php");
                exit();
            }

            $query = "DELETE FROM tblcomments WHERE comment_id={$comment_id}";
            $result = mysqli_query($connection, $query);
            
            checkQuery($result);

            if(isset($_GET['post_id'])) {

                $post_id = $_GET['post_id'];
                $post_id = mysqli_real_escape_string($connection, $post_id);

                header("Location: comments.php?post_id={$post_id}");
                exit();

            } else {

                header("Location: comments.php");
                exit();

            }

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
                $query = "UPDATE tblcomments SET comment_status = 'Approved' WHERE comment_id={$comment_id}";
            } else {
                $query = "UPDATE tblcomments SET comment_status = 'Unapproved' WHERE comment_id={$comment_id}";
            }

            $result = mysqli_query($connection, $query);

            checkQuery($result);

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

        $query = "SELECT * FROM tblusers";
        $result = mysqli_query($connection, $query);

        checkQuery($result);

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
                echo "<td><a href='users.php?src=edit_user&user_id={$user_id}'>Edit</td>";
                echo "<td><a href='users.php?delete={$user_id}'>Delete</td>";
    
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

    function deleteUser() {

        global $connection;

        if(isset($_GET['delete'])) {
            
            if(isset($_SESSION['user_role'])) {

                $user_role = $_SESSION['user_role'];

                if($user_role == "Admin") {

                    $user_id = mysqli_real_escape_string($connection, $_GET['delete']);
    
                    if(!is_numeric($user_id)) {
                        header("Location: users.php");
                        exit();
                    }

                    $query = "DELETE FROM tblusers WHERE user_id={$user_id}";
                    $result = mysqli_query($connection, $query);

                    checkQuery($result);

                    header("Location: users.php");
                    exit();
                    
                }

            }

        }

    }

    function changeRole() {

        global $connection;

        if(isset($_GET['change_to_admin']) && isset($_GET['user_id'])) {

            $user_id = clean($_GET['user_id']);
            $query = "UPDATE tblusers SET user_role = 'Admin' WHERE user_id={$user_id}";
            $result = mysqli_query($connection, $query);

            checkQuery($result);

            header("Location: users.php");
            exit();

        } else if(isset($_GET['change_to_sub']) && isset($_GET['user_id'])) {

            $user_id = clean($_GET['user_id']);
            $query = "UPDATE tblusers SET user_role = 'Subscriber' WHERE user_id={$user_id}";
            $result = mysqli_query($connection, $query);

            checkQuery($result);
            
            header("Location: users.php");
            exit();

        }

    }

    function countRecords($table, $filter = "", $value = "") {

        global $connection;

        if(!empty($filter)) {
            $query = "SELECT * FROM {$table} WHERE {$filter} = '{$value}'";
        } else {
            $query = "SELECT * FROM {$table}";
        }

        $result = mysqli_query($connection, $query);
        
        checkQuery($result);

        return mysqli_num_rows($result);

    }

    function isAdmin($username) {

        global $connection;

        $query = "SELECT user_role FROM tblusers WHERE BINARY username = '{$username}'";
        $result = mysqli_query($connection, $query);

        checkQuery($result);
            
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

        $query = "SELECT * FROM tblusers WHERE {$filter} = '{$value}'";
        $result = mysqli_query($connection, $query);

        checkQuery($result);

        if(mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }

    }

    function register($first_name, $last_name, $email, $username, $hashed_password, $role="Subscriber") {

        global $connection;

        $query = "INSERT INTO tblusers(firstname, lastname, email, username, password, user_role) ";
        $query .= "VALUES('{$first_name}', '{$last_name}', '{$email}', '{$username}', '{$hashed_password}', '{$role}')";                    
        $result = mysqli_query($connection, $query);

        checkQuery($result);

    }

?>