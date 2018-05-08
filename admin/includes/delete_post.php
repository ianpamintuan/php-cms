<?php require_once('../../includes/db.php'); ?>
<?php require_once('functions.php'); ?>

<?php

    if(isset($_POST['post_id'])) {

        $id = clean($_POST['post_id']);

        $post_stmt = mysqli_prepare($connection, "DELETE FROM tblposts WHERE post_id = ?");

        checkPreparedStatement($post_stmt);

        mysqli_stmt_bind_param($post_stmt, "i", $id);
        mysqli_stmt_execute($post_stmt);

    }

?>