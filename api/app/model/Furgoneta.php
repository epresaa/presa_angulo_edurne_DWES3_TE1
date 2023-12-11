<?php

require_once("Vehiculo.php");

// Clase Furgoneta: clase que extiende Vehiculo e implementa sus métodos
class Furgoneta extends Vehiculo {
    // ---------------- ATRIBUTOS ----------------
    private $tamanio;
    private $volumenCarga_m3;

    // ---------------- METODOS ------------------
    // Constructor
    function __construct($matricula, $tipo, $marca, $modelo, $anio, $color, $km, $precio, $combustible, $tamanio, $volumenCarga_m3) {
        parent::__construct($matricula, $tipo,  $marca, $modelo, $anio, $color, $km, $precio, $combustible);
        $this->volumenCarga_m3 = $volumenCarga_m3;
        
        // Tamanio: validación -> solo 'corta', 'mediana' o 'larga'
        $tamaPermitidos = ["corta", "mediana", "larga"];
        
        if (in_array(strtolower($tamanio), $tamaPermitidos)) {
            // El valor se encuentra en el array de opciones: se almacena
            $this->tamanio = strtolower($tamanio);
        
        } else {
            // El valor no es válido: Excepción
            throw new InvalidArgumentException("Error: el tamaño de furgoneta debe ser corta, mediana o larga");
        }
    }

    // Función toArray: se llama para convertir un objeto Furgoneta en array asociativo
    public function toArray() {
        return array(
            "matricula" => $this->matricula,
            "tipo" => $this->tipo,
            "marca" => $this->marca,
            "modelo" => $this->modelo,
            "anio" => $this->anio,
            "color" => $this->color,
            "km" => $this->km,
            "precio" => $this->precio,
            "combustible" => $this->combustible,
            "tamanio" => $this->tamanio,
            "volumenCarga_m3" => $this->volumenCarga_m3,
        );
    }

    // Función actualizar: se llama para actualizar campos del objeto Furgoneta 
    public function actualizar($data) {
        // Verifica y actualiza cada campo
        if (isset($data["matricula"])) {
            $this->matricula = $data["matricula"];
        }
        if (isset($data["tipo"])) {
            $this->tipo = $data["tipo"];
        }
        if (isset($data["marca"])) {
            $this->marca = $data["marca"];
        }
        if (isset($data["modelo"])) {
            $this->modelo = $data["modelo"];
        }
        if (isset($data["anio"])) {
            $this->anio = $data["anio"];
        }
        if (isset($data["color"])) {
            $this->color = $data["color"];
        }
        if (isset($data["km"])) {
            $this->km = $data["km"];
        }
        if (isset($data["precio"])) {
            $this->precio = $data["precio"];
        }
        if (isset($data["combustible"])) {
            $this->combustible = $data["combustible"];
        }
        if (isset($data["tamanio"])) {
            $this->tamanio = $data["tamanio"];
        }
        if (isset($data["volumenCarga_m3"])) {
            $this->volumenCarga_m3 = $data["volumenCarga_m3"];
        }
    }
}
?>