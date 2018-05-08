<?php

    if(isset($_GET['edit'])) {

        $post_id = clean($_GET['edit']);
        $post_info = array();

        $post_stmt = mysqli_prepare($connection, "SELECT * FROM tblposts WHERE post_id = ?");

        checkPreparedStatement($post_stmt);

        mysqli_stmt_bind_param($post_stmt, "i", $post_id);
        mysqli_stmt_execute($post_stmt);
        $result = mysqli_stmt_get_result($post_stmt);

        if(!is_numeric($post_id) || mysqli_num_rows($result) == NULL) {
            header("Location: posts.php");
            exit();
        }

        while($row = mysqli_fetch_assoc($result)) {
            
            $post_info['id'] = $row['post_id'];
            $post_info['title'] = $row['post_title'];
            $post_info['author'] = $row['post_author'];
            $post_info['content'] = $row['post_content'];
            $post_info['category_id'] = $row['category_id'];
            $post_info['status'] = $row['post_status'];
            $post_info['tags'] = $row['post_tags'];
            $post_info['image'] = $row['post_image'];
            $post_info['total_comments'] = $row['post_comment_count'];
            $post_info['total_views'] = $row['post_views_count'];
            $post_info['date'] = $row['post_date'];

        }

    } else {
        echo "<h1>404</h1>";
    }
    
    if(isset($_POST['update_post'])) {

        $post_info['title'] = $_POST['post_title'];
        $post_info['author'] = $_POST['post_author'];
        $post_info['content'] = $_POST['post_content'];
        $post_info['category_id'] = $_POST['category_id'];
        $post_info['status'] = $_POST['post_status'];
        $post_info['tags'] = $_POST['post_tags'];
        $post_info['image'] = $_FILES['post_image']['name'];
        $post_info['image_temp'] = $_FILES['post_image']['tmp_name'];

        move_uploaded_file($post_info['image_temp'], "../images/{$post_info['image']}");

        if(empty($post_info['image'])) {

            $image_stmt = mysqli_prepare($connection, "SELECT * FROM tblposts WHERE post_id = ?");

            checkPreparedStatement($image_stmt);

            mysqli_stmt_bind_param($image_stmt, "i", $post_info['id']);
            mysqli_stmt_execute($image_stmt);
            $image_result = mysqli_stmt_get_result($image_stmt);

            $row = mysqli_fetch_array($image_result);
            $post_info['image'] = $row['post_image'];

        }

        $post_update_stmt = mysqli_prepare($connection, "UPDATE tblposts SET post_title = ?, post_author = ?, post_image = ?, post_content = ?, post_tags = ?, post_status = ?, category_id = ? WHERE post_id = ?");

        checkPreparedStatement($post_update_stmt);

        mysqli_stmt_bind_param($post_update_stmt, "ssssssii", $post_info['title'], $post_info['author'], $post_info['image'], $post_info['content'], $post_info['tags'], $post_info['status'], $post_info['category_id'], $post_info['id']);
        mysqli_stmt_execute($post_update_stmt);

        echo "<div class='alert alert-success alert-dismissible' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        Post updated successfully. <a href='../post.php?post_id={$post_id}'>View Post</a></div>";
        
    }

?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="post_title" value="<?php echo $post_info['title']; ?>" required>
    </div>

    <div class="form-group">
        <label for="category_id">Post Category</label>
        <?php displayCategories("dropdown", $post_info['category_id']); ?>
    </div>

    <div class="form-group">
        <label for="post_author">Post Author</label>
        <?php displayUsers("dropdown", $post_info['author']); ?>
    </div>

    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select name="post_status" id="post_status" class="form-control">
            <option value="<?php echo $post_info['status']; ?>"><?php echo $post_info['status']; ?></option>
            <?php
                if($post_info['status'] !== "Draft")
                    echo "<option value='Draft'>Draft</option>";
                else
                    echo "<option value='Published'>Published</option>";
            ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <img width="100" src="../images/<?php echo $post_info['image']; ?>" alt="Post image" class="img-responsive" style="margin-bottom: 10px;">
        <input type="file" class="form-control" name="post_image" accept="image/*">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_info['tags']; ?>">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" class="form-control" cols="30" rows="10"><?php echo $post_info['content']; ?></textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
    </div>

</form>