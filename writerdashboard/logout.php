<?php
session_start();
unset($_SESSION['w_email']);
header("Location: ../login.php");

?>