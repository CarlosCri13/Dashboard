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

    // Verifica si el id es válido
    if (!empty($id) && is_numeric($id)) {
        $sql = "DELETE FROM reprobacion_definitiva WHERE id = ?";
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            die("Error en la preparación de la consulta SQL: " . $conn->error);
        }

        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            header("Location: reprobacion_definitiva.php");  // Redirige a la página correcta después de eliminar
            exit();
        } else {
            echo "Error al eliminar el registro: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Actualizar registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];

    if (!empty($id) && is_numeric($id)) {
        $periodo = $_POST['periodo'];
        $facultad = $_POST['facultad'];
        $carrera = $_POST['carrera'];
        $est_pierden_titulacion_prorroga = $_POST['est_pierden_titulacion_prorroga'];
        $est_pierden_actualizacion_sin_curso = $_POST['est_pierden_actualizacion_sin_curso'];
        $est_pierden_actualizacion_con_curso = $_POST['est_pierden_actualizacion_con_curso'];
        $total_profesores_carga_horaria = $_POST['total_profesores_carga_horaria'];
        $total_horas_tutorias = $_POST['total_horas_tutorias'];
        $profesores_tutoria_proyecto_investigacion = $_POST['profesores_tutoria_proyecto_investigacion'];
        $profesores_tutoria_examen_complexivo = $_POST['profesores_tutoria_examen_complexivo'];
        $est_matriculados_actualizacion_aprobacion = $_POST['est_matriculados_actualizacion_aprobacion'];
        $est_aprobaron_curso_actualizacion = $_POST['est_aprobaron_curso_actualizacion'];
        $est_reprobaron_curso_actualizacion = $_POST['est_reprobaron_curso_actualizacion'];

        $sql = "UPDATE reprobacion_definitiva SET periodo=?, facultad=?, carrera=?, est_pierden_titulacion_prorroga=?, est_pierden_actualizacion_sin_curso=?, est_pierden_actualizacion_con_curso=?, total_profesores_carga_horaria=?, total_horas_tutorias=?, profesores_tutoria_proyecto_investigacion=?, profesores_tutoria_examen_complexivo=?, est_matriculados_actualizacion_aprobacion=?, est_aprobaron_curso_actualizacion=?, est_reprobaron_curso_actualizacion=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            die("Error en la consulta SQL: " . $conn->error);
        }

        $stmt->bind_param("sssiiiiiiiiiii", $periodo, $facultad, $carrera, $est_pierden_titulacion_prorroga, $est_pierden_actualizacion_sin_curso, $est_pierden_actualizacion_con_curso, $total_profesores_carga_horaria, $total_horas_tutorias, $profesores_tutoria_proyecto_investigacion, $profesores_tutoria_examen_complexivo, $est_matriculados_actualizacion_aprobacion, $est_aprobaron_curso_actualizacion, $est_reprobaron_curso_actualizacion, $id);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success text-center'>Registro actualizado exitosamente.</div>";
        } else {
            echo "<div class='alert alert-danger text-center'>Error al actualizar el registro: " . $stmt->error . "</div>";
        }

        $stmt->close();
    }
}

// Crear nuevo registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    $periodo = $_POST['periodo'];
    $facultad = $_POST['facultad'];
    $carrera = $_POST['carrera'];
    $est_pierden_titulacion_prorroga = $_POST['est_pierden_titulacion_prorroga'];
    $est_pierden_actualizacion_sin_curso = $_POST['est_pierden_actualizacion_sin_curso'];
    $est_pierden_actualizacion_con_curso = $_POST['est_pierden_actualizacion_con_curso'];
    $total_profesores_carga_horaria = $_POST['total_profesores_carga_horaria'];
    $total_horas_tutorias = $_POST['total_horas_tutorias'];
    $profesores_tutoria_proyecto_investigacion = $_POST['profesores_tutoria_proyecto_investigacion'];
    $profesores_tutoria_examen_complexivo = $_POST['profesores_tutoria_examen_complexivo'];
    $est_matriculados_actualizacion_aprobacion = $_POST['est_matriculados_actualizacion_aprobacion'];
    $est_aprobaron_curso_actualizacion = $_POST['est_aprobaron_curso_actualizacion'];
    $est_reprobaron_curso_actualizacion = $_POST['est_reprobaron_curso_actualizacion'];

    $sql = "INSERT INTO reprobacion_definitiva (periodo, facultad, carrera, est_pierden_titulacion_prorroga, est_pierden_actualizacion_sin_curso, est_pierden_actualizacion_con_curso, total_profesores_carga_horaria, total_horas_tutorias, profesores_tutoria_proyecto_investigacion, profesores_tutoria_examen_complexivo, est_matriculados_actualizacion_aprobacion, est_aprobaron_curso_actualizacion, est_reprobaron_curso_actualizacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en la consulta SQL: " . $conn->error);
    }

    $stmt->bind_param("sssiiiiiiiiii", $periodo, $facultad, $carrera, $est_pierden_titulacion_prorroga, $est_pierden_actualizacion_sin_curso, $est_pierden_actualizacion_con_curso, $total_profesores_carga_horaria, $total_horas_tutorias, $profesores_tutoria_proyecto_investigacion, $profesores_tutoria_examen_complexivo, $est_matriculados_actualizacion_aprobacion, $est_aprobaron_curso_actualizacion, $est_reprobaron_curso_actualizacion);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success text-center'>Registro creado exitosamente.</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Error al crear el registro: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

// Obtener todos los registros
$sql = "SELECT * FROM reprobacion_definitiva";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reprobación Definitiva - CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .form-container {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 100%;
            margin: 0 auto;
            overflow-x: auto;
        }
        .btn-primary {
            background-color: #ff7700;
            border-color: #ff7700;
        }
        .btn-primary:hover {
            background-color: #e06600;
            border-color: #e06600;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 0.75rem;
        }
        table, th, td {
            border: 1px solid #dee2e6;
        }
        th, td {
            padding: 2px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .table-responsive {
            margin-top: 20px;
        }
        select.form-select, input.form-control {
            min-width: 80px;
            font-size: 0.75rem;
            padding: 2px;
        }
        input.form-control.number-input {
            max-width: 60px;
            font-size: 0.75rem;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 class="text-center">Crear nuevo registro</h2>
        <form action="reprobacion_definitiva.php" method="POST">
            <input type="hidden" name="create" value="1">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="periodo" class="form-label">Periodo:</label>
                    <select name="periodo" class="form-select">
                        <option value="2024-1S">2024-1S</option>
                        <option value="2024-2S">2024-2S</option>
                        <option value="2023-1S">2023-1S</option>
                        <option value="2023-2S">2023-2S</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="fac" class="form-label">Facultad:</label>
                    <select id="fac" name="facultad" class="form-select" onchange="actualizarCarreras()">
                        <option value="Facultad de Ciencias de la Educación, Humanas y Tecnologías">Facultad de Ciencias de la Educación, Humanas y Tecnologías</option>
                        <option value="Facultad de Ciencias Políticas y Administrativas">Facultad de Ciencias Políticas y Administrativas</option>
                        <option value="Facultad de Ciencias de la Salud">Facultad de Ciencias de la Salud</option>
                        <option value="Facultad de Ingeniería">Facultad de Ingeniería</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="carr" class="form-label">Carrera:</label>
                    <select id="carr" name="carrera" class="form-select"></select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="est_pierden_titulacion_prorroga" class="form-label">Est. pierden titulación prórroga:</label>
                    <input type="number" name="est_pierden_titulacion_prorroga" class="form-control number-input" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="est_pierden_actualizacion_sin_curso" class="form-label">Est. pierden actualización sin curso:</label>
                    <input type="number" name="est_pierden_actualizacion_sin_curso" class="form-control number-input" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="est_pierden_actualizacion_con_curso" class="form-label">Est. pierden actualización con curso:</label>
                    <input type="number" name="est_pierden_actualizacion_con_curso" class="form-control number-input" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="total_profesores_carga_horaria" class="form-label">Total profesores carga horaria:</label>
                    <input type="number" name="total_profesores_carga_horaria" class="form-control number-input" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="total_horas_tutorias" class="form-label">Total horas tutorías:</label>
                    <input type="number" name="total_horas_tutorias" class="form-control number-input" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="profesores_tutoria_proyecto_investigacion" class="form-label">Profesores tutoria proyecto investigación:</label>
                    <input type="number" name="profesores_tutoria_proyecto_investigacion" class="form-control number-input" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="profesores_tutoria_examen_complexivo" class="form-label">Profesores tutoria examen complexivo:</label>
                    <input type="number" name="profesores_tutoria_examen_complexivo" class="form-control number-input" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="est_matriculados_actualizacion_aprobacion" class="form-label">Est. matriculados actualización aprobación:</label>
                    <input type="number" name="est_matriculados_actualizacion_aprobacion" class="form-control number-input" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="est_aprobaron_curso_actualizacion" class="form-label">Est. aprobaron curso actualización:</label>
                    <input type="number" name="est_aprobaron_curso_actualizacion" class="form-control number-input" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="est_reprobaron_curso_actualizacion" class="form-label">Est. reprobaron curso actualización:</label>
                    <input type="number" name="est_reprobaron_curso_actualizacion" class="form-control number-input" required>
                </div>
            </div>
            <div class="text-center">
                <input type="submit" value="Crear nuevo registro" class="btn btn-primary">
            </div>
        </form>
    </div>

    <!-- Tabla para mostrar y actualizar registros existentes -->
    <div class="form-container table-responsive">
        <h2 class="text-center">Listado de registros</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Periodo</th>
                    <th>Facultad</th>
                    <th>Carrera</th>
                    <th>Est. Pierden Titulación Prórroga</th>
                    <th>Est. Pierden Actualización Sin Curso</th>
                    <th>Est. Pierden Actualización Con Curso</th>
                    <th>Total Profesores Carga Horaria</th>
                    <th>Total Horas Tutorías</th>
                    <th>Profesores Tutoria Proyecto Investigación</th>
                    <th>Profesores Tutoria Examen Complexivo</th>
                    <th>Est. Matriculados Actualización Aprobación</th>
                    <th>Est. Aprobaron Curso Actualización</th>
                    <th>Est. Reprobaron Curso Actualización</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <form action="reprobacion_definitiva.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <td><input type="text" name="periodo" value="<?php echo $row['periodo']; ?>" class="form-control"></td>
                        <td><input type="text" name="facultad" value="<?php echo $row['facultad']; ?>" class="form-control"></td>
                        <td><input type="text" name="carrera" value="<?php echo $row['carrera']; ?>" class="form-control"></td>
                        <td><input type="number" name="est_pierden_titulacion_prorroga" value="<?php echo $row['est_pierden_titulacion_prorroga']; ?>" class="form-control number-input"></td>
                        <td><input type="number" name="est_pierden_actualizacion_sin_curso" value="<?php echo $row['est_pierden_actualizacion_sin_curso']; ?>" class="form-control number-input"></td>
                        <td><input type="number" name="est_pierden_actualizacion_con_curso" value="<?php echo $row['est_pierden_actualizacion_con_curso']; ?>" class="form-control number-input"></td>
                        <td><input type="number" name="total_profesores_carga_horaria" value="<?php echo $row['total_profesores_carga_horaria']; ?>" class="form-control number-input"></td>
                        <td><input type="number" name="total_horas_tutorias" value="<?php echo $row['total_horas_tutorias']; ?>" class="form-control number-input"></td>
                        <td><input type="number" name="profesores_tutoria_proyecto_investigacion" value="<?php echo $row['profesores_tutoria_proyecto_investigacion']; ?>" class="form-control number-input"></td>
                        <td><input type="number" name="profesores_tutoria_examen_complexivo" value="<?php echo $row['profesores_tutoria_examen_complexivo']; ?>" class="form-control number-input"></td>
                        <td><input type="number" name="est_matriculados_actualizacion_aprobacion" value="<?php echo $row['est_matriculados_actualizacion_aprobacion']; ?>" class="form-control number-input"></td>
                        <td><input type="number" name="est_aprobaron_curso_actualizacion" value="<?php echo $row['est_aprobaron_curso_actualizacion']; ?>" class="form-control number-input"></td>
                        <td><input type="number" name="est_reprobaron_curso_actualizacion" value="<?php echo $row['est_reprobaron_curso_actualizacion']; ?>" class="form-control number-input"></td>
                        <td>
                            <div class="d-flex justify-content-between">
                                <input type="submit" name="update" value="Guardar" class="btn btn-success btn-sm">
                                <a href="reprobacion_definitiva.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?')">Eliminar</a>
                            </div>
                        </td>
                    </form>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <div class="text-center mt-4">
        <a href="welcome.php" class="btn btn-secondary">Regresar a la página de bienvenida</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
</body>
</html>

<?php
$conn->close();
?>
