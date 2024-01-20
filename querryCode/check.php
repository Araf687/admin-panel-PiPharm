<?php
$admin_pass='araf';
$admin_pass_encrypted = password_hash($admin_pass, PASSWORD_DEFAULT);

$checkPass=password_verify($admin_pass, $admin_pass_encrypted);
echo $admin_pass."   ".$admin_pass_encrypted."      ".$checkPass."     ".gettype($admin_pass_encrypted);
