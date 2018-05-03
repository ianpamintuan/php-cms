<?php require_once('db.php'); ?>
<?php

    function clean($value) {

        global $connection;
        return mysqli_real_escape_string($connection, trim($value));
        
    }

    function getCategories() {
        
        global $connection;

        $query = "SELECT * FROM tblcategories;";
        
        $result = mysqli_query($connection, $query);

        if($result) {

            while($row = mysqli_fetch_assoc($result)) {

                $category_id = $row['category_id'];
                $category_title = $row['category_title'];

                if(isset($_GET['category']) && $_GET['category'] == $category_id) {
                    echo "<li class='active'><a href='category.php?category={$category_id}'>{$category_title}</a></li>";
                } else {
                    echo "<li><a href='category.php?category={$category_id}'>{$category_title}</a></li>";
                }

                

            }

        }

    }

?>    