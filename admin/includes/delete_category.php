<?php require_once('../../includes/db.php'); ?>
<?php require_once('functions.php'); ?>

<?php

    if(isset($_POST['category_id'])) {

        $id = clean($_POST['category_id']);

        $category_stmt = mysqli_prepare($connection, "DELETE FROM tblcategories WHERE category_id = ?");

        checkPreparedStatement($category_stmt);

        mysqli_stmt_bind_param($category_stmt, "i", $id);
        mysqli_stmt_execute($category_stmt);

    }

?>