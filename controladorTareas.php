<?php
include('modeloTareas.php');

$conexionBD = conectar($bd);
$path = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$endpoints = array(
    'GET' => array(
        '/listTasks' => 'getTasksList',
        '/taskDetail' => 'getTaskById',
        '/tasksByDay' => 'getOrderedTasksListByDay',
        '/orderedTasksList' => 'getOrderedTasksList',
        '/finishedTasks' => 'getFinishedTasks',
        '/unfinishedTasks' => 'getUnfinishedTasks'
    ),
    'POST' => array(
        '/addTask' => 'createTask'
    ),
    'PUT' => array(
        '/updateTask' => 'updateTask'
    ),
    'DELETE' => array(
        '/removeTask' => 'removeTask'
    )
);

$foundPath = null;
foreach ($endpoints[$method] as $endpoint => $funcion) {
    if (strpos($path, $endpoint) !== false) {
        $foundPath = $funcion;
        break;
    }
}

if ($foundPath === null) {
    http_response_code(400);
    $response = array("error" => "Ruta no encontrada");
} else {
    $response = call_user_func($foundPath, $_GET);
    if (isset($response['error'])) {
        http_response_code(400); 
    } else {
        http_response_code(200);
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>