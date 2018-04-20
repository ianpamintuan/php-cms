<?php require_once('../../includes/db.php'); ?>

<?php

    if (isset($_POST['title'])) {

        $id = $_POST['cat_id'];

        $cat_title = strip_tags($_POST['title']);
        $cat_title = htmlspecialchars($cat_title);

        $query = "UPDATE tblcategories SET category_title='{$cat_title}' WHERE category_id=$id;";

        $result = mysqli_query($connection, $query);

        if($result) {

            echo "<div class='alert alert-success alert-dismissible' role='alert'>
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
            Category successully updated.</div>";

        } else {
            die("SQL error " . mysqli_error($connection));
        }



    }

?>