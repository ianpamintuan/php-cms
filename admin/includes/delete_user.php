<?php require_once('../../includes/db.php'); ?>
<?php require_once('functions.php'); ?>

<?php

    if(isset($_POST['user_id'])) {

        $id = clean($_POST['user_id']);

        $query = "DELETE FROM tblusers WHERE user_id = $id";
        $result = mysqli_query($connection, $query);

        checkQuery($result);

    }

?>