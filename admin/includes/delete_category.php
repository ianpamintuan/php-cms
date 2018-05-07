<?php require_once('../../includes/db.php'); ?>
<?php require_once('functions.php'); ?>

<?php

    if(isset($_POST['category_id'])) {

        $id = clean($_POST['category_id']);

        $query = "DELETE FROM tblcategories WHERE category_id = $id";
        $result = mysqli_query($connection, $query);

        checkQuery($result);

    }

?>