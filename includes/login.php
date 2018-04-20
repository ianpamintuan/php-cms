<?php require_once('db.php'); ?>

<?php session_start(); ?>

<?php

    if(isset($_POST['login'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $username = mysqli_real_escape_string($connection, $username);
        $password = mysqli_real_escape_string($connection, $password);

        $query = "SELECT * FROM tblusers WHERE BINARY username = '{$username}' AND BINARY password = '{$password}'";
        $result = mysqli_query($connection, $query);

        if(!$result) {
            die("Error on login query!" . mysqli_error($connection));
        } else {

            while($row = mysqli_fetch_array($result)) {

                $db_user_id = $row['user_id'];
                $db_username = $row['username'];
                $db_password = $row['password'];
                $db_first_name = $row['firstname'];
                $db_last_name = $row['lastname'];
                $db_email = $row['email'];
                $db_image = $row['image'];
                $db_user_role = $row['user_role'];

            }
            
            if(mysqli_num_rows($result) > 0) {

                $_SESSION['user_id'] = $db_user_id;
                $_SESSION['username'] = $db_username;
                $_SESSION['first_name'] = $db_first_name;
                $_SESSION['last_name'] = $db_last_name;
                $_SESSION['email'] = $db_email;
                $_SESSION['image'] = $db_image;
                $_SESSION['user_role'] = $db_user_role;

                header("Location: ../admin");
            } else {
                header("Location: ../index.php");
            }

        }
    }

?>