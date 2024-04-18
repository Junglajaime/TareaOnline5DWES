<?php
include('config.php');


function getTasksList() {
    global $conexionBD;
    $sql = "SELECT * FROM tareas";
    $stmt = $conexionBD->query($sql);
    $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($tareas) {
        return $tareas;
    } else {
        return array("message" => "No se encontraron tareas");
    }
}

function getOrderedTasksListByDay($params) {
    global $conexionBD;
    $dia = isset($params['dia']) ? $params['dia'] : null;
    if ($dia !== null) {
        $sql = "SELECT * FROM tareas WHERE DATE(fecha) = :dia";
        $stmt = $conexionBD->prepare($sql);
        $stmt->execute(['dia' => $dia]);
        $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($tareas) {
            return $tareas;
        } else {
            return array("message" => "No se encontraron tareas para la fecha proporcionada");
        }
    } else {
        return array("error" => "Fecha no proporcionada");
    }
}

function getTaskById($params) {
    global $conexionBD;
    $id = isset($params['id']) ? $params['id'] : null;
    if ($id !== null) {
        $sql = "SELECT * FROM tareas WHERE id = :id";
        $stmt = $conexionBD->prepare($sql);
        $stmt->execute(['id' => $id]);
        $tarea = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tarea) {
            return $tarea;
        } else {
            return array("message" => "No se encontró ninguna tarea con el ID proporcionado");
        }
    } else {
        return array("error" => "ID de tarea no proporcionado");
    }
}

function getOrderedTasksList($params) {
    global $conexionBD;
    $pagina = isset($params['pagina']) ? intval($params['pagina']) : 1;
    $tareasPorPagina = isset($params['tareasPorPag']) ? intval($params['tareasPorPag']) : 5;
    $offset = ($pagina - 1) * $tareasPorPagina;

    $orden = isset($params['orden']) ? strtoupper($params['orden']) : 'desc';

    $sql = "SELECT * FROM tareas ORDER BY fecha $orden LIMIT :offset, :tareasPorPag";
    $stmt = $conexionBD->prepare($sql);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':tareasPorPag', $tareasPorPagina, PDO::PARAM_INT);
    $stmt->execute();
    $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sqlTotal = "SELECT COUNT(*) AS total FROM tareas";
    $stmtTotal = $conexionBD->query($sqlTotal);
    $totalRegistros = $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

    return array(
        "tareas" => $tareas,
        "total_registros" => $totalRegistros
    );
}

function getFinishedTasks() {
    global $conexionBD;
    $sql = "SELECT * FROM tareas WHERE ESTADO = 'Completada'";
    $stmt = $conexionBD->query($sql);
    $tareasCompletadas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($tareasCompletadas) {
        return $tareasCompletadas;
    } else {
        return array("message" => "No se encontraron tareas completadas");
    }
}

function getUnfinishedTasks() {
    global $conexionBD;
    $sql = "SELECT * FROM tareas WHERE ESTADO = 'Pendiente'";
    $stmt = $conexionBD->query($sql);
    $tareasPendientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($tareasPendientes) {
        return $tareasPendientes;
    } else {
        return array("message" => "No se encontraron tareas pendientes");
    }
}

function createTask() {
    global $conexionBD;
    $data = json_decode(file_get_contents('php://input'), true);
    $sql = "INSERT INTO tareas (CAT_ID, TITULO, IMAGEN, DESCRIPCION, LUGAR, ESTADO) 
            VALUES (:cat_id, :titulo, :imagen, :descripcion, :lugar, :estado)";
    $stmt = $conexionBD->prepare($sql);
    $stmt->execute([
        'cat_id' => $data['cat_id'],
        'titulo' => $data['titulo'],
        'imagen' => $data['imagen'],
        'descripcion' => $data['descripcion'],
        'lugar' => $data['lugar'],
        'estado' => $data['estado']
    ]);

    if ($stmt->rowCount() > 0) {
        return array("message" => "Tarea creada correctamente");
    } else {
        return array("error" => "No se pudo crear la tarea");
    }
}

function updateTask($params) {
    global $conexionBD;
    $data = json_decode(file_get_contents('php://input'), true);
    $id = isset($params['id']) ? $params['id'] : null;
    if ($id !== null) {
        $sql = "UPDATE tareas 
                SET TITULO = :titulo, IMAGEN = :imagen, DESCRIPCION = :descripcion, CAT_ID = :cat_id, 
                    LUGAR = :lugar, ESTADO = :estado 
                WHERE id = :id";
        $stmt = $conexionBD->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'titulo' => $data['titulo'],
            'imagen' => $data['imagen'],
            'descripcion' => $data['descripcion'],
            'cat_id' => $data['cat_id'],
            'lugar' => $data['lugar'],
            'estado' => $data['estado']
        ]);

        if ($stmt->rowCount() > 0) {
            return array("message" => "Tarea actualizada correctamente");
        } else {
            return array("message" => "No se encontró ninguna tarea con el ID proporcionado");
        }
    } else {
        return array("error" => "ID de tarea no proporcionado");
    }
}

function removeTask($params) {
    global $conexionBD;
    $id = isset($params['id']) ? $params['id'] : null;
    if (!isset($id) || !is_numeric($id)) {
        return array("error" => "ID de tarea no válido");
    }
    $sql = "DELETE FROM tareas WHERE id = :id";
    $stmt = $conexionBD->prepare($sql);
    $stmt->execute(['id' => $id]);
    if ($stmt->rowCount() > 0) {
        return array("message" => "Tarea eliminada correctamente");
    } else {
        return array("message" => "No se encontró ninguna tarea con el ID proporcionado");
    }
}



?>