<?php
session_start();
require 'db.php';

// Verificar si el usuario ha iniciado sesión y es admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    die('<div class="alert alert-danger text-center">Acceso denegado. Solo el administrador puede acceder a esta página.</div>');
}

// Obtener los datos del usuario que se va a editar
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
} else {
    die('<div class="alert alert-danger text-center">ID de usuario no proporcionado.</div>');
}

// Actualizar el usuario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $username = $_POST['username'];
    $role = $_POST['role'];
    
    if (!empty($_POST['new_password'])) {
        $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
        $sql = "UPDATE users SET username = ?, password = ?, role = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $username, $new_password, $role, $id);
    } else {
        $sql = "UPDATE users SET username = ?, role = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $username, $role, $id);
    }
    
    if ($stmt->execute()) {
        echo "<div class='alert alert-success text-center'>Usuario actualizado exitosamente.</div>";
        header("Location: admin.php");
        exit();
    } else {
        echo "<div class='alert alert-danger text-center'>Error al actualizar el usuario.</div>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .edit-container {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        .btn-primary {
            background-color: #ff7700;
            border-color: #ff7700;
        }
        .btn-primary:hover {
            background-color: #e06600;
            border-color: #e06600;
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <h2 class="text-center">Editar Usuario</h2>
        <form action="edit_user.php?id=<?php echo $id; ?>" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Usuario:</label>
                <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">Nueva Contraseña (opcional):</label>
                <input type="password" id="new_password" name="new_password" class="form-control">
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Rol:</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>Usuario</option>
                    <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Administrador</option>
                </select>
            </div>
            <div class="text-center">
                <input type="submit" name="update" value="Actualizar Usuario" class="btn btn-primary">
            </div>
        </form>
        <div class="text-center mt-3">
            <a href="admin.php" class="btn btn-secondary">Volver a la lista de usuarios</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
