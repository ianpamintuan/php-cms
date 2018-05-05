<?php require_once("../includes/db.php"); ?>

<?php

    if(isset($_POST['add_user'])) {

        $user_firstname = clean($_POST['user_firstname']);
        $user_lastname = clean($_POST['user_lastname']);
        $user_role = clean($_POST['roles']);
        $user_email = clean($_POST['user_email']);
        $user_username = clean($_POST['user_username']);
        $user_password = clean($_POST['user_password']);

        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

        if(userDetailDuplicate("username", $username)) {

            echo "<div class='alert alert-danger alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
            Username already exists.</div>";

        } else if(userDetailDuplicate("email", $email)) {

            echo "<div class='alert alert-danger alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
            Email already exists.</div>";

        } else {

            register($user_firstname, $user_lastname, $user_email, $user_username, $hashed_password, $user_role);

            $user_firstname = "";
            $user_lastname = "";
            $user_role = "";
            $user_email = "";
            $user_username = "";
            $user_password = "";

            echo "<div class='alert alert-success alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
            User added successfully. <a href='users.php'>Back to Users</a></div>";

        }

    }

?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input type="text" class="form-control" name="user_firstname" required>
    </div>

    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input type="text" class="form-control" name="user_lastname" required>
    </div>

    <div class="form-group">
        <label for="roles">User Role</label>
        <select name="roles" id="roles" class="form-control" required>
            <option value="Admin">Admin</option>
            <option value="Subscriber">Subscriber</option>
        </select>
    </div>

    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email" required>
    </div>

    <div class="form-group">
        <label for="user_username">Username</label>
        <input type="text" class="form-control" name="user_username" required>
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password" required>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="add_user" value="Add User">
    </div>

</form>