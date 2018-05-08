<?php require_once('../includes/db.php'); ?>

<?php

    if(isset($_GET['src']) == 'edit_user') {

        $user_id = clean($_GET['user_id']);
        $user_info = array();

        $user_stmt = mysqli_prepare($connection, "SELECT * FROM tblusers WHERE user_id = ?");

        checkPreparedStatement($user_stmt);

        mysqli_stmt_bind_param($user_stmt, "i", $user_id);
        mysqli_stmt_execute($user_stmt);
        $result = mysqli_stmt_get_result($user_stmt);

        if(!is_numeric($user_id) || mysqli_num_rows($result) == NULL) {
            header("Location: users.php");
            exit();
        }

        while($row = mysqli_fetch_assoc($result)) {

            $user_info['first_name'] = $row['firstname'];
            $user_info['last_name'] = $row['lastname'];
            $user_info['user_role'] = $row['user_role'];
            $user_info['email'] = $row['email'];
            $user_info['username'] = $row['username'];
            $user_info['password'] = $row['password'];

        }

    } else {

        header("Location: users.php");
        exit();

    }

    if(isset($_POST['edit_user'])) {

        $user_info['first_name'] = $_POST['user_firstname'];
        $user_info['last_name'] = $_POST['user_lastname'];
        $user_info['user_role'] = $_POST['roles'];
        $user_info['email'] = $_POST['user_email'];
        $user_info['username'] = $_POST['user_username'];
        $user_info['password'] = $_POST['user_password'];

        $hashed_password = password_hash($user_info['password'], PASSWORD_DEFAULT);

        $user_update_stmt = mysqli_prepare($connection, "UPDATE tblusers SET firstname = ?, lastname = ?, user_role = ?, email = ?, username = ?, password = ? WHERE user_id = ?");
                    
        checkPreparedStatement($user_update_stmt);

        mysqli_stmt_bind_param($user_update_stmt, "ssssssi", $user_info['first_name'], $user_info['last_name'], $user_info['user_role'], $user_info['email'], $user_info['username'], $hashed_password, $user_id);
        mysqli_stmt_execute($user_update_stmt);

        echo "<div class='alert alert-success alert-dismissible' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        User updated successfully. <a href='users.php'>Back to Users</a></div>";

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
            <option value="<?php echo isset($user_info['user_role']) ? $user_info['user_role'] : ''; ?>"><?php echo isset($user_info['user_role']) ? $user_info['user_role'] : ''; ?></option>
            <?php 
                if($user_info['user_role'] !== 'Admin')
                    echo "<option value='Admin'>Admin</option>";
                else
                    echo "<option value='Subscriber'>Subscriber</option>";
            ?>

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
        <input type="password" class="form-control" name="user_password" required>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_user" value="Update User">
    </div>

</form>