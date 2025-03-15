<?php

require_once('configBD.php');

class conexion
{
    public $conexion;
    private static $instancia;

    public function __construct()
    {
        try {
            $this->conexion = new PDO(
                "mysql:host=" . DB_SERVER . ";dbname=" . DB_DATABASE . ";charset=utf8",
                DB_USERNAME,
                DB_PASSWORD
            );
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            exit;
        }
    }

    public static function getInstancia()
    {
        if (!isset(self::$instancia)) {
            self::$instancia = new conexion();
        }
        return self::$instancia;

    }

    static function consulta($sql, $parametros = [])
    {
        try {
            $c = self::getInstancia()->conexion;
            $stmt = $c->prepare($sql);
            $stmt->execute($parametros);

            $rsx = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rsx;
        } catch (PDOException $e) {
            die("Error en la consulta: " . $e->getMessage());
        }
    }

    // Método para ejecutar consultas INSERT, UPDATE, DELETE
    static function ejecutar($sql, $parametros = [])
    {
        try {
            $c = self::getInstancia()->conexion;
            $stmt = $c->prepare($sql);
            return $stmt->execute($parametros);
        } catch (PDOException $e) {
            die("Error al ejecutar la consulta: " . $e->getMessage());
        }
    }

    // Método para SELECT que devuelve una sola fila
    static function select($sql, $parametros = [])
    {
        try {
            $c = self::getInstancia()->conexion;
            $stmt = $c->prepare($sql);
            $stmt->execute($parametros);

            $rsx = $stmt->fetch(PDO::FETCH_ASSOC);
            return $rsx;
        } catch (PDOException $e) {
            die("Error en la consulta SELECT: " . $e->getMessage());
        }
    }

    // Método para insertar datos y devolver el ID insertado
    static function insert($sql, $parametros = [])
    {
        try {
            $c = self::getInstancia()->conexion;
            $stmt = $c->prepare($sql);
            $stmt->execute($parametros);

            return $c->lastInsertId();
        } catch (PDOException $e) {
            die("Error al insertar datos: " . $e->getMessage());
        }
    }

}