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
    $sql = "DELETE FROM titulados_modalidad WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: formulario.php");
    exit();
}

// Actualizar registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $periodo = $_POST['periodo'];
    $fac = $_POST['fac'];
    $carr = $_POST['carr'];
    $est_mat_pi = $_POST['est_mat_pi'];
    $est_tit_pi = $_POST['est_tit_pi'];
    $est_mat_ect = $_POST['est_mat_ect'];
    $est_tit_ect = $_POST['est_tit_ect'];
    $est_mat_ectp = $_POST['est_mat_ectp'];
    $est_tit_ectp = $_POST['est_tit_ectp'];
    $est_prim_pror = $_POST['est_prim_pror'];
    $est_seg_pror = $_POST['est_seg_pror'];
    $est_seg_pror_acs = $_POST['est_seg_pror_acs'];
    $est_seg_pror_acc = $_POST['est_seg_pror_acc'];

    $sql = "UPDATE titulados_modalidad SET periodo=?, fac=?, carr=?, est_mat_pi=?, est_tit_pi=?, est_mat_ect=?, est_tit_ect=?, est_mat_ectp=?, est_tit_ectp=?, est_prim_pror=?, est_seg_pror=?, est_seg_pror_acs=?, est_seg_pror_acc=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssddddddddddi", $periodo, $fac, $carr, $est_mat_pi, $est_tit_pi, $est_mat_ect, $est_tit_ect, $est_mat_ectp, $est_tit_ectp, $est_prim_pror, $est_seg_pror, $est_seg_pror_acs, $est_seg_pror_acc, $id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success text-center'>Registro actualizado exitosamente.</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Error al actualizar el registro.</div>";
    }

    $stmt->close();
}

// Crear nuevo registro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create'])) {
    $periodo = $_POST['periodo'];
    $fac = $_POST['fac'];
    $carr = $_POST['carr'];
    $est_mat_pi = $_POST['est_mat_pi'];
    $est_tit_pi = $_POST['est_tit_pi'];
    $est_mat_ect = $_POST['est_mat_ect'];
    $est_tit_ect = $_POST['est_tit_ect'];
    $est_mat_ectp = $_POST['est_mat_ectp'];
    $est_tit_ectp = $_POST['est_tit_ectp'];
    $est_prim_pror = $_POST['est_prim_pror'];
    $est_seg_pror = $_POST['est_seg_pror'];
    $est_seg_pror_acs = $_POST['est_seg_pror_acs'];
    $est_seg_pror_acc = $_POST['est_seg_pror_acc'];

    $sql = "INSERT INTO titulados_modalidad (periodo, fac, carr, est_mat_pi, est_tit_pi, est_mat_ect, est_tit_ect, est_mat_ectp, est_tit_ectp, est_prim_pror, est_seg_pror, est_seg_pror_acs, est_seg_pror_acc) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdddddddddd", $periodo, $fac, $carr, $est_mat_pi, $est_tit_pi, $est_mat_ect, $est_tit_ect, $est_mat_ectp, $est_tit_ectp, $est_prim_pror, $est_seg_pror, $est_seg_pror_acs, $est_seg_pror_acc);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success text-center'>Registro creado exitosamente.</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Error al crear el registro.</div>";
    }
    $stmt->close();
}

// Obtener todos los registros
$sql = "SELECT * FROM titulados_modalidad";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Titulados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            font-size: 0.75rem; /* Reduced font size to make table fit better */
        }
        table, th, td {
            border: 1px solid #dee2e6;
        }
        th, td {
            padding: 2px; /* Further reduced padding to save space */
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .table-responsive {
            margin-top: 20px;
        }
        select.form-select, input.form-control {
            min-width: 80px; /* Further reduced minimum width to fit better */
            font-size: 0.75rem; /* Adjust font size */
            padding: 2px; /* Reduce padding for better fit */
        }
        input.form-control.number-input {
            max-width: 60px; /* Reduced max width for number inputs to save space */
            font-size: 0.75rem; /* Adjust font size */
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 class="text-center">Crear nuevo registro</h2>
        <form action="formulario.php" method="POST">
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
                    <select id="fac" name="fac" class="form-select" onchange="actualizarCarreras()">
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
                    <select id="carr" name="carr" class="form-select"></select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="est_mat_pi" class="form-label">Est. Mat. PI:</label>
                    <input type="number" name="est_mat_pi" class="form-control number-input" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="est_tit_pi" class="form-label">Est. Tit. PI:</label>
                    <input type="number" name="est_tit_pi" class="form-control number-input" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="est_mat_ect" class="form-label">Est. Mat. ECT:</label>
                    <input type="number" name="est_mat_ect" class="form-control number-input" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="est_tit_ect" class="form-label">Est. Tit. ECT:</label>
                    <input type="number" name="est_tit_ect" class="form-control number-input" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="est_mat_ectp" class="form-label">Est. Mat. ECTP:</label>
                    <input type="number" name="est_mat_ectp" class="form-control number-input" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="est_tit_ectp" class="form-label">Est. Tit. ECTP:</label>
                    <input type="number" name="est_tit_ectp" class="form-control number-input" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="est_prim_pror" class="form-label">Est. Prim. Prorrog:</label>
                    <input type="number" name="est_prim_pror" class="form-control number-input" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="est_seg_pror" class="form-label">Est. Seg. Prorrog:</label>
                    <input type="number" name="est_seg_pror" class="form-control number-input" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="est_seg_pror_acs" class="form-label">Est. Seg. Prorrog. ACS:</label>
                    <input type="number" name="est_seg_pror_acs" class="form-control number-input" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="est_seg_pror_acc" class="form-label">Est. Seg. Prorrog. ACC:</label>
                    <input type="number" name="est_seg_pror_acc" class="form-control number-input" required>
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
                    <th>Est. Mat. PI</th>
                    <th>Est. Tit. PI</th>
                    <th>Est. Mat. ECT</th>
                    <th>Est. Tit. ECT</th>
                    <th>Est. Mat. ECTP</th>
                    <th>Est. Tit. ECTP</th>
                    <th>Est. Prim. Prorrog</th>
                    <th>Est. Seg. Prorrog</th>
                    <th>Est. Seg. Prorrog. ACS</th>
                    <th>Est. Seg. Prorrog. ACC</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <form action="formulario.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <td>
                            <select name="periodo" class="form-select">
                                <option value="2024-1S" <?php if($row['periodo'] == '2024-1S') echo 'selected'; ?>>2024-1S</option>
                                <option value="2024-2S" <?php if($row['periodo'] == '2024-2S') echo 'selected'; ?>>2024-2S</option>
                                <option value="2023-1S" <?php if($row['periodo'] == '2023-1S') echo 'selected'; ?>>2023-1S</option>
                                <option value="2023-2S" <?php if($row['periodo'] == '2023-2S') echo 'selected'; ?>>2023-2S</option>
                            </select>
                        </td>
                        <td>
                            <select name="fac" class="form-select">
                                <option value="Facultad de Ciencias de la Educación, Humanas y Tecnologías" <?php if($row['fac'] == 'Facultad de Ciencias de la Educación, Humanas y Tecnologías') echo 'selected'; ?>>Facultad de Ciencias de la Educación, Humanas y Tecnologías</option>
                                <option value="Facultad de Ciencias Políticas y Administrativas" <?php if($row['fac'] == 'Facultad de Ciencias Políticas y Administrativas') echo 'selected'; ?>>Facultad de Ciencias Políticas y Administrativas</option>
                                <option value="Facultad de Ciencias de la Salud" <?php if($row['fac'] == 'Facultad de Ciencias de la Salud') echo 'selected'; ?>>Facultad de Ciencias de la Salud</option>
                                <option value="Facultad de Ingeniería" <?php if($row['fac'] == 'Facultad de Ingeniería') echo 'selected'; ?>>Facultad de Ingeniería</option>
                            </select>
                        </td>
                        <td><input type="text" name="carr" value="<?php echo $row['carr']; ?>" class="form-control"></td>
                        <td><input type="number" name="est_mat_pi" value="<?php echo $row['est_mat_pi']; ?>" class="form-control number-input"></td>
                        <td><input type="number" name="est_tit_pi" value="<?php echo $row['est_tit_pi']; ?>" class="form-control number-input"></td>
                        <td><input type="number" name="est_mat_ect" value="<?php echo $row['est_mat_ect']; ?>" class="form-control number-input"></td>
                        <td><input type="number" name="est_tit_ect" value="<?php echo $row['est_tit_ect']; ?>" class="form-control number-input"></td>
                        <td><input type="number" name="est_mat_ectp" value="<?php echo $row['est_mat_ectp']; ?>" class="form-control number-input"></td>
                        <td><input type="number" name="est_tit_ectp" value="<?php echo $row['est_tit_ectp']; ?>" class="form-control number-input"></td>
                        <td><input type="number" name="est_prim_pror" value="<?php echo $row['est_prim_pror']; ?>" class="form-control number-input"></td>
                        <td><input type="number" name="est_seg_pror" value="<?php echo $row['est_seg_pror']; ?>" class="form-control number-input"></td>
                        <td><input type="number" name="est_seg_pror_acs" value="<?php echo $row['est_seg_pror_acs']; ?>" class="form-control number-input"></td>
                        <td><input type="number" name="est_seg_pror_acc" value="<?php echo $row['est_seg_pror_acc']; ?>" class="form-control number-input"></td>
                        <td>
                            <div class="d-flex justify-content-between">
                                <input type="submit" name="update" value="Guardar" class="btn btn-success btn-sm">
                                <a href="formulario.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?')">Eliminar</a>
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
