<?php
$password_plain = "K@rabo@123";
$password_hash = password_hash($password_plain, PASSWORD_DEFAULT);
echo $password_hash;
?>