<?php

"use-strict";

// ------------------------------ IMPORTS -----------------------------------------
// Importar documentos
require "../app/model/Coche.php";
require "../app/model/Furgoneta.php";
require "../core/Codes.php";
require "../core/Router.php";
require "../app/controllers/Concesionario.php";
require "../core/HTTPNotFoundException.php";


// ------------------------------ VARIABLES GLOBALES ------------------------------
$jsonRuta = "../app/model/vehiculos.json";


// ------------------------------ MAIN --------------------------------------------

// - - - - - - - - ROUTER - - - - - - - -
$url = $_SERVER["QUERY_STRING"];

// Crea una instancia el Router
$router = new Router(); 

// Se almacenan 5 rutas
// Ruta GET: para mostrar todo
$router->add("/public/concesionario/get", array(
    "controller"=>"Concesionario",
    "action"=>"getAllVehicles"
    )
);
// Ruta GET con {id}: para mostrar vehículo con ese id 
$router->add("/public/concesionario/get/{id}", array(
    "controller"=>"Concesionario",
    "action"=>"getVehicleById"
    )
);
// Ruta POST: para añadir un vehículo 
$router->add("/public/concesionario/create", array(
    "controller"=>"Concesionario",
    "action"=>"createVehicle"
    )
);
// Ruta update/{id}: para actualizar la información de vehículo con ese id 
$router->add("/public/concesionario/update/{id}", array(
    "controller"=>"Concesionario",
    "action"=>"updateVehicle"
    )
);
// Ruta delete/{id}: para borrar vehículo con ese id
$router->add("/public/concesionario/delete/{id}", array(
    "controller"=>"Concesionario",
    "action"=>"deleteVehicle"
    )
);


// - - - - - - - - CONTROLADOR FRONTAL - - - - - - - -
// Array con los parámetros de la url recibida
$urlParams = explode("/", $url);

// Array con la petición recibida desglosada en valores
$urlArray = array (
    "HTTP"=>$_SERVER["REQUEST_METHOD"], // Método CRUD llamado
    "path"=>$url,                       // Guarda url del nav: para buscarlo en ruter (existe?) 
    "controller"=>"",                   // Controlador: qué controlador se llama
    "action"=>"",                       // Método: qué método se llama en el controlador
    "params"=>""                        // Parámetros: parámetros recibidos por URL para el método 
);

// Validación: existe el controlador?
// Primero: comprueba si está recibiendo un controlador
if(!empty($urlParams[2])) {
    // Si recibe: lo rellena con eso
    $urlArray["controller"] = ucwords($urlParams[2]);
    
    // Comprueba si hay 'action'
    if(!empty($urlParams[3])) {
        // Sí hay: lo rellena con eso
        $urlArray["action"] = $urlParams[3];

        // Comprueba si hay parámetros y si hay los pasa
        if(!empty($urlParams[4])) {
            $urlArray["params"] = $urlParams[4];
        }
    } else {
        // No hay: el defecto
        $urlArray["action"] = "index";
    }
} else {
    // Si viene vacío: 
    $urlArray["controller"] = "Home";
    $urlArray["action"] = "index";
}


// - - - - - - - - MATCH DINAMICO - - - - - - - -
// Si la ruta está en el Router
try {
    if($router->matchRoutes($urlArray)) {
        // Qué método usa el cliente en la petición (CRUD)
        $method = $_SERVER["REQUEST_METHOD"];

        // Define un array de parámetros que se pasa a matchRoutes() -> en función del metodo recibido define unos u otros parámetros
        $params = [];

        switch ($method) {
            case "GET":
                // Puede necesitar id
                $params[] = intval($urlArray["params"]) ?? null;         // si no encuentra ningún id lo pone a null
                break;
            
            case "POST":
                // Necesita datos JSON
                $json = file_get_contents("php://input");
                $params[] = json_decode($json, true);
                break;
        
            case "PUT":
                // Necesita id
                $id = intval($urlArray["params"]) ?? null;
                $params[] = $id;
                // Necesita datos JSON
                $json = file_get_contents("php://input");
                $params[] = json_decode($json, true);
                break;
        
            case "DELETE":
                // Necesita id
                $params[] = intval($urlArray["params"]) ?? null;
                break;
        }

        // Crea controlador y métodos dinámicamente
        $controller = $router->getParams()["controller"];
        $action = $router->getParams()["action"];
        // Se le pasa la ruta del JSON al crearlo
        $controller = new $controller($jsonRuta);               

        // Llamada de métodos: debe comprobar si la action existe en el controller
        if(method_exists($controller, $action)) {
            $respuesta = call_user_func_array([$controller, $action], $params);
        } else {
            echo "El método no existe";
        }

    // Cuando la URL no existe
    } else {
        // Lanza la excepción
        throw new HTTPNotFoundException();
    }

} catch(HTTPNotFoundException $e) {
    // Maneja la excepción
    echo "Error 404: " . $e->getMessage();
}
?>