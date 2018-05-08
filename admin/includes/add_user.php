<?php require_once("../includes/db.php"); ?>

<?php

    if(isset($_POST['add_user'])) {

        $user_info = array();

        $user_info['first_name'] = $_POST['user_firstname'];
        $user_info['last_name'] = $_POST['user_lastname'];
        $user_info['user_role'] = $_POST['roles'];
        $user_info['email'] = $_POST['user_email'];
        $user_info['username'] = $_POST['user_username'];
        $user_info['password'] = $_POST['user_password'];

        foreach($user_info as $info) {
            if(empty($info)) {
                echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                Please complete all the required fields.</div>";
                break;
            }
        }

        if(userDetailDuplicate("username", $user_info['username'])) {

            echo "<div class='alert alert-danger alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
            Username already exists.</div>";

        } else if(userDetailDuplicate("email", $user_info['email'])) {

            echo "<div class='alert alert-danger alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
            Email already exists.</div>";

        } else {

            $hashed_password = password_hash($user_info['password'], PASSWORD_DEFAULT);

            register($user_info['first_name'], $user_info['last_name'], $user_info['email'], $user_info['username'], $hashed_password, $user_info['user_role']);

            echo "<div class='alert alert-success alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
            User added successfully. <a href='users.php'>Back to Users</a></div>";

            unset($user_info);

        }

    }

?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php echo isset($user_info['first_name']) ? $user_info['first_name'] : ''; ?>" required>
    </div>

    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input type="text" class="form-control" name="user_lastname" value="<?php echo isset($user_info['last_name']) ? $user_info['last_name'] : ''; ?>" required>
    </div>

    <div class="form-group">
        <label for="roles">User Role</label>
        <select name="roles" id="roles" class="form-control" required>
            <?php 
                if(isset($user_info['user_role'])) {
                    echo "<option value='" . $user_info['user_role'] . "'>" .$user_info['user_role'] . "</option>";
                    if($user_info['user_role'] !== "Admin") {
                        echo "<option value='Admin'>Admin</option>";
                    } else {
                        echo "<option value='Subscriber'>Subscriber</option>";
                    }
                } else {
            ?>
            <option value="Admin">Admin</option>
            <option value="Subscriber">Subscriber</option>
            <?php   }   ?>
        </select>
    </div>

    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email" value="<?php echo isset($user_info['email']) ? $user_info['email'] : ''; ?>" required>
    </div>

    <div class="form-group">
        <label for="user_username">Username</label>
        <input type="text" class="form-control" name="user_username" value="<?php echo isset($user_info['username']) ? $user_info['username'] : ''; ?>" required>
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password" value="<?php echo isset($user_info['password']) ? $user_info['password'] : ''; ?>" required>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="add_user" value="Add User">
    </div>

</form>