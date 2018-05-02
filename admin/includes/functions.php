<?php

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

    function displayCategories($type, $cat_id = 0) {

        global $connection;

        $query = "SELECT * FROM tblcategories;";
        
        $result = mysqli_query($connection, $query);

        if($result) {

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

    }

    function insertCategory() {
        
        if (isset($_POST['submit']) ) {

            $cat_name = $_POST["category"];

            if(trim($cat_name) == "" || empty($cat_name)) {

                echo "<div class='alert alert-warning alert-dismissible' role='alert'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                    Category name should not be empty.</div>";

            } else {

                global $connection;
                                        
                $query = "INSERT INTO tblcategories(category_title) VALUES('" . $cat_name . "');";
                                        
                $result = mysqli_query($connection, $query);
                                        
                if($result) {
                                    
                    echo "<div class='alert alert-success alert-dismissible' role='alert'>
                          <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                            Category successully added.</div>";
                                        
                } else {
                                        
                    echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                    There's an error in your query.</div>";
                                        
                    die('Query failed' . mysqli_error($connection));
                                        
                }

            }

        }

    }

    function deleteCategory() {

        if (isset($_GET['delete'])) {
            
            global $connection;

            $cat_id = $_GET['delete'];
            
            $query = "DELETE FROM tblcategories WHERE category_id={$cat_id}";
            
            $result = mysqli_query($connection, $query);
            
            if($result) {
            
                echo "<div class='alert alert-success alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                Category successully deleted.</div>";
                header("Location: categories.php");
            
            } else {

                die("Query failed." . mysqli_error($connection));
 
            }
            
        }

    }

    function displayPostsTable() {
        
        global $connection;
        
        $query = "SELECT * FROM tblposts ORDER BY post_id DESC;";
                
        $result = mysqli_query($connection, $query);
        
        if($result) {
        
            while($row = mysqli_fetch_assoc($result)) {
                
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_content = $row['post_content'];
                $post_author = $row['post_author'];
                $category_id = $row['category_id'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_comment_count = $row['post_comment_count'];
                $post_views_count = $row['post_views_count'];
                $post_date = $row['post_date'];

                $category_query = "SELECT category_title FROM tblcategories WHERE category_id = {$category_id}";
                $category_result = mysqli_query($connection, $category_query);

                if(!$category_result) {
                    die("SQL Error " . mysqli_error($connection));
                } else {
                    while($row = mysqli_fetch_array($category_result)) {
                        $category_title = $row['category_title']; 
                    }                    
                }

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
                echo "<td><a href='posts.php?src=edit_post&edit={$post_id}'>Edit</td>";
                echo "<td><a id='delete_post' href='#' data-id='{$post_id}'>Delete</td>";
                echo "</tr>";
            }                
    
        }

    }

    function deletePost() {

        global $connection;

        if(isset($_GET['delete'])) {
            
            $post_id = $_GET['delete'];

            $query = "DELETE FROM tblposts WHERE post_id={$post_id}";

            $result = mysqli_query($connection, $query);

            if(!$result) {
                die("Query Failed " . mysqli_error());
            } else {
                header("Location: posts.php?message=delete_success");
            }

        }

    }

    function resetViews() {

        global $connection;

        if(isset($_GET['reset_views'])) {

            $post_id = $_GET['reset_views'];

            $query = "UPDATE tblposts SET post_views_count = 0 WHERE post_id={$post_id}";

            $result = mysqli_query($connection, $query);

            if(!$result) {
                die("Query Failed " . mysqli_error());
            } else {
                header("Location: posts.php?message=reset_view_success");
            }

        }

    }

    function showCategories() {

        global $connection;

        $query = "SELECT * FROM tblcategories";

        $result = mysqli_query($connection, $query);

        if(!$result) {
            die("Query Failed " . mysqli_error());
        } else {

            while($row = mysqli_fetch_assoc($result)) {
                $category_id = $row['category_id'];
                $category_title = $row['category_title'];
                echo "<select>";


            }        

        }

    }

    function displayCommentsTable() {

        global $connection;

        if(isset($_GET['post_id'])) {

            $post_id = $_GET['post_id'];
            $post_id = mysqli_real_escape_string($connection, $post_id);

            if(!is_numeric($post_id)) {
                header("Location: comments.php");
            }

            $query = "SELECT * FROM tblcomments WHERE post_id = {$post_id}";

        } else {

            $query = "SELECT * FROM tblcomments";

        }

        $result = mysqli_query($connection, $query);

        if(!$result) {
            die("Query Failed" . mysqli_error());
        } else {

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

                while($comment = mysqli_fetch_assoc($posts_result)) {
                    $comment_post_id = $comment['post_id'];
                    $post_title = $comment['post_title'];
                    echo "<td><a href='../post.php?post_id=" . $comment_post_id . "'>{$post_title}</a></td>";
                }

                echo "<td><a href='comments.php?approve=1&comment_id={$comment_id}'>Approve</td>";
                echo "<td><a href='comments.php?approve=0&comment_id={$comment_id}'>Unapprove</td>";
                echo "<td><a href='comments.php?delete={$comment_id}'>Delete</td>";
    
                echo "</tr>";
            }

        }

    }

    function deleteComment() {

        global $connection;

        if(isset($_GET['delete'])) {
            
            $comment_id = $_GET['delete'];

            $query = "DELETE FROM tblcomments WHERE comment_id={$comment_id}";

            $result = mysqli_query($connection, $query);

            if(!$result) {
                die("Query Failed " . mysqli_error());
            } else {
                header("Location: comments.php");
            }

        }

    }

    function approveComment() {

        global $connection;

        if(isset($_GET['approve'])) {
            
            $approve = $_GET['approve'];

            $comment_id = $_GET['comment_id'];

            if($approve == 1) {

                $query = "UPDATE tblcomments SET comment_status = 'Approved' WHERE comment_id={$comment_id}";

                $result = mysqli_query($connection, $query);

            } else {

                $query = "UPDATE tblcomments SET comment_status = 'Unapproved' WHERE comment_id={$comment_id}";

                $result = mysqli_query($connection, $query);

            }

            if(!$result) {
                die("Query Failed " . mysqli_error($connection));
            } else {
                header("Location: comments.php");
            }

        }

    }

    function displayUsersTable() {

        global $connection;

        $query = "SELECT * FROM tblusers";

        $result = mysqli_query($connection, $query);

        if(!$result) {
            die("Query Failed" . mysqli_error());
        } else {

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

        }

    }

    function deleteUser() {

        global $connection;

        if(isset($_GET['delete'])) {
            
            $user_id = $_GET['delete'];

            $query = "DELETE FROM tblusers WHERE user_id={$user_id}";

            $result = mysqli_query($connection, $query);

            if(!$result) {
                die("Query Failed " . mysqli_error($connection));
            } else {
                header("Location: users.php");
            }

        }

    }

    function changeRole() {

        global $connection;

        if(isset($_GET['change_to_admin'])) {

            $user_id = $_GET['user_id'];
            $query = "UPDATE tblusers SET user_role = 'Admin' WHERE user_id={$user_id}";

            $result = mysqli_query($connection, $query);

            if(!$result) {
                die("Query Failed " . mysqli_error($connection));
            } else {
                header("Location: users.php");
            }


        } else if(isset($_GET['change_to_sub'])) {

            $user_id = $_GET['user_id'];
            $query = "UPDATE tblusers SET user_role = 'Subscriber' WHERE user_id={$user_id}";

            $result = mysqli_query($connection, $query);

            if(!$result) {
                die("Query Failed " . mysqli_error($connection));
            } else {
                header("Location: users.php");
            }

        }

    }

?>