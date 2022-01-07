<?php
session_start();
unset($_SESSION['Admin_logged_in']);
session_destroy();
header('location:../index.php');

?>