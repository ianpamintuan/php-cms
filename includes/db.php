<?php

    $db['db_host'] = "localhost";
    $db['db_username'] = "root";
    $db['db_password'] = "";
    $db['db_name'] = "dbcms";
    
    foreach($db as $key => $val) {
        define(strtoupper($key), $val);
    }
 
    $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if (!$connection) {
        die("Error in connecting database. " . mysqli_error($connection));
    }

?>