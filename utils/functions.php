<?php

require "Conexion.php";

// Función para iniciar sesión
/**
 * Comprueba si el correo y la contraseña coinciden con el correo del usuario.
 * 
 * @return array - Si la es exitoso devuelve un array con la información del usuario.
 */
function login(string $correo, string $contraseña)
{
    $info = [];

    $conn = Conexion::conectar();
    $sql = "SELECT * FROM USUARIO WHERE correo = :correo";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":correo", $correo);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($contraseña, $user['contraseña'])) {
        $info = [
            'id' => $user['id'],
            'nombre' => $user['nombre'],
            'correo' => $user['correo'],
            'rol' => $user['id_rol'],
        ];
    }
    return $info;
}

function logout()
{
    session_unset();
    session_destroy();
}

// Función para obtener todos los proyectos
function obtenerProyectos()
{
    $conn = Conexion::conectar();
    $sql = "SELECT * FROM PROYECTO";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener los proyectos activos
function obtenerProyectosActivos()
{
    $conn = Conexion::conectar();
    $sql = "SELECT id, nombre FROM PROYECTO WHERE estado != 'Finalizado'";
    $stmt = $conn->prepare("$sql");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener los proyectos mediante un id
function obtenerProyectoPorId($id)
{
    $conn = Conexion::conectar();
    $sql = "SELECT * FROM PROYECTO WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Función para crear proyectos
function crearProyecto($nombre, $descripcion, $estado)
{
    $conn = Conexion::conectar();
    $sql = "INSERT INTO PROYECTO (nombre, descripcion, estado) VALUES (:nombre, :descripcion, :estado)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":descripcion", $descripcion);
    $stmt->bindParam(":estado", $estado);
    return $stmt->execute();
}

// Función para actualizar un proyecto
function actualizarProyecto($id, $nombre, $descripcion, $estado)
{
    $conn = Conexion::conectar();
    $sql = "UPDATE PROYECTO SET nombre = :nombre, descripcion = :descripcion, estado = :estado WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":descripcion", $descripcion);
    $stmt->bindParam(":estado", $estado);
    $stmt->execute();
    return $stmt->rowCount() >= 1;
}

// Función para eliminar un proyecto
function eliminarProyecto($id)
{
    $conn = Conexion::conectar();
    $sql = "DELETE FROM PROYECTO WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    return $stmt->execute();
}

// Función para obtener el proyecto asignado al trabajador
function obtenerProyectosAsignados($id_trabajador)
{
    $conn = Conexion::conectar();
    $sql = "SELECT p.id, p.nombre
            FROM PROYECTO p, registro_horas rh 
            WHERE p.id = rh.id_proyecto
            and rh.id_trabajador = :id_trabajador";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_trabajador', $id_trabajador, PDO::PARAM_INT);
    $stmt->execute();
    $proyectos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    Conexion::desconectar();
    return $proyectos;
}

// Función para registrar hora de entrada
function registrarCheckIn($id_trabajador, $id_proyecto)
{
    $conn = Conexion::conectar();
    $fecha_actual = date('Y-m-d');
    $hora_entrada = date('H:i:s');
    $sql = "INSERT INTO REGISTRO_HORAS (id_trabajador, id_proyecto, fecha, hora_entrada) VALUES (:id_trabajador, :id_proyecto, :fecha, :hora_entrada)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_trabajador', $id_trabajador);
    $stmt->bindParam(':id_proyecto', $id_proyecto);
    $stmt->bindParam(':fecha', $fecha_actual);
    $stmt->bindParam(':hora_entrada', $hora_entrada);
    $_SESSION['checkin'] = false; // Para controlar que el usuario no acceda a la página.
    $_SESSION['checkout'] = true;
    return $stmt->execute();
}

// Función para registrar el check_out
function registrarCheckOut($id_trabajador, $id_proyecto)
{
    $conn = Conexion::conectar();
    $fecha_actual = date('Y-m-d');
    $hora_salida = date('H:i:s');
    $sql = "UPDATE REGISTRO_HORAS SET hora_salida = :hora_salida WHERE id_trabajador = :id_trabajador AND id_proyecto = :id_proyecto AND fecha = :fecha AND hora_salida IS NULL";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':hora_salida', $hora_salida);
    $stmt->bindParam(':id_trabajador', $id_trabajador);
    $stmt->bindParam(':id_proyecto', $id_proyecto);
    $stmt->bindParam(':fecha', $fecha_actual);
    $_SESSION['checkin'] = true;
    $_SESSION['checkout'] = false;
    return $stmt->execute();
}

function calcularTiempoTrabajado($hora_entrada, $hora_salida)
{
    // Convertir las horas a objetos DateTime
    $entrada = new DateTime($hora_entrada);
    $salida = new DateTime($hora_salida);

    // Calcular la diferencia entre la hora de entrada y la hora de salida
    $diferencia = $entrada->diff($salida);

    // Formatear la diferencia como horas y minutos
    $horas = $diferencia->h + $diferencia->days * 24;
    $minutos = $diferencia->i;
    $segundos = $diferencia->s;


    // Formatear la salida
    $formato_amigable = intval($horas) . "h " . intval($minutos) . "min " . intval($segundos) . "s";

    // Devolver el tiempo trabajado en formato "horas:minutos"
    return $formato_amigable;
}

// Función para obtener los trabajadores
function obtenerTrabajadores()
{
    $conn = Conexion::conectar();
    $sql = "SELECT * FROM USUARIO WHERE id_rol = 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener los trabajadores mediante un ID
function obtenerTrabajadorPorId($id)
{
    $conn = Conexion::conectar();
    $sql = "SELECT * FROM USUARIO WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Función para crear un trabajador
function crearTrabajador($nombre, $correo, $contrasena, $id_rol)
{
    $conn = Conexion::conectar();
    $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);
    $sql = "INSERT INTO USUARIO (nombre, correo, contraseña, id_rol) VALUES (:nombre, :correo, :contrasena, :id_rol)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":correo", $correo);
    $stmt->bindParam(":contrasena", $hashedPassword);
    $stmt->bindParam(":id_rol", $id_rol);
    return $stmt->execute();
}

// Función para actualizar los trabajadores
function actualizarTrabajador($id, $nombre, $correo, $id_rol)
{
    $conn = Conexion::conectar();
    $sql = "UPDATE USUARIO SET nombre = :nombre, correo = :correo, id_rol = :id_rol WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":correo", $correo);
    $stmt->bindParam(":id_rol", $id_rol);
    return $stmt->execute();
}

// Función para eliminar
function eliminarTrabajador($id)
{
    $conn = Conexion::conectar();
    $sql = "DELETE FROM USUARIO WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    return $stmt->execute();
}

function obtenerRegistrosHoras($id_trabajador)
{
    $conn = Conexion::conectar();
    $sql = "SELECT rh.fecha, rh.hora_entrada, rh.hora_salida, p.id, p.nombre as nombre_proyecto
            FROM REGISTRO_HORAS rh, proyecto p
            where rh.id_proyecto = p.id  and id_trabajador = :id_trabajador
            ORDER BY fecha DESC, hora_entrada DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id_trabajador', $id_trabajador, PDO::PARAM_INT);
    $stmt->execute();
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
    Conexion::desconectar();
    return $registros;
}

function crearRegistroHoras($id_trabajador, $id_proyecto, $fecha, $hora_entrada, $hora_salida)
{
    $conn = Conexion::conectar();
    $sql = "INSERT INTO REGISTRO_HORAS (id_trabajador, id_proyecto, fecha, hora_entrada, hora_salida) VALUES (:id_trabajador, :id_proyecto, :fecha, :hora_entrada, :hora_salida)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id_trabajador", $id_trabajador);
    $stmt->bindParam(":id_proyecto", $id_proyecto);
    $stmt->bindParam(":fecha", $fecha);
    $stmt->bindParam(":hora_entrada", $hora_entrada);
    $stmt->bindParam(":hora_salida", $hora_salida);
    return $stmt->execute();
}

function actualizarRegistroHoras($id_registro, $hora_salida)
{
    $conn = Conexion::conectar();
    $sql = "UPDATE REGISTRO_HORAS SET hora_salida = :hora_salida WHERE id_registro = :id_registro";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id_registro", $id_registro);
    $stmt->bindParam(":hora_salida", $hora_salida);
    return $stmt->execute();
}

function formatearHora($hora)
{
    // Separar la hora, los minutos y los segundos
    list($horas, $minutos, $segundos) = explode(":", $hora);

    // Formatear la salida
    $formato_amigable = intval($horas) . "h, " . intval($minutos) . "min";

    return $formato_amigable;
}

// Función para crear reportes
function create_report(int $id_project, array $workers) {
    // Convierto el array en cadenas separadas por , 
    $trabajadores = implode(",", $workers);
    $conn = Conexion::conectar();
    // Hago LA consulta para obtener nombre de proyecto, descripción, nombre de usuario
    // y las horas trabajadas
    $sql = "SELECT
                p.nombre as nombre_proyecto,
                p.descripcion as descripcion,
                u.nombre as nombre,
                -- Convertimos los segundo a formato fecha = total de horas trabajadas * cada usuario 
                sec_to_time(
                  -- Sumamos todos los segundos
                  sum(
                    -- Convertimos el tiempo a segundos
                    time_to_sec(
                      -- Sacamos diferencia entre la hora de salida y entrada = al tiempo trabajado en formato fecha
                      timediff(rh.hora_salida, rh.hora_entrada))
                  )
                ) as horas_trabajadas
              FROM
                proyecto p,
                registro_horas rh,
                usuario u
              where
                rh.id_trabajador = u.id
                and rh.id_proyecto = p.id
                and p.id = :id
                and u.id in ($trabajadores)
              group by
                u.id
              order by
                u.nombre";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id_project, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    Conexion::desconectar();
    return $result;
}