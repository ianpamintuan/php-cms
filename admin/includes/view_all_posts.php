<?php

    if(isset($_POST['submit'])) {

        $bulk_options = $_POST['bulk_options'];

        if($bulk_options !== '') {
            
            if(isset($_POST['checkboxArray'])) {

                $checkboxArray = $_POST['checkboxArray'];

                foreach($checkboxArray as $checkbox) {
                
                    switch($bulk_options) {
    
                        case 'Clone':
                        $query_stmt = mysqli_prepare($connection, "INSERT INTO tblposts(post_title, post_author, category_id, post_date, post_image, post_content, post_tags, post_status) SELECT post_title, post_author, category_id, post_date, post_image, post_content, post_tags, post_status FROM tblposts WHERE post_id = ?");
                        mysqli_stmt_bind_param($query_stmt, "i", $checkbox);
                        break;

                        case 'Published':
                        $query_stmt = mysqli_prepare($connection, "UPDATE tblposts SET post_status = ? WHERE post_id = ?");
                        mysqli_stmt_bind_param($query_stmt, "si", $bulk_options, $checkbox);
                        break;
    
                        case 'Draft':
                        $query_stmt = mysqli_prepare($connection, "UPDATE tblposts SET post_status = ? WHERE post_id = ?");
                        mysqli_stmt_bind_param($query_stmt, "si", $bulk_options, $checkbox);
                        break;

                        case 'Delete':
                        $query_stmt = mysqli_prepare($connection, "DELETE FROM tblposts WHERE post_id = ?");
                        mysqli_stmt_bind_param($query_stmt, "i", $checkbox);
                        break;
    
                    }

                    checkPreparedStatement($query_stmt);

                    mysqli_stmt_execute($query_stmt);

                }

                header("Location: posts.php");

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