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




?>