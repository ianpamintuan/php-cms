<?php require_once('../includes/db.php'); ?>

<?php

    if(isset($_GET['src']) == 'edit_user') {

        $user_id = clean($_GET['user_id']);
        $user_info = array();
        
        $query = "SELECT * FROM tblusers WHERE user_id = {$user_id}";
        $result = mysqli_query($connection, $query);

        checkQuery($result);

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

        foreach($user_info as $key => $value) {
            $user_info[$key] = clean($value);
        }

        $hashed_password = password_hash($user_info['password'], PASSWORD_DEFAULT);

        $query = "UPDATE tblusers SET firstname = '" . $user_info['first_name'] . "', lastname = '" . $user_info['last_name'] . "', user_role = '" . $user_info['user_role'] . "', email = '" . $user_info['email'] . "', username = '" . $user_info['username'] . "', password = '{$hashed_password}' ";
        $query .= "WHERE user_id = $user_id";
        $result = mysqli_query($connection, $query);

        checkQuery($result);

        $user_info['first_name'] = $_POST['user_firstname'];
        $user_info['last_name'] = $_POST['user_lastname'];
        $user_info['user_role'] = $_POST['roles'];
        $user_info['email'] = $_POST['user_email'];
        $user_info['username'] = $_POST['user_username'];
        $user_info['password'] = $_POST['user_password'];

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