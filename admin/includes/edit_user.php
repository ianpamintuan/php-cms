<?php require_once('../includes/db.php'); ?>

<?php

    if(isset($_GET['src']) == 'edit_user') {

        $user_id = clean($_GET['user_id']);
        
        $query = "SELECT * FROM tblusers WHERE user_id = {$user_id}";
        $result = mysqli_query($connection, $query);

        if(!is_numeric($user_id) || mysqli_num_rows($result) == NULL) {
            header("Location: users.php");
            exit();
        }

        if(!$result) {
            die("SQL error " . mysqli_error($connection));
        } else {

            while($row = mysqli_fetch_assoc($result)) {

                $user_firstname = $row['firstname'];
                $user_lastname = $row['lastname'];
                $user_role = $row['user_role'];
                $user_email = $row['email'];
                $user_username = $row['username'];
                $user_password = $row['password'];

            }            

        }

    } else {

        header("Location: users.php");
        exit();

    }

    if(isset($_POST['edit_user'])) {

        $user_firstname = clean($_POST['user_firstname']);
        $user_lastname = clean($_POST['user_lastname']);
        $user_role = clean($_POST['roles']);
        $user_email = clean($_POST['user_email']);
        $user_username = clean($_POST['user_username']);
        $user_password = clean($_POST['user_password']);

        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

        $query = "UPDATE tblusers SET firstname = '{$user_firstname}', lastname = '{$user_lastname}', user_role = '{$user_role}', email = '{$user_email}', username = '{$user_username}', password = '{$hashed_password}' ";
        $query .= "WHERE user_id = $user_id";
        $result = mysqli_query($connection, $query);

        checkQuery($result);

        echo "<div class='alert alert-success alert-dismissible' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        User updated successfully. <a href='users.php'>Back to Users</a></div>";

    }

?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php echo isset($user_firstname) ? $user_firstname : ''; ?>" required>
    </div>

    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input type="text" class="form-control" name="user_lastname" value="<?php echo isset($user_lastname) ? $user_lastname : ''; ?>" required>
    </div>
    <div class="form-group">
        <label for="roles">User Role</label>
        <select name="roles" id="roles" class="form-control" required>
            <option value='<?php echo $user_role; ?>'><?php echo $user_role; ?></option>
            <?php 
                if($user_role !== 'Admin')
                    echo "<option value='Admin'>Admin</option>";
                else
                    echo "<option value='Subscriber'>Subscriber</option>";
            ?>

        </select>
    </div>

    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email" value="<?php echo isset($user_email) ? $user_email : ''; ?>" required>
    </div>

    <div class="form-group">
        <label for="user_username">Username</label>
        <input type="text" class="form-control" name="user_username" value="<?php echo isset($user_username) ? $user_username : ''; ?>" required>
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password" required>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_user" value="Update User">
    </div>

</form>