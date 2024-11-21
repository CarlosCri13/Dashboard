<?php
session_start();
require 'db.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Eliminar registro
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM datos_modalidad WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: datos.php");
    exit();
}

// Actualizar registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $per = $_POST['per'] ?? '';
    $fac = $_POST['fac'] ?? '';
    $carr = $_POST['carr'] ?? '';
    $est_mat = $_POST['est_mat'] ?? 0;
    $est_ult_niv = $_POST['est_ult_niv'] ?? 0;
    $est_tit_ult_niv = $_POST['est_tit_ult_niv'] ?? 0;
    $est_prim_pror = $_POST['est_prim_pror'] ?? 0;
    $est_tit_prim_pror = $_POST['est_tit_prim_pror'] ?? 0;
    $est_seg_pror = $_POST['est_seg_pror'] ?? 0;
    $est_tit_seg_pror = $_POST['est_tit_seg_pror'] ?? 0;
    $est_act_sin_curso_prim_pror = $_POST['est_act_sin_curso_prim_pror'] ?? 0;
    $est_tit_act_sin_curso_prim_pror = $_POST['est_tit_act_sin_curso_prim_pror'] ?? 0;
    $est_act_sin_curso_seg_pror = $_POST['est_act_sin_curso_seg_pror'] ?? 0;
    $est_tit_act_sin_curso_seg_pror = $_POST['est_tit_act_sin_curso_seg_pror'] ?? 0;
    $est_aprob_act_prim_pror = $_POST['est_aprob_act_prim_pror'] ?? 0;
    $est_aprob_tit_act_prim_pror = $_POST['est_aprob_tit_act_prim_pror'] ?? 0;
    $est_aprob_act_seg_pror = $_POST['est_aprob_act_seg_pror'] ?? 0;
    $est_aprob_tit_act_seg_pror = $_POST['est_aprob_tit_act_seg_pror'] ?? 0;

    $sql = "UPDATE datos_modalidad SET per=?, fac=?, carr=?, est_mat=?, est_ult_niv=?, est_tit_ult_niv=?, est_prim_pror=?, est_tit_prim_pror=?, est_seg_pror=?, est_tit_seg_pror=?, est_act_sin_curso_prim_pror=?, est_tit_act_sin_curso_prim_pror=?, est_act_sin_curso_seg_pror=?, est_tit_act_sin_curso_seg_pror=?, est_aprob_act_prim_pror=?, est_aprob_tit_act_prim_pror=?, est_aprob_act_seg_pror=?, est_aprob_tit_act_seg_pror=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssiiiiiiiiiiiiiiii", $per, $fac, $carr, $est_mat, $est_ult_niv, $est_tit_ult_niv, $est_prim_pror, $est_tit_prim_pror, $est_seg_pror, $est_tit_seg_pror, $est_act_sin_curso_prim_pror, $est_tit_act_sin_curso_prim_pror, $est_act_sin_curso_seg_pror, $est_tit_act_sin_curso_seg_pror, $est_aprob_act_prim_pror, $est_aprob_tit_act_prim_pror, $est_aprob_act_seg_pror, $est_aprob_tit_act_seg_pror, $id);

        if ($stmt->execute()) {
            echo "Registro actualizado exitosamente.";
        } else {
            echo "Error al actualizar el registro.";
        }

        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta.";
    }
}

// Crear nuevo registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    $per = $_POST['per'] ?? '';
    $fac = $_POST['fac'] ?? '';
    $carr = $_POST['carr'] ?? '';
    $est_mat = $_POST['est_mat'] ?? 0;
    $est_ult_niv = $_POST['est_ult_niv'] ?? 0;
    $est_tit_ult_niv = $_POST['est_tit_ult_niv'] ?? 0;
    $est_prim_pror = $_POST['est_prim_pror'] ?? 0;
    $est_tit_prim_pror = $_POST['est_tit_prim_pror'] ?? 0;
    $est_seg_pror = $_POST['est_seg_pror'] ?? 0;
    $est_tit_seg_pror = $_POST['est_tit_seg_pror'] ?? 0;
    $est_act_sin_curso_prim_pror = $_POST['est_act_sin_curso_prim_pror'] ?? 0;
    $est_tit_act_sin_curso_prim_pror = $_POST['est_tit_act_sin_curso_prim_pror'] ?? 0;
    $est_act_sin_curso_seg_pror = $_POST['est_act_sin_curso_seg_pror'] ?? 0;
    $est_tit_act_sin_curso_seg_pror = $_POST['est_tit_act_sin_curso_seg_pror'] ?? 0;
    $est_aprob_act_prim_pror = $_POST['est_aprob_act_prim_pror'] ?? 0;
    $est_aprob_tit_act_prim_pror = $_POST['est_aprob_tit_act_prim_pror'] ?? 0;
    $est_aprob_act_seg_pror = $_POST['est_aprob_act_seg_pror'] ?? 0;
    $est_aprob_tit_act_seg_pror = $_POST['est_aprob_tit_act_seg_pror'] ?? 0;

    $sql = "INSERT INTO datos_modalidad (per, fac, carr, est_mat, est_ult_niv, est_tit_ult_niv, est_prim_pror, est_tit_prim_pror, est_seg_pror, est_tit_seg_pror, est_act_sin_curso_prim_pror, est_tit_act_sin_curso_prim_pror, est_act_sin_curso_seg_pror, est_tit_act_sin_curso_seg_pror, est_aprob_act_prim_pror, est_aprob_tit_act_prim_pror, est_aprob_act_seg_pror, est_aprob_tit_act_seg_pror) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssiiiiiiiiiiiiii", $per, $fac, $carr, $est_mat, $est_ult_niv, $est_tit_ult_niv, $est_prim_pror, $est_tit_prim_pror, $est_seg_pror, $est_tit_seg_pror, $est_act_sin_curso_prim_pror, $est_tit_act_sin_curso_prim_pror, $est_act_sin_curso_seg_pror, $est_tit_act_sin_curso_seg_pror, $est_aprob_act_prim_pror, $est_aprob_tit_act_prim_pror, $est_aprob_act_seg_pror, $est_aprob_tit_act_seg_pror);

        if ($stmt->execute()) {
            echo "Registro creado exitosamente.";
        } else {
            echo "Error al crear el registro.";
        }
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta.";
    }
}

// Obtener todos los registros
$sql = "SELECT * FROM datos_modalidad";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Datos Modalidad</title>
    <script>
        function actualizarCarreras() {
            const facultad = document.getElementById("fac").value;
            const carreraSelect = document.getElementById("carr");
            carreraSelect.innerHTML = "";

            let opciones = [];

            if (facultad === "Facultad de Ciencias de la Educación, Humanas y Tecnologías") {
                opciones = ["Ciencias Exactas", "Ciencias Sociales", "Diseño Gráfico", "Educación Básica", "Educación Parvularia e Inicial", "Idiomas Inglés", "Psicología Educativa, Orientación Vocacional y Familiar"];
            } else if (facultad === "Facultad de Ciencias Políticas y Administrativas") {
                opciones = ["Comunicación Social", "Contabilidad y Auditoría", "Derecho", "Economía", "Gestión Turística y Hotelera", "Ingeniería Comercial"];
            } else if (facultad === "Facultad de Ciencias de la Salud") {
                opciones = ["Enfermería", "Laboratorio Clínico e Histopatológico", "Medicina", "Odontología", "Psicología Clínica", "Terapia Física"];
            } else if (facultad === "Facultad de Ingeniería") {
                opciones = ["Arquitectura", "Ingeniería Agroindustrial", "Ingeniería Civil", "Ingeniería en Electrónica y Telecomunicaciones", "Ingeniería en Sistemas y Computación", "Ingeniería Industrial"];
            }

            opciones.forEach(function (opcion) {
                const nuevoOpcion = document.createElement("option");
                nuevoOpcion.value = opcion;
                nuevoOpcion.text = opcion;
                carreraSelect.appendChild(nuevoOpcion);
            });
        }
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<!-- Formulario para crear un nuevo registro -->
<h2>Crear nuevo registro</h2>
<form action="datos.php" method="POST">
    <input type="hidden" name="create" value="1">

    <label for="per">Periodo:</label>
    <select name="per">
        <option value="2024-1S">2024-1S</option>
        <option value="2024-2S">2024-2S</option>
        <option value="2023-1S">2023-1S</option>
        <option value="2023-2S">2023-2S</option>
    </select><br>

    <label for="fac">Facultad:</label>
    <select id="fac" name="fac" onchange="actualizarCarreras()">
        <option value="Facultad de Ciencias de la Educación, Humanas y Tecnologías">Facultad de Ciencias de la Educación, Humanas y Tecnologías</option>
        <option value="Facultad de Ciencias Políticas y Administrativas">Facultad de Ciencias Políticas y Administrativas</option>
        <option value="Facultad de Ciencias de la Salud">Facultad de Ciencias de la Salud</option>
        <option value="Facultad de Ingeniería">Facultad de Ingeniería</option>
    </select><br>

    <label for="carr">Carrera:</label>
    <select id="carr" name="carr"></select><br>

    <!-- Campos numéricos -->
    <label for="est_mat">Estudiantes Matriculados:</label>
    <input type="number" name="est_mat" required><br>

    <label for="est_ult_niv">Estudiantes Último Nivel:</label>
    <input type="number" name="est_ult_niv" required><br>

    <label for="est_tit_ult_niv">Estudiantes Titulados Último Nivel:</label>
    <input type="number" name="est_tit_ult_niv" required><br>

    <label for="est_prim_pror">Estudiantes Primera Prórroga:</label>
    <input type="number" name="est_prim_pror" required><br>

    <label for="est_tit_prim_pror">Estudiantes Titulados Primera Prórroga:</label>
    <input type="number" name="est_tit_prim_pror" required><br>

    <label for="est_seg_pror">Estudiantes Segunda Prórroga:</label>
    <input type="number" name="est_seg_pror" required><br>

    <label for="est_tit_seg_pror">Estudiantes Titulados Segunda Prórroga:</label>
    <input type="number" name="est_tit_seg_pror" required><br>

    <label for="est_act_sin_curso_prim_pror">Est. Actualización sin Curso Primera Prórroga:</label>
    <input type="number" name="est_act_sin_curso_prim_pror" required><br>

    <label for="est_tit_act_sin_curso_prim_pror">Est. Titulados Actualización sin Curso Primera Prórroga:</label>
    <input type="number" name="est_tit_act_sin_curso_prim_pror" required><br>

    <label for="est_act_sin_curso_seg_pror">Est. Actualización sin Curso Segunda Prórroga:</label>
    <input type="number" name="est_act_sin_curso_seg_pror" required><br>

    <label for="est_tit_act_sin_curso_seg_pror">Est. Titulados Actualización sin Curso Segunda Prórroga:</label>
    <input type="number" name="est_tit_act_sin_curso_seg_pror" required><br>

    <label for="est_aprob_act_prim_pror">Est. Aprob. Actualización Primera Prórroga:</label>
    <input type="number" name="est_aprob_act_prim_pror" required><br>

    <label for="est_aprob_tit_act_prim_pror">Est. Aprob. Titulados Actualización Primera Prórroga:</label>
    <input type="number" name="est_aprob_tit_act_prim_pror" required><br>

    <label for="est_aprob_act_seg_pror">Est. Aprob. Actualización Segunda Prórroga:</label>
    <input type="number" name="est_aprob_act_seg_pror" required><br>

    <label for="est_aprob_tit_act_seg_pror">Est. Aprob. Titulados Actualización Segunda Prórroga:</label>
    <input type="number" name="est_aprob_tit_act_seg_pror" required><br>

    <input type="submit" value="Crear nuevo registro">
</form>

<!-- Tabla para mostrar y actualizar registros existentes -->
<h2>Listado de registros</h2>
<table>
    <tr>
        <th>Periodo</th>
        <th>Facultad</th>
        <th>Carrera</th>
        <th>Est. Mat.</th>
        <th>Est. Último Nivel</th>
        <th>Est. Tit. Último Nivel</th>
        <th>Est. Primera Prórroga</th>
        <th>Est. Tit. Primera Prórroga</th>
        <th>Est. Segunda Prórroga</th>
        <th>Est. Tit. Segunda Prórroga</th>
        <th>Est. Act. sin Curso Primera Prórroga</th>
        <th>Est. Tit. Act. sin Curso Primera Prórroga</th>
        <th>Est. Act. sin Curso Segunda Prórroga</th>
        <th>Est. Tit. Act. sin Curso Segunda Prórroga</th>
        <th>Est. Aprob. Act. Primera Prórroga</th>
        <th>Est. Aprob. Tit. Act. Primera Prórroga</th>
        <th>Est. Aprob. Act. Segunda Prórroga</th>
        <th>Est. Aprob. Tit. Act. Segunda Prórroga</th>
        <th>Acciones</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <form action="datos.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <td><input type="text" name="per" value="<?php echo $row['per']; ?>"></td>
            <td><input type="text" name="fac" value="<?php echo $row['fac']; ?>"></td>
            <td><input type="text" name="carr" value="<?php echo $row['carr']; ?>"></td>
            <td><input type="number" name="est_mat" value="<?php echo $row['est_mat']; ?>"></td>
            <td><input type="number" name="est_ult_niv" value="<?php echo $row['est_ult_niv']; ?>"></td>
            <td><input type="number" name="est_tit_ult_niv" value="<?php echo $row['est_tit_ult_niv']; ?>"></td>
            <td><input type="number" name="est_prim_pror" value="<?php echo $row['est_prim_pror']; ?>"></td>
            <td><input type="number" name="est_tit_prim_pror" value="<?php echo $row['est_tit_prim_pror']; ?>"></td>
            <td><input type="number" name="est_seg_pror" value="<?php echo $row['est_seg_pror']; ?>"></td>
            <td><input type="number" name="est_tit_seg_pror" value="<?php echo $row['est_tit_seg_pror']; ?>"></td>
            <td><input type="number" name="est_act_sin_curso_prim_pror" value="<?php echo $row['est_act_sin_curso_prim_pror']; ?>"></td>
            <td><input type="number" name="est_tit_act_sin_curso_prim_pror" value="<?php echo $row['est_tit_act_sin_curso_prim_pror']; ?>"></td>
            <td><input type="number" name="est_act_sin_curso_seg_pror" value="<?php echo $row['est_act_sin_curso_seg_pror']; ?>"></td>
            <td><input type="number" name="est_tit_act_sin_curso_seg_pror" value="<?php echo $row['est_tit_act_sin_curso_seg_pror']; ?>"></td>
            <td><input type="number" name="est_aprob_act_prim_pror" value="<?php echo $row['est_aprob_act_prim_pror']; ?>"></td>
            <td><input type="number" name="est_aprob_tit_act_prim_pror" value="<?php echo $row['est_aprob_tit_act_prim_pror']; ?>"></td>
            <td><input type="number" name="est_aprob_act_seg_pror" value="<?php echo $row['est_aprob_act_seg_pror']; ?>"></td>
            <td><input type="number" name="est_aprob_tit_act_seg_pror" value="<?php echo $row['est_aprob_tit_act_seg_pror']; ?>"></td>
            <td>
                <input type="submit" name="update" value="Guardar">
                <a href="datos.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?')">Eliminar</a>
            </td>
        </form>
    </tr>
    <?php endwhile; ?>
</table>

<p><a href="welcome.php">Regresar a la página de bienvenida</a></p>

</body>
</html>

<?php
$conn->close();
?>
