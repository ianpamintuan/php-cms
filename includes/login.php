<?php session_start(); ?>
<?php require_once('db.php'); ?>
<?php require_once('../admin/includes/functions.php'); ?>

<?php

    if(isset($_POST['login'])) {

        $username = clean($_POST['username']);
        $password = clean($_POST['password']);

        $login_stmt = mysqli_prepare($connection, "SELECT * FROM tblusers WHERE BINARY username = ?");

        checkPreparedStatement($login_stmt);

        mysqli_stmt_bind_param($login_stmt, "s", $username);
        mysqli_stmt_execute($login_stmt);
        $result = mysqli_stmt_get_result($login_stmt);

        if(mysqli_num_rows($result) > 0) {

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

            $hashed_password = password_verify($password, $db_password);

            if($hashed_password) {

                $_SESSION['user_id'] = $db_user_id;
                $_SESSION['username'] = $db_username;
                $_SESSION['first_name'] = $db_first_name;
                $_SESSION['last_name'] = $db_last_name;
                $_SESSION['email'] = $db_email;
                $_SESSION['image'] = $db_image;
                $_SESSION['user_role'] = $db_user_role;

                header("Location: ../admin");
                exit();

            } else {

                header("Location: ../index.php?login=error");
                exit();

            }
                
        } else {

            header("Location: ../index.php?login=error");
            exit();

        }

    }

?>