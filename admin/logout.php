<?php
session_start();
$_SESSION['login']=="";
session_unset();
$_SESSION['errmsg']="You have successfully logout";
header("Location: index.php");
?>
