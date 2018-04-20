<?php require_once('../includes/db.php'); ?>

<?php

    if(isset($_GET['src']) == 'edit_user') {

        $user_id = $_GET['user_id'];
        
        $query = "SELECT * FROM tblusers WHERE user_id = {$user_id}";

        $result = mysqli_query($connection, $query);

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

    }

    if(isset($_POST['edit_user'])) {

        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_role = $_POST['roles'];
        $user_email = $_POST['user_email'];
        $user_username = $_POST['user_username'];
        $user_password = $_POST['user_password'];

        $query = "UPDATE tblusers SET firstname = '{$user_firstname}', lastname = '{$user_lastname}', user_role = '{$user_role}', email = '{$user_email}', username = '{$user_username}', password = '{$user_password}' ";
        $query .= "WHERE user_id = $user_id";

        $result = mysqli_query($connection, $query);

        if(!$result) {
            die("SQL error " . mysqli_error($connection));
        } else {
            echo "User updated successfully!";
        }

    }

?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php echo isset($user_firstname) ? $user_firstname : ''; ?>">
    </div>

    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input type="text" class="form-control" name="user_lastname" value="<?php echo isset($user_lastname) ? $user_lastname : ''; ?>">
    </div>
    <div class="form-group">
        <label for="roles">User Role</label>
        <select name="roles" id="roles" class="form-control">
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
        <input type="text" class="form-control" name="user_email" value="<?php echo isset($user_email) ? $user_email : ''; ?>">
    </div>

    <div class="form-group">
        <label for="user_username">Username</label>
        <input type="text" class="form-control" name="user_username" value="<?php echo isset($user_username) ? $user_username : ''; ?>">
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password" value="<?php echo isset($user_password) ? $user_password : ''; ?>">
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_user" value="Update User">
    </div>

</form>