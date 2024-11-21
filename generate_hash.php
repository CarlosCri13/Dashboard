<?php
// Generar una contraseña hasheada usando password_hash
$hashed_password = password_hash('titulacion2024', PASSWORD_BCRYPT);
echo $hashed_password;
?>
