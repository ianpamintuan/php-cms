<?php require_once('../../includes/db.php'); ?>
<?php require_once('functions.php'); ?>

<?php

    if(isset($_POST['post_id'])) {

        $id = clean($_POST['post_id']);

        $query = "DELETE FROM tblposts WHERE post_id = $id";
        $result = mysqli_query($connection, $query);

        checkQuery($result);

    }

?>