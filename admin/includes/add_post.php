<?php require_once("../includes/db.php"); ?>

<?php

    if(isset($_POST['create_post'])) {

        $post_title = clean($_POST['post_title']);
        $post_author = clean($_POST['post_author']);
        $post_content = clean($_POST['post_content']);
        $category_id = clean($_POST['category_id']);
        $post_status = clean($_POST['post_status']);
        $post_tags = clean($_POST['post_tags']);

        $post_image = $_FILES['post_image']['name'];
        $post_image_temp = $_FILES['post_image']['tmp_name'];

        $post_date = date('d-m-y');
        $post_comment_count = 0;

        move_uploaded_file($post_image_temp, "../images/$post_image");

        $query = "INSERT INTO tblposts(post_title, post_author, category_id, post_date, post_image, post_content, post_tags, post_comment_count, post_status) ";
        $query .= "VALUES('{$post_title}', '{$post_author}', {$category_id}, now(), '{$post_image}', '{$post_content}', '{$post_tags}', '${post_comment_count}', '{$post_status}')";

        $result = mysqli_query($connection, $query);

        $post_id = mysqli_insert_id($connection);

        if(!$result) {
            die("SQL error " . mysqli_error($connection));
        } else {
            echo "<div class='alert alert-success alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
            Post added successfully. <a href='../post.php?post_id={$post_id}'>View Post</a></div>";
        }

    }

?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="post_title" required>
    </div>

    <div class="form-group">
        <label for="category_id">Post Category</label>
        <?php displayCategories("dropdown"); ?>
    </div>

    <div class="form-group">
        <label for="post_author">Post Author</label>
        <?php displayUsers("dropdown"); ?>
    </div>

    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select name="post_status" id="post_status" class="form-control">
            <option value="Draft">Draft</option>
            <option value="Published">Published</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" class="form-control" name="post_image" accept="image/*">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" class="form-control" cols="30" rows="10"></textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="Create Post">
    </div>

</form>