<?php require_once('../../includes/db.php'); ?>
<?php require_once('../../admin/includes/functions.php'); ?>

<?php

    if (isset($_POST['title'])) {

        $id = clean($_POST['cat_id']);

        $cat_title = strip_tags($_POST['title']);
        $cat_title = htmlspecialchars($cat_title);
        $cat_title = mysqli_real_escape_string($connection, $cat_title);

        $category_stmt = mysqli_prepare($connection, "UPDATE tblcategories SET category_title = ? WHERE category_id = ?");

        checkPreparedStatement($category_stmt);

        mysqli_stmt_bind_param($category_stmt, "si", $cat_title, $id);
        mysqli_stmt_execute($category_stmt);

        echo "<div class='alert alert-success alert-dismissible' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        Category successully updated.</div>";

    }

?>