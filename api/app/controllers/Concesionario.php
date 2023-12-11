<?php 

// Clase Concesionario: maneja los métodos usados por las peticiones CRUD
class Concesionario {
    // ---------------- ATRIBUTOS ------------------ 
    private $ruta_mi_JSON;
    private $concesionario = array(
        "vehiculos" => array()
    );
    private $max;

    // ---------------- METODOS -------------------- 
    // Constructor
    function __construct($ruta_JSON) {
        $this->ruta_mi_JSON = $ruta_JSON;
        $this->cargarArray();
        $this->max;
    }

    // Función cargarArray: método que carga un array de objetos de tipo Coche o Furgoneta a partir de la información del JSON
    private function cargarArray() {          
        // Se comprueba si existe el fichero: si existe se va cargando el array
        if(file_exists($this->ruta_mi_JSON)) {
            $json = file_get_contents($this->ruta_mi_JSON);
            $info = json_decode($json, true);

            // Se carga el array de objetos 
            foreach($info["vehiculos"] as $datosVehi) {
                // Comprueba el tipo: coche o furgoneta
                $vehiculo = $this->crearObjetosVehiculo($datosVehi);
                $this->concesionario["vehiculos"][] = $vehiculo;
            }
        }
    }

    // Función crearVehiculo: 
    private function crearObjetosVehiculo($data) {
        if(strtolower($data["tipo"]) == "coche") {
            return new Coche($data["matricula"], $data["tipo"], $data["marca"], $data["modelo"], $data["anio"], $data["color"], $data["km"], $data["precio"], $data["combustible"], $data["categoria"]);
        } elseif(strtolower($data["tipo"]) == "furgoneta") {
            return new Furgoneta($data["matricula"], $data["tipo"], $data["marca"], $data["modelo"], $data["anio"], $data["color"], $data["km"], $data["precio"], $data["combustible"], $data["tamanio"], $data["volumenCarga_m3"]);
        }
    }

    // Función obtenerJSON: función que a partir del array de objetos crea un array asociativo
    // return: a partir del array asociativo genera un JSON que es devuelto
    private function obtenerJSON() {
        $array = [];
        foreach($this->concesionario["vehiculos"] as $vehiculo) {
            array_push($array, $vehiculo->toArray());
        }
        return json_encode($array, JSON_PRETTY_PRINT);
    }

    // Función obtenerJSONById: función que a partir del array de objetos selecciona uno por su ID y lo convierte a array
    // return: a partir del array genera un JSON que es devuelto
    private function obtenerJSONById($id) {
        $buscado = $this->concesionario["vehiculos"][$id]->toArray();
        return json_encode($buscado, JSON_PRETTY_PRINT);
    }

    // Función mostrarCode: función que usa la clase estática Codes para mostrar el código HTTP y su significado
    private function mostrarCode() {
        // Recoge el codigo generado automáticamente
        $resp = http_response_code();
        // Muestra un mensaje usando la clase Codes
        $codigo_JSON = Codes::generarCodigo($resp);
        return $codigo_JSON;
    }

    // Función guardarJSON: función que actualiza el fichero vehiculos.json
    private function guardarJSON() {
        $jsonActualizado = json_encode($this->concesionario, JSON_PRETTY_PRINT);
        file_put_contents($this->ruta_mi_JSON, $jsonActualizado);
    }

    // ---------------- CRUD ----------------------- 
    // - - - - GET - - - -
    function getAllVehicles() {
        // Muestra código respuesta
        $this->mostrarCode();
        echo "\n";
        
        // Muestra todos los vehiculos
        $json = $this->obtenerJSON();
        echo $json;
    } 
    
    function getVehicleById($id){
        // Manejo de excepciones: si se introduce un id que no existe 
        try {
            if(isset($this->concesionario["vehiculos"][$id])) {
                // Muestra código respuesta
                $this->mostrarCode();
                echo "\n";

                // Busca el vehiculo con ese id y muestra solo ese
                $json = $this->obtenerJSONById($id);
                echo $json;

            } else {
                $this->max = count($this->concesionario["vehiculos"]);
                throw new Exception("El id introducido no existe: número máximo " . ($this->max - 1));
            }
        } catch (Exception $e) {
            // Muestra mensaje de exepción
            echo "Error: " . $e->getMessage();
        }    
    }

    // - - - - POST - - - -
    function createVehicle($data) {
        // Muestra código respuesta
        $this->mostrarCode();
        echo "\n";

        // Se carga el nuevo dato al array
        $vehiculo = $this->crearObjetosVehiculo($data);
        $this->concesionario["vehiculos"][] = $vehiculo;

        // Obtiene el nuevo JSON
        $nuevoJSON = $this->obtenerJSON();
        $this->concesionario["vehiculos"] = json_decode($nuevoJSON, true);

        // Actualiza el fichero JSON
        $this->guardarJSON();

        // Muestra el nuevo vehiculo
        $nuevoVehiculoJSON = json_encode($data, JSON_PRETTY_PRINT);
        echo $nuevoVehiculoJSON;
    }

    // - - - - PUT - - - -
    function updateVehicle($id, $data){
        // Manejo de excepciones: si se introduce un id que no existe 
        try {
            if(isset($this->concesionario["vehiculos"][$id])) {
                // Muestra código respuesta
                $this->mostrarCode();
                echo "\n";
                
                // Vehiculo a modificar
                $modificar = $this->concesionario["vehiculos"][$id];
                // Se actualiza con los datos recibidos 
                $modificar->actualizar($data);

                // Obtiene el nuevo JSON
                $nuevoJSON = $this->obtenerJSON();
                $this->concesionario["vehiculos"] = json_decode($nuevoJSON, true);

                // Actualiza el fichero JSON
                $this->guardarJSON();

                // Muestra el nuevo vehiculo
                $nuevoVehiculoJSON = json_encode($data, JSON_PRETTY_PRINT);
                echo $nuevoVehiculoJSON;
                
            } else {
                $this->max = count($this->concesionario["vehiculos"]);
                throw new Exception("El id introducido no existe: número máximo " . ($this->max - 1));
            }
        } catch (Exception $e) {
            // Muestra mensaje de exepcion
            echo "Error: " . $e->getMessage();
        }
    }

    // - - - - DELETE - - - -
    function deleteVehicle($id) {
        // Manejo de excepciones: si se introduce un id que no existe 
        try {
            if(isset($this->concesionario["vehiculos"][$id])) {
                // Muestra código respuesta
                $this->mostrarCode();
                echo "\n";

                // Muestra vehiculo a borrar
                print_r($this->obtenerJSONById($id));

                // Se elimina el elemento del concesionario
                unset($this->concesionario["vehiculos"][$id]);
                // Reindexa el array
                $this->concesionario["vehiculos"] = array_values($this->concesionario["vehiculos"]);

                // Obtiene el nuevo JSON
                $nuevoJSON = $this->obtenerJSON();
                $this->concesionario["vehiculos"] = json_decode($nuevoJSON, true);

                // Actualiza el fichero JSON
                $this->guardarJSON();
                
            } else {
                $this->max = count($this->concesionario["vehiculos"]);
                throw new Exception("El id introducido no existe: número máximo " . ($this->max - 1));
            }
        } catch (Exception $e) {
            // Muestra mensaje de exepcion
            echo "Error: " . $e->getMessage();
        }
    }
}
?>