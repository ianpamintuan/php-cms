<?php require_once("../includes/db.php"); ?>

<?php

    if(isset($_POST['create_post'])) {

        $post_info = array();

        $post_info['title'] = $_POST['post_title'];
        $post_info['author'] = $_POST['post_author'];
        $post_info['content'] = $_POST['post_content'];
        $post_info['category_id'] = $_POST['category_id'];
        $post_info['status'] = $_POST['post_status'];
        $post_info['tags'] = $_POST['post_tags'];
        $post_info['image'] = $_FILES['post_image']['name'];
        $post_info['image_temp'] = $_FILES['post_image']['tmp_name'];
        $post_info['date'] = date('d-m-y');

        move_uploaded_file($post_info['image_temp'], "../images/{$post_info['image']}");

        date_default_timezone_set("Asia/Taipei");
        $post_date = date("Y-m-d");

        $post_stmt = mysqli_prepare($connection, "INSERT INTO tblposts(post_title, post_author, post_date, category_id, post_image, post_content, post_tags, post_status) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");

        checkPreparedStatement($post_stmt);

        mysqli_stmt_bind_param($post_stmt, "sssissss", $post_info['title'], $post_info['author'], $post_date, $post_info['category_id'], $post_info['image'], $post_info['content'], $post_info['tags'], $post_info['status']);
        mysqli_stmt_execute($post_stmt);

        $post_id = mysqli_insert_id($connection);

        echo "<div class='alert alert-success alert-dismissible' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        Post added successfully. <a href='../post.php?post_id={$post_id}'>View Post</a></div>";

        unset($post_info);
        
    }

?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="post_title" value="<?php echo isset($post_info['title']) ? $post_info['title'] : '';?>" required>
    </div>

    <div class="form-group">
        <label for="category_id">Post Category</label>
        <?php isset($post_info['category_id']) ? displayCategories("dropdown", $post_info['category_id']) : displayCategories("dropdown"); ?>
    </div>

    <div class="form-group">
        <label for="post_author">Post Author</label>
        <?php isset($post_info['author']) ? displayUsers("dropdown", $post_info['author']) : displayUsers("dropdown"); ?>
    </div>

    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select name="post_status" id="post_status" class="form-control">
            <?php
                if(isset($post_info['status'])) {
                    echo "<option value='" . $post_info['status'] . "'>" .$post_info['status'] . "</option>";
                    if($post_info['status'] !== "Draft") {
                        echo "<option value='Draft'>Draft</option>";
                    } else {
                        echo "<option value='Published'>Published</option>";
                    }
                } else {
            ?>
            <option value="Draft">Draft</option>
            <option value="Published">Published</option>
            <?php   }   ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" class="form-control" name="post_image" accept="image/*">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo isset($post_info['tags']) ? $post_info['tags'] : '';?>">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" class="form-control" cols="30" rows="10" value="<?php echo isset($post_info['content']) ? $post_info['content'] : '';?>"></textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="Create Post">
    </div>

</form>