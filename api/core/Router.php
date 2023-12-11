<?php

// Clase Router: define puntos de entrada a la API (endpoints)
class Router {
    // ----------------------- ATRIBUTOS -----------------------
    // Atributo routes: array que define rutas
    protected $routes = array(); 
    // Atributo params: Array con parámetros para definir rutas
    protected $params = array();

    // ----------------------- METODOS -------------------------
    // Funcion add: recibe una ruta guardada en array y un array de parámetros 
    public function add($route, $params) {
        $this -> routes[$route] = $params;
    }

    // Función getRoutes: usada para visualizar las rutas
    public function getRoutes() {
        return $this->routes;
    }
    
    // Funcion getParams: usada para visualizar los parametros 
    public function getParams() {
        return $this->params;
    }

    // Función matchRoutes: compara dinamicamente las URL recibidas con las guardadas en router
    public function matchRoutes($url) {
        foreach($this->routes as $route=>$params) {
            // Reemplaza todas las apariciones de '{id}' con numeros
            $pattern = str_replace(["{id}", "/"], ["([0-9]+)", "\/"], $route);
            $pattern =  "/^" . $pattern . "$/";

            // Comprueba si eso coincide con lo guardado -> formato válido
            if(preg_match($pattern, $url["path"])) {
                $this->params = $params;
                return true;
            }
        }
        return false;  
    }
}