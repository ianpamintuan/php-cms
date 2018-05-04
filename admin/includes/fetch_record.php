<?php require_once('../../includes/db.php'); ?>
<?php require_once('functions.php'); ?>

<?php

    if(isset($_POST['row_id'])) {

        $id = clean($_POST['row_id']);

        $query = "SELECT * FROM tblcategories WHERE category_id = $id";
        $result = mysqli_query($connection, $query);

        checkQuery($result); 

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