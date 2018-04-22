<?php

    if(isset($_GET['edit'])) {

        $post_id = $_GET['edit'];

        $query = "SELECT * FROM tblposts WHERE post_id={$post_id}";
        $result = mysqli_query($connection, $query);

        if(!$result) {
            die("SQL Error " . mysqli_error());
        } else {

            while($row = mysqli_fetch_assoc($result)) {
                
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_content = $row['post_content'];
                $post_author = $row['post_author'];
                $category_id = $row['category_id'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_comment_count = $row['post_comment_count'];
                $post_views_count = $row['post_views_count'];
                $post_date = $row['post_date'];
            
            }

        }

    } else {
        echo "<h1>404</h1>";
    }
    
    if(isset($_POST['update_post'])) {

        $post_title = $_POST['post_title'];
        $post_author = $_POST['post_author'];
        $post_content = $_POST['post_content'];
        $category_id = $_POST['category_id'];
        $post_status = $_POST['post_status'];
        $post_tags = $_POST['post_tags'];
        
        $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']['tmp_name'];

        move_uploaded_file($post_image_temp, "../images/$post_image");

        if(empty($post_image)) {
            $image_query = "SELECT * FROM tblposts WHERE post_id = {$post_id}";
            $image_result = mysqli_query($connection, $image_query);

            while($row = mysqli_fetch_array($image_result)) {
                $post_image = $row['post_image']; 
            }
        }

        $query = "UPDATE tblposts SET post_title = '{$post_title}', post_author = '{$post_author}', category_id = {$category_id}, post_content = '{$post_content}', post_status = '{$post_status}', post_tags = '{$post_tags}', post_image = '{$post_image}' WHERE post_id = {$post_id}";

        $result = mysqli_query($connection, $query);

        if(!$result) {
            die("SQL Error" . mysqli_error($connection));
        } else {
            echo "<div class='alert alert-success alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
            Post updated successfully. <a href='../post.php?post_id={$post_id}'>View Post</a></div>";
        }
    }

?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="post_title" value="<?php echo $post_title; ?>">
    </div>

    <div class="form-group">
        <label for="category_id">Post Category</label>
        <?php displayCategories("dropdown", $category_id); ?>
    </div>

    <div class="form-group">
        <label for="post_author">Post Author</label>
        <input type="text" class="form-control" name="post_author" value="<?php echo $post_author; ?>">
    </div>

    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select name="post_status" id="post_status" class="form-control">
            <option value="<?php echo $post_status; ?>"><?php echo $post_status; ?></option>
            <?php
                if($post_status !== "Draft")
                    echo "<option value='Draft'>Draft</option>";
                else
                    echo "<option value='Published'>Published</option>";
            ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <img width="100" src="../images/<?php echo $post_image; ?>" alt="Post image" class="img-responsive" style="margin-bottom: 10px;">
        <input type="file" class="form-control" name="post_image" accept="image/*">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" class="form-control" cols="30" rows="10"><?php echo $post_content; ?></textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
    </div>

</form>