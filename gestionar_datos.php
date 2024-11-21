<?php
session_start();
require 'db.php'; // Incluye el archivo de conexión a la base de datos

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Crear registro
if (isset($_POST['crear'])) {
    $per = $_POST['per'];
    $fac = $_POST['fac'];
    $car = $_POST['car'];
    $est_mat = isset($_POST['est_mat']) && $_POST['est_mat'] !== "" ? $_POST['est_mat'] : 0;
    $est_ult_nv = isset($_POST['est_ult_nv']) && $_POST['est_ult_nv'] !== "" ? $_POST['est_ult_nv'] : 0;
    $est_tit_ult_nv = isset($_POST['est_tit_ult_nv']) && $_POST['est_tit_ult_nv'] !== "" ? $_POST['est_tit_ult_nv'] : 0;
    $est_pri_prr = isset($_POST['est_pri_prr']) && $_POST['est_pri_prr'] !== "" ? $_POST['est_pri_prr'] : 0;
    $est_tit_pri_prr = isset($_POST['est_tit_pri_prr']) && $_POST['est_tit_pri_prr'] !== "" ? $_POST['est_tit_pri_prr'] : 0;
    $est_seg_prr = isset($_POST['est_seg_prr']) && $_POST['est_seg_prr'] !== "" ? $_POST['est_seg_prr'] : 0;
    $est_tit_seg_prr = isset($_POST['est_tit_seg_prr']) && $_POST['est_tit_seg_prr'] !== "" ? $_POST['est_tit_seg_prr'] : 0;
    $est_act_con_prim = isset($_POST['est_act_con_prim']) && $_POST['est_act_con_prim'] !== "" ? $_POST['est_act_con_prim'] : 0;
    $est_tit_act_con_prim = isset($_POST['est_tit_act_con_prim']) && $_POST['est_tit_act_con_prim'] !== "" ? $_POST['est_tit_act_con_prim'] : 0;
    $est_act_con_seg = isset($_POST['est_act_con_seg']) && $_POST['est_act_con_seg'] !== "" ? $_POST['est_act_con_seg'] : 0;
    $est_tit_act_con_seg = isset($_POST['est_tit_act_con_seg']) && $_POST['est_tit_act_con_seg'] !== "" ? $_POST['est_tit_act_con_seg'] : 0;
    $est_apr_act_prim = isset($_POST['est_apr_act_prim']) && $_POST['est_apr_act_prim'] !== "" ? $_POST['est_apr_act_prim'] : 0;
    $est_apr_tit_act_prim = isset($_POST['est_apr_tit_act_prim']) && $_POST['est_apr_tit_act_prim'] !== "" ? $_POST['est_apr_tit_act_prim'] : 0;
    $est_apr_act_seg = isset($_POST['est_apr_act_seg']) && $_POST['est_apr_act_seg'] !== "" ? $_POST['est_apr_act_seg'] : 0;
    $est_apr_tit_act_seg = isset($_POST['est_apr_tit_act_seg']) && $_POST['est_apr_tit_act_seg'] !== "" ? $_POST['est_apr_tit_act_seg'] : 0;

    $sql = "INSERT INTO Datos (per, fac, car, est_mat, est_ult_nv, est_tit_ult_nv, est_pri_prr, 
    est_tit_pri_prr, est_seg_prr, est_tit_seg_prr, est_act_con_prim, est_tit_act_con_prim, est_act_con_seg, 
    est_tit_act_con_seg, est_apr_act_prim, est_apr_tit_act_prim, est_apr_act_seg, 
    est_apr_tit_act_seg) VALUES ('$per', '$fac', '$car', $est_mat, $est_ult_nv, $est_tit_ult_nv, $est_pri_prr, 
    $est_tit_pri_prr, $est_seg_prr, $est_tit_seg_prr, $est_act_con_prim, $est_tit_act_con_prim, $est_act_con_seg, 
    $est_tit_act_con_seg, $est_apr_act_prim, $est_apr_tit_act_prim, $est_apr_act_seg, 
    $est_apr_tit_act_seg)";
    
    echo ($conn->query($sql) === TRUE) ? "Registro creado con éxito" : "Error: " . $sql . "<br>" . $conn->error;
}

// Actualizar registro
if (isset($_POST['actualizar'])) {
    // Obtén el ID y los valores actualizados del formulario
    $id = $_POST['id'];
    $nuevo_per = htmlspecialchars($_POST['nuevo_per']);
    $nuevo_fac = htmlspecialchars($_POST['nuevo_fac']);
    $nuevo_car = htmlspecialchars($_POST['nuevo_car']);
    $nuevo_est_mat = isset($_POST['nuevo_est_mat']) ? (int)$_POST['nuevo_est_mat'] : 0;
    $nuevo_est_ult_nv = isset($_POST['nuevo_est_ult_nv']) ? (int)$_POST['nuevo_est_ult_nv'] : 0;
    $nuevo_est_tit_ult_nv = isset($_POST['nuevo_est_tit_ult_nv']) ? (int)$_POST['nuevo_est_tit_ult_nv'] : 0;
    // Agrega los campos restantes que quieras actualizar

    // Prepara la consulta para actualizar
    $sql = "UPDATE Datos SET per = ?, fac = ?, car = ?, est_mat = ?, est_ult_nv = ?, est_tit_ult_nv = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiiii", $nuevo_per, $nuevo_fac, $nuevo_car, $nuevo_est_mat, $nuevo_est_ult_nv, $nuevo_est_tit_ult_nv, $id);

    // Ejecuta la consulta y verifica si fue exitosa
    if ($stmt->execute()) {
        echo "Registro actualizado con éxito";
    } else {
        echo "Error al actualizar el registro: " . $stmt->error;
    }

    $stmt->close();
}
// Eliminar registro
if (isset($_POST['eliminar'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM Datos WHERE id=$id";
    echo ($conn->query($sql) === TRUE) ? "Registro eliminado con éxito" : "Error al eliminar el registro: " . $conn->error;
}

// Leer registros
$sql = "SELECT * FROM Datos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Datos de Titulación Crear Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <title>Gestión de Datos</title>
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
            max-width: 50px; /* Further reduced max width for number inputs to save space */
            font-size: 0.75rem; /* Adjust font size */
        }
    </style>
    <script>
        function actualizarCarreras() {
            const facultad = document.getElementById("fac").value;
            const carreraSelect = document.getElementById("car");
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
</head>
<body>
    <h1>Gestión de Datos de Titulación</h1>

    <!-- Formulario para Crear -->
    <h2>Crear Registro</h2>
    <form method="post">
        <label for="per">Periodo:</label>
        <select id="per" name="per" required>
            <option value="2024-1S">2024-1S</option>
            <option value="2024-2S">2024-2S</option>
            <option value="2023-1S">2023-1S</option>
            <option value="2023-2S">2023-2S</option>
        </select><br>
        <label for="fac">Facultad:</label>
        <select id="fac" name="fac" onchange="actualizarCarreras()" required>
            <option value="Facultad de Ciencias de la Educación, Humanas y Tecnologías">Facultad de Ciencias de la Educación, Humanas y Tecnologías</option>
            <option value="Facultad de Ciencias Políticas y Administrativas">Facultad de Ciencias Políticas y Administrativas</option>
            <option value="Facultad de Ciencias de la Salud">Facultad de Ciencias de la Salud</option>
            <option value="Facultad de Ingeniería">Facultad de Ingeniería</option>
        </select><br>
        <label for="car">Carrera:</label>
        <select id="car" name="car" required></select><br>
        <label for="est_mat">Matriculados:</label>
        <input type="number" id="est_mat" name="est_mat" required><br>
        <label for="est_ult_nv">Último Nivel:</label>
        <input type="number" id="est_ult_nv" name="est_ult_nv"><br>
        <label for="est_tit_ult_nv">Titulados Último Nivel:</label>
        <input type="number" id="est_tit_ult_nv" name="est_tit_ult_nv"><br>
        <label for="est_pri_prr">Primera Prórroga:</label>
        <input type="number" id="est_pri_prr" name="est_pri_prr"><br>
        <label for="est_tit_pri_prr">Titulados Primera Prórroga:</label>
        <input type="number" id="est_tit_pri_prr" name="est_tit_pri_prr"><br>
        <label for="est_seg_prr">Segunda Prórroga:</label>
        <input type="number" id="est_seg_prr" name="est_seg_prr"><br>
        <label for="est_tit_seg_prr">Titulados Segunda Prórroga:</label>
        <input type="number" id="est_tit_seg_prr" name="est_tit_seg_prr"><br>
        <label for="est_act_con_prim">Actualización Conocimientos (Primera Prórroga):</label>
        <input type="number" id="est_act_con_prim" name="est_act_con_prim"><br>
        <label for="est_tit_act_con_prim">Titulados Actualización (Primera Prórroga):</label>
        <input type="number" id="est_tit_act_con_prim" name="est_tit_act_con_prim"><br>
        <label for="est_act_con_seg">Actualización Conocimientos (Segunda Prórroga):</label>
        <input type="number" id="est_act_con_seg" name="est_act_con_seg"><br>
        <label for="est_tit_act_con_seg">Titulados Actualización (Segunda Prórroga):</label>
        <input type="number" id="est_tit_act_con_seg" name="est_tit_act_con_seg"><br>
        <label for="est_apr_act_prim">Aprobados Actualización (Primera Prórroga):</label>
        <input type="number" id="est_apr_act_prim" name="est_apr_act_prim"><br>
        <label for="est_apr_tit_act_prim">Titulados Aprobados (Primera Prórroga):</label>
        <input type="number" id="est_apr_tit_act_prim" name="est_apr_tit_act_prim"><br>
        <label for="est_apr_act_seg">Aprobados Actualización (Segunda Prórroga):</label>
        <input type="number" id="est_apr_act_seg" name="est_apr_act_seg"><br>
        <label for="est_apr_tit_act_seg">Titulados Aprobados (Segunda Prórroga):</label>
        <input type="number" id="est_apr_tit_act_seg" name="est_apr_tit_act_seg"><br>
        <div class="text-center">
                <input type="submit" value="Crear nuevo registro" class="btn btn-primary">
            </div>
    </form>

    <!-- Mostrar y Editar Registros -->
    <h2>Registros Existentes</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Periodo</th>
            <th>Facultad</th>
            <th>Carrera</th>
            <th>Matriculados</th>
            <th>Último Nivel</th>
            <th>Titulados Último Nivel</th>
            <th>Primera Prórroga</th>
            <th>Titulados Primera Prórroga</th>
            <th>Segunda Prórroga</th>
            <th>Titulados Segunda Prórroga</th>
            <th>Actualización Conocimientos (Primera Prórroga)</th>
            <th>Titulados Actualización (Primera Prórroga)</th>
            <th>Actualización Conocimientos (Segunda Prórroga)</th>
            <th>Titulados Actualización (Segunda Prórroga)</th>
            <th>Aprobados Actualización (Primera Prórroga)</th>
            <th>Titulados Aprobados (Primera Prórroga)</th>
            <th>Aprobados Actualización (Segunda Prórroga)</th>
            <th>Titulados Aprobados (Segunda Prórroga)</th>
            <th>Acciones</th>
        </tr>
        <?php if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <form method="post">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <td><?php echo $row["id"]; ?></td>
                        <td><input type="text" name="nuevo_per" value="<?php echo htmlspecialchars($row['per']); ?>"></td>
                        <td><input type="text" name="nuevo_fac" value="<?php echo htmlspecialchars($row['fac']); ?>"></td>
                        <td><input type="text" name="nuevo_car" value="<?php echo htmlspecialchars($row['car']); ?>"></td>
                        <td><input type="number" name="nuevo_est_mat" value="<?php echo htmlspecialchars($row['est_mat']); ?>"></td>
                        <td><input type="number" name="nuevo_est_ult_nv" value="<?php echo htmlspecialchars($row['est_ult_nv']); ?>"></td>
                        <td><input type="number" name="nuevo_est_tit_ult_nv" value="<?php echo htmlspecialchars($row['est_tit_ult_nv']); ?>"></td>
                        <td><input type="number" name="nuevo_est_pri_prr" value="<?php echo htmlspecialchars($row['est_pri_prr']); ?>"></td>
                        <td><input type="number" name="nuevo_est_tit_pri_prr" value="<?php echo htmlspecialchars($row['est_tit_pri_prr']); ?>"></td>
                        <td><input type="number" name="nuevo_est_seg_prr" value="<?php echo htmlspecialchars($row['est_seg_prr']); ?>"></td>
                        <td><input type="number" name="nuevo_est_tit_seg_prr" value="<?php echo htmlspecialchars($row['est_tit_seg_prr']); ?>"></td>
                        <td><input type="number" name="nuevo_est_act_con_prim" value="<?php echo htmlspecialchars($row['est_act_con_prim']); ?>"></td>
                        <td><input type="number" name="nuevo_est_tit_act_con_prim" value="<?php echo htmlspecialchars($row['est_tit_act_con_prim']); ?>"></td>
                        <td><input type="number" name="nuevo_est_act_con_seg" value="<?php echo htmlspecialchars($row['est_act_con_seg']); ?>"></td>
                        <td><input type="number" name="nuevo_est_tit_act_con_seg" value="<?php echo htmlspecialchars($row['est_tit_act_con_seg']); ?>"></td>
                        <td><input type="number" name="nuevo_est_apr_act_prim" value="<?php echo htmlspecialchars($row['est_apr_act_prim']); ?>"></td>
                        <td><input type="number" name="nuevo_est_apr_tit_act_prim" value="<?php echo htmlspecialchars($row['est_apr_tit_act_prim']); ?>"></td>
                        <td><input type="number" name="nuevo_est_apr_act_seg" value="<?php echo htmlspecialchars($row['est_apr_act_seg']); ?>"></td>
                        <td><input type="number" name="nuevo_est_apr_tit_act_seg" value="<?php echo htmlspecialchars($row['est_apr_tit_act_seg']); ?>"></td>
                        <td>
                            <div class="d-flex justify-content-between">
                                <input type="submit" name="update" value="Guardar" class="btn btn-success btn-sm">
                                <a href="reprobacion_definitiva.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?')">Eliminar</a>
                            </div>
                        </td>
                    </form>
                </tr>
        <?php } } else { echo "<tr><td colspan='20'>Sin registros</td></tr>"; } ?>
    </table>
</body>
</html>
<div class="text-center mt-4">
        <a href="welcome.php" class="btn btn-secondary">Regresar a la página de bienvenida</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
<?php $conn->close(); ?>
