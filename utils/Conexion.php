<?php

/**
 * Representa la conexión con una base de datos MYSQL.
 */
class Conexion {

    // Atributos
    // --------------------
    private static ?PDO $conexion = null;
    private static $host = 'localhost';
    private static $usuario = 'root';
    private static $contrasena = '';
    private static $nombreDB = 'TimeTrack';

    /**
     * Establece una conexión con la base de datos.
     * 
     * @return PDO conexión con base de datos
     */
    public static function conectar() {
        if (is_null(self::$conexion)) {
            $sdn = sprintf("mysql:host=%s;dbname=%s;charset=utf8mb4", self::$host, self::$nombreDB);
            self::$conexion = new PDO($sdn, self::$usuario, self::$contrasena);
            self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conexion;
    }

    /**
     * Termina la conexión con la base de datos.
     */
    public static function desconectar() {
        self::$conexion = null;
    }
}
