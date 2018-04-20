<?php require_once('db.php'); ?>
<?php

    function getCategories() {
        
        global $connection;

        $query = "SELECT * FROM tblcategories;";
        
        $result = mysqli_query($connection, $query);

        if($result) {

            while($row = mysqli_fetch_assoc($result)) {
                $category_id = $row['category_id'];
                $category_title = $row['category_title'];
                echo "<li><a href='category.php?category={$category_id}'>{$category_title}</a></li>";
            }

        }

    }

?>    