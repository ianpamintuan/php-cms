<?php require_once('../../includes/db.php'); ?>
<?php require_once('functions.php'); ?>

<?php

    if(isset($_POST['comment_id'])) {

        $id = clean($_POST['comment_id']);

        $comment_stmt = mysqli_prepare($connection, "DELETE FROM tblcomments WHERE comment_id = ?");

        checkPreparedStatement($comment_stmt);

        mysqli_stmt_bind_param($comment_stmt, "i", $id);
        mysqli_stmt_execute($comment_stmt);

    }

?>