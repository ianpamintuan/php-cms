<?php require_once('../../includes/db.php'); ?>
<?php require_once('functions.php'); ?>

<?php

    if(isset($_POST['comment_id'])) {

        $id = clean($_POST['comment_id']);

        $query = "DELETE FROM tblcomments WHERE comment_id = $id";
        $result = mysqli_query($connection, $query);

        checkQuery($result);

    }

?>