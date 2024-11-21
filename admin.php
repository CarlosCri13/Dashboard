<?php
session_start();
require 'db.php';

// Verificar si el usuario ha iniciado sesión y es admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    die('<div class="alert alert-danger text-center">Acceso denegado. Solo el administrador puede acceder a esta página.</div>');
}

// Crear nuevo usuario si se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    $new_username = $_POST['new_username'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $new_username, $new_password, $role);
    
    if ($stmt->execute()) {
        echo "<div class='alert alert-success text-center'>Usuario creado exitosamente.</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Error al crear el usuario.</div>";
    }

    $stmt->close();
}

// Eliminar usuario
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: admin.php"); // Recargar la página después de eliminar
    exit();
}

// Obtener todos los usuarios
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .admin-container {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin: 0 auto;
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
    <div class="admin-container">
        <h2 class="text-center">Panel de administración</h2>
        <h3>Crear un nuevo usuario</h3>
        <form action="admin.php" method="post">
            <div class="mb-3">
                <label for="new_username" class="form-label">Nuevo Usuario:</label>
                <input type="text" id="new_username" name="new_username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">Contraseña:</label>
                <input type="password" id="new_password" name="new_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Rol:</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="user">Usuario</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>
            <div class="text-center">
                <input type="submit" name="create" value="Crear Usuario" class="btn btn-primary">
            </div>
        </form>
        <hr>
        <h3>Usuarios registrados</h3>
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td>
                        <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="admin.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="text-center mt-4">
            <a href="logout.php" class="btn btn-secondary">Cerrar sesión</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
