<?php require_once('../../includes/db.php'); ?>
<?php require_once('functions.php'); ?>

<?php

    if(isset($_POST['row_id'])) {

        $id = clean($_POST['row_id']);

        $category_stmt = mysqli_prepare($connection, "SELECT * FROM tblcategories WHERE category_id = ?");

        checkPreparedStatement($category_stmt);

        mysqli_stmt_bind_param($category_stmt, "i", $id);
        mysqli_stmt_execute($category_stmt);
        $result = mysqli_stmt_get_result($category_stmt);

        while($row = mysqli_fetch_assoc($result)) {

            $category_title = $row['category_title'];

            echo "<form class='editForm' name='editForm'>";
            echo "<b>Category ID:</b> <input value='{$row['category_id']}' name='cat_id' class='form-control' readonly> <br><br>";
            echo "<div class='form-group'>";
            echo "<label>Category Name</label>";
            ?>
            <input value="<?php echo $category_title; ?>" name="title" class="form-control" required>
            </div>
            <?php
        }

    }

?>