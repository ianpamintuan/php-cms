<?php require_once("../includes/db.php"); ?>

<?php

    if(isset($_POST['add_user'])) {

         $user_firstname = $_POST['user_firstname'];
         $user_lastname = $_POST['user_lastname'];
         $user_role = $_POST['roles'];
         $user_email = $_POST['user_email'];
         $user_username = $_POST['user_username'];
         $user_password = $_POST['user_password'];

         $query = "INSERT INTO tblusers(firstname, lastname, user_role, email, username, password) ";
         $query .= "VALUES('{$user_firstname}', '{$user_lastname}', '{$user_role}', '{$user_email}', '{$user_username}', '{$user_password}')";

        $result = mysqli_query($connection, $query);

        if(!$result) {
            die("SQL error " . mysqli_error($connection));
        } else {
            echo "User added successfully!";
        }

    }

?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>

    <div class="form-group">
        <label for="roles">User Role</label>
        <select name="roles" id="roles" class="form-control">
            <option value="Admin">Admin</option>
            <option value="User">User</option>
        </select>
    </div>

    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="text" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <label for="user_username">Username</label>
        <input type="text" class="form-control" name="user_username">
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="add_user" value="Add User">
    </div>

</form>