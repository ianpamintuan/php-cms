<?php require_once("../includes/db.php"); ?>

<?php

    if(isset($_POST['create_post'])) {

         $post_title = $_POST['post_title'];
         $post_author = $_POST['post_author'];
         $post_content = $_POST['post_content'];
         $category_id = $_POST['category_id'];
         $post_status = $_POST['post_status'];
         $post_tags = $_POST['post_tags'];

         $post_image = $_FILES['post_image']['name'];
         $post_image_temp = $_FILES['post_image']['tmp_name'];

         $post_date = date('d-m-y');
         $post_comment_count = 0;

         move_uploaded_file($post_image_temp, "../images/$post_image");

         $query = "INSERT INTO tblposts(post_title, post_author, category_id, post_date, post_image, post_content, post_tags, post_comment_count, post_status) ";
         $query .= "VALUES('{$post_title}', '{$post_author}', {$category_id}, now(), '{$post_image}', '{$post_content}', '{$post_tags}', '${post_comment_count}', '{$post_status}')";

        $result = mysqli_query($connection, $query);

        if(!$result) {
            die("SQL error " . mysqli_error($connection));
        } else {
            echo "Post added successfully!";
        }

    }

?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="post_title">
    </div>

    <div class="form-group">
        <label for="category_id">Post Category</label>
        <?php displayCategories("dropdown"); ?>
    </div>

    <div class="form-group">
        <label for="post_author">Post Author</label>
        <input type="text" class="form-control" name="post_author">
    </div>

    <div class="form-group">
        <label for="post_status">Post Status</label>
        <input type="text" class="form-control" name="post_status">
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