<?php
require_once 'libreria/conexBD.php';
require_once 'libreria/configBD.php';

// Verificar si se recibió un ID válido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    try {
        // Verificar si el contacto existe antes de eliminarlo
        $sqlCheck = "SELECT * FROM contactos WHERE id = ?";
        $contacto = Conexion::select($sqlCheck, [$id]);
        
        if ($contacto) {
            // Eliminar el contacto de la base de datos
            $sqlDelete = "DELETE FROM contactos WHERE id = ?";
            Conexion::ejecutar($sqlDelete, [$id]);
            
            // Redirigir a la página de listado después de eliminar
            header("Location: listadeVis.php?mensaje=Contacto eliminado exitosamente");
            exit;
        } else {
            // Mostrar mensaje de error con los colores de la plantilla
            echo "<div style='text-align: center; padding: 20px; background-color: #ffcc00; border: 2px solid #ff5733; border-radius: 15px; max-width: 500px; margin: 50px auto;'>";
            echo "<h1 style='color: #ff5733;'>⚠ Error</h1>";
            echo "<p>El contacto que intentas eliminar no existe.</p>";
            echo "<a href='listadeVis.php' style='color: white; background-color: #34495e; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>⬅ Volver al listado</a>";
            echo "</div>";
        }
    } catch (Exception $e) {
        // Mostrar error con los colores de la plantilla
        echo "<div style='text-align: center; padding: 20px; background-color: #f4f4f4; color: #e74c3c; border: 2px solid #e74c3c; border-radius: 15px; max-width: 500px; margin: 50px auto;'>";
        echo "<p>Error al eliminar el contacto: " . $e->getMessage() . "</p>";
        echo "<a href='listadeVis.php' style='color: white; background-color: #34495e; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>⬅ Volver al listado</a>";
        echo "</div>";
    }
} else {
    // Si no se recibió un ID válido, redirigir al listado
    header("Location: listadeVis.php?mensaje=ID inválido");
    exit;
}
?>
