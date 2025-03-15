<?php
$configFile = 'configBD.php';

// Si ya existe db_config.php, redirigir a la aplicación
if (file_exists($configFile)) {
    header("Location: index.php");
    exit;
}

// Si se envía el formulario, procesar los datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dbHost = $_POST['db_host'];
    $dbUser = $_POST['db_user'];
    $dbPass = $_POST['db_pass'];
    $dbName = $_POST['db_name'];

    try {
        // Intentar conectar con el servidor MySQL
        $pdo = new PDO("mysql:host=$dbHost", $dbUser, $dbPass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Crear la base de datos si no existe
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

        // Conectar con la base de datos recién creada
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        // Crear la tabla `personajes` si no existe
        $sql = "CREATE TABLE IF NOT EXISTS contactos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            telefono VARCHAR(15) NOT NULL,
            nombre VARCHAR(50) NOT NULL,
            apellido VARCHAR(50) NOT NULL,
            correo_electronico VARCHAR(100) NOT NULL UNIQUE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $pdo->exec($sql);

        // Guardar la configuración en `config.php`
        $configContent = "<?php
define('DB_HOST', '$dbHost');
define('DB_USER', '$dbUser');
define('DB_PASS', '$dbPass');
define('DB_NAME', '$dbName');
?>";

        file_put_contents($configFile, $configContent);

        // Redirigir a la aplicación después de la instalación exitosa
        header("Location: index.php");
        exit;

    } catch (PDOException $e) {
        $error = "Error en la conexión: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Instalación de Base de Datos</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin: 50px; }
        form { display: inline-block; text-align: left; background: #f4f4f4; padding: 20px; border-radius: 8px; }
        input { width: 100%; padding: 8px; margin: 5px 0; }
        button { padding: 10px 15px; background: #28a745; color: white; border: none; cursor: pointer; }
        button:hover { background: #218838; }
    </style>
</head>
<body>
    <h2>🔧 Asistente de Configuración de Base de Datos</h2>
    <p>Ingrese los detalles de la base de datos para instalar la aplicación.</p>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Servidor de Base de Datos:</label>
        <input type="text" name="db_host" value="localhost" required>

        <label>Usuario de Base de Datos:</label>
        <input type="text" name="db_user" required>

        <label>Contraseña:</label>
        <input type="password" name="db_pass">

        <label>Nombre de la Base de Datos:</label>
        <input type="text" name="db_name" required>

        <button type="submit">📥 Instalar</button>
    </form>
</body>
</html>
