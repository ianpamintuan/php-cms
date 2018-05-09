<?php session_start(); ?>
<?php require_once('db.php'); ?>
<?php require_once('../admin/includes/functions.php'); ?>

<?php

    if(isset($_POST['login'])) {

        login($_POST['username'], $_POST['password']);

    }

?>