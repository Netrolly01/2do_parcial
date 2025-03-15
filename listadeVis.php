<?php

if (!file_exists('libreria/configBD.php')) {
    header("Location: launcher.php");
    exit;
}

require_once 'libreria/configBD.php';
require_once 'libreria/conexBD.php';
require_once 'libreria/plantilla.php';
plantilla::aplicar();

$conexion = new PDO("mysql:host=localhost;dbname=seg_parcial", "root", "");
$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM contactos";
$stmt = $conexion->query($sql);
$filas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section class="tabla-container">
    <h2 class="titulo-tabla">📋 Registro de Visitas 📋</h2>

    <table class="tabla">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Correo Electrónico</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (empty($filas)) {
                echo "<tr><td colspan='5' class='mensaje-vacio'>🚫 No hay visitas registradas.</td></tr>";
            } else {
                foreach ($filas as $fila) {
                    echo "
                    <tr>
                        <td>{$fila['id']}</td>
                        <td>{$fila['nombre']}</td>
                        <td>{$fila['telefono']}</td>
                        <td>{$fila['correo_electronico']}</td>
                        <td>
                            <a href='registro.php?id={$fila['id']}' class='btn-accion btn-editar'>📝 Editar</a>
                            <button onclick='eliminarContacto({$fila['id']}, this)' class='btn-accion btn-eliminar'>🗑️ Eliminar</button>
                        </td>
                    </tr>
                    ";
                }
            }
            ?>
        </tbody>
    </table>
</section>

<script>
    function eliminarContacto(id, boton) {
        if (!confirm("⚠ ¿Estás seguro de que deseas eliminar este contacto?")) {
            return;
        }

        fetch('eliminar.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}`
        })
        .then(response => response.text())
        .then(data => {
            try {
                let jsonData = JSON.parse(data);
                if (jsonData.success) {
                    let row = boton.closest("tr");
                    row.style.transition = "opacity 0.5s ease";
                    row.style.opacity = "0";
                    setTimeout(() => {
                        row.remove();
                    }, 600);
                } else {
                    alert("⚠ Error: " + jsonData.message);
                }
            } catch (e) {
                alert("⚠ Error inesperado del servidor.");
            }
        })
        .catch(error => {
            alert("⚠ Hubo un problema al eliminar el contacto.");
        });
    }
</script>
