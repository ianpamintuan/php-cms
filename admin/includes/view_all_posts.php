<?php

    if(isset($_POST['submit'])) {

        $bulk_options = $_POST['bulk_options'];

        if($bulk_options !== '') {
            
            if(isset($_POST['checkboxArray'])) {

                $checkboxArray = $_POST['checkboxArray'];

                foreach($checkboxArray as $checkbox) {
                
                    switch($bulk_options) {
    
                        case 'Clone':
                        $clone_query = "INSERT INTO tblposts(post_title, post_author, category_id, post_date, post_image, post_content, post_tags, post_status) ";
                        $clone_query .= "SELECT post_title, post_author, category_id, post_date, post_image, post_content, post_tags, post_status FROM tblposts WHERE post_id = {$checkbox}" ;
                        $clone_result = mysqli_query($connection, $clone_query);

                        if(!$clone_result) {
                            die("SQL Error " . mysqli_error($connection));
                        } else {

                        }

                        break;

                        case 'Published':
                        $query = "UPDATE tblposts SET post_status = '{$bulk_options}' WHERE post_id = {$checkbox}";
                        break;
    
                        case 'Draft':
                        $query = "UPDATE tblposts SET post_status = '{$bulk_options}' WHERE post_id = {$checkbox}";
                        break;

                        case 'Delete':
                        $query = "DELETE FROM tblposts WHERE post_id = {$checkbox}";
                        break;
    
                    }
                   
                    if(isset($query)) {

                        $result = mysqli_query($connection, $query);

                        if(!$result) {
                            echo "SQL Error. " . mysqli_error($connection);
                        }

                    }

                }

                echo "<div class='alert alert-success alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                Successful in updating posts.</div>";
                

            } else {

                echo "<div class='alert alert-danger alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                Please choose post(s) to {$bulk_options}.</div>";

            }

        } else {
            echo "<div class='alert alert-danger alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
            Please choose an option.</div>";
        }

    }

?>

<form action="" method="post" id="posts_form">

    <div class="row">
        <div id="bulkOptionsContainer" class="col-xs-4">

            <select name="bulk_options" id="" class="form-control">
                <option value="">Select an option</option>
                <option value="Clone">Clone</option>
                <option value="Published">Published</option>
                <option value="Draft">Draft</option>
                <option value="Delete">Delete</option>
            </select>

        </div>
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a href="posts.php?src=add_post" class="btn btn-primary">Add New</a>
        </div>
    </div>

    <br>

    <?php
    
    //set notification message here
        if(isset($_GET['message'])) {

            $message = $_GET['message'];

            switch($message) {

                case 'delete_success':
                echo "<div class='alert alert-success alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                Successful in deleting post(s).</div>";
                break;

                case 'reset_view_success':
                echo "<div class='alert alert-success alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                Successful in resetting post view.</div>";
                break;

            }

        }

    ?>
        
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th><input type="checkbox" name="select_all" id="select_all"></th>
                <th>Id</th>
                <th>Title</th>
                <th>Content</th>
                <th>Author</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Views</th>
                <th>Date</th>
                <th colspan=2 class="text-center">Options</th>
            </tr>
        </thead>
        <tbody>
            <?php displayPostsTable(); ?>
            <?php resetViews(); ?>
        </tbody>
    </table>

</form>