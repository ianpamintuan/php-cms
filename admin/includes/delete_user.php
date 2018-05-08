<?php require_once('../../includes/db.php'); ?>
<?php require_once('functions.php'); ?>

<?php

    if(isset($_POST['user_id'])) {

        $id = clean($_POST['user_id']);

        $user_stmt = mysqli_prepare($connection, "DELETE FROM tblusers WHERE user_id = ?");

        checkPreparedStatement($user_stmt);

        mysqli_stmt_bind_param($user_stmt, "i", $id);
        mysqli_stmt_execute($user_stmt);

    }

?>