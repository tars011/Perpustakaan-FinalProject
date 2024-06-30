<?php
session_start();
$_SESSION = [];
session_unset();
session_destroy();

setcookie('login', '', time() - 3600);
setcookie('id_user', '', time() - 3600);

header("Location: index.php");
exit;

?>