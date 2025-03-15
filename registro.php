<?php
session_start(); // Iniciar sesión

ob_start(); // Iniciar buffer de salida para evitar problemas con header()

require_once 'libreria/conexBD.php';
require_once 'libreria/plantilla.php';
plantilla::aplicar();

// Verificar si se está editando un contacto existente
$contacto = null;
if (isset($_GET['id'])) {
    $sql = "SELECT * FROM contactos WHERE id = ?";
    $parametros = [$_GET['id']];
    $contacto = conexion::select($sql, $parametros);

    if (!$contacto) {
        echo "<div style='text-align: center; padding: 20px; background-color:rgb(87, 18, 235); border: 2px solidrgb(20, 224, 255); border-radius: 15px; max-width: 500px; margin: 50px auto;'>";
        echo "<h1 style='color:rgb(36, 11, 164);'>⚠ Oops...</h1>";
        echo "<p>El contacto que buscas no existe.</p>";
        echo "<a href='listadeVis.php' class='boton'>⬅ Volver al listado</a>";
        echo "</div>";
        exit;
    }
}

// Si no es edición, se asignan valores por defecto
if (!$contacto) {
    $contacto = [
        'id'     => '',
        'telefono' => '',
        'nombre'  => '',
        'apellido'   => '',
        'correo_electronico'  => '',
    ];
}

// Guardar datos cuando se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id      = $_POST['id'];
    $telefono  = $_POST['telefono'];
    $nombre   = $_POST['nombre'];
    $apellido    = $_POST['apellido'];
    $correo   = $_POST['correo_electronico'];
    
    try {
        if ($id) {
            // Actualizar contacto
            $sql = "UPDATE contactos SET telefono=?, nombre=?, apellido=?, correo_electronico=? WHERE id=?";
            $parametros = [$telefono, $nombre, $apellido, $correo, $id];
            Conexion::ejecutar($sql, $parametros);
            $_SESSION['mensaje'] = "¡Contacto actualizado correctamente!";
        } else {
            // Insertar nuevo contacto
            $sql = "INSERT INTO contactos (telefono, nombre, apellido, correo_electronico) VALUES (?, ?, ?, ?)";
            $parametros = [$telefono, $nombre, $apellido, $correo];
            $id = Conexion::insert($sql, $parametros);
            $_SESSION['mensaje'] = "¡Nuevo contacto guardado exitosamente!";
        }

        ob_end_clean(); // Limpiar el buffer de salida
        header("Location: listadeVis.php");
        exit;
    } catch (Exception $e) {
        $_SESSION['mensaje_error'] = "Error al guardar: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de visitas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1 class="title">👩🏻‍🤝‍👨🏽 Registro de Contactos</h1>
<p>Ingrese los datos del contacto y guárdelos en la base de datos.</p>

<!-- Mensaje de éxito o error -->
<?php if (isset($_SESSION['mensaje'])): ?>
    <div class="mensaje-exito">
        <?= $_SESSION['mensaje']; ?>
    </div>
    <?php unset($_SESSION['mensaje']); // Limpiar mensaje después de mostrarlo ?>
<?php elseif (isset($_SESSION['mensaje_error'])): ?>
    <div class="mensaje-error">
        <?= $_SESSION['mensaje_error']; ?>
    </div>
    <?php unset($_SESSION['mensaje_error']); // Limpiar mensaje de error ?>
<?php endif; ?>

<div class="form-container">
    <form method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($contacto['id'] ?? '') ?>">

        <div class="form-group">
            <label>📞 Teléfono:</label>
            <input type="text" name="telefono" value="<?= htmlspecialchars($contacto['telefono'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>👤 Nombre:</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($contacto['nombre'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>📝 Apellido:</label>
            <input type="text" name="apellido" value="<?= htmlspecialchars($contacto['apellido'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label>✉️ Correo Electrónico:</label>
            <input type="email" name="correo_electronico" value="<?= htmlspecialchars($contacto['correo_electronico'] ?? '') ?>" required>
        </div>

        <button type="submit" class="boton">✅ Guardar</button>
    </form>

    <?php if (!empty($contacto['id'])): ?>
        <form method="post" action="eliminar.php">
            <input type="hidden" name="id" value="<?= htmlspecialchars($contacto['id']) ?>">
            <button type="submit" class="boton eliminar" onclick="return confirm('¿Seguro que deseas eliminar este contacto?');">❌ Eliminar</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
