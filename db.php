<?php
$host = 'localhost';
$db = 'login_db';
$user = 'root';  // Cambia esto si tienes un usuario diferente
$pass = '';  // Normalmente la contraseña de root en XAMPP está vacía

$conn = new mysqli($host, $user, $pass, $db);

// Verificar la conexión
if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}
?>
