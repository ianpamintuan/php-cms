<?php require_once('includes/header.php'); ?>
<?php require_once('../includes/db.php'); ?>
<?php require_once('includes/functions.php'); ?>

<?php

    if(isset($_SESSION['user_id'])) {

        $user_id = $_SESSION['user_id'];

        $query = "SELECT * FROM tblusers WHERE user_id = {$user_id}";
        $result = mysqli_query($connection, $query);

        if(!$result) {
            die("SQL Error in the Profile query." . mysqli_error($connection));
        } else {

            while($row = mysqli_fetch_array($result)) {

                $user_firstname = $row['firstname'];
                $user_lastname = $row['lastname'];
                $user_role = $row['user_role'];
                $user_email = $row['email'];
                $user_username = $row['username'];
                $user_password = $row['password'];

            }

        }

    }

?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php require_once('includes/nav.php'); ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            My Profile
                        </h1>

                        <?php
                        
                        if(isset($_POST['update_profile'])) {

                            $user_firstname = $_POST['user_firstname'];
                            $user_lastname = $_POST['user_lastname'];
                            $user_role = $_POST['roles'];
                            $user_email = $_POST['user_email'];
                            $user_username = $_POST['user_username'];
                            $user_password = $_POST['user_password'];
                            
                            $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
                    
                            $query = "UPDATE tblusers SET firstname = '{$user_firstname}', lastname = '{$user_lastname}', user_role = '{$user_role}', email = '{$user_email}', username = '{$user_username}', password = '{$hashed_password}' ";
                            $query .= "WHERE user_id = $user_id";
                    
                            $result = mysqli_query($connection, $query);
                    
                            if(!$result) {
                                die("SQL error " . mysqli_error($connection));
                            } else {
                                echo "<div class='alert alert-success alert-dismissible' role='alert'>
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                Profile updated successfully.</div>";
                            }
                    
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
                            <input type="submit" class="btn btn-primary" name="update_profile" value="Update Profile">
                        </div>

                    </form>                

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php require_once('includes/footer.php'); ?>
